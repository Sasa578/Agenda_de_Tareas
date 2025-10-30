@extends('adminlte::page')

@section('title', 'Calendario de Tareas')

@section('content_header')
    <h1>Calendario de Tareas</h1>
@stop

@section('content')
    <div class="mobile-header z-depth-1">
        <div class="row">
            <div class="col s2">
                <a href="#" data-activates="sidebar" class="button-collapse">
                    <i class="material-icons">menu</i>
                </a>
            </div>
            <div class="col s10">
                <h4>Calendario</h4>
            </div>
        </div>
    </div>

    <div class="main-wrapper">
        <!-- Sidebar -->
        <div class="sidebar-wrapper z-depth-2 side-nav fixed" id="sidebar">
            <div class="sidebar-title">
                <h4>Tareas</h4>
                <h5 id="eventDayName">{{ date('d F Y') }}</h5>
            </div>
            <div class="sidebar-events" id="sidebarEvents">
                <div class="empty-message">Selecciona una fecha para ver las tareas</div>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="content-wrapper">
            <div class="container">
                <div class="calendar-wrapper z-depth-2">
                    <!-- Header del Calendario -->
                    <div class="header-background">
                        <div class="calendar-header">
                            <a class="prev-button" id="prev">
                                <i class="material-icons">keyboard_arrow_left</i>
                            </a>
                            <a class="next-button" id="next">
                                <i class="material-icons">keyboard_arrow_right</i>
                            </a>

                            <div class="row header-title">
                                <div class="header-text">
                                    <h3 id="month-name">Mes</h3>
                                    <h5 id="todayDayName">Hoy es {{ date('l d M') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Calendario -->
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

                    <!-- Formulario para Nueva Tarea -->
                    <div class="calendar-footer">
                        <div class="emptyForm" id="emptyForm">
                            <h4 id="emptyFormTitle">Agregar nueva tarea</h4>
                            <a class="addEvent waves-effect waves-light btn" id="changeFormButton">
                                <i class="material-icons left">add</i>Nueva Tarea
                            </a>
                        </div>
                        
                        <div class="addForm" id="addForm">
                            <h4>Nueva Tarea</h4>
                            <form id="eventForm">
                                @csrf
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="eventTitleInput" name="titulo" type="text" class="validate" required>
                                        <label for="eventTitleInput">Título *</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <textarea id="eventDescInput" name="descripcion" class="materialize-textarea"></textarea>
                                        <label for="eventDescInput">Descripción</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s6">
                                        <select id="eventMateria" name="materia_id">
                                            <option value="" disabled selected>Seleccionar materia</option>
                                            @foreach($materias as $materia)
                                                <option value="{{ $materia->id }}" data-color="{{ $materia->color }}">
                                                    {{ $materia->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label>Materia</label>
                                    </div>
                                    
                                    <div class="input-field col s6">
                                        <select id="eventPriority" name="prioridad" required>
                                            <option value="media" selected>Media</option>
                                            <option value="alta">Alta</option>
                                            <option value="baja">Baja</option>
                                        </select>
                                        <label>Prioridad *</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s6">
                                        <input type="datetime-local" id="eventStartDate" name="fecha_inicio" class="validate">
                                        <label for="eventStartDate">Fecha Inicio</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input type="datetime-local" id="eventEndDate" name="fecha_entrega" class="validate" required>
                                        <label for="eventEndDate">Fecha Entrega *</label>
                                    </div>
                                </div>

                                <div class="addEventButtons">
                                    <button type="submit" class="waves-effect waves-light btn blue lighten-2">
                                        <i class="material-icons left">save</i>Guardar
                                    </button>
                                    <a class="waves-effect waves-light btn grey lighten-2" id="cancelAdd">
                                        <i class="material-icons left">cancel</i>Cancelar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <style>
        :root {
            --primary-bg: #1e1e1e;
            --secondary-bg: #2d2d30;
            --tertiary-bg: #3e3e42;
            --text-primary: #ffffff;
            --text-secondary: #cccccc;
            --accent-color: #0078d4;
            --accent-hover: #106ebe;
            --border-color: #484848;
        }

        body {
            background-color: var(--primary-bg);
            color: var(--text-primary);
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
        }

        .mobile-header {
            display: none;
            padding: 15px;
            background: var(--tertiary-bg) !important;
            position: fixed;
            width: 100%;
            z-index: 997;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .mobile-header h4 {
            color: var(--text-primary);
            margin: 0;
            font-weight: 300;
        }

        .mobile-header .material-icons {
            color: var(--text-primary);
        }

        .main-wrapper {
            margin-top: 0;
        }

        .sidebar-wrapper {
            background: var(--tertiary-bg) !important;
            color: var(--text-primary);
            width: 300px;
            padding: 0;
        }

        .sidebar-title {
            background: var(--accent-color);
            padding: 30px 20px;
            margin-bottom: 20px;
        }

        .sidebar-title h4, .sidebar-title h5 {
            color: var(--text-primary);
            margin: 0;
            font-weight: 300;
        }

        .sidebar-events {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }

        .empty-message {
            padding: 20px;
            color: var(--text-secondary);
            text-align: center;
        }

        .eventCard {
            background: var(--secondary-bg);
            border-left: 4px solid var(--accent-color);
            margin: 10px;
            padding: 15px;
            border-radius: 4px;
            animation: slideInDown 0.5s;
        }

        .eventCard.priority-high {
            border-left-color: #e81123;
        }

        .eventCard.priority-medium {
            border-left-color: #ffb900;
        }

        .eventCard.priority-low {
            border-left-color: #107c10;
        }

        .eventCard-header {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 5px;
        }

        .eventCard-description {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .eventCard-materia {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-top: 5px;
        }

        .content-wrapper {
            margin-left: 300px;
            background: var(--primary-bg);
            min-height: 100vh;
            padding: 20px 0;
        }

        .calendar-wrapper {
            background: var(--secondary-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            max-width: 900px;
            margin: 0 auto;
        }

        .header-background {
            background: linear-gradient(135deg, var(--accent-color), #005a9e);
            height: 180px;
        }

        .calendar-header {
            padding: 30px;
            color: var(--text-primary);
            position: relative;
            height: 100%;
        }

        .header-text h3 {
            color: var(--text-primary);
            margin: 0;
            font-size: 2rem;
            font-weight: 300;
        }

        .header-text h5 {
            color: rgba(255,255,255,0.8);
            margin: 5px 0 0 0;
            font-weight: 300;
        }

        .prev-button, .next-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.8) !important;
            cursor: pointer;
        }

        .prev-button {
            left: 20px;
        }

        .next-button {
            right: 20px;
        }

        .prev-button i, .next-button i {
            font-size: 3rem;
        }

        .calendar-content {
            background: var(--secondary-bg);
            padding: 20px;
        }

        #table-header {
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 10px;
        }

        #table-header .row, #table-body .row {
            margin-bottom: 0;
        }

        #table-header .col, #table-body .col {
            padding: 15px 5px;
            text-align: center;
        }

        #table-body .col {
            background: var(--tertiary-bg);
            border: 2px solid transparent;
            border-radius: 4px;
            margin: 2px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            min-height: 80px;
            color: var(--text-primary);
        }

        #table-body .col:hover {
            border-color: var(--accent-color);
            transform: translateY(-2px);
        }

        #table-body .col.empty-day {
            background: transparent;
            cursor: default;
        }

        #table-body .col.empty-day:hover {
            border-color: transparent;
            transform: none;
        }

        #table-body .col.blue.lighten-3 {
            background: var(--accent-color) !important;
            color: white;
        }

        .day-mark {
            width: 6px;
            height: 6px;
            background-color: #ffb900;
            border-radius: 50%;
            position: absolute;
            bottom: 8px;
            left: 50%;
            transform: translateX(-50%);
        }

        .calendar-footer {
            background: var(--tertiary-bg);
            padding: 30px;
            position: relative;
            overflow: hidden;
        }

        .emptyForm h4 {
            color: var(--text-primary);
            margin-bottom: 20px;
            font-weight: 300;
        }

        .addEvent {
            background: var(--accent-color) !important;
            border-radius: 25px;
            padding: 0 30px;
        }

        .addForm {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--tertiary-bg);
            padding: 30px;
            transition: top 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .addForm h4 {
            color: var(--text-primary);
            margin-bottom: 20px;
            font-weight: 300;
        }

        .input-field label {
            color: var(--text-secondary);
        }

        .input-field input, .input-field textarea {
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-color);
        }

        .input-field input:focus, .input-field textarea:focus {
            border-bottom: 1px solid var(--accent-color);
            box-shadow: 0 1px 0 0 var(--accent-color);
        }

        .input-field input:focus + label, .input-field textarea:focus + label {
            color: var(--accent-color);
        }

        .select-wrapper input.select-dropdown {
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        .dropdown-content {
            background: var(--secondary-bg);
        }

        .dropdown-content li {
            background: var(--secondary-bg);
        }

        .dropdown-content li span {
            color: var(--text-primary);
        }

        .dropdown-content li:hover, .dropdown-content li.active {
            background: var(--accent-color);
        }

        .addEventButtons {
            margin-top: 20px;
            text-align: right;
        }

        .addEventButtons .btn {
            margin-left: 10px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .content-wrapper {
                margin-left: 0;
            }
            .mobile-header {
                display: block;
            }
            .calendar-wrapper {
                margin-top: 80px;
            }
        }

        @media (max-width: 600px) {
            .calendar-content {
                padding: 10px;
            }
            #table-body .col {
                min-height: 60px;
                padding: 10px 2px;
            }
            .header-text h3 {
                font-size: 1.5rem;
            }
        }

        @keyframes slideInDown {
            from {
                transform: translate3d(0, -100%, 0);
                opacity: 0;
            }
            to {
                transform: translate3d(0, 0, 0);
                opacity: 1;
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
            
            var calendar = {
                currentDate: new Date(),
                selectedDate: new Date(),
                selectedDayBlock: null,
                events: [],

                init: function() {
                    this.loadEvents();
                    this.createCalendar(this.currentDate);
                    this.bindEvents();
                },

                createCalendar: function(date, side) {
                    var currentDate = date;
                    var startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
                    
                    var monthTitle = document.getElementById("month-name");
                    var monthName = currentDate.toLocaleString("es-ES", { month: "long" });
                    var yearNum = currentDate.toLocaleString("es-ES", { year: "numeric" });
                    monthTitle.innerHTML = `${this.capitalizeFirst(monthName)} ${yearNum}`;

                    var gridTable = document.getElementById("table-body");
                    
                    if (side) {
                        gridTable.className = side === "left" ? "animated fadeOutRight" : "animated fadeOutLeft";
                    }

                    setTimeout(() => {
                        gridTable.innerHTML = "";

                        var newTr = document.createElement("div");
                        newTr.className = "row";
                        var currentTr = gridTable.appendChild(newTr);

                        // Días vacíos al inicio
                        for (let i = 1; i < (startDate.getDay() || 7); i++) {
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
                            currentDay.innerHTML = i;

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
                        for (let i = currentTr.getElementsByTagName("div").length; i < 7; i++) {
                            let emptyDivCol = document.createElement("div");
                            emptyDivCol.className = "col empty-day";
                            currentTr.appendChild(emptyDivCol);
                        }

                        if (side) {
                            gridTable.className = side === "left" ? "animated fadeInLeft" : "animated fadeInRight";
                        }

                    }, side ? 270 : 0);
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
                            this.showEvents();
                        })
                        .catch(error => console.error('Error loading events:', error));
                },

                getEventsForDate: function(date) {
                    return this.events.filter(event => {
                        const eventDate = new Date(event.start);
                        return eventDate.toDateString() === date.toDateString();
                    });
                },

                showEvents: function() {
                    let sidebarEvents = document.getElementById("sidebarEvents");
                    let dayEvents = this.getEventsForDate(this.selectedDate);

                    sidebarEvents.innerHTML = "";

                    if (dayEvents.length > 0) {
                        dayEvents.forEach(event => {
                            let eventContainer = document.createElement("div");
                            eventContainer.className = `eventCard priority-${event.prioridad}`;

                            let eventHeader = document.createElement("div");
                            eventHeader.className = "eventCard-header";
                            eventHeader.textContent = event.titulo;

                            let eventDescription = document.createElement("div");
                            eventDescription.className = "eventCard-description";
                            eventDescription.textContent = event.descripcion || 'Sin descripción';

                            let eventMateria = document.createElement("div");
                            eventMateria.className = "eventCard-materia";
                            eventMateria.textContent = `Materia: ${event.materia}`;

                            eventContainer.appendChild(eventHeader);
                            eventContainer.appendChild(eventDescription);
                            eventContainer.appendChild(eventMateria);

                            eventContainer.addEventListener('click', () => {
                                window.location.href = `/tareas/${event.id}`;
                            });

                            sidebarEvents.appendChild(eventContainer);
                        });

                        document.getElementById("emptyFormTitle").textContent = `${dayEvents.length} tareas para esta fecha`;
                    } else {
                        let emptyMessage = document.createElement("div");
                        emptyMessage.className = "empty-message";
                        emptyMessage.textContent = "No hay tareas para esta fecha";
                        sidebarEvents.appendChild(emptyMessage);
                        document.getElementById("emptyFormTitle").textContent = "Agregar nueva tarea";
                    }
                },

                bindEvents: function() {
                    // Navegación del calendario
                    document.getElementById("prev").addEventListener("click", () => {
                        this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1);
                        this.createCalendar(this.currentDate, "left");
                    });

                    document.getElementById("next").addEventListener("click", () => {
                        this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1);
                        this.createCalendar(this.currentDate, "right");
                    });

                    // Selección de día
                    document.getElementById("table-body").addEventListener("click", (e) => {
                        if (!e.target.classList.contains("col") || e.target.classList.contains("empty-day")) {
                            return;
                        }

                        if (this.selectedDayBlock) {
                            this.selectedDayBlock.classList.remove("blue", "lighten-3");
                        }

                        this.selectedDayBlock = e.target;
                        this.selectedDayBlock.classList.add("blue", "lighten-3");

                        let day = parseInt(e.target.textContent);
                        this.selectedDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), day);

                        // Actualizar fecha en el sidebar
                        document.getElementById("eventDayName").textContent = 
                            this.selectedDate.toLocaleDateString("es-ES", {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });

                        // Prellenar fecha de entrega en el formulario
                        const formattedDate = this.selectedDate.toISOString().slice(0, 16);
                        document.getElementById("eventEndDate").value = formattedDate;

                        this.showEvents();
                    });

                    // Formulario
                    document.getElementById("changeFormButton").addEventListener("click", () => {
                        document.getElementById("addForm").style.top = "0";
                    });

                    document.getElementById("cancelAdd").addEventListener("click", (e) => {
                        e.preventDefault();
                        document.getElementById("addForm").style.top = "100%";
                        document.getElementById("eventForm").reset();
                    });

                    // Envío del formulario
                    document.getElementById("eventForm").addEventListener("submit", (e) => {
                        e.preventDefault();
                        this.saveEvent();
                    });

                    // Sidebar móvil
                    document.querySelector('.button-collapse')?.addEventListener('click', function(e) {
                        e.preventDefault();
                        var sidebar = document.getElementById('sidebar');
                        if (sidebar.style.left === '0px') {
                            sidebar.style.left = '-300px';
                        } else {
                            sidebar.style.left = '0px';
                        }
                    });
                },

                saveEvent: function() {
                    const formData = new FormData(document.getElementById("eventForm"));
                    
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
                            document.getElementById("addForm").style.top = "100%";
                            document.getElementById("eventForm").reset();
                            this.loadEvents();
                            this.showToast('Tarea creada exitosamente', 'success');
                        }
                    })
                    .catch(error => {
                        console.error('Error saving event:', error);
                        this.showToast('Error al crear la tarea', 'error');
                    });
                },

                showToast: function(message, type) {
                    M.toast({
                        html: message,
                        classes: type === 'success' ? 'green' : 'red'
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