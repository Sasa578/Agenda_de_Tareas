@extends('adminlte::page')

@section('title', 'Crear Tarea')

@section('content_header')
    <h1>Crear Nueva Tarea</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('tareas.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="titulo">Título *</label>
                            <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" 
                                   value="{{ old('titulo') }}" required>
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
                                    <option value="{{ $materia->id }}" {{ old('materia_id') == $materia->id ? 'selected' : '' }}>
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
                              rows="3">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="prioridad">Prioridad *</label>
                            <select name="prioridad" id="prioridad" class="form-control @error('prioridad') is-invalid @enderror" required>
                                <option value="baja" {{ old('prioridad') == 'baja' ? 'selected' : '' }}>Baja</option>
                                <option value="media" {{ old('prioridad') == 'media' || !old('prioridad') ? 'selected' : '' }}>Media</option>
                                <option value="alta" {{ old('prioridad') == 'alta' ? 'selected' : '' }}>Alta</option>
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
                                   value="{{ old('fecha_entrega') }}" required>
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
                                   value="{{ old('fecha_inicio') }}">
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
                                   value="{{ old('ubicacion') }}">
                            @error('ubicacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-check mt-4">
                                <input type="checkbox" name="todo_el_dia" id="todo_el_dia" value="1" 
                                       class="form-check-input" {{ old('todo_el_dia') ? 'checked' : '' }}>
                                <label class="form-check-label" for="todo_el_dia">Evento de todo el día</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" name="crear_recordatorio" id="crear_recordatorio" value="1" 
                               class="form-check-input" {{ old('crear_recordatorio') ? 'checked' : '' }}>
                        <label class="form-check-label" for="crear_recordatorio">Crear recordatorio automático</label>
                    </div>
                </div>

                <div class="form-group" id="recordatorio_field" style="display: none;">
                    <label for="fecha_recordatorio">Fecha Recordatorio</label>
                    <input type="datetime-local" name="fecha_recordatorio" id="fecha_recordatorio" 
                           class="form-control" value="{{ old('fecha_recordatorio') }}">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Crear Tarea
                    </button>
                    <a href="{{ route('tareas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Mostrar/ocultar campo de recordatorio
            $('#crear_recordatorio').change(function() {
                if ($(this).is(':checked')) {
                    $('#recordatorio_field').show();
                } else {
                    $('#recordatorio_field').hide();
                }
            });

            // Trigger change on page load
            $('#crear_recordatorio').trigger('change');

            // Set default reminder time (24 hours before due date)
            $('#fecha_entrega').change(function() {
                if (!$('#fecha_recordatorio').val()) {
                    const dueDate = new Date($(this).val());
                    dueDate.setHours(dueDate.getHours() - 24);
                    $('#fecha_recordatorio').val(dueDate.toISOString().slice(0, 16));
                }
            });
        });
    </script>
@stop