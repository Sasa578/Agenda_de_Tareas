@extends('adminlte::page')

@section('title', 'Dashboard - Agenda de Tareas')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <!-- Estadísticas -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $materiasCount }}</h3>
                    <p>Materias Registradas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <a href="{{ route('materias.index') }}" class="small-box-footer">Ver materias <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $tareasCount }}</h3>
                    <p>Total de Tareas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <a href="{{ route('tareas.index') }}" class="small-box-footer">Ver tareas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $tareasPendientesCount }}</h3>
                    <p>Tareas Pendientes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('tareas.index') }}" class="small-box-footer">Ver pendientes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Tareas Pendientes -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tareas Pendientes</h3>
                </div>
                <div class="card-body">
                    @if($tareasPendientes->count() > 0)
                        <div class="list-group">
                            @foreach($tareasPendientes as $tarea)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $tarea->titulo }}</h5>
                                        <small class="text-{{ $tarea->prioridad == 'alta' ? 'danger' : ($tarea->prioridad == 'media' ? 'warning' : 'success') }}">
                                            {{ ucfirst($tarea->prioridad) }}
                                        </small>
                                    </div>
                                    <p class="mb-1">Materia: {{ $tarea->materia->nombre }}</p>
                                    <small>Entrega: {{ $tarea->fecha_entrega->format('d/m/Y') }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No hay tareas pendientes.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tareas Próximas -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Próximas a Vencer (7 días)</h3>
                </div>
                <div class="card-body">
                    @if($tareasProximas->count() > 0)
                        <div class="list-group">
                            @foreach($tareasProximas as $tarea)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $tarea->titulo }}</h5>
                                        <small class="text-danger">
                                            {{ $tarea->fecha_entrega->diffForHumans() }}
                                        </small>
                                    </div>
                                    <p class="mb-1">Materia: {{ $tarea->materia->nombre }}</p>
                                    <small>Estado: {{ ucfirst(str_replace('_', ' ', $tarea->estado)) }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No hay tareas próximas a vencer.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Dashboard loaded!'); </script>
@stop