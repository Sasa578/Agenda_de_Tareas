@extends('adminlte::page')

@section('title', 'Crear Materia')

@section('content_header')
    <h1>Crear Nueva Materia</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('materias.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="nombre">Nombre de la Materia *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                           value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="codigo">Código de la Materia *</label>
                    <input type="text" name="codigo" id="codigo" class="form-control @error('codigo') is-invalid @enderror" 
                           value="{{ old('codigo') }}" required>
                    @error('codigo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="color">Color de Identificación *</label>
                    <input type="color" name="color" id="color" class="form-control @error('color') is-invalid @enderror" 
                           value="{{ old('color', '#007bff') }}" required style="height: 45px;">
                    @error('color')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" 
                              rows="3">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Crear Materia
                    </button>
                    <a href="{{ route('materias.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop