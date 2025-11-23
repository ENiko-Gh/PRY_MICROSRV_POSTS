<!doctype html>

<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Micro-Blog | @yield('title', 'Bienvenido')</title>

    <!-- Enlace a Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- NUEVO: Enlace a Bootstrap Icons (Necesario para los iconos en el Login y Posts) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Estilo personalizado para mejorar la tipografía (opcional, pero mejora la vista) -->
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8f9fa;
            /* Fondo gris claro */
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
            /* Sombra ligera en el navbar */
        }

        .container {
            padding-top: 2rem;
        }
    </style>


</head>

<body>
    <!-- Navbar (Barra de Navegación) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Título / Logo -->
            <a class="navbar-brand" href="{{ route('posts.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-earmark-text-fill mb-1 me-2" viewBox="0 0 16 16">
                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zm0 2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zm0 2a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1z" />
                </svg>
                Micro-Blog
            </a>

            <!-- Lógica Condicional: Sesión Iniciada vs. No Iniciada -->
            <div class="d-flex align-items-center">
                @if (Session::has('token'))
                <!-- Si el usuario tiene token (Sesión activa) -->
                <span class="text-light me-3 small">
                    Microservicio Posts + Token
                </span>

                <!-- Botón Cerrar Sesión (Logout) -->
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        Cerrar Sesión
                    </button>
                </form>
                @else
                <!-- Si el usuario NO tiene token (Sesión inactiva) -->
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                    Iniciar Sesión
                </a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Contenedor Principal (Donde se inyecta el contenido específico) -->
    <div class="container">

        <!-- Manejo de mensajes de éxito/error globales de Laravel -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @yield('content')
    </div>

    <!-- Enlace a Bootstrap 5.3.3 JS (necesario para el botón de cerrar alerta) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>