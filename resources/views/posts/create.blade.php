@extends('layouts.app')

@section('title', 'Crear Nuevo Post')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-8">

        <div class="d-flex justify-content-between align-items-center mb-4 pt-3">
            <h1 class="h2 text-dark">Crear Nuevo Artículo</h1>
            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-square-fill me-1"></i>
                Volver al Listado
            </a>
        </div>

        <div class="card shadow-lg border-0 mb-5">
            <div class="card-body p-4 p-md-5">

                @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif

                <!-- Formulario de Creación (Apunta al método store, que luego redirige al index con el mensaje de éxito) -->
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf

                    <!-- Campo Título -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Título del Post</label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title" required value="{{ old('title') }}" placeholder="Escribe un título conciso y atractivo">
                        @error('title')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo Contenido -->
                    <div class="mb-4">
                        <label for="content" class="form-label fw-bold">Contenido del Post</label>
                        <textarea class="form-control" id="content" name="content" rows="10" required placeholder="Escribe el cuerpo completo de tu artículo aquí...">{{ old('content') }}</textarea>
                        @error('content')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo Autor -->
                    <div class="mb-4">
                        <label for="author" class="form-label fw-bold">Autor</label>
                        <input type="text" class="form-control form-control-lg" id="author" name="author" required value="{{ old('author') }}" placeholder="Escribe el nombre del autor">
                        @error('author')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Botón de Guardar -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg shadow">
                            <i class="bi bi-save-fill me-2"></i>
                            Guardar Artículo
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection