@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card p-4 shadow-lg">
            <h3 class="text-center mb-4">
               <i class="bi bi-pencil-square"></i> Editar Usuario
            </h3>

            <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text"
                           name="nombre"
                           class="form-control rounded-pill @error('nombre') is-invalid @enderror"
                           maxlength="100"
                           value="{{ old('nombre', $usuario->nombre) }}"
                           required>
                    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Código</label>
                    <input type="number"
                           name="codigo"
                           class="form-control rounded-pill @error('codigo') is-invalid @enderror"
                           value="{{ old('codigo', $usuario->codigo) }}"
                           required>
                    @error('codigo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña (opcional)</label>
                    <input type="password"
                           name="password"
                           class="form-control rounded-pill @error('password') is-invalid @enderror"
                           minlength="6"
                           placeholder="Dejar en blanco para no cambiar">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmar Contraseña</label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control rounded-pill"
                           minlength="6"
                           placeholder="Confirmar solo si cambias la contraseña">
                </div>

                <div class="mb-3">
                    <label class="form-label">Dependencia</label>
                    <select name="dependencia_id"
                            class="form-select rounded-pill @error('dependencia_id') is-invalid @enderror"
                            required>
                        <option value="">Selecciona una dependencia</option>
                        @foreach($dependencias as $dep)
                            <option value="{{ $dep->id }}" {{ old('dependencia_id', $usuario->dependencia_id) == $dep->id ? 'selected' : '' }}>
                                {{ $dep->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('dependencia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="text-center d-flex justify-content-center gap-2">
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                       <i class="bi bi-box-arrow-in-up"></i> Actualizar
                    </button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-success rounded-pill px-4">
                        <i class="bi bi-card-list"></i> Ver Listado
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
