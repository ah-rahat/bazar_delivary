<?php

    

namespace App\Http\Controllers;

     

use Illuminate\Http\Request;

use Session;

use Stripe;

     

class StripePaymentController extends Controller

{

    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function stripe()

    {

        return view('stripe');

    }

    

    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function stripePost(Request $request)

    {
        
     
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

 

       $charge  = Stripe\Charge::create ([

                "amount" => $request->amount * 100,

                "currency" => "GBP",

                "source" => $request->stripeToken,

                "description" => "Test payment" 

        ]);

        Session::flash('success', $charge->id);              

        return back();

    }

}