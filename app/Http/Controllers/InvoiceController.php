<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\User;
use App\Models\Subscription;
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
    $user = User::findOrFail($request->get('userId'));
    //$Subscription = Subscription::findOrFail($request->get('subscriptionId'));
    $lastSubscription = count($user->subscription);
    $priceHT = $user->subscription[$lastSubscription-1]->typeSubscription->price;
    $tva = 0.2;
    $priceTTC = ($priceHT*$tva) + $priceHT;
    $priceTTC = number_format($priceTTC,2);
    //dd($priceTTC);

    $pdf = \App::make('dompdf.wrapper');
    $head = '<html lang="en">
      <head>
        <meta charset="utf-8">
        <title>Example 1</title>
        <link rel="stylesheet" href="'.public_path().'/css/style.css" media="all" />
      </head>';
    $body = ' <body>
        <header class="clearfix">
          <div id="logo">
              <img src="'.public_path().'/images/logo-dataface-noir.png">
          </div>
          <h1>'.$user->subscription[$lastSubscription-1]->pivot->no_facture.'</h1>
          <div id="company" class="clearfix">
            <div>DATAFACE</div>
            <div>6 Place Charles Hernu, 69100 Villeurbanne<br /> France</div>
            <div><a >contact@dataface.com</a></div>
          </div>
          <div id="project">
            <div><span>PROJET </span> Application development</div>
            <div><span>CLIENT </span>  ' .$user->lastname.' '.$user->firstname.'</div>
            <div><span>ADRESSE </span> '.$user->Coordinate->address . ' '.$user->Coordinate->postal_code.' '.$user->Coordinate->country.'</div>
            <div><span>EMAIL </span> <ahref> '.$user->email.'</a></div>
            <div><span>DATE </span> '.$user->subscription[$lastSubscription-1]->pivot->date_facture.'</div>
          </div>
        </header>
        <main>
        <br/>
        <br/>
        <br/>
          <table>
            <thead>
              <tr>
                <th class="service">SERVICE</th>
                <th class="desc">DESCRIPTION</th>
                <th>PRIX</th>
                <th>QUANTITE</th>
                <th>TOTAL</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="service">'.$user->subscription[$lastSubscription-1]->typeSubscription->name.'</td>
                <td class="desc">'.$user->subscription[$lastSubscription-1]->typeSubscription->description.'</td>
                <td class="unit">'.$priceHT.' '.$user->subscription[$lastSubscription-1]->currency.'</td>
                <td class="qty">1</td>
                <td class="total">'.$priceHT.' '.$user->subscription[$lastSubscription-1]->currency.'</td>
              </tr>
              <tr>
              <td colspan="4" class="grand total">TVA</td>
              <td class="grand total">'.(number_format($tva*100,2)).'%</td>
              </tr>
              <tr>
                <td colspan="4" class="grand total">TOTAL TTC</td>
                <td class="grand total">'.$priceTTC.' '.$user->subscription[$lastSubscription-1]->currency.'</td>
              </tr>

            </tbody>
          </table>
        </main>

      </body></html>';

    $html = $head.$body;
    $pdf->loadHTML($html)->setPaper('letter', 'landscape');

    return $pdf->stream();

   }

}
