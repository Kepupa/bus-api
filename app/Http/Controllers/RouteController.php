<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RouteStop;
use App\Models\Schedule;
use App\Models\Stop;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'from' => 'required|integer|exists:stops,id',
            'to' => 'required|integer|exists:stops,id',
        ]);

        $fromStop = Stop::find($request->from);
        $toStop = Stop::find($request->to);

        if (!$fromStop || !$toStop) {
            return response()->json(['error' => 'Остановки не найдены'], 400);
        }

        $routes = Route::whereHas('routeStops', function ($query) use ($request) {
            $query->where('stop_id', $request->from);
        })->whereHas('routeStops', function ($query) use ($request) {
            $query->where('stop_id', $request->to);
        })->get();

        $result = [
            "from" => $fromStop->name,
            "to" => $toStop->name,
            "buses" => []
        ];

        $busData = [];

        foreach ($routes as $route) {
            $arrivals = Schedule::where('route_id', $route->id)
                ->where('stop_id', $request->from)
                ->orderBy('arrival_time')
                ->limit(3)
                ->pluck('arrival_time')
                ->map(fn($time) => Carbon::parse($time)->format('H:i'))
                ->toArray();

            $busNumber = $route->bus->number;

            if (isset($busData[$busNumber])) {
                $busData[$busNumber]['next_arrivals'] = array_merge($busData[$busNumber]['next_arrivals'], $arrivals);
                $busData[$busNumber]['next_arrivals'] = array_unique($busData[$busNumber]['next_arrivals']); // Убираем дубли
                sort($busData[$busNumber]['next_arrivals']); // Сортируем по времени
            } else {
                // Если автобуса ещё нет, добавляем новый маршрут
                $busData[$busNumber] = [
                    "route" => "Автобус No{$route->bus->number} в сторону ост. {$route->lastStop->stop->name}",
                    "next_arrivals" => $arrivals
                ];
            }

        }
        $result['buses'] = array_values($busData);

        return response()->json($result);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'stops' => 'required|array|min:2',
            'stops.*' => 'integer|exists:stops,id'
        ]);

        $route = Route::findOrFail($id);


        $route->routeStops()->delete();


        foreach ($request->stops as $index => $stopId) {
            RouteStop::create([
                'route_id' => $route->id,
                'stop_id' => $stopId,
                'stop_order' => $index
            ]);
        }

        return response()->json(["message" => "Маршрут обновлён успешно."]);
    }


}
