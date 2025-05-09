@extends('layouts.dashboard')

@section('title', 'Dashboard - Administrador')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Dashboard - Administrador</h1>

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
