<?php

namespace Database\Factories;

use App\Models\LockDown;
use App\Enums\LockDownStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class LockDownFactory extends Factory
{
    protected $model = LockDown::class;

    public function definition()
    {
        // Opcionalmente genera fechas con cierta lógica (e.g., endedAt después de createdAt si está finalizado)
        $createdAt = $this->faker->dateTimeBetween('-1 month', 'now');
        $status = $this->faker->randomElement(LockDownStatus::getValues());

        return [
            'createdAt' => $createdAt,
            'endedAt' => $status === LockDownStatus::ENDED ? $this->faker->dateTimeBetween($createdAt, 'now') : null,
            'status' => $status,
            'reason' => $this->faker->sentence
        ];
    }
}
