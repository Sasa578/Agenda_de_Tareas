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
                            <a class="dropdown-item"
                                href="{{ request()->fullUrlWithQuery(['estado' => '']) }}">Todas</a>
                            <a class="dropdown-item"
                                href="{{ request()->fullUrlWithQuery(['estado' => 'pendiente']) }}">Pendientes</a>
                            <a class="dropdown-item"
                                href="{{ request()->fullUrlWithQuery(['estado' => 'en_progreso']) }}">En Progreso</a>
                            <a class="dropdown-item"
                                href="{{ request()->fullUrlWithQuery(['estado' => 'completada']) }}">Completadas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($tareas->count() > 0)
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-hover task-table">
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
                                <tr
                                    class="task-row {{ $tarea->fecha_entrega->isPast() && $tarea->estado != 'completada' ? 'task-overdue' : '' }}">
                                    <td>
                                        <div class="task-title">
                                            <strong>{{ $tarea->titulo }}</strong>
                                            @if($tarea->descripcion)
                                                <div class="task-desc">{{ Str::limit($tarea->descripcion, 50) }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($tarea->materia)
                                            <span class="materia-badge" style="background-color: {{ $tarea->materia->color }};">
                                                {{ $tarea->materia->nombre }}
                                            </span>
                                        @else
                                            <span class="materia-badge no-materia">Sin materia</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="due-date">
                                            {{ $tarea->fecha_entrega->format('d/m/Y H:i') }}
                                            @if($tarea->fecha_entrega->isPast() && $tarea->estado != 'completada')
                                                <div class="overdue-badge">Vencida</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $prioridadColors = [
                                                'alta' => 'priority-high',
                                                'media' => 'priority-medium',
                                                'baja' => 'priority-low'
                                            ];
                                        @endphp
                                        <span class="priority-badge {{ $prioridadColors[$tarea->prioridad] }}">
                                            <i class="fas fa-circle"></i>
                                            {{ ucfirst($tarea->prioridad) }}
                                        </span>
                                    </td>
                                    <td>
                                        <select class="status-select {{ $tarea->estado }}" data-tarea-id="{{ $tarea->id }}">
                                            <option value="pendiente" {{ $tarea->estado == 'pendiente' ? 'selected' : '' }}>
                                                Pendiente</option>
                                            <option value="en_progreso" {{ $tarea->estado == 'en_progreso' ? 'selected' : '' }}>En
                                                Progreso</option>
                                            <option value="completada" {{ $tarea->estado == 'completada' ? 'selected' : '' }}>
                                                Completada</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('tareas.show', $tarea) }}" class="btn-action view" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('tareas.edit', $tarea) }}" class="btn-action edit" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('tareas.destroy', $tarea) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action delete" title="Eliminar"
                                                    onclick="return confirm('¿Estás seguro?')">
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
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-tasks fa-3x"></i>
                </div>
                <h3>No tienes tareas registradas</h3>
                <p>Comienza agregando tu primera tarea para organizar tu tiempo</p>
                <a href="{{ route('tareas.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus"></i> Crear Primera Tarea
                </a>
            </div>
        @endif

        <style>
            .table-container {
                background: var(--secondary-bg);
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            }

            .task-table {
                margin: 0;
            }

            .task-row {
                transition: all 0.3s ease;
            }

            .task-row:hover {
                background: rgba(255, 255, 255, 0.05) !important;
            }

            .task-row.task-overdue {
                border-left: 4px solid var(--danger-color);
                background: rgba(232, 17, 35, 0.05);
            }

            .task-title {
                max-width: 250px;
            }

            .task-desc {
                font-size: 0.85rem;
                color: var(--text-secondary);
                margin-top: 4px;
            }

            .materia-badge {
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 500;
                color: white;
            }

            .materia-badge.no-materia {
                background: var(--tertiary-bg);
                color: var(--text-secondary);
            }

            .due-date {
                font-weight: 500;
            }

            .overdue-badge {
                background: var(--danger-color);
                color: white;
                padding: 2px 8px;
                border-radius: 10px;
                font-size: 0.7rem;
                margin-top: 4px;
                display: inline-block;
            }

            .priority-badge {
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }

            .priority-badge i {
                font-size: 0.6rem;
            }

            .priority-high {
                background: rgba(220, 53, 69, 0.2);
                color: #dc3545;
                border: 1px solid rgba(220, 53, 69, 0.3);
            }

            .priority-medium {
                background: rgba(255, 193, 7, 0.2);
                color: #ffc107;
                border: 1px solid rgba(255, 193, 7, 0.3);
            }

            .priority-low {
                background: rgba(40, 167, 69, 0.2);
                color: #28a745;
                border: 1px solid rgba(40, 167, 69, 0.3);
            }

            .status-select {
                background: var(--tertiary-bg);
                border: 1px solid var(--border-color);
                color: var(--text-primary);
                border-radius: 20px;
                padding: 6px 12px;
                font-size: 0.8rem;
                transition: all 0.3s ease;
                min-width: 120px;
            }

            .status-select.pendiente {
                border-color: #6c757d;
            }

            .status-select.en_progreso {
                border-color: #ffc107;
            }

            .status-select.completada {
                border-color: #28a745;
            }

            .action-buttons {
                display: flex;
                gap: 8px;
            }

            .btn-action {
                width: 35px;
                height: 35px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                transition: all 0.3s ease;
                border: none;
                cursor: pointer;
            }

            .btn-action.view {
                background: rgba(0, 120, 212, 0.1);
                color: var(--accent-color);
            }

            .btn-action.edit {
                background: rgba(255, 193, 7, 0.1);
                color: #ffc107;
            }

            .btn-action.delete {
                background: rgba(220, 53, 69, 0.1);
                color: #dc3545;
            }

            .btn-action:hover {
                transform: scale(1.1);
            }
        </style>
    </div>
</div>

<!-- Botón flotante para nueva tarea -->
<div class="floating-action-btn">
    <a href="{{ route('tareas.create') }}" class="btn-floating">
        <i class="fas fa-plus"></i>
    </a>
</div>

<style>
    .floating-action-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
    }

    .btn-floating {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent-color), #005a9e);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(0, 120, 212, 0.4);
        transition: all 0.3s ease;
        border: none;
    }

    .btn-floating:hover {
        transform: scale(1.1) rotate(90deg);
        box-shadow: 0 6px 25px rgba(0, 120, 212, 0.6);
        color: white;
        text-decoration: none;
    }
</style>
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
    $(document).ready(function () {
        // Cambiar estado de tarea
        $('.estado-select').change(function () {
            const tareaId = $(this).data('tarea-id');
            const nuevoEstado = $(this).val();

            $.ajax({
                url: `/tareas/${tareaId}/cambiar-estado`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    estado: nuevoEstado
                },
                success: function (response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Estado actualizado correctamente'
                    });
                },
                error: function (xhr) {
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