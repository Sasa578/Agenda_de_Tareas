@extends('adminlte::page')

@section('title', 'Editar Tarea')

@section('content_header')
    <h1>Editar Tarea: {{ $tarea->titulo }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('tareas.update', $tarea) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="titulo">Título *</label>
                            <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" 
                                   value="{{ old('titulo', $tarea->titulo) }}" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="materia_id">Materia *</label>
                            <select name="materia_id" id="materia_id" class="form-control @error('materia_id') is-invalid @enderror" required>
                                <option value="">Seleccionar materia</option>
                                @foreach($materias as $materia)
                                    <option value="{{ $materia->id }}" {{ old('materia_id', $tarea->materia_id) == $materia->id ? 'selected' : '' }}>
                                        {{ $materia->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('materia_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" 
                              rows="3">{{ old('descripcion', $tarea->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="prioridad">Prioridad *</label>
                            <select name="prioridad" id="prioridad" class="form-control @error('prioridad') is-invalid @enderror" required>
                                <option value="baja" {{ old('prioridad', $tarea->prioridad) == 'baja' ? 'selected' : '' }}>Baja</option>
                                <option value="media" {{ old('prioridad', $tarea->prioridad) == 'media' ? 'selected' : '' }}>Media</option>
                                <option value="alta" {{ old('prioridad', $tarea->prioridad) == 'alta' ? 'selected' : '' }}>Alta</option>
                            </select>
                            @error('prioridad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_entrega">Fecha Entrega *</label>
                            <input type="datetime-local" name="fecha_entrega" id="fecha_entrega" 
                                   class="form-control @error('fecha_entrega') is-invalid @enderror" 
                                   value="{{ old('fecha_entrega', $tarea->fecha_entrega->format('Y-m-d\TH:i')) }}" required>
                            @error('fecha_entrega')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha Inicio</label>
                            <input type="datetime-local" name="fecha_inicio" id="fecha_inicio" 
                                   class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                   value="{{ old('fecha_inicio', $tarea->fecha_inicio ? $tarea->fecha_inicio->format('Y-m-d\TH:i') : '') }}">
                            @error('fecha_inicio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ubicacion">Ubicación</label>
                            <input type="text" name="ubicacion" id="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" 
                                   value="{{ old('ubicacion', $tarea->ubicacion) }}">
                            @error('ubicacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estado">Estado *</label>
                            <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror" required>
                                <option value="pendiente" {{ old('estado', $tarea->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_progreso" {{ old('estado', $tarea->estado) == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                                <option value="completada" {{ old('estado', $tarea->estado) == 'completada' ? 'selected' : '' }}>Completada</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" name="todo_el_dia" id="todo_el_dia" value="1" 
                               class="form-check-input" {{ old('todo_el_dia', $tarea->todo_el_dia) ? 'checked' : '' }}>
                        <label class="form-check-label" for="todo_el_dia">Evento de todo el día</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar Tarea
                    </button>
                    <a href="{{ route('tareas.show', $tarea) }}" class="btn btn-secondary">
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
                    <p class="text-muted">{{ $tarea->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Última Actualización:</strong>
                    <p class="text-muted">{{ $tarea->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <strong>Recordatorios:</strong>
                    <p class="text-muted">{{ $tarea->recordatorios->count() }} recordatorios</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Toggle campos de fecha/hora según "todo el día"
            $('#todo_el_dia').change(function() {
                const isAllDay = $(this).is(':checked');
                $('#fecha_inicio, #fecha_entrega').attr('type', isAllDay ? 'date' : 'datetime-local');
                
                // Si se marca "todo el día", quitar la hora de las fechas
                if (isAllDay) {
                    const fechaEntrega = $('#fecha_entrega').val().split('T')[0];
                    $('#fecha_entrega').val(fechaEntrega);
                    
                    if ($('#fecha_inicio').val()) {
                        const fechaInicio = $('#fecha_inicio').val().split('T')[0];
                        $('#fecha_inicio').val(fechaInicio);
                    }
                }
            });

            // Trigger change on page load para inicializar correctamente
            $('#todo_el_dia').trigger('change');
        });
    </script>
@stop