<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\HealthStatus; // Suponiendo que HealthStatus es un enum de PHP 8.1 o superior.

class Dinosaur extends Model
{
    protected $table = 'dinosaurs'; // Nombre de la tabla si no sigue la convención de nombres de Laravel

    protected $fillable = [
        'name',
        'genus',
        'length',
        'enclosure',
        'health',
    ];

    protected $casts = [
        'health' => HealthStatus::class,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        // Si necesitas inicializar propiedades predeterminadas, hazlo aquí.
    }

    public function sizeDescription(): string
    {
        if ($this->length >= 10) {
            return 'Large';
        }

        if ($this->length >= 5) {
            return 'Medium';
        }

        return 'Small';
    }

    public function isAcceptingVisitors(): bool
    {
        return $this->health !== HealthStatus::SICK;
    }
}
