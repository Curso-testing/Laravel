<?php

namespace App\Repositories;

use App\Models\Dinosaur;

class DinosaurRepository
{
    public function find($id)
    {
        return Dinosaur::find($id);
    }

    public function findAll()
    {
        return Dinosaur::all();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $query = Dinosaur::query();

        foreach ($criteria as $field => $value) {
            $query->where($field, $value);
        }

        if ($orderBy) {
            foreach ($orderBy as $field => $direction) {
                $query->orderBy($field, $direction);
            }
        }

        if ($limit) {
            $query->limit($limit);
        }

        if ($offset) {
            $query->offset($offset);
        }

        return $query->get();
    }

    public function save(Dinosaur $dinosaur, bool $flush = false)
    {
        $dinosaur->save();

        if ($flush) {
            // En Laravel, el método save() ya persiste y guarda el modelo en la base de datos,
            // por lo que normalmente no necesitas hacer nada adicional para "flushear".
        }
    }
}
