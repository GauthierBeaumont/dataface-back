<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Stripe;
use App\Http\Requests;
use App\Services\stripeServices;
use App\Services\paypalServices;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\User;
class PayController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function payment(Stripe $stripe, stripeServices $stripeServices,Request $request,paypalServices $paypalServices)
  {
    if("stripe" == $request->get('pay')){
        $response =  $stripeServices->initPayementStripe($stripe,$request,Auth::user());
        $response = response()->json($response);
    }elseif ("paypal" == $request->get('pay') ) {
       $response = $paypalServices->initPayementPaypal($request);
    }
      return $response;
  }
}
