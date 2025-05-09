@extends('layouts.dashboard')

@section('title', 'Dashboard - Estudiante')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Dashboard - Estudiante</h1>

    <h2 class="mt-5">Mis Inscripciones</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Fecha de Inscripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inscripciones as $inscripcion)
            <tr>
                <td>{{ $inscripcion->curso->curso }}</td>
                <td>{{ $inscripcion->fecha_inscripcion instanceof \Carbon\Carbon ? $inscripcion->fecha_inscripcion->format('d/m/Y') : $inscripcion->fecha_inscripcion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5">Mis Evaluaciones</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($evaluaciones as $evaluacion)
            <tr>
                <td>{{ $evaluacion->curso->curso }}</td>
                <td>{{ $evaluacion->nota }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5">Notas Finales</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Nota Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notasFinales as $notaFinal)
            <tr>
                <td>{{ $notaFinal->curso }}</td>
                <td>{{ $notaFinal->nota_final }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5">Cursos Disponibles</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Cupos Disponibles</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursosDisponibles as $curso)
            <tr>
                <td>{{ $curso->curso }}</td>
                <td>{{ $curso->cupos - $curso->cantidad_alumnos }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
