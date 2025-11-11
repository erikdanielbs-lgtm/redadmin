@extends('layouts.app')

@section('title', 'Insertar Nueva IP')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card p-4 shadow-lg">
            <h3 class="text-center mb-4">
                <i class="bi bi-plus-circle me-1"></i> Insertar Nueva IP
            </h3>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show alert-auto-hide" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @php
                $ipSeleccionada = $ipSeleccionada ?? old('ip');
                $segmentoSeleccionado = $segmentoSeleccionado ?? old('segmento_id');
                $redSeleccionada = $redSeleccionada ?? old('red_id');
                $dispositivoSeleccionado = $dispositivoSeleccionado ?? old('tipo_dispositivo_id');
            @endphp

            <form method="POST" action="{{ route('registros.store') }}">
                @csrf

                {{-- RED --}}
                <div class="mb-3">
                    <label class="form-label">Red</label>
                    <select name="red_id" id="red_id"
                            class="form-select rounded-pill @error('red_id') is-invalid @enderror"
                            required>
                        <option value="">Seleccionar red</option>
                        @foreach ($redes as $r)
                            <option value="{{ $r->id }}"
                                    data-usa-segmentos="{{ $r->usa_segmentos ? '1' : '0' }}"
                                    data-base="{{ $r->direccion_base }}"
                                    {{ $redSeleccionada == $r->id ? 'selected' : '' }}>
                                {{ $r->direccion_completa }}
                            </option>
                        @endforeach
                    </select>
                    @error('red_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- SEGMENTO --}}
                <div class="mb-3" id="segmento_container">
                    <label class="form-label">Segmento</label>
                    <select name="segmento_id" id="segmento_id"
                            class="form-select rounded-pill @error('segmento_id') is-invalid @enderror">
                        <option value="">Seleccionar segmento</option>
                        @foreach ($segmentos as $seg)
                            <option value="{{ $seg->id }}"
                                    data-seg="{{ $seg->segmento }}"
                                    {{ $segmentoSeleccionado == $seg->id ? 'selected' : '' }}>
                                {{ $seg->segmento }}
                            </option>
                        @endforeach
                    </select>
                    @error('segmento_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- TIPO DE DISPOSITIVO --}}
                <div class="mb-3">
                    <label class="form-label">Tipo de Dispositivo</label>
                    <select name="tipo_dispositivo_id" id="tipo_dispositivo_id"
                            class="form-select rounded-pill @error('tipo_dispositivo_id') is-invalid @enderror"
                            required>
                        <option value="">Seleccionar tipo de dispositivo</option>
                        @foreach ($dispositivos as $disp)
                            <option value="{{ $disp->id }}"
                                    data-red-id="{{ $disp->red_id }}" {{-- Añadido para el JS --}}
                                    {{ $dispositivoSeleccionado == $disp->id ? 'selected' : '' }}>
                                {{ $disp->tipo_dispositivo }}
                            </option>
                            @endforeach
                    </select>
                    @error('tipo_dispositivo_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- IP --}}
                <div class="mb-3">
                    <label class="form-label">Dirección IP</label>
                    <input type="text" name="ip" id="ip"
                           class="form-control rounded-pill @error('ip') is-invalid @enderror"
                           placeholder="Ej: 192.168.x.x"
                           value="{{ $ipSeleccionada }}"
                           required>
                    @error('ip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- ... (Resto de campos: MAC, N° Serie, Descripción, Responsable, Dependencia sin cambios) ... --}}
                {{-- MAC --}}
                <div class="mb-3">
                    <label class="form-label">Dirección MAC</label>
                    <input type="text" name="mac"
                           class="form-control rounded-pill @error('mac') is-invalid @enderror"
                           placeholder="00:1A:2B:3C:4D:5E"
                           value="{{ old('mac') }}"
                           required>
                    @error('mac') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- NUMERO DE SERIE --}}
                <div class="mb-3">
                    <label class="form-label">Número de Serie</label>
                    <input type="text" name="numero_serie"
                           class="form-control rounded-pill @error('numero_serie') is-invalid @enderror"
                           maxlength="100"
                           value="{{ old('numero_serie') }}"
                           required>
                    @error('numero_serie') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- DESCRIPCION --}}
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <input type="text" name="descripcion"
                           class="form-control rounded-pill @error('descripcion') is-invalid @enderror"
                           maxlength="255"
                           value="{{ old('descripcion') }}">
                    @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- RESPONSABLE --}}
                <div class="mb-3">
                    <label class="form-label">Responsable</label>
                    <input type="text" name="responsable"
                           class="form-control rounded-pill @error('responsable') is-invalid @enderror"
                           maxlength="100"
                           value="{{ old('responsable') }}">
                    @error('responsable') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- DEPENDENCIA --}}
                <div class="mb-3">
                    <label class="form-label">Dependencia</label>
                    <select name="dependencia_id"
                            class="form-select rounded-pill @error('dependencia_id') is-invalid @enderror"
                            required>
                        <option value="">Seleccionar dependencia</option>
                        @foreach ($dependencias as $dep)
                            <option value="{{ $dep->id }}" {{ old('dependencia_id') == $dep->id ? 'selected' : '' }}>
                                {{ $dep->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('dependencia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>


                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="bi bi-save me-1"></i> Guardar
                    </button>
                    <a href="{{ route('registros.ocupadas') }}" class="btn btn-success rounded-pill px-4">
                        <i class="bi bi-router"></i> Ver ocupadas
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const redSelect = document.getElementById('red_id');
    const segmentoSelect = document.getElementById('segmento_id');
    const ipInput = document.getElementById('ip');
    const segmentoContainer = document.getElementById('segmento_container');

    // --- 🟢 NUEVO ---
    const dispositivoSelect = document.getElementById('tipo_dispositivo_id');
    // Guardar una copia de todas las opciones de dispositivos (excepto la primera "Seleccionar...")
    const todasLasOpcionesDisp = Array.from(dispositivoSelect.options).slice(1);
    // --- 🟢 FIN NUEVO ---

    let ipPrefijo = ''; // Mantiene el prefijo actual válido

    // Deshabilitar campo IP hasta que se elija red/segmento válidos
    function bloquearIP() {
        ipInput.value = '';
        ipInput.disabled = true;
        ipPrefijo = '';
        ipInput.placeholder = 'Selecciona red y segmento primero';
    }

    // Activar y autocompletar IP según red/segmento
    function actualizarIP() {
        const selectedRed = redSelect.selectedOptions[0];
        const base = selectedRed?.dataset.base || '';
        const usaSegmentos = selectedRed?.dataset.usaSegmentos === '1';
        const segText = segmentoSelect.selectedOptions[0]?.dataset.seg || '';

        if (!base) {
            bloquearIP();
            return;
        }

        // Si la red usa segmentos y aún no se eligió, bloquear
        if (usaSegmentos && !segText) {
            bloquearIP();
            return;
        }

        // Construir prefijo
        ipPrefijo = usaSegmentos ? `${base}.${segText}.` : `${base}.`;

        ipInput.disabled = false;
        ipInput.placeholder = `Ej: ${ipPrefijo}X`;

        // Si el valor no coincide con el prefijo actual, reemplazarlo
        if (!ipInput.value.startsWith(ipPrefijo)) {
            ipInput.value = ipPrefijo;
        }
    }

    // --- 🟢 NUEVO ---
    // Controla las opciones del selector de dispositivo
    function actualizarDispositivos() {
        const selectedRedId = redSelect.value;
        const valorSeleccionadoAnterior = dispositivoSelect.value;
        
        dispositivoSelect.innerHTML = ''; // Limpiar opciones
        dispositivoSelect.add(new Option('Seleccionar tipo de dispositivo', '')); // Añadir la opción default

        let seEncontroElAnterior = false;

        // Filtrar y añadir solo las opciones que coinciden con la red
        todasLasOpcionesDisp.forEach(option => {
            // Comparamos el data-attribute con el ID de la red seleccionada
            if (!selectedRedId || option.dataset.redId === selectedRedId) {
                const nuevaOpcion = option.cloneNode(true);
                
                if (nuevaOpcion.value === valorSeleccionadoAnterior) {
                    nuevaOpcion.selected = true;
                    seEncontroElAnterior = true;
                }
                dispositivoSelect.add(nuevaOpcion);
            }
        });

        if (!seEncontroElAnterior) {
            dispositivoSelect.value = '';
        }

        // Si no hay red seleccionada, deshabilitar y limpiar
        dispositivoSelect.disabled = !selectedRedId;
        if (!selectedRedId) {
            dispositivoSelect.value = '';
        }
    }
    // --- 🟢 FIN NUEVO ---

    // Controla la visibilidad del selector de segmento
    function actualizarSegmento() {
        const selectedRed = redSelect.selectedOptions[0];
        const usaSegmentos = selectedRed?.dataset.usaSegmentos === '1';
        segmentoContainer.style.display = usaSegmentos ? 'block' : 'none';

        if (!usaSegmentos) {
            segmentoSelect.value = '';
        }
        actualizarIP(); // <== Esta llamada estaba en tu código original y es correcta
    }

    // Impedir que el usuario borre o cambie el prefijo IP
    ipInput.addEventListener('input', () => {
        if (!ipPrefijo) return;
        if (!ipInput.value.startsWith(ipPrefijo)) {
            ipInput.value = ipPrefijo;
        }
    });

    // Listeners
    redSelect.addEventListener('change', function() {
        actualizarSegmento(); // Esto ya llama a actualizarIP()
        actualizarDispositivos(); // --- 🟢 NUEVO ---
    });

    segmentoSelect.addEventListener('change', actualizarIP);

    // Inicializar al cargar
    actualizarSegmento();
    actualizarDispositivos(); // --- 🟢 NUEVO ---
});
</script>
@endpush

@endsection