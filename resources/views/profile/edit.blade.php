@extends('adminlte::page')

@section('title', 'Mi Perfil')

@section('content_header')
    <h1>Mi Perfil</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información Personal</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" id="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Información
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cambiar Contraseña</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="current_password">Contraseña Actual</label>
                            <input type="password" name="current_password" id="current_password" 
                                   class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Nueva Contraseña</label>
                            <input type="password" name="password" id="password" 
                                   class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="form-control">
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key"></i> Cambiar Contraseña
                        </button>
                    </form>
                </div>
            </div>

            <!-- Estadísticas del Usuario -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Mis Estadísticas</h3>
                </div>
                <div class="card-body">
                    @php
                        $totalTareas = auth()->user()->tareas()->count();
                        $tareasCompletadas = auth()->user()->tareas()->where('estado', 'completada')->count();
                        $tareasPendientes = auth()->user()->tareas()->where('estado', 'pendiente')->count();
                        $totalMaterias = auth()->user()->materias()->count();
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

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $tareasCompletadas }}</h3>
                            <p>Tareas Completadas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
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
                            <h3>{{ $totalMaterias }}</h3>
                            <p>Materias Registradas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop