<?php

namespace App\Http\Controllers;

use App\Services\RouteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function update(Request $request, RouteService $service, int $id): JsonResponse
    {
        $request->validate([
            'stops' => 'required|array|min:2    ',
            'stops.*' => 'integer|exists:stops,id',
        ]);

        if (count($request->stops) !== count(array_unique($request->stops))) {
            return response()->json(['error' => 'Маршрут не может содержать дублирующиеся остановки'], 400);
        }

        $message = $service->update($id, $request->stops);

        return response()->json(["message" => $message]);
    }
}
