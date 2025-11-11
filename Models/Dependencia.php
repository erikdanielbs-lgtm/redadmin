<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Dependencia extends Model
{
    use Searchable;

    protected $fillable = ['nombre'];

    public function registros()
    {
        return $this->hasMany(Registro::class);
    }

    public function toSearchableArray()
    {
        return [
            'nombre' => $this->nombre,
        ];
    }
}
