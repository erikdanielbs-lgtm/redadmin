<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\Usuario;
use App\Models\Dependencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->get('buscar', '');
        $ordenar = $request->get('ordenar', 'asc');

        if ($buscar) {
            $usuarios = Usuario::search($buscar)
                ->paginate(15);
        } else {
            $query = Usuario::with('dependencia');
            switch ($ordenar) {
                case 'antiguo':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'asc':
                    $query->orderBy('nombre', 'asc');
                    break;
                case 'desc':
                    $query->orderBy('nombre', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
            $usuarios = $query->paginate(15)->withQueryString();
        }

        return view('usuarios.listado', [
            'usuarios' => $usuarios,
            'buscar' => $buscar,
            'ordenar' => $ordenar,
        ]);
    }

    public function create()
    {
        $dependencias = Dependencia::orderBy('nombre')->get();
        return view('usuarios.formulario', compact('dependencias'));
    }

    public function store(UsuarioRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        Usuario::create($data);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario agregado correctamente.');
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $dependencias = Dependencia::orderBy('nombre')->get();
        return view('usuarios.editar', compact('usuario', 'dependencias'));
    }

    public function update(UsuarioRequest $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data['password'] = $usuario->password;
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado.');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado.');
    }
}

