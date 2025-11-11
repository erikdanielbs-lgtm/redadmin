<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Permiso;
use App\Http\Requests\RolRequest;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->get('buscar', '');
        $ordenar = $request->get('ordenar', 'nuevo');

        if ($buscar) {
            $query = Rol::where('nombre_rol', 'LIKE', "%{$buscar}%");
        } else {
            $query = Rol::query();

            switch ($ordenar) {
                case 'antiguo': $query->orderBy('created_at', 'asc'); break;
                case 'asc': $query->orderBy('nombre_rol', 'asc'); break;
                case 'desc': $query->orderBy('nombre_rol', 'desc'); break;
                default: $query->orderBy('created_at', 'desc'); break; // 'nuevo'
            }
        }
        
        $roles = $query->with('permisos')->paginate(15)->withQueryString();

        return view('roles.listado', compact('roles', 'buscar', 'ordenar'));
    }

    public function create()
    {
        $permisos = Permiso::orderBy('nombre_permiso')->get();
        
        return view('roles.formulario', compact('permisos'));
    }

    public function store(RolRequest $request)
    {
        $data = $request->validated();

        $rol = Rol::create([
            'nombre_rol' => $data['nombre_rol']
        ]);

        $rol->permisos()->attach($data['permisos']);

        return redirect()->route('roles.index')
            ->with('success', 'Rol agregado correctamente.');
    }

    public function edit($id)
    {
        $rol = Rol::findOrFail($id);
        $permisos = Permiso::orderBy('nombre_permiso')->get();
        
        return view('roles.editar', compact('rol', 'permisos'));
    }

    public function update(RolRequest $request, $id)
    {
        $rol = Rol::findOrFail($id);
        $data = $request->validated();

        $rol->update([
            'nombre_rol' => $data['nombre_rol']
        ]);

        // Sincronizamos (sync) los permisos
        $rol->permisos()->sync($data['permisos']);

        return redirect()->route('roles.index')
            ->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Rol eliminado correctamente.');
    }
}