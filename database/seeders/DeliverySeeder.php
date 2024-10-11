<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Delivery;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //10 одинаковых доставок с начальным статусом для теста
        for ($i=0;$i<10;$i++) {
            Delivery::create(['status' => Delivery::STATUS_PLANNED]);
        }
    }
}
