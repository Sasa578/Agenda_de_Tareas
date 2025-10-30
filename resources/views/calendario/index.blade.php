@extends('adminlte::page')

@section('title', 'Calendario de Tareas')

@section('content_header')
    <h1>Calendario de Tareas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="card-title">Gestión de Tareas en Calendario</h3>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('tareas.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Nueva Tarea
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="calendario"></div>
        </div>
    </div>

    <!-- Modal para crear/editar evento -->
    <div class="modal fade" id="eventoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitulo">Nueva Tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="eventoForm">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="eventoId">
                        
                        <div class="form-group">
                            <label for="titulo">Título *</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="materia_id">Materia</label>
                            <select class="form-control" id="materia_id" name="materia_id">
                                <option value="">Seleccionar materia</option>
                                @foreach($materias as $materia)
                                    <option value="{{ $materia->id }}" data-color="{{ $materia->color }}">
                                        {{ $materia->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="prioridad">Prioridad *</label>
                            <select class="form-control" id="prioridad" name="prioridad" required>
                                <option value="baja">Baja</option>
                                <option value="media" selected>Media</option>
                                <option value="alta">Alta</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="todo_el_dia" name="todo_el_dia">
                                <label class="form-check-label" for="todo_el_dia">Todo el día</label>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha Inicio</label>
                                    <input type="datetime-local" class="form-control" id="fecha_inicio" name="fecha_inicio">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_entrega">Fecha Entrega *</label>
                                    <input type="datetime-local" class="form-control" id="fecha_entrega" name="fecha_entrega" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ubicacion">Ubicación</label>
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <style>
        #calendario {
            height: 600px;
        }
        .fc-event {
            cursor: pointer;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendario');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                events: '{{ route("calendario.eventos") }}',
                editable: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                
                // Cuando se selecciona un rango de fechas
                select: function(info) {
                    $('#fecha_inicio').val(info.start.toISOString().slice(0, 16));
                    $('#fecha_entrega').val(info.end ? info.end.toISOString().slice(0, 16) : info.start.toISOString().slice(0, 16));
                    $('#eventoId').val('');
                    $('#modalTitulo').text('Nueva Tarea');
                    $('#eventoForm')[0].reset();
                    $('#eventoModal').modal('show');
                    calendar.unselect();
                },
                
                // Cuando se hace click en un evento
                eventClick: function(info) {
                    // Redirigir a la vista de la tarea
                    window.location.href = '/tareas/' + info.event.id;
                },
                
                // Cuando se arrastra un evento
                eventDrop: function(info) {
                    actualizarEvento(info.event);
                },
                
                // Cuando se cambia el tamaño del evento
                eventResize: function(info) {
                    actualizarEvento(info.event);
                }
            });

            calendar.render();

            // Formulario para crear evento
            $('#eventoForm').on('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                fetch('{{ route("calendario.crear") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        calendar.refetchEvents();
                        $('#eventoModal').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Tarea creada exitosamente'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Toast.fire({
                        icon: 'error',
                        title: 'Error al crear la tarea'
                    });
                });
            });

            // Función para actualizar evento al arrastrar
            function actualizarEvento(event) {
                const data = {
                    fecha_entrega: event.start.toISOString(),
                    fecha_inicio: event.end ? event.end.toISOString() : null,
                    todo_el_dia: event.allDay
                };

                fetch(`/calendario/eventos/${event.id}`, {
                    method: 'PUT',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        calendar.refetchEvents(); // Revertir cambios si hay error
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    calendar.refetchEvents(); // Revertir cambios si hay error
                });
            }

            // Toggle campos de fecha/hora según "todo el día"
            $('#todo_el_dia').change(function() {
                const isAllDay = $(this).is(':checked');
                $('#fecha_inicio, #fecha_entrega').attr('type', isAllDay ? 'date' : 'datetime-local');
            });

            // SweetAlert para notificaciones
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