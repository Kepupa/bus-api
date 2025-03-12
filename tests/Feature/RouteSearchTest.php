<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteSearchTest extends TestCase
{
    /**
     * Проверка, что корневой маршрут API работает.
     */
    public function test_api_root_responds_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200); // Проверяем, что сервер отвечает 200 OK
    }

    public function test_find_bus_requires_parameters(): void
    {
        $response = $this->getJson('/api/routes/find-bus');

        $response->assertStatus(422) // Ожидаем ошибку валидации
        ->assertJsonValidationErrors(['from', 'to']); // Проверяем, что не хватает параметров
    }

    public function test_find_bus_returns_eror(): void
    {
        $response = $this->getJson('/api/routes/find-bus?from=1&to=1');

        $response->assertStatus(400)
            ->assertJson(['error' => 'Остановки отправления и прибытия не могут совпадать']);
    }

}

