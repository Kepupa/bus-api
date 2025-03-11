<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {

        Schedule::query()->delete();

        $routes = Route::all();

        foreach ($routes as $route) {
            $stops = $route->routeStops()->pluck('stop_id');

            foreach ($stops as $stop) {

                $arrivalTime = Carbon::today()->addHours(5);

                for ($i = 0; $i < 5; $i++) {
                    Schedule::create([
                        'route_id' => $route->id,
                        'stop_id' => $stop,
                        'arrival_time' => $arrivalTime->format('H:i'),
                    ]);

                    // Следующий рейс с разбросом в 30-90 минут
                    $arrivalTime->addMinutes(rand(30, 90));
                }
            }
        }
    }
}
