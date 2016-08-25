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
  public function createInvoicePdf($user,$subscription)
  {

    $pdf = App::make('dompdf.wrapper');
    $pdf->loadHTML('<h1>Test</h1>');
    return $pdf->stream();
  }
}
