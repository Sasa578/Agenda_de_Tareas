@extends('adminlte::page')

@section('title', $tarea->titulo)

@section('content_header')
    <h1>{{ $tarea->titulo }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalles de la Tarea</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Descripción:</strong>
                            <p class="text-muted">{{ $tarea->descripcion ?: 'Sin descripción' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Materia:</strong>
                            @if($tarea->materia)
                                <span class="badge" style="background-color: {{ $tarea->materia->color }}; color: white;">
                                    {{ $tarea->materia->nombre }}
                                </span>
                            @else
                                <span class="badge badge-secondary">Sin materia</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <strong>Fecha Entrega:</strong>
                            <p class="text-muted">{{ $tarea->fecha_entrega->format('d/m/Y H:i') }}</p>
                            @if($tarea->fecha_entrega->isPast() && $tarea->estado != 'completada')
                                <small class="text-danger"><i class="fas fa-exclamation-triangle"></i> Vencida</small>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <strong>Fecha Inicio:</strong>
                            <p class="text-muted">{{ $tarea->fecha_inicio ? $tarea->fecha_inicio->format('d/m/Y H:i') : 'No especificada' }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong>Todo el día:</strong>
                            <p class="text-muted">{{ $tarea->todo_el_dia ? 'Sí' : 'No' }}</p>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <strong>Prioridad:</strong>
                            @php
                                $prioridadColors = [
                                    'alta' => 'danger',
                                    'media' => 'warning',
                                    'baja' => 'success'
                                ];
                            @endphp
                            <span class="badge badge-{{ $prioridadColors[$tarea->prioridad] }}">
                                {{ ucfirst($tarea->prioridad) }}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <strong>Estado:</strong>
                            <span class="badge badge-{{ $tarea->estado == 'completada' ? 'success' : ($tarea->estado == 'en_progreso' ? 'warning' : 'secondary') }}">
                                {{ ucfirst(str_replace('_', ' ', $tarea->estado)) }}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <strong>Ubicación:</strong>
                            <p class="text-muted">{{ $tarea->ubicacion ?: 'No especificada' }}</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <strong>Fecha de Creación:</strong>
                            <p class="text-muted">{{ $tarea->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Última Actualización:</strong>
                            <p class="text-muted">{{ $tarea->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <a href="{{ route('tareas.edit', $tarea) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('tareas.destroy', $tarea) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta tarea?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                        @if($tarea->estado != 'completada')
                            <form action="{{ route('tareas.completar', $tarea) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Marcar como Completada
                                </button>
                            </form>
                        @else
                            <form action="{{ route('tareas.pendiente', $tarea) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-undo"></i> Marcar como Pendiente
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('tareas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Recordatorios -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recordatorios</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($recordatorios->count() > 0)
                        <div class="list-group">
                            @foreach($recordatorios as $recordatorio)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $recordatorio->mensaje }}</h6>
                                        <small class="{{ $recordatorio->enviado ? 'text-success' : 'text-warning' }}">
                                            {{ $recordatorio->enviado ? 'Enviado' : 'Pendiente' }}
                                        </small>
                                    </div>
                                    <small>Fecha: {{ $recordatorio->fecha_recordatorio->format('d/m/Y H:i') }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No hay recordatorios para esta tarea.</p>
                    @endif
                </div>
            </div>

            <!-- Información Rápida -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Información Rápida</h3>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="far fa-calendar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Días Restantes</span>
                            <span class="info-box-number">
                                @if($tarea->estado == 'completada')
                                    <span class="text-success">Completada</span>
                                @else
                                    {{ $tarea->fecha_entrega->diffForHumans() }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-box-icon bg-{{ $prioridadColors[$tarea->prioridad] }}"><i class="fas fa-exclamation"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Prioridad</span>
                            <span class="info-box-number">{{ ucfirst($tarea->prioridad) }}</span>
                        </div>
                    </div>

                    @if($tarea->ubicacion)
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-map-marker-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Ubicación</span>
                            <span class="info-box-number">{{ $tarea->ubicacion }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .info-box {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            border-radius: .25rem;
            background: #fff;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 1rem;
            min-height: 80px;
            padding: .5rem;
            position: relative;
        }
        .info-box .info-box-icon {
            border-radius: .25rem;
            -ms-flex-align: center;
            align-items: center;
            display: -ms-flexbox;
            display: flex;
            font-size: 1.875rem;
            -ms-flex-pack: center;
            justify-content: center;
            text-align: center;
            width: 70px;
        }
        .info-box .info-box-content {
            -ms-flex: 1;
            flex: 1;
            padding: 5px 10px;
        }
        .info-box .info-box-text {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .info-box .info-box-number {
            display: block;
            margin-top: .25rem;
            font-weight: 700;
        }
    </style>
@stop