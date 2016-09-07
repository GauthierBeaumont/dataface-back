<?php

use Illuminate\Database\Seeder;
use App\Models\SubscriptionsTypes;

class SubscriptionsTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      SubscriptionsTypes::create([
          'price' => 300,
          'name'  => 'Premium',
          'description' => 'Abonnement de 1 ans',
          'duration_month'  => 12,
      ]);
      SubscriptionsTypes::create([
          'price' => 500,
          'name'  => 'Premium +',
          'description' => 'Abonnement de 2 ans avec en cadeau une carte collector yu-gi-oh!',
          'duration_month'  => 24,
      ]);
      SubscriptionsTypes::create([
          'price' => 0,
          'name'  => 'Free',
          'description' =>'Essai gratuit pendant 1 mois',
          'duration_month'  => 1,
      ]);



    }
}
