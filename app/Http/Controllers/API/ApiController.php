<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use App\Http\Controllers\API\BaseController as BaseController;

class ApiController extends BaseController
{

    public function submitFrom(Request $request) {
        $website = new Website; 
        $website->design = $request->design_option;        
        $website->save();
        
        return json_encode($website);
    }

    public function updateFrom(Request $request) {
        $website = Website::find($request->id); 

        if(isset($request->logo)) {
            $imagePath = $this->uploadImage($request->logo, 'logo');
            $website->logo = $imagePath;  
        }
        $website->design = $request->design_option;   
        $website->colors = $request->colors;    
        $website->caption = $request->caption;    
        $website->sub_caption = $request->subCaption;    
        $website->colors = $request->colors;    
        $website->caption = $request->caption;    
        $website->sub_caption = $request->subCaption;    
        $website->services = $request->services;    
        $website->processes = $request->processes;    
        $website->about = $request->about;    
        $website->qualifications = $request->qualifications;    
        $website->partners = $request->partners;    
        $website->testimonials = $request->testimonials;    
        $website->social_media = $request->socialMedia;    
        $website->contact_email = $request->contact_email;    
        $website->contact_phone = $request->contact_phone;    
        $website->contact_name = $request->contact_name;    
        $website->age_group = $request->age_group;     
        $website->gender = $request->gender;     
        $website->ethnicity = $request->ethnicity;     
        $website->professions = $request->professions;   
        $website->interests = $request->interests;       
        $website->achievements = $request->achievements;     
        $website->save();

        return json_encode($website);
    }
    

    public function uploadImage($image, $location)
    {
        $imageName = time().'.'.$image->getClientOriginalExtension();
        
        $image->move(public_path('storage/'.$location), $imageName);
        
        return 'storage/'.$location.'/'.$imageName;
    }

    public function saveLogo(Request $request) {
        $imagePath = '';
        if($request->logo !== null) {
            $imagePath = $this->uploadImage($request->logo, 'partners');
        }
        return json_encode($imagePath);

    }

}
