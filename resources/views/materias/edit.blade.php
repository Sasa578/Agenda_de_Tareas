@extends('adminlte::page')

@section('title', 'Editar Materia')

@section('content_header')
    <h1>Editar Materia: {{ $materia->nombre }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('materias.update', $materia) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="nombre">Nombre de la Materia *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                           value="{{ old('nombre', $materia->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="codigo">Código de la Materia *</label>
                    <input type="text" name="codigo" id="codigo" class="form-control @error('codigo') is-invalid @enderror" 
                           value="{{ old('codigo', $materia->codigo) }}" required>
                    @error('codigo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="color">Color de Identificación *</label>
                    <div class="input-group">
                        <input type="color" name="color" id="color" class="form-control @error('color') is-invalid @enderror" 
                               value="{{ old('color', $materia->color) }}" required style="height: 45px;">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                Color actual: <span class="badge ml-2" style="background-color: {{ $materia->color }}; color: white;">{{ $materia->color }}</span>
                            </span>
                        </div>
                    </div>
                    @error('color')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" 
                              rows="4">{{ old('descripcion', $materia->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar Materia
                    </button>
                    <a href="{{ route('materias.show', $materia) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Información Adicional -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Información Adicional</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <strong>Fecha de Creación:</strong>
                    <p class="text-muted">{{ $materia->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Última Actualización:</strong>
                    <p class="text-muted">{{ $materia->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <strong>Tareas asociadas:</strong>
                    <p class="text-muted">{{ $materia->tareas->count() }} tareas</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Actualizar el badge de color cuando cambie el color picker
            $('#color').change(function() {
                const newColor = $(this).val();
                $('.input-group-text .badge').css('background-color', newColor).text(newColor);
            });
        });
    </script>
@stop