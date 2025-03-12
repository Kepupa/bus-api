<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\RouteSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RouteSearchController extends Controller
{
    public function search(Request $request, RouteSearchService $service): JsonResponse
    {
        $request->validate([
            'from' => 'required|integer|exists:stops,id',
            'to' => 'required|integer|exists:stops,id',
        ]);

        if ($request->from === $request->to) {
            return response()->json(['error' => 'Остановки отправления и прибытия не могут совпадать'], 400);
        }

        return response()->json($service->search((int)$request->from, (int)$request->to));
    }
}
