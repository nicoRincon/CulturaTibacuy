@extends('layouts.dashboard')

@section('content')
<div class="container">
    <!-- Botón de Mi Perfil -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-center">Administrador</h1>
                <div class="d-flex gap-2" >
                    <a href="{{ route('usuarios.show', Auth::user()->id_usuario) }}" class="btn btn-outline-primary">
                        <i class="fas fa-user"></i> Ver Mi Perfil
                    </a>
                    <a href="{{ route('usuarios.edit', Auth::user()->id_usuario) }}" class="btn btn-primary">
                        <i class="fas fa-user-edit"></i> Editar Mi Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Información personal del usuario -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 24px;">
                                {{ substr(Auth::user()->primer_nombre, 0, 1) }}{{ substr(Auth::user()->primer_apellido, 0, 1) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-1">{{ Auth::user()->primer_nombre }} {{ Auth::user()->primer_apellido }}</h4>
                            <p class="text-muted mb-1">{{ Auth::user()->rol->rol }}</p>
                            <p class="text-muted mb-0">{{ Auth::user()->contacto->email }}</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <small class="text-muted">Último acceso:</small><br>
                            <small class="text-muted">{{ now()->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row text-center mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Usuarios</h5>
                    <p class="card-text display-6 text-primary">{{ $totalUsuarios }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Cursos</h5>
                    <p class="card-text display-6 text-success">{{ $totalCursos }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Inscripciones</h5>
                    <p class="card-text display-6 text-warning">{{ $totalInscripciones }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Escuelas</h5>
                    <p class="card-text display-6 text-danger">{{ $totalEscuelas }}</p>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mt-5">Cursos por Capacidad</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Cupos</th>
                <th>Alumnos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursosPorCapacidad as $curso)
            <tr>
                <td>{{ $curso->curso }}</td>
                <td>{{ $curso->cupos }}</td>
                <td>{{ $curso->cantidad_alumnos }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5">Usuarios por Rol</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Rol</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuariosPorRol as $rol)
            <tr>
                <td>{{ $rol->rol }}</td>
                <td>{{ $rol->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5">Programas por Escuela</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Escuela</th>
                <th>Total Programas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($programasPorEscuela as $escuela)
            <tr>
                <td>{{ $escuela->nombre }}</td>
                <td>{{ $escuela->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
