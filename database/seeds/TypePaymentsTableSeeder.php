<?php
use Illuminate\Database\Seeder;
use App\Models\TypePayment;
class TypePaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      TypePayment::create([
          'label' => 'Stripe'
      ]);
      TypePayment::create([
          'label' => 'Paypal'
      ]);
    }
}