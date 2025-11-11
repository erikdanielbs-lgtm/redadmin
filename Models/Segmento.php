<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Segmento extends Model
{
    use Searchable;

    protected $fillable = ['segmento', 'red_id'];

    public function registros()
    {
        return $this->hasMany(Registro::class);
    }

    public function red()
    {
        return $this->belongsTo(Red::class);
    }

    public function toSearchableArray()
    {
        return [
            'segmento' => $this->segmento,
            'red' => $this->red?->direccion_base,
        ];
    }
}


