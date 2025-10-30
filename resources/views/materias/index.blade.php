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
                            <div class="card">
                                <div class="card-header" style="background-color: {{ $materia->color }}; color: white;">
                                    <h5 class="card-title mb-0">{{ $materia->nombre }}</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <strong>Código:</strong> {{ $materia->codigo }}<br>
                                        @if($materia->descripcion)
                                            <strong>Descripción:</strong> {{ Str::limit($materia->descripcion, 100) }}
                                        @endif
                                    </p>
                                    <p>
                                        <span class="badge badge-info">
                                            {{ $materia->tareasPendientes->count() }} tareas pendientes
                                        </span>
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('materias.show', $materia) }}" class="btn btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('materias.edit', $materia) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('materias.destroy', $materia) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    <p>No tienes materias registradas. <a href="{{ route('materias.create') }}">Crea tu primera materia</a></p>
                </div>
            @endif
        </div>
    </div>
@stop