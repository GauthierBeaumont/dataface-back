<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Cartalyst\Stripe\Stripe;
use App\Http\Requests;
use App\Services\stripeServices;
use App\Services\paypalServices;


class PayController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    private $currency = null;
    private $object = null;
    private $amount = null;
    private $name = null;
    private $number = null;
    private $cvc = null;
    private $expMount = null;
    private $expYear = null;


    public function __construct(Request $request)
    {
        $this->currency = $request->get('currency');
        $this->object = 'card';
        $this->amount = $request->get('amount');
        $this->name = $request->get('name');
        $this->number = $request->get('card_no');
        $this->cvc = $request->get('cvc');
        $this->expMonth = $request->get('expiration_month');
        $this->expYear = $request->get('expiration_year');
    }

    private function statusPaiement($status) {

        if($status == 'succeeded') {
            //si status == succeeded TODO save en table user_payments
            $message = 'Paiement envoyé avec succès';
        }elseif($status == 'pending') {
            $message = 'Paiement en cours de traitement';
        }else{
            $message = "Erreur lors de l''envoi du paiement";
        }

        return $message;
    }
  /**
   * Create a new controller instance.
   *
   * @return void
   */


  public function payment(Stripe $stripe, stripeServices $stripeServices,Request $request,paypalServices $paypalServices)
  {

    if("stripe" == $request->get('pay')){

        $response =  $stripeServices->initPayementStripe($stripe,$request);
        $response = response()->json($response);

    }elseif ("paypal" == $request->get('pay') ) {

       $response = $paypalServices->initPayementPaypal($request);
    }
      return $response;

  }
}
