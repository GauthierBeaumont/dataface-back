<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\User;
use Illuminate\Support\Facades\Auth;


class InvoiceController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function createInvoicePdf(Request $request)
  {
    $user = \App\Models\User::find()$request->get('userId');


    //$Subscription = \App\::find($request->get('subscriptionId'));
    $pdf = \App::make('dompdf.wrapper');
    $html = '<header><h1>FACTURE</h1><h2>DATAFACE</h2></header>';
    $pdf->loadHTML($html);

    return $pdf->stream();

   }

}
