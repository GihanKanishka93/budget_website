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
        $amount = ($type == 'single') ? 253 : (($type == 'multi') ? 422 : 0);
        $url = '';
        $url = $this->ewayPayment($amount);

        return redirect($url);
    }

    public function ewayPayment($amount)
    {
        $total_amount = $amount;

        $apiKey = env('EWAY_API_KEY');
        $apiPassword = env('EWAY_API_PASSWORD');
        $apiEndpoint = 'Sandbox';
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
        $apiEndpoint = \Eway\Rapid\Client::MODE_SANDBOX;

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
        $status = $payment->payment_status == 1 ? 'Approved' : 'Rejected';

        if ($payment->payment_status == 'COMPLETED') {


        }

        //         Mail::html(
//             '<html><body>Hi ' . $user->first_name . ' ' . $user->last_name . ',<br/><br/>
//             Great news! Your payment has been successfully processed, and we\'re thrilled to inform you that you\'ve been upgraded to Level ' . $user_level . '. <br/><br/>
//             Here are the added perks you can now enjoy:<br/>

        //             <ul>
//             <li>Full Futurise Foundation program access</li>
//             <li>Automated Digital Strategy access</li>
//             <li>Digital blueprint feature with an advisor</li>
//             <li>Social Media Post Generation access</li>
//             <li>Blog Post Generation access</li>
//             </ul>

        //             <br/>
//             Payment Details: <br/>

        // <ul>
// <li>Name : ' . $user->first_name . ' ' . $user->last_name . '</li>
// <li>Payment Id : ' . $payment->payment_id . '</li>
// <li>Amount: ' . $payment->amount . 'AUD </li>
// <li>Payment Status: ' . $status . '</li>
// <li>Date: ' . date('Y-m-d h:i:s') . '</li>

        // </ul>
// <p>Thank you for your commitment to our platform and for choosing to level up your experience with us. Should you have any questions or need assistance, please don\'t hesitate to reach out to our support team.</p>
// <p>Wishing you continued success on your journey with us!</p><br/>

        // Warm regards <br/>Netstripes Team</body></html>',
//             function ($message) use ($user, $user_level) {
//                 $message->to($user->email)->subject('Congratulations! You\'ve Been Upgraded to Level ' . $user_level);
//             }
//         );

        return $payment->id;

    }

}