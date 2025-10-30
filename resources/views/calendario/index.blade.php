@extends('adminlte::page')

@section('title', 'Calendario de Tareas')

@section('content_header')
    <h1>Calendario de Tareas</h1>
@stop

@section('content')
    <div class="calendar-container">
        <div class="calendar-main">
            <!-- Header del Calendario -->
            <div class="calendar-header-section">
                <div class="header-background">
                    <div class="calendar-header">
                        <a class="prev-button" id="prev">
                            <i class="material-icons">keyboard_arrow_left</i>
                        </a>
                        <a class="next-button" id="next">
                            <i class="material-icons">keyboard_arrow_right</i>
                        </a>

                        <div class="header-title">
                            <h3 id="month-name">Mes</h3>
                            <h5 id="todayDayName">Hoy es {{ date('l d M') }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendario -->
            <div class="calendar-section">
                <div class="calendar-content">
                    <div id="calendar-table" class="calendar-cells">
                        <div id="table-header">
                            <div class="row">
                                <div class="col">Lun</div>
                                <div class="col">Mar</div>
                                <div class="col">Mié</div>
                                <div class="col">Jue</div>
                                <div class="col">Vie</div>
                                <div class="col">Sáb</div>
                                <div class="col">Dom</div>
                            </div>
                        </div>
                        <div id="table-body"></div>
                    </div>
                </div>
            </div>

            <!-- Botón para abrir formulario -->
            <div class="calendar-actions">
                <a class="add-event-btn waves-effect waves-light btn" id="openFormButton">
                    <i class="material-icons left">add</i>Nueva Tarea
                </a>
            </div>
        </div>

        <!-- Sidebar para Formulario -->
        <div class="form-sidebar" id="formSidebar">
            <div class="form-header">
                <h4>Nueva Tarea</h4>
                <a class="close-form" id="closeFormButton">
                    <i class="material-icons">close</i>
                </a>
            </div>
            
            <div class="form-content">
                @if ($errors->any())
                    <div class="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="eventForm" method="POST" action="{{ route('calendario.crear') }}">
                    @csrf
                    
                    <div class="inputBx">
                        <input id="eventTitleInput" name="titulo" type="text" placeholder="Título de la tarea *" required>
                    </div>
                    
                    <div class="inputBx">
                        <textarea id="eventDescInput" name="descripcion" placeholder="Descripción (opcional)" rows="3"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="inputBx">
                            <select id="eventMateria" name="materia_id" required>
                                <option value="" disabled selected>Seleccionar materia *</option>
                                @foreach($materias as $materia)
                                    <option value="{{ $materia->id }}" data-color="{{ $materia->color }}">
                                        {{ $materia->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="inputBx">
                            <select id="eventPriority" name="prioridad" required>
                                <option value="" disabled selected>Prioridad *</option>
                                <option value="media">Media</option>
                                <option value="alta">Alta</option>
                                <option value="baja">Baja</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="inputBx">
                            <input type="datetime-local" id="eventStartDate" name="fecha_inicio" placeholder="Fecha de inicio">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="inputBx">
                            <input type="datetime-local" id="eventEndDate" name="fecha_entrega" placeholder="Fecha de entrega *" required>
                        </div>
                    </div>

                    <div class="inputBx">
                        <input type="text" id="eventLocation" name="ubicacion" placeholder="Lugar de Entrega">
                    </div>

                    <div class="checkboxBx">
                        <label>
                            <input type="checkbox" id="todoElDia" name="todo_el_dia" value="1" />
                            <span>Evento de todo el día</span>
                        </label>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="submit-btn">
                            <i class="material-icons left">save</i>Guardar Tarea
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <h4>¡Éxito!</h4>
            <p id="successMessage">La tarea ha sido creada correctamente.</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
        </div>
    </div>

    <!-- Modal de error -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <h4>Error</h4>
            <p id="errorMessage">Ha ocurrido un error al crear la tarea.</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
        </div>
    </div>
@stop

@section('css')
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-bg: #1e1e1e;
            --secondary-bg: #2d2d30;
            --tertiary-bg: #3e3e42;
            --text-primary: #ffffff;
            --text-secondary: #cccccc;
            --accent-color: #42a5f5;
            --accent-hover: #478ed1;
            --border-color: #484848;
            --success-color: #4caf50;
            --error-color: #f44336;
        }

        * {
            font-family: "Quicksand", sans-serif;
            box-sizing: border-box;
        }

        body {
            background: var(--primary-bg);
            color: var(--text-primary);
            margin: 0;
            padding: 0;
        }

        .calendar-container {
            display: flex;
            min-height: 80vh;
            gap: 20px;
            padding: 20px;
        }

        .calendar-main {
            flex: 1;
            background: var(--secondary-bg);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .form-sidebar {
            width: 400px;
            background: var(--tertiary-bg);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            display: none;
            flex-direction: column;
        }

        .form-sidebar.active {
            display: flex;
        }

        /* HEADER DEL CALENDARIO */
        .calendar-header-section {
            background: linear-gradient(135deg, var(--accent-color), #005a9e);
        }

        .header-background {
            padding: 30px;
        }

        .calendar-header {
            position: relative;
            color: var(--text-primary);
            text-align: center;
        }

        .prev-button, .next-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.8) !important;
            cursor: pointer;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .prev-button:hover, .next-button:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-50%) scale(1.1);
        }

        .prev-button {
            left: 0;
        }

        .next-button {
            right: 0;
        }

        .header-title h3 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 300;
            color: white;
        }

        .header-title h5 {
            margin: 10px 0 0 0;
            font-weight: 300;
            color: rgba(255,255,255,0.8);
        }

        /* CALENDARIO */
        .calendar-section {
            padding: 20px;
        }

        .calendar-content {
            background: var(--secondary-bg);
        }

        #table-header {
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 10px;
            background: var(--tertiary-bg);
            border-radius: 8px;
            padding: 15px 0;
        }

        #table-header .row {
            margin-bottom: 0;
            display: flex;
        }

        #table-header .col {
            flex: 1;
            text-align: center;
            padding: 10px 5px;
            font-weight: 600;
        }

        #table-body {
            background: var(--secondary-bg);
        }

        #table-body .row {
            margin-bottom: 5px;
            display: flex;
        }

        #table-body .col {
            flex: 1;
            text-align: center;
            padding: 20px 5px;
            margin: 2px;
            background: var(--tertiary-bg);
            border: 2px solid transparent;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            min-height: 80px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            color: var(--text-primary);
            font-weight: 500;
        }

        #table-body .col:hover {
            border-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(66, 165, 245, 0.2);
        }

        #table-body .col.empty-day {
            background: transparent;
            cursor: default;
            color: var(--text-secondary);
        }

        #table-body .col.empty-day:hover {
            border-color: transparent;
            transform: none;
            box-shadow: none;
        }

        #table-body .col.blue.lighten-3 {
            background: var(--accent-color) !important;
            color: white;
            border-color: var(--accent-color);
        }

        .day-number {
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        .day-mark {
            width: 6px;
            height: 6px;
            background-color: #ffb900;
            border-radius: 50%;
            margin-top: 5px;
        }

        /* BOTÓN NUEVA TAREA */
        .calendar-actions {
            padding: 20px;
            text-align: center;
            border-top: 1px solid var(--border-color);
        }

        .add-event-btn {
            background: linear-gradient(45deg, var(--accent-color), var(--accent-hover)) !important;
            border-radius: 25px;
            padding: 0 30px;
            height: 45px;
            line-height: 45px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(66, 165, 245, 0.4);
            transition: all 0.3s ease;
        }

        .add-event-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(66, 165, 245, 0.6);
        }

        /* FORMULARIO LATERAL */
        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            background: var(--secondary-bg);
            border-radius: 12px 12px 0 0;
        }

        .form-header h4 {
            margin: 0;
            color: var(--text-primary);
            font-weight: 500;
        }

        .close-form {
            color: var(--text-secondary);
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .close-form:hover {
            color: var(--text-primary);
            background: rgba(255,255,255,0.1);
        }

        .form-content {
            padding: 20px;
            flex: 1;
            overflow-y: auto;
        }

        /* ESTILOS DEL FORMULARIO */
        .inputBx {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .inputBx input,
        .inputBx textarea,
        .inputBx select {
            position: relative;
            width: 100%;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            font-size: 1em;
            color: var(--text-primary);
            box-shadow: none;
            outline: none;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            font-family: "Quicksand", sans-serif;
        }

        .inputBx textarea {
            border-radius: 15px;
            min-height: 80px;
            resize: vertical;
        }

        .inputBx select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 14px;
            padding-right: 40px;
        }

        .inputBx input:focus,
        .inputBx textarea:focus,
        .inputBx select:focus {
            border-color: var(--accent-color);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 15px rgba(66, 165, 245, 0.3);
        }

        .inputBx input::placeholder,
        .inputBx textarea::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-row {
            display: flex;
            gap: 10px;
        }

        .form-row .inputBx {
            flex: 1;
        }

        /* Checkbox */
        .checkboxBx {
            margin: 20px 0;
        }

        .checkboxBx label {
            color: var(--text-primary);
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 0.9em;
        }

        .checkboxBx input[type="checkbox"] {
            margin-right: 10px;
            transform: scale(1.1);
        }

        /* Botones */
        .form-buttons {
            margin-top: 20px;
        }

        .submit-btn {
            width: 100%;
            padding: 12px 20px;
            background: linear-gradient(45deg, var(--accent-color), var(--accent-hover));
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(66, 165, 245, 0.4);
        }

        /* Mensajes de error */
        .error-message {
            background: rgba(244, 67, 54, 0.1);
            border: 1px solid rgba(244, 67, 54, 0.3);
            color: #ffcdd2;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
        }

        .error-message ul {
            margin: 0;
            padding-left: 20px;
            font-size: 0.9em;
        }

        .error-message li {
            margin-bottom: 3px;
        }

        /* Loading */
        .loading {
            opacity: 0.6;
            pointer-events: none;
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid var(--accent-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .calendar-container {
                flex-direction: column;
            }
            
            .form-sidebar {
                width: 100%;
                max-width: 500px;
                margin: 0 auto;
            }
        }

        @media (max-width: 768px) {
            .calendar-container {
                padding: 10px;
            }
            
            .header-title h3 {
                font-size: 2rem;
            }
            
            #table-body .col {
                padding: 15px 2px;
                min-height: 60px;
                font-size: 0.9em;
            }
            
            .form-content {
                padding: 15px;
            }
        }
    </style>
@stop

@section('js')
    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar componentes de Materialize
            M.AutoInit();
            var modals = M.Modal.init(document.querySelectorAll('.modal'));

            var calendar = {
                currentDate: new Date(),
                selectedDate: new Date(),
                selectedDayBlock: null,
                events: [],

                init: function() {
                    this.loadEvents();
                    this.createCalendar(this.currentDate);
                    this.bindEvents();
                    this.initializeForm();
                },

                initializeForm: function() {
                    // Inicializar selects
                    var selects = document.querySelectorAll('select');
                    M.FormSelect.init(selects);

                    // Prellenar fecha de hoy por defecto
                    const today = new Date();
                    const formattedDate = today.toISOString().slice(0, 16);
                    document.getElementById("eventEndDate").value = formattedDate;

                    // Configurar evento de "todo el día"
                    document.getElementById('todoElDia').addEventListener('change', function() {
                        const startDateInput = document.getElementById('eventStartDate');
                        const endDateInput = document.getElementById('eventEndDate');
                        
                        if (this.checked) {
                            startDateInput.type = 'date';
                            endDateInput.type = 'date';
                        } else {
                            startDateInput.type = 'datetime-local';
                            endDateInput.type = 'datetime-local';
                        }
                    });
                },

                createCalendar: function(date, side) {
                    var currentDate = date;
                    var startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
                    
                    var monthTitle = document.getElementById("month-name");
                    var monthName = currentDate.toLocaleString("es-ES", { month: "long" });
                    var yearNum = currentDate.toLocaleString("es-ES", { year: "numeric" });
                    monthTitle.innerHTML = `${this.capitalizeFirst(monthName)} ${yearNum}`;

                    var gridTable = document.getElementById("table-body");
                    gridTable.innerHTML = "";

                    var newTr = document.createElement("div");
                    newTr.className = "row";
                    var currentTr = gridTable.appendChild(newTr);

                    // Días vacíos al inicio (Lunes es el primer día)
                    var firstDayOfWeek = startDate.getDay();
                    var emptyDays = firstDayOfWeek === 0 ? 6 : firstDayOfWeek - 1;
                    
                    for (let i = 0; i < emptyDays; i++) {
                        let emptyDivCol = document.createElement("div");
                        emptyDivCol.className = "col empty-day";
                        currentTr.appendChild(emptyDivCol);
                    }

                    var lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
                    lastDay = lastDay.getDate();

                    for (let i = 1; i <= lastDay; i++) {
                        if (currentTr.children.length >= 7) {
                            currentTr = gridTable.appendChild(this.addNewRow());
                        }
                        
                        let currentDay = document.createElement("div");
                        currentDay.className = "col";
                        
                        let dayNumber = document.createElement("div");
                        dayNumber.className = "day-number";
                        dayNumber.textContent = i;
                        currentDay.appendChild(dayNumber);

                        let dateKey = new Date(currentDate.getFullYear(), currentDate.getMonth(), i);
                        
                        // Marcar día seleccionado
                        if (this.selectedDate.toDateString() === dateKey.toDateString()) {
                            this.selectedDayBlock = currentDay;
                            currentDay.classList.add("blue", "lighten-3");
                        }

                        // Mostrar marcas de eventos
                        let dayEvents = this.getEventsForDate(dateKey);
                        if (dayEvents.length > 0) {
                            let eventMark = document.createElement("div");
                            eventMark.className = "day-mark";
                            currentDay.appendChild(eventMark);
                        }

                        currentTr.appendChild(currentDay);
                    }

                    // Días vacíos al final
                    while (currentTr.children.length < 7) {
                        let emptyDivCol = document.createElement("div");
                        emptyDivCol.className = "col empty-day";
                        currentTr.appendChild(emptyDivCol);
                    }
                },

                addNewRow: function() {
                    let node = document.createElement("div");
                    node.className = "row";
                    return node;
                },

                capitalizeFirst: function(string) {
                    return string.charAt(0).toUpperCase() + string.slice(1);
                },

                loadEvents: function() {
                    fetch('{{ route("calendario.eventos") }}')
                        .then(response => response.json())
                        .then(events => {
                            this.events = events;
                            this.createCalendar(this.currentDate);
                        })
                        .catch(error => console.error('Error loading events:', error));
                },

                getEventsForDate: function(date) {
                    return this.events.filter(event => {
                        const eventDate = new Date(event.start);
                        return eventDate.toDateString() === date.toDateString();
                    });
                },

                bindEvents: function() {
                    // Navegación del calendario
                    document.getElementById("prev").addEventListener("click", () => {
                        this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1);
                        this.createCalendar(this.currentDate);
                    });

                    document.getElementById("next").addEventListener("click", () => {
                        this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1);
                        this.createCalendar(this.currentDate);
                    });

                    // Selección de día
                    document.getElementById("table-body").addEventListener("click", (e) => {
                        let target = e.target;
                        // Si se hace clic en el número del día o en el marcador
                        if (target.classList.contains("day-number") || target.classList.contains("day-mark")) {
                            target = target.parentElement;
                        }
                        
                        if (!target.classList.contains("col") || target.classList.contains("empty-day")) {
                            return;
                        }

                        if (this.selectedDayBlock) {
                            this.selectedDayBlock.classList.remove("blue", "lighten-3");
                        }

                        this.selectedDayBlock = target;
                        this.selectedDayBlock.classList.add("blue", "lighten-3");

                        let day = parseInt(target.querySelector('.day-number').textContent);
                        this.selectedDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), day);

                        // Prellenar fecha de entrega en el formulario
                        const formattedDate = this.selectedDate.toISOString().slice(0, 16);
                        document.getElementById("eventEndDate").value = formattedDate;
                    });

                    // Abrir/cerrar formulario
                    document.getElementById("openFormButton").addEventListener("click", () => {
                        document.getElementById("formSidebar").classList.add("active");
                    });

                    document.getElementById("closeFormButton").addEventListener("click", () => {
                        document.getElementById("formSidebar").classList.remove("active");
                        document.getElementById("eventForm").reset();
                        this.initializeForm();
                    });

                    // Envío del formulario
                    document.getElementById("eventForm").addEventListener("submit", (e) => {
                        e.preventDefault();
                        this.saveEvent();
                    });
                },

                saveEvent: function() {
                    const form = document.getElementById("eventForm");
                    const formData = new FormData(form);
                    
                    // Mostrar loading
                    form.classList.add('loading');
                    
                    fetch('{{ route("calendario.crear") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        form.classList.remove('loading');
                        
                        if (data.success) {
                            // Cerrar formulario y resetear
                            document.getElementById("formSidebar").classList.remove("active");
                            form.reset();
                            
                            // Recargar eventos y calendario
                            this.loadEvents();
                            
                            // Mostrar mensaje de éxito
                            M.toast({html: 'Tarea creada exitosamente', classes: 'green'});
                        } else {
                            throw new Error(data.message || 'Error al crear la tarea');
                        }
                    })
                    .catch(error => {
                        form.classList.remove('loading');
                        console.error('Error saving event:', error);
                        M.toast({html: error.message || 'Error al crear la tarea', classes: 'red'});
                    });
                }
            };

            // Inicializar el calendario
            calendar.init();

            // Actualizar fecha de hoy
            var todayDayName = document.getElementById("todayDayName");
            var today = new Date();
            todayDayName.textContent = "Hoy es " + today.toLocaleDateString("es-ES", {
                weekday: 'long',
                day: 'numeric',
                month: 'short'
            });
        });
    </script>
@stop