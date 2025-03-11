<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Route;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buses = Bus::all();

        foreach ($buses as $bus) {
            Route::create([
                'bus_id' => $bus->id,
                'direction' => 'Прямой',
            ]);

            Route::create([
                'bus_id' => $bus->id,
                'direction' => 'Обратный',
            ]);
        }
    }
}
