<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\LockDownStatus; // Asegúrate de adaptar el Enum a las convenciones de Laravel/PHP

class LockDown extends Model
{
    protected $table = 'lock_downs'; // Asegúrate de que el nombre de la tabla coincida con tu esquema de base de datos

    protected $fillable = [
        'createdAt',
        'endedAt',
        'status',
        'reason',
    ];

    protected $casts = [
        'createdAt' => 'datetime:Y-m-d H:i:s',
        'endedAt' => 'datetime:Y-m-d H:i:s',
        'status' => LockDownStatus::class,
    ];

    protected $dates = [
        'createdAt',
        'endedAt',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        // Establece valores predeterminados aquí si es necesario
        $this->attributes['createdAt'] = $this->attributes['createdAt'] ?? now();
    }

    // Considera si necesitas métodos personalizados para manejar la lógica de negocio, como el cambio de estado
    public function endLockDown()
    {
        if ($this->status !== LockDownStatus::ENDED) {
            $this->status = LockDownStatus::ENDED;
            $this->endedAt = now();
            $this->save();
        }
    }
}
