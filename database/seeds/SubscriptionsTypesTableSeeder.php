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
          'duration_month'  => 12,
          'nbApplication' => 10,
      ]);
      SubscriptionsTypes::create([
          'price' => 0,
          'name'  => 'Free',
          'duration_month'  => 1,
          'nbApplication' => 1,
      ]);
    }
}