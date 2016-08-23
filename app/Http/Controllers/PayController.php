<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cartalyst\Stripe\Stripe;

use App\Http\Requests;

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

    public function payment(Stripe $stripe)
    {
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

        return ['status' => $status,'message' => $message];
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
}
