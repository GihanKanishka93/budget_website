<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:customer');
    }



    public function createPayment(Request $request)
    {
        $type = '';
        $amount = 0;
        $type = $request->query('type');
        $amount = ($type == 'single') ? 274 : (($type == 'multi') ? 457.6 : 0);
        $url = '';
        $url = $this->ewayPayment($amount);

        return redirect($url);
    }

    public function ewayPayment($amount)
    {
        $total_amount = $amount;

        $apiKey = env('EWAY_API_KEY');
        $apiPassword = env('EWAY_API_PASSWORD');
        $apiEndpoint = 'Production';
        $client = \Eway\Rapid::createClient($apiKey, $apiPassword, $apiEndpoint);

        $transaction = [
            'RedirectUrl' => url('/payment-success'),
            'CancelUrl' => url('/payment-failure'),
            'TransactionType' => \Eway\Rapid\Enum\TransactionType::PURCHASE,
            'Payment' => [
                'TotalAmount' => $total_amount * 100,
            ]
        ];
        $response = $client->createTransaction(\Eway\Rapid\Enum\ApiMethod::RESPONSIVE_SHARED, $transaction);
        $sharedURL = '';
        $transID = '';

        if (!$response->getErrors()) {
            $returnData = $response->SharedPaymentUrl;
        } else {
            $returnData = url('/payment-failure');
        }

        return $returnData;

    }

    public function paymentSuccess(Request $request)
    {
        $accessCode = $request->input('AccessCode', null);

        //echo $accessCode;


        // Make an API call to eWAY to retrieve transaction details
        $apiKey = env('EWAY_API_KEY');
        $apiPassword = env('EWAY_API_PASSWORD');
        $apiEndpoint = \Eway\Rapid\Client::MODE_PRODUCTION;

        // Create the eWAY Client
        $client = \Eway\Rapid::createClient($apiKey, $apiPassword, $apiEndpoint);

        // Query the transaction result.
        $response = $client->queryTransaction($accessCode);
        $transactionResponse = $response->Transactions[0];

        // Use the transaction details as needed
        $transactionId = $transactionResponse->TransactionID;
        $authorisationCode = $transactionResponse->AuthorisationCode;
        $amount = $transactionResponse->TotalAmount;
        $paymentStatus = $transactionResponse->TransactionStatus;

        $customerFname = $transactionResponse->Customer->FirstName;
        $customerlname = $transactionResponse->Customer->LastName;
        $customerTitle = $transactionResponse->Customer->Title;
        $address_street1 = $transactionResponse->Customer->Street1;
        $address_street2 = $transactionResponse->Customer->Street2;
        $address_city = $transactionResponse->Customer->City;
        $address_state = $transactionResponse->Customer->State;
        $country = $transactionResponse->Customer->Country;
        $email = $transactionResponse->Customer->Email;
        $phone_number = $transactionResponse->Customer->Phone;
        // $currency = $$transactionResponse->Currency;
        //$paymentStatus = $$transactionResponse->TransactionStatus;

        // Handle successful payment
        $paymentData = [
            'payment_id' => $transactionId,
            'amount' => $amount / 100,
            'currency' => 'AUD',
            'payment_status' => $paymentStatus,
            'accesscode' => $accessCode,
            'authorisationCode' => $authorisationCode,
            'fname' => $customerFname,
            'lname' => $customerlname,
            'title' => $customerTitle,
            'street1' => $address_street1,
            'street2' => $address_street2,
            'city' => $address_city,
            'state' => $address_state,
            'country' => $country,
            'email' => $email,
            'phone' => $phone_number,

        ];
        $this->updatePayment($paymentData);

        if ($paymentStatus == false && $authorisationCode == null) {
            return redirect('https://netstripes.com/budget-website-design/');
        }

        return redirect('https://web.netstripes.com/');

    }

    public function paymentFailure(Request $request)
    {
        // Handle failed payment

        return redirect('https://netstripes.com/budget-website-design/');
    }


    public function updatePayment($paymentData)
    {

        $user = Auth::user();
        $payment = new Payment;
        $payment->customer_id = 0;
        $payment->payment_id = $paymentData['payment_id'];
        $payment->amount = $paymentData['amount'];
        $payment->currency = $paymentData['currency'];
        $payment->payment_status = $paymentData['payment_status'];
        $payment->accesscode = $paymentData['accesscode'];
        $payment->authorisationCode = $paymentData['authorisationCode'];
        $payment->customer_fname = $paymentData['fname'];
        $payment->customer_lname = $paymentData['lname'];
        $payment->customer_title = $paymentData['title'];
        $payment->address_street1 = $paymentData['street1'];
        $payment->address_street2 = $paymentData['street2'];
        $payment->address_city = $paymentData['city'];
        $payment->address_state = $paymentData['state'];
        $payment->country = $paymentData['country'];
        $payment->email = $paymentData['email'];
        $payment->phone_number = $paymentData['phone'];

        $payment->save();
        $status = $payment->payment_status == 1 ? 'Approved' : 'Declined';

        if ($payment->payment_status == 'Approved') {
            Mail::html(
                '<html>
                    <body>
                        Hi ' . $payment->customer_fname . ',<br/><br/>
                        Great news! Your payment has been successfully processed, and we\'re thrilled to inform you that your budget website form has been activated.<br/><br/>
                        You can review your payment details using the following link:<br/><br/>
                        <a href="https://secure.ewaypayments.com/sharedpage/sharedpayment/Result?AccessCode=' . $payment->accesscode . '">Payment Details</a><br/><br/>
                        Payment Details:<br/>
                        <ul>
                            <li>Name: ' . $payment->customer_fname . ' ' . $payment->customer_lname . '</li>
                            <li>Payment Id: ' . $payment->payment_id . '</li>
                            <li>Amount: ' . $payment->amount . ' AUD</li>
                            <li>Payment Status: Approved</li>
                            <li>Date: ' . date('Y-m-d h:i:s') . '</li>
                        </ul>
                        <p>We will now direct you to your Budget Website dashboard. Please carefully complete and submit the form, and we will develop your website within seven days of form submission.</p>
                        <p>If you have any questions or need assistance, please don\'t hesitate to contact our support team.</p><br/>
                        <p>Wishing you continued success on your journey with us!</p><br/>
                        Warm regards,<br/>
                        Netstripes Team
                    </body>
                </html>',
                function ($message) use ($payment) {
                    $message->to($payment->email)->subject('Your Budget Website Form is Now Activated');
                }
            );

        } else {
            Mail::html(
                '<html>
                    <body>
                        Hi ' . $payment->customer_fname . ',<br/><br/>
                        We regret to inform you that your recent payment attempt was not successful. As a result, your budget website form could not be activated.<br/><br/>
                        Payment Details:<br/>
                        <ul>
                            <li>Name: ' . $payment->customer_fname . ' ' . $payment->customer_lname . '</li>
                            <li>Payment Id: ' . $payment->payment_id . '</li>
                            <li>Amount: ' . $payment->amount . ' AUD</li>
                            <li>Payment Status: Declined</li>
                            <li>Date: ' . date('Y-m-d h:i:s') . '</li>
                        </ul>
                        <p>Please verify your payment information and try again. If you continue to experience issues, contact your bank or reach out to our support team for further assistance.</p>
                        <p>We apologize for any inconvenience this may have caused and appreciate your understanding.</p><br/>
                        Warm regards,<br/>
                        Netstripes Team
                    </body>
                </html>',
                function ($message) use ($payment) {
                    $message->to($payment->email)->subject('Payment Declined - Action Required');
                }
            );


        }




        return $payment->id;

    }

}