<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\RouteStop;
use App\Models\Stop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteStopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = Route::all();
        $stops = Stop::all();

        foreach ($routes as $route) {
            $stopOrder = 1;

            foreach ($stops->random(rand(3, 5)) as $stop) {
                RouteStop::create([
                    'route_id' => $route->id,
                    'stop_id' => $stop->id,
                    'stop_order' => $stopOrder++
                ]);
            }
        }
    }
}
