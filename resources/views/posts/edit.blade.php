@extends('layouts.app')

@section('title', 'Editar Post')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-8">

        <div class="d-flex justify-content-between align-items-center mb-4 pt-3">
            <h1 class="h2 text-dark">Editar Post</h1>
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

                <!-- Formulario de Edición -->
                <form action="{{ route('posts.update', $post->id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- ⚠️ Importante para PUT -->

                    <!-- Campo Título -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Título</label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title" required value="{{ old('title', $post->title) }}" placeholder="Escribe un título conciso y atractivo">
                        @error('title')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo Contenido -->
                    <div class="mb-4">
                        <label for="content" class="form-label fw-bold">Contenido</label>
                        <textarea class="form-control" id="content" name="content" rows="10" required placeholder="Escribe el cuerpo completo de tu artículo aquí...">{{ old('content', $post->content) }}</textarea>
                        @error('content')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo Autor -->
                    <div class="mb-4">
                        <label for="author" class="form-label fw-bold">Autor</label>
                        <input type="text" class="form-control form-control-lg" id="author" name="author" required value="{{ old('author', $post->author) }}" placeholder="Escribe el nombre del autor">
                        @error('author')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save-fill me-2"></i>
                            Actualizar
                        </button>
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-lg">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection