<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
   
    public function createCheckoutSession(Request $request){
       
    }

    // Example success route
    public function paymentSuccess()
    {
        return 'sfdf'; // create this Blade view
    }

    // Example failed route
    public function paymentFailed()
    {
       return 'ihf'; // create this Blade view
    }
}
