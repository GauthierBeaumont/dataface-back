<?php

namespace App\Services;

use Illuminate\Http\Request;
use Cartalyst\Stripe\Stripe;
use App\User;
use App\Models\Subscription;
use App\Models\SubscriptionsTypes;
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
  private $typeSubscription = null;

  public function initPayementStripe ($stripe, $request,$user){

      $this->user = $user;
      $this->typeSubscription = SubscriptionsTypes::findOrFail($request->get('typeSubscription'));
      $this->currency=  $request->get('currency');
      $this->object=  'card';
      $this->amount=  $request->get('amount');
      $this->name=  $this->user->name;
      $this->number=  $request->get('card_no');
      $this->cvc=  $request->get('cvc');
      $this->expMonth=  $request->get('expiration_month');
      $this->expYear=  $request->get('expiration_year');

      //dd(SubscriptionsTypes::findOrFail($request->get('typeSubscription')));

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

    $message = $this->statusPaiement($status);

    $response = ['status' => $status,'message' => $message];

return $response;

  }
  private function statusPaiement($status){

    if($status == 'succeeded'){
        //insert into Subscriptions table
        $Subscription = new Subscription();
        $Subscription->created_at = new \DateTime();
        $Subscription->price = $this->amount;
        $Subscription->currency = $this->currency;
        $Subscription->date_validation = (new \DateTime())->add(new \DateInterval('P'.$this->typeSubscription->duration_month.'M'));
        $Subscription->date_payment = new \DateTime();
        $Subscription->key_user = rand(1000000000,2000000000);
        $Subscription->type_payments_id = 1;
        $Subscription->subscriptions_types_id = $this->typeSubscription->id;
        $Subscription->save();
        // insert into user_subscriptions
        $Subscription->users()->attach($this->user->id,['no_facture'=> $Subscription->key_user, 'date_facture'=>date("Y-m-d H:i:s")]);
        //dd($Subscription);
        $message = 'Paiement envoyé avec succès et abonnement enregistré';

    }elseif($status == 'pending'){
      $message = 'Paiement en cours de traitement';
    }else{
      $message = "Erreur lors de l''envoi du paiement";
    }
    return $message;
  }


}
