<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = Route::all();

        foreach ($routes as $route) {
            $stops = $route->routeStops()->pluck('stop_id');

            foreach ($stops as $stop) {

                $arrivalTime = Carbon::now()
                    ->addHours(rand(1, 2))    // Случайный час (0-12)
                    ->addMinutes(rand(0, 59));

                for ($i = 0; $i < 5; $i++) { // 5 рейсов на каждую остановку
                    Schedule::firstOrCreate([
                        'route_id' => $route->id,
                        'stop_id' => $stop,
                        'arrival_time' => $arrivalTime->format('H:i'),
                    ]);
                }
            }
        }
    }
}
