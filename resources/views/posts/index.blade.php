@extends('layouts.app')

@section('title', 'Listado de Posts')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 pt-3">
    <h1 class="h2 text-dark">Listado de Posts del Micro-Blog (50 Artículos)</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-primary btn-lg shadow-sm">
        <i class="bi bi-plus-circle-fill me-1"></i>
        Crear Nuevo Post
    </a>
</div>

<!-- MANEJO DEL MENSAJE DE ÉXITO (Resuelve "donde se guarda") -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>¡Operación Exitosa!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body p-0">

        @if(empty($posts))
        <div class="alert alert-warning m-4" role="alert">
            Aún no hay posts para mostrar. ¡Crea el primero!
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 5%;">ID</th>
                        <th scope="col">Título del Artículo</th>
                        <th scope="col" style="width: 15%;">Autor</th>
                        <th scope="col" style="width: 15%;">Fecha de Creación</th>
                        <th scope="col" class="text-center" style="width: 15%;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <th scope="row">{{ $post->id }}</th>
                        <td>
                            <a href="#" class="text-decoration-none text-dark fw-bold">
                                {{ Str::limit($post->title, 60) }}
                            </a>
                        </td>
                        <td>{{ $post->author }}</td>
                        <td>{{ $post->created_at ?? 'N/A' }}</td>
                        <td class="text-center">
                            <!-- Botón de Editar -->
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-info me-2" title="Editar Post">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <!-- Botón de Eliminar (Formulario para DELETE) -->
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Está seguro de eliminar este post?')" title="Eliminar Post">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

@endsection