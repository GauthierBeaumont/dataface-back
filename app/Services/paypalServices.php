<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use Paypal;

class paypalServices
{
  private $_apiContext;
  private $amount = null;

   public function __construct()
   {
       $this->_apiContext = PayPal::ApiContext(
           config('services.paypal.client_id'),
           config('services.paypal.secret'));

       $this->_apiContext->setConfig(array(
           'mode' => 'sandbox',
           'service.EndPoint' => 'https://api.sandbox.paypal.com',
           'http.ConnectionTimeOut' => 30,
           'log.LogEnabled' => true,
           'log.FileName' => storage_path('logs/paypal.log'),
           'log.LogLevel' => 'FINE'
       ));

   }
   public function initPayementPaypal($request){
    return $this->getCheckout($request);
   }
   public function getCheckout($request)
{
    $this->amount=  $request->get('amount');
    $payer = PayPal::Payer();
    $payer->setPaymentMethod('paypal');

    $amount = PayPal:: Amount();
    $amount->setCurrency('EUR');
    $amount->setTotal($this->amount); // This is the simple way,
    // you can alternatively describe everything in the order separately;
    // Reference the PayPal PHP REST SDK for details.

    $transaction = PayPal::Transaction();
    $transaction->setAmount($amount);
    $transaction->setDescription('What are you selling?');

    // $redirectUrls = PayPal:: RedirectUrls();
    // $redirectUrls->setReturnUrl(action('ThisController@getDone'));
    // $redirectUrls->setCancelUrl(action('ThisController@getCancel'));

    $payment = PayPal::Payment();
    $payment->setIntent('sale');
    $payment->setPayer($payer);
    $payment->setRedirectUrls($redirectUrls);
    $payment->setTransactions(array($transaction));

    $response = $payment->create($this->_apiContext);
    $redirectUrl = $response->links[1]->href;

    return Redirect::to( $redirectUrl );
}

public function getDone(Request $request)
{
    $id = $request->get('paymentId');
    $token = $request->get('token');
    $payer_id = $request->get('PayerID');

    $payment = PayPal::getById($id, $this->_apiContext);

    $paymentExecution = PayPal::PaymentExecution();

    $paymentExecution->setPayerId($payer_id);
    $executePayment = $payment->execute($paymentExecution, $this->_apiContext);

    // Clear the shopping cart, write to database, send notifications, etc.

    // Thank the user for the purchase
    return view('checkout.done');
}

public function getCancel()
{
    // Curse and humiliate the user for cancelling this most sacred payment (yours)
    return view('checkout.cancel');
}
}
