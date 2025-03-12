<?php

namespace App\Services;

use App\Models\Route;
use App\Models\Schedule;
use App\Models\Stop;
use Carbon\Carbon;

class RouteSearchService
{
    public function search(int $from, int $to): array
    {
        $fromStop = Stop::find($from);
        $toStop = Stop::find($to);

        $routes = Route::whereHas('routeStops', fn ($q) => $q->where('stop_id', $from))
            ->whereHas('routeStops', fn ($q) => $q->where('stop_id', $to))
            ->get();

        $result = [
            'from' => $fromStop->name,
            'to' => $toStop->name,
            'buses' => [],
        ];

        foreach ($routes as $route) {
            $arrivals = Schedule::where('route_id', $route->id)
                ->where('stop_id', $from)
                ->orderBy('arrival_time')
                ->limit(3)
                ->pluck('arrival_time')
                ->map(fn ($time) => Carbon::parse($time)->format('H:i'))
                ->toArray();

            $busNumber = $route->bus->number ?? 'Неизвестно';
            $finalStop = $route->lastStop->stop->name ?? 'Неизвестно';

            $result['buses'][] = [
                'route' => "Автобус No{$busNumber} в сторону ост. {$finalStop}",
                'next_arrivals' => $arrivals,
            ];
        }

        return $result;
    }
}
