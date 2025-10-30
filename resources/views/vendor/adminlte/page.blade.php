<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') - Agenda Universitaria</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

  <!-- CSS Personalizado -->
  <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">

  @yield('css')
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo"
        height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ route('dashboard') }}" class="nav-link">Inicio</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#" id="notificationsDropdown">
            <i class="far fa-bell"></i>
            @if(auth()->user()->unreadNotifications->count() > 0)
              <span class="badge badge-warning navbar-badge notification-count">
                {{ auth()->user()->unreadNotifications->count() }}
              </span>
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">
              {{ auth()->user()->unreadNotifications->count() }} Notificaciones
            </span>
            <div class="dropdown-divider"></div>
            <div id="notificationsList">
              @foreach(auth()->user()->unreadNotifications->take(5) as $notification)
                <a href="{{ $notification->data['url'] ?? '#' }}" class="dropdown-item notification-item"
                  data-id="{{ $notification->id }}">
                  <div class="media">
                    <div class="media-body">
                      <h3 class="dropdown-item-title">
                        <i class="fas fa-bell mr-2 text-warning"></i>
                        {{ $notification->data['titulo'] ?? 'Notificación' }}
                      </h3>
                      <p class="text-sm">{{ $notification->data['mensaje'] ?? '' }}</p>
                      <p class="text-sm text-muted">
                        <i class="far fa-clock mr-1"></i>
                        {{ $notification->created_at->diffForHumans() }}
                      </p>
                    </div>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
              @endforeach
            </div>
            <a href="{{ route('notificaciones.index') }}" class="dropdown-item dropdown-footer">Ver todas las
              notificaciones</a>
          </div>
        </li>

        <!-- User Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-user"></i>
            {{ Auth::user()->name }}
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">Mi Cuenta</span>
            <div class="dropdown-divider"></div>
            <a href="{{ route('profile.edit') }}" class="dropdown-item">
              <i class="fas fa-user-edit mr-2"></i> Mi Perfil
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-cog mr-2"></i> Configuración
            </a>
            <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <a href="{{ route('logout') }}" class="dropdown-item"
                onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
              </a>
            </form>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
          class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Agenda Universitaria</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
              alt="User Image">
          </div>
          <div class="info">
            <a href="{{ route('profile.edit') }}" class="d-block">{{ Auth::user()->name }}</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('calendario.index') }}"
                class="nav-link {{ request()->routeIs('calendario.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-calendar"></i>
                <p>Calendario</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('materias.index') }}"
                class="nav-link {{ request()->routeIs('materias.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-book"></i>
                <p>Materias</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('tareas.index') }}"
                class="nav-link {{ request()->routeIs('tareas.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tasks"></i>
                <p>Tareas</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('profile.edit') }}"
                class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Mi Perfil</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              @yield('content_header')
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item active">@yield('title')</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          @yield('content')
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
      </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        Agenda Universitaria v1.0
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2024 <a href="{{ route('dashboard') }}">Agenda Universitaria</a>.</strong> Todos los
      derechos reservados.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

  <!-- SweetAlert2 -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @yield('js')

  <script>
$(document).ready(function() {
    // Marcar notificación como leída al hacer clic
    $(document).on('click', '.notification-item', function(e) {
        e.preventDefault();
        var notificationId = $(this).data('id');
        var url = $(this).attr('href');
        
        // Marcar como leída
        $.post('/notificaciones/' + notificationId + '/read', {
            _token: '{{ csrf_token() }}'
        });
        
        // Redirigir después de un breve delay
        setTimeout(function() {
            window.location.href = url;
        }, 100);
    });

    // Actualizar contador de notificaciones cada 30 segundos
    function updateNotificationCount() {
        $.get('/notificaciones/unread-count', function(data) {
            var count = data.count;
            var $badge = $('.notification-count');
            var $dropdownHeader = $('.dropdown-header');
            
            if (count > 0) {
                if ($badge.length === 0) {
                    $('#notificationsDropdown').append('<span class="badge badge-warning navbar-badge notification-count">' + count + '</span>');
                } else {
                    $badge.text(count);
                }
                $dropdownHeader.text(count + ' Notificaciones');
            } else {
                $badge.remove();
                $dropdownHeader.text('0 Notificaciones');
            }
        });
    }

    // Actualizar cada 30 segundos
    setInterval(updateNotificationCount, 30000);

    // Cargar notificaciones al abrir el dropdown
    $('#notificationsDropdown').on('click', function() {
        $.get('/notificaciones/latest', function(data) {
            var $notificationsList = $('#notificationsList');
            $notificationsList.empty();
            
            if (data.length > 0) {
                data.forEach(function(notification) {
                    var notificationHtml = `
                        <a href="${notification.url}" class="dropdown-item notification-item" data-id="${notification.id}">
                            <div class="media">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        <i class="fas fa-bell mr-2 text-warning"></i>
                                        ${notification.titulo}
                                    </h3>
                                    <p class="text-sm">${notification.mensaje}</p>
                                    <p class="text-sm text-muted">
                                        <i class="far fa-clock mr-1"></i>
                                        ${notification.time}
                                    </p>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                    `;
                    $notificationsList.append(notificationHtml);
                });
            } else {
                $notificationsList.html(`
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item text-center text-muted">
                        No hay notificaciones nuevas
                    </a>
                    <div class="dropdown-divider"></div>
                `);
            }
        });
    });
});
</script>
</body>

</html>