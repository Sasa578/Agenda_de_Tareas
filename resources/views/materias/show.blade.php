@extends('adminlte::page')

@section('title', $materia->nombre)

@section('content_header')
    <h1>{{ $materia->nombre }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color: {{ $materia->color }}; color: white;">
                    <h3 class="card-title">Información de la Materia</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Código:</strong>
                            <p class="text-muted">{{ $materia->codigo }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Color:</strong>
                            <p>
                                <span class="badge" style="background-color: {{ $materia->color }}; color: white; padding: 8px 15px;">
                                    {{ $materia->color }}
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <strong>Descripción:</strong>
                            <p class="text-muted">{{ $materia->descripcion ?: 'Sin descripción' }}</p>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <strong>Fecha de Creación:</strong>
                            <p class="text-muted">{{ $materia->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong>Última Actualización:</strong>
                            <p class="text-muted">{{ $materia->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <a href="{{ route('materias.edit', $materia) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('materias.destroy', $materia) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta materia? Se eliminarán todas las tareas asociadas.')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                        <a href="{{ route('materias.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Estadísticas de la Materia -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Estadísticas</h3>
                </div>
                <div class="card-body">
                    @php
                        $totalTareas = $materia->tareas->count();
                        $tareasPendientes = $materia->tareas->where('estado', 'pendiente')->count();
                        $tareasEnProgreso = $materia->tareas->where('estado', 'en_progreso')->count();
                        $tareasCompletadas = $materia->tareas->where('estado', 'completada')->count();
                    @endphp
                    
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalTareas }}</h3>
                            <p>Total de Tareas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                    </div>

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $tareasPendientes }}</h3>
                            <p>Tareas Pendientes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>

                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $tareasEnProgreso }}</h3>
                            <p>En Progreso</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-spinner"></i>
                        </div>
                    </div>

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $tareasCompletadas }}</h3>
                            <p>Completadas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tareas Recientes -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Tareas Recientes</h3>
                </div>
                <div class="card-body">
                    @if($tareas->count() > 0)
                        <div class="list-group">
                            @foreach($tareas->take(5) as $tarea)
                                <a href="{{ route('tareas.show', $tarea) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $tarea->titulo }}</h6>
                                        <small class="text-{{ $tarea->fecha_entrega->isPast() && $tarea->estado != 'completada' ? 'danger' : 'muted' }}">
                                            {{ $tarea->fecha_entrega->format('d/m') }}
                                        </small>
                                    </div>
                                    <p class="mb-1">
                                        <span class="badge badge-{{ $tarea->estado == 'completada' ? 'success' : ($tarea->estado == 'en_progreso' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst(str_replace('_', ' ', $tarea->estado)) }}
                                        </span>
                                        <span class="badge badge-{{ $tarea->prioridad == 'alta' ? 'danger' : ($tarea->prioridad == 'media' ? 'warning' : 'success') }}">
                                            {{ ucfirst($tarea->prioridad) }}
                                        </span>
                                    </p>
                                </a>
                            @endforeach
                        </div>
                        @if($tareas->count() > 5)
                            <div class="text-center mt-2">
                                <a href="{{ route('tareas.index') }}?materia={{ $materia->id }}" class="btn btn-sm btn-outline-primary">
                                    Ver todas las tareas
                                </a>
                            </div>
                        @endif
                    @else
                        <p class="text-muted">No hay tareas para esta materia.</p>
                        <a href="{{ route('tareas.create') }}?materia_id={{ $materia->id }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Crear primera tarea
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop