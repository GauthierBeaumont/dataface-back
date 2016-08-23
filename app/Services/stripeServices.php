<?php

namespace App\Services;

use Illuminate\Http\Request;
use Cartalyst\Stripe\Stripe;
use App\User;

use App\Http\Requests;

class stripeServices
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
  private $user = null;

  public function initPayementStripe ($stripe, $request,$user){


      $this->currency=  $request->get('currency');
      $this->object=  'card';
      $this->amount=  $request->get('amount');
      $this->name=  $request->get('name');
      $this->number=  $request->get('card_no');
      $this->cvc=  $request->get('cvc');
      $this->expMonth=  $request->get('expiration_month');
      $this->expYear=  $request->get('expiration_year');
      $this->user = $user;
      return $this->payment($stripe);
  }

  public function payment($stripe)
  {

    $message;
    $response;
    $charge = $stripe->charges()->create([
        'amount' => $this->amount,
        'currency' => $this->currency,
        'source' => [
            'object'    => $this->object,
            'name'      => $this->name,
            'number'    => $this->number,
            'cvc'       => $this->cvc,
            'exp_month' => $this->expMonth,
            'exp_year'  => $this->expYear,
        ]
    ]);
    $status = $charge['status'];

    $message = $this->statusPaiement($status,$user);

    $response = ['status' => $status,'message' => $message];

return $response;

  }
  private function statusPaiement($status){

    if($status == 'succeeded'){
      $message = 'Paiement envoyé avec succès';
    }elseif($status == 'pending'){
      $message = 'Paiement en cours de traitement';
    }else{
      $message = "Erreur lors de l''envoi du paiement";
    }
    return $message;
  }


}
