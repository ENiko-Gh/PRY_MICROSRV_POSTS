@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8 col-lg-5">

        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-primary text-white text-center py-3">
                <h3 class="h4 mb-0">Acceso al Sistema</h3>
            </div>

            <div class="card-body p-4">

                <!-- Mensaje de error general de Laravel -->
                @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    Verifica tus credenciales.
                </div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    <!-- Campo Correo Electrónico -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            class="form-control"
                            required
                            value="{{ old('email') }}"
                            placeholder="usuario@ejemplo.com">
                    </div>

                    <!-- Campo Contraseña -->
                    <div class="mb-4">
                        <label for="password" class="form-label">Contraseña</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="form-control"
                            required
                            placeholder="********">
                    </div>

                    <!-- Botón de Enviar -->
                    <div class="d-grid gap-2">
                        <button
                            type="submit"
                            class="btn btn-success btn-lg shadow-sm">
                            Ingresar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection