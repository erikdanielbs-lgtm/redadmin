<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class Usuario extends Authenticatable
{
    use Notifiable, Searchable;

    protected $fillable = ['nombre', 'codigo', 'password', 'dependencia_id', 'imagen'];

    protected $hidden = ['password'];

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_usuario');
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function toSearchableArray()
    {
        return [
            'nombre' => $this->nombre,
            'codigo' => $this->codigo,
            'dependencia' => $this->dependencia?->nombre,
        ];
    }


    public function hasPermissionTo($nombrePermiso): bool
    {
        // Recorre cada rol que tiene el usuario (ej. "Admin", "Editor")
        foreach ($this->roles as $rol) {
            
            //Revisa si la colección de permisos de ese rol
            //contiene el permiso que estamos buscando.
            if ($rol->permisos->contains('nombre_permiso', $nombrePermiso)) {
                return true;
            }
        }
        
        return false;
    }
}
