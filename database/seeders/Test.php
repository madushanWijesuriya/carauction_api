<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
class Test extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payments = [
            [
                'vehicle_id' => 1,'customer_id' => 1, 'agent'=> 'Agent 01', 'paid_amount'=> 1000.00
            ],
            [
                'vehicle_id' => 2,'customer_id' => 2, 'agent'=> 'Agent 02', 'paid_amount'=> 2000.00
            ],
            [
                'vehicle_id' => 3,'customer_id' => 3, 'agent'=> 'Agent 03', 'paid_amount'=> 1000.00
            ],
            [
                'vehicle_id' => 4,'customer_id' => 1, 'agent'=> 'Agent 04', 'paid_amount'=> 1000.00
            ],
            [
                'vehicle_id' => 5,'customer_id' => 3, 'agent'=> 'Agent 05', 'paid_amount'=> 1000.00
            ],
            [
                'vehicle_id' => 6,'customer_id' => 2, 'agent'=> 'Agent 01', 'paid_amount'=> 1000.00
            ],
            [
                'vehicle_id' => 7,'customer_id' => 3, 'agent'=> 'Agent 01', 'paid_amount'=> 1000.00
            ],
            [
                'vehicle_id' => 8,'customer_id' => 2, 'agent'=> 'Agent 01', 'paid_amount'=> 1000.00
            ],

        ] ;
        
        foreach ($payments as $key => $value) {
            Payment::create($value);
        }
        
    }
}
