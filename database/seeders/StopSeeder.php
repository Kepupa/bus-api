<?php

namespace Database\Seeders;

use App\Models\Stop;
use Illuminate\Database\Seeder;

class StopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stop::query()->delete();

        $stops = ['ул. Ленина', 'ул. Оушен-драйв', 'ост. Хорошей жизни', 'пл. Революции', 'ул. Стетхема'];

        foreach ($stops as $stop) {
            Stop::create(['name' => $stop]);
        }
    }
}
