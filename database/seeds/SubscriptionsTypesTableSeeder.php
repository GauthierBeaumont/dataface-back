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
          'price' => 0,
          'name'  => 'Free',
          'description' =>'Essai gratuit pendant 1 mois',
          'duration_month'  => 1,
          'order' => 0,
          'nbApplication' => 1,
      ]);

      SubscriptionsTypes::create([
          'price' => 300,
          'name'  => 'Premium',
          'description' => 'Abonnement de 1 ans',
          'duration_month'  => 12,
          'order' => 0,
          'nbApplication' => 10,
      ]);

      SubscriptionsTypes::create([
          'price' => 1500,
          'name'  => 'Business',
          'description' =>'Abonnement de 24 mois',
          'duration_month'  => 24,
          'order' => 1,
          'nbApplication' => 50,
      ]);

      SubscriptionsTypes::create([
          'price' => 2500,
          'name'  => 'Pro',
          'description' => 'Abonnement illimité',
          'duration_month' => 0,
          'order' => 0,
          'nbApplication' => 100,
      ]);

      

      
    }
}
