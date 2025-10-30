@extends('adminlte::page')

@section('title', 'Mis Tareas')

@section('content_header')
    <h1>Mis Tareas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('tareas.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nueva Tarea
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="float-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['estado' => '']) }}">Todas</a>
                                <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['estado' => 'pendiente']) }}">Pendientes</a>
                                <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['estado' => 'en_progreso']) }}">En Progreso</a>
                                <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['estado' => 'completada']) }}">Completadas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($tareas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Materia</th>
                                <th>Fecha Entrega</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tareas as $tarea)
                                <tr>
                                    <td>
                                        <strong>{{ $tarea->titulo }}</strong>
                                        @if($tarea->descripcion)
                                            <br><small class="text-muted">{{ Str::limit($tarea->descripcion, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($tarea->materia)
                                            <span class="badge" style="background-color: {{ $tarea->materia->color }}; color: white;">
                                                {{ $tarea->materia->nombre }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">Sin materia</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $tarea->fecha_entrega->format('d/m/Y H:i') }}
                                        @if($tarea->fecha_entrega->isPast() && $tarea->estado != 'completada')
                                            <br><small class="text-danger">Vencida</small>
                                        @endif
                                    </td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <select class="form-control form-control-sm estado-select" data-tarea-id="{{ $tarea->id }}">
                                            <option value="pendiente" {{ $tarea->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                            <option value="en_progreso" {{ $tarea->estado == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                                            <option value="completada" {{ $tarea->estado == 'completada' ? 'selected' : '' }}>Completada</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('tareas.show', $tarea) }}" class="btn btn-info" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('tareas.edit', $tarea) }}" class="btn btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('tareas.destroy', $tarea) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">
                    <h5>No tienes tareas registradas</h5>
                    <p><a href="{{ route('tareas.create') }}" class="btn btn-primary">Crea tu primera tarea</a></p>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <style>
        .estado-select {
            min-width: 120px;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Cambiar estado de tarea
            $('.estado-select').change(function() {
                const tareaId = $(this).data('tarea-id');
                const nuevoEstado = $(this).val();
                
                $.ajax({
                    url: `/tareas/${tareaId}/cambiar-estado`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        estado: nuevoEstado
                    },
                    success: function(response) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Estado actualizado correctamente'
                        });
                    },
                    error: function(xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Error al actualizar el estado'
                        });
                    }
                });
            });

            // Inicializar Toast
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        });
    </script>
@stop