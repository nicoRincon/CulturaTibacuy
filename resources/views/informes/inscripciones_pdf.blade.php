<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Inscripciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }
        .summary {
            background-color: #e8f4f8;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Informe de Inscripciones</h1>
        <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        <p><strong>Generado por:</strong> {{ Auth::user()->primer_nombre }} {{ Auth::user()->primer_apellido }}</p>
    </div>
    
    <!-- Resumen -->
    <div class="summary">
        <h3>Resumen del Informe</h3>
        <p><strong>Total de inscripciones:</strong> {{ $inscripciones->count() }}</p>
        <p><strong>Cursos diferentes:</strong> {{ $inscripciones->unique('id_curso')->count() }}</p>
        <p><strong>Estudiantes diferentes:</strong> {{ $inscripciones->unique('id_usuario')->count() }}</p>
    </div>
    
    <!-- Tabla de inscripciones -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Estudiante</th>
                <th>Documento</th>
                <th>Curso</th>
                <th>Instructor</th>
                <th>Fecha Inscripción</th>
                <th>Especialidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscripciones as $inscripcion)
            <tr>
                <td>{{ $inscripcion->id_inscripcion }}</td>
                <td>
                    {{ $inscripcion->usuario->primer_nombre ?? 'N/A' }} 
                    {{ $inscripcion->usuario->primer_apellido ?? '' }}
                </td>
                <td>{{ $inscripcion->usuario->num_documento ?? 'N/A' }}</td>
                <td>{{ $inscripcion->curso->curso ?? 'N/A' }}</td>
                <td>
                    {{ $inscripcion->curso->instructor->primer_nombre ?? 'Sin instructor' }} 
                    {{ $inscripcion->curso->instructor->primer_apellido ?? '' }}
                </td>
                <td>
                    {{ $inscripcion->fecha_inscripcion instanceof \Carbon\Carbon ? 
                        $inscripcion->fecha_inscripcion->format('d/m/Y') : 
                        $inscripcion->fecha_inscripcion }}
                </td>
                <td>{{ $inscripcion->usuario->especialidad->especialidad ?? 'Sin especialidad' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Estadísticas por curso -->
    @php
        $inscripcionesPorCurso = $inscripciones->groupBy(function($inscripcion) {
            return $inscripcion->curso->curso ?? 'Sin curso';
        });
    @endphp
    
    @if($inscripcionesPorCurso->count() > 0)
    <div style="margin-top: 30px;">
        <h3>Inscripciones por Curso</h3>
        <table style="width: 70%;">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Cantidad de Inscripciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inscripcionesPorCurso as $curso => $inscripcionesDelCurso)
                <tr>
                    <td>{{ $curso }}</td>
                    <td>{{ $inscripcionesDelCurso->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    
    <div class="footer">
        <p>© {{ date('Y') }} {{ config('app.name', 'Sistema Escolar') }} - Todos los derechos reservados</p>
    </div>
</body>
</html>