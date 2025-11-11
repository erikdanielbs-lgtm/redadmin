<?php

namespace App\Http\Controllers;

use App\Http\Requests\RedRequest;
use App\Models\Red;
use Illuminate\Http\Request;

class RedController extends Controller
{

    public function index(Request $request)
    {
        $buscar = $request->get('buscar', '');
        $ordenar = $request->get('ordenar', 'nuevo');

        if ($buscar) {
            $redes = Red::search($buscar)->paginate(15);
        } else {
            $query = Red::query();

            switch ($ordenar) {
                case 'antiguo':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'asc':
                    $query->orderBy('direccion_base', 'asc');
                    break;
                case 'desc':
                    $query->orderBy('direccion_base', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            $redes = $query->paginate(15)->withQueryString();
        }

        return view('redes.listado', compact('redes', 'buscar', 'ordenar'));
    }

    public function create()
    {
        return view('redes.formulario');
    }

    /**
     * Procesa el string de hosts_reservados (ej. "1, 126, 500")
     * y lo convierte en un array filtrado y válido (ej. [1, 126]).
     */
    private function procesarHostsReservados(array $data): array
    {
        if (isset($data['hosts_reservados']) && is_string($data['hosts_reservados'])) {
            $hosts = array_map(
                'intval', // Convertir cada item a entero
                array_filter( // Quitar items vacíos (ej. si ponen '1,,2')
                    array_map('trim', explode(',', $data['hosts_reservados'])) // Separar por coma y quitar espacios
                )
            );
            
            // Filtrar para que sean únicos y estén en el rango 1-255
            $data['hosts_reservados'] = array_unique(
                array_filter($hosts, fn($h) => $h >= 1 && $h <= 255)
            );
        } else {
            // Si no se envió o está vacío, guardar como un array vacío
            $data['hosts_reservados'] = [];
        }
        
        return $data;
    }

    public function store(RedRequest $request)
    {
        // 1. Obtenemos los datos YA validados Y normalizados desde RedRequest
        $data = $request->validated();
        
        // 2. Solo necesitamos procesar los hosts reservados (esto no se normalizó en el request)
        $data = $this->procesarHostsReservados($data);

        // 3. Creamos directamente.
        // Ya no hay que normalizar 'direccion_base' ni 'usa_segmentos' aquí.
        Red::create($data); 

        return redirect()
            ->route('redes.index')
            ->with('success', 'Red registrada correctamente.');
    }


    public function edit($id)
    {
        $red = Red::findOrFail($id);
        return view('redes.editar', compact('red'));
    }

    public function update(RedRequest $request, $id)
    {
        $red = Red::findOrFail($id);

        // 1. Obtenemos los datos YA validados Y normalizados desde RedRequest
        $data = $request->validated();
        
        // 2. Solo necesitamos procesar los hosts reservados
        $data = $this->procesarHostsReservados($data);

        // 3. Actualizamos directamente.
        // Ya no hay que normalizar 'direccion_base' ni 'usa_segmentos' aquí.
        $red->update($data); 

        return redirect()
            ->route('redes.index')
            ->with('success', 'Red actualizada correctamente.');
    }

    public function destroy($id)
    {
        $red = Red::findOrFail($id);
        $red->delete();

        return redirect()
            ->route('redes.index')
            ->with('success', 'Red eliminada correctamente.');
    }
}