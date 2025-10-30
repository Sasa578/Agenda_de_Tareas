@extends('adminlte::page')

@section('title', 'Mis Notificaciones')

@section('content_header')
    <h1>Mis Notificaciones</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="card-title">Historial de Notificaciones</h3>
                </div>
                <div class="col-md-6 text-right">
                    @if(auth()->user()->notifications->count() > 0)
                        <form action="{{ route('notificaciones.markAllRead') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-check-double"></i> Marcar todas como leídas
                            </button>
                        </form>
                        <form action="{{ route('notificaciones.clearAll') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar todas las notificaciones?')">
                                <i class="fas fa-trash"></i> Limpiar todo
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($notifications->count() > 0)
                <div class="list-group">
                    @foreach($notifications as $notification)
                        <div class="list-group-item list-group-item-action {{ $notification->read_at ? '' : 'list-group-item-warning' }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">
                                    <i class="fas fa-bell mr-2 {{ $notification->read_at ? 'text-secondary' : 'text-warning' }}"></i>
                                    {{ $notification->data['titulo'] ?? 'Notificación' }}
                                </h5>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ $notification->data['mensaje'] ?? '' }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    @if(isset($notification->data['tipo']))
                                        <span class="badge badge-{{ $notification->data['tipo'] == 'recordatorio' ? 'warning' : 'info' }}">
                                            {{ ucfirst($notification->data['tipo']) }}
                                        </span>
                                    @endif
                                </small>
                                <div class="btn-group btn-group-sm">
                                    @if(isset($notification->data['url']) && $notification->data['url'] != '#')
                                        <a href="{{ $notification->data['url'] }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    @endif
                                    @if(!$notification->read_at)
                                        <form action="{{ route('notificaciones.markRead', $notification->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> Leída
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('notificaciones.destroy', $notification->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta notificación?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-3">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <h5><i class="fas fa-bell-slash"></i> No tienes notificaciones</h5>
                    <p class="mb-0">Cuando tengas recordatorios de tareas, aparecerán aquí.</p>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <style>
        .list-group-item-warning {
            background-color: rgba(255, 193, 7, 0.1);
            border-left: 4px solid #ffc107;
        }
    </style>
@stop