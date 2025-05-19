@extends('layouts.dashboard')

@section('title', 'Dashboard - Instructor')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Dashboard - Instructor</h1>

    <h2 class="mt-5">Cursos que Imparte</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Capacidad</th>
                <th>Alumnos Inscritos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursos as $curso)
            <tr>
                <td>{{ $curso->curso }}</td>
                <td>{{ $curso->cupos }}</td>
                <td>{{ $curso->cantidad_alumnos }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5">Inscripciones en tus Cursos</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Fecha de Inscripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inscripciones as $inscripcion)
            <tr>
                <td>{{ $inscripcion->usuario->primer_nombre}}</td>
                <td>{{ $inscripcion->curso->curso }}</td>
                <td>{{ $inscripcion->fecha_inscripcion instanceof \Carbon\Carbon ? $inscripcion->fecha_inscripcion->format('d/m/Y') : $inscripcion->fecha_inscripcion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5">Evaluaciones Recientes</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Nota</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($evaluacionesRecientes as $evaluacion)
            <tr>
                <td>{{ $evaluacion->usuario->primer_nombre }}</td>
                <td>{{ $evaluacion->curso->curso }}</td>
                <td>{{ $evaluacion->nota }}</td>
                <td>{{ $evaluacion->fecha_evaluacion instanceof \Carbon\Carbon ? $evaluacion->fecha_evaluacion->format('d/m/Y') : $evaluacion->fecha_evaluacion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5">Promedio de Evaluaciones por Curso</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Promedio</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($promedio_evaluaciones as $promedio)
            <tr>
                <td>{{ $promedio->curso }}</td>
                <td>{{ number_format($promedio->promedio, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
