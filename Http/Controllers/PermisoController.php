<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Http\Requests\PermisoRequest;
use Illuminate\Http\Request;

class PermisoController extends Controller
{

    public function index(Request $request)
    {
        $buscar = $request->get('buscar', '');
        $ordenar = $request->get('ordenar', 'nuevo');

        if ($buscar) {
            $query = Permiso::where('nombre_permiso', 'LIKE', "%{$buscar}%");
        } else {
            $query = Permiso::query();

            switch ($ordenar) {
                case 'antiguo': $query->orderBy('created_at', 'asc'); break;
                case 'asc': $query->orderBy('nombre_permiso', 'asc'); break;
                case 'desc': $query->orderBy('nombre_permiso', 'desc'); break;
                default: $query->orderBy('created_at', 'desc'); break; // 'nuevo'
            }
        }
        
        $permisos = $query->paginate(15)->withQueryString();

        return view('permisos.listado', compact('permisos', 'buscar', 'ordenar'));
    }


    public function create()
    {
        return view('permisos.formulario');
    }

    public function store(PermisoRequest $request)
    {

        Permiso::create($request->validated());

        return redirect()->route('permisos.index')
            ->with('success', 'Permiso agregado correctamente.');
    }


    public function edit($id)
    {
        $permiso = Permiso::findOrFail($id);
        
        return view('permisos.editar', compact('permiso'));
    }

    public function update(PermisoRequest $request, $id)
    {
        $permiso = Permiso::findOrFail($id);
        
        $permiso->update($request->validated());

        return redirect()->route('permisos.index')
            ->with('success', 'Permiso actualizado correctamente.');
    }

    public function destroy($id)
    {
        $permiso = Permiso::findOrFail($id);
        
        $permiso->delete();

        return redirect()->route('permisos.index')
            ->with('success', 'Permiso eliminado correctamente.');
    }
}