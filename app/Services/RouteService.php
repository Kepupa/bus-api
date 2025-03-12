<?php
declare(strict_types=1);

namespace App\Services;


use App\Models\Route;
use App\Models\RouteStop;

class RouteService
{
    public function update($routeId, $stopsId): string
    {

        $route = Route::findOrFail($routeId);

        $route->routeStops()->delete();

        if (count($stopsId) !== count(array_unique($stopsId))) {
            throw new \Exception("Остановки не должны повторяться");
        }


        foreach ($stopsId as $index => $stopId) {
            RouteStop::create([
                'route_id' => $route->id,
                'stop_id' => $stopId,
                'stop_order' => $index,
            ]);
        }

        return "Маршрут обновлён успешно.";
    }
}
