@extends('adminlte::page')

@section('title', 'Mis Materias')

@section('content_header')
<h1>Mis Materias</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('materias.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Materia
        </a>
    </div>
    <div class="card-body">
        @if($materias->count() > 0)
            <div class="row">
                @foreach($materias as $materia)
                    <div class="col-md-4 mb-4">
                        <div class="materia-card">
                            <div class="materia-header" style="background-color: {{ $materia->color }};">
                                <div class="materia-icon">
                                    <i class="fas fa-book"></i>
                                </div>
                                <h3 class="materia-title">{{ $materia->nombre }}</h3>
                            </div>
                            <div class="materia-body">
                                <div class="materia-info">
                                    <span class="materia-code">{{ $materia->codigo }}</span>
                                    @if($materia->descripcion)
                                        <p class="materia-desc">{{ Str::limit($materia->descripcion, 80) }}</p>
                                    @endif
                                </div>
                                <div class="materia-stats">
                                    <div class="stat">
                                        <span class="stat-number">{{ $materia->tareasPendientes->count() }}</span>
                                        <span class="stat-label">Pendientes</span>
                                    </div>
                                </div>
                            </div>
                            <div class="materia-actions">
                                <a href="{{ route('materias.show', $materia) }}" class="btn-action view" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('materias.edit', $materia) }}" class="btn-action edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('materias.destroy', $materia) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Eliminar"
                                        onclick="return confirm('¿Estás seguro?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-book fa-3x"></i>
                </div>
                <h3>No tienes materias registradas</h3>
                <p>Comienza agregando tu primera materia para organizar tus tareas</p>
                <a href="{{ route('materias.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus"></i> Crear Primera Materia
                </a>
            </div>
        @endif

        <style>
            .materia-card {
                background: var(--secondary-bg);
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
                transition: all 0.3s ease;
                border: 1px solid var(--border-color);
            }

            .materia-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            }

            .materia-header {
                padding: 20px;
                color: white;
                position: relative;
                min-height: 120px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
            }

            .materia-icon {
                font-size: 2rem;
                margin-bottom: 10px;
                opacity: 0.9;
            }

            .materia-title {
                margin: 0;
                font-size: 1.3rem;
                font-weight: 600;
            }

            .materia-body {
                padding: 20px;
            }

            .materia-code {
                background: rgba(255, 255, 255, 0.1);
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 0.85rem;
                color: var(--text-secondary);
            }

            .materia-desc {
                margin: 10px 0 0 0;
                color: var(--text-secondary);
                font-size: 0.9rem;
                line-height: 1.4;
            }

            .materia-stats {
                margin-top: 15px;
                padding-top: 15px;
                border-top: 1px solid var(--border-color);
            }

            .stat {
                text-align: center;
            }

            .stat-number {
                display: block;
                font-size: 1.5rem;
                font-weight: 600;
                color: var(--accent-color);
            }

            .stat-label {
                font-size: 0.8rem;
                color: var(--text-secondary);
                text-transform: uppercase;
            }

            .materia-actions {
                display: flex;
                justify-content: space-around;
                padding: 15px 20px;
                background: var(--tertiary-bg);
                border-top: 1px solid var(--border-color);
            }

            .btn-action {
                width: 40px;
                height: 40px;
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

            .empty-state {
                text-align: center;
                padding: 60px 20px;
                color: var(--text-secondary);
            }

            .empty-icon {
                margin-bottom: 20px;
                opacity: 0.5;
            }
        </style>
    </div>
</div>
@stop