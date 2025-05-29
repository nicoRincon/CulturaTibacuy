<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Evaluaciones</title>
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
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Informe de Evaluaciones</h1>
        <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        <p><strong>Generado por:</strong> {{ Auth::user()->primer_nombre }} {{ Auth::user()->primer_apellido }}</p>
    </div>
    
    <!-- Resumen -->
    <div class="summary">
        <h3>Resumen del Informe</h3>
        <p><strong>Total de evaluaciones:</strong> {{ $evaluaciones->count() }}</p>
        <p><strong>Promedio general:</strong> {{ number_format($evaluaciones->avg('nota'), 2) }}</p>
        <p><strong>Nota más alta:</strong> {{ number_format($evaluaciones->max('nota'), 2) }}</p>
        <p><strong>Nota más baja:</strong> {{ number_format($evaluaciones->min('nota'), 2) }}</p>
        <p><strong>Estudiantes aprobados:</strong> {{ $evaluaciones->where('nota', '>=', 3.0)->count() }} ({{ number_format(($evaluaciones->where('nota', '>=', 3.0)->count() / $evaluaciones->count()) * 100, 1) }}%)</p>
    </div>
    
    <!-- Tabla de evaluaciones -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Instructor</th>
                <th>Fecha Evaluación</th>
                <th>Nota</th>
                <th>Estado</th>
                <th>Comentarios</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluaciones as $evaluacion)
            <tr>
                <td>{{ $evaluacion->id_evaluacion }}</td>
                <td>
                    {{ $evaluacion->usuario->primer_nombre ?? 'N/A' }} 
                    {{ $evaluacion->usuario->primer_apellido ?? '' }}
                </td>
                <td>{{ $evaluacion->curso->curso ?? 'N/A' }}</td>
                <td>
                    {{ $evaluacion->curso->instructor->primer_nombre ?? 'Sin instructor' }} 
                    {{ $evaluacion->curso->instructor->primer_apellido ?? '' }}
                </td>
                <td>
                    {{ $evaluacion->fecha_evaluacion instanceof \Carbon\Carbon ? 
                        $evaluacion->fecha_evaluacion->format('d/m/Y') : 
                        $evaluacion->fecha_evaluacion }}
                </td>
                <td>{{ number_format($evaluacion->nota, 2) }}</td>
                <td>
                    @if($evaluacion->nota >= 3.0)
                        <span class="badge badge-success">Aprobado</span>
                    @else
                        <span class="badge badge-danger">Reprobado</span>
                    @endif
                </td>
                <td>{{ $evaluacion->comentarios ? Str::limit($evaluacion->comentarios, 50) : 'Sin comentarios' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Estadísticas por curso -->
    @php
        $evaluacionesPorCurso = $evaluaciones->groupBy(function($evaluacion) {
            return $evaluacion->curso->curso ?? 'Sin curso';
        });
    @endphp
    
    @if($evaluacionesPorCurso->count() > 0)
    <div style="margin-top: 30px;">
        <h3>Estadísticas por Curso</h3>
        <table style="width: 80%;">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Evaluaciones</th>
                    <th>Promedio</th>
                    <th>Aprobados</th>
                    <th>% Aprobación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evaluacionesPorCurso as $curso => $evaluacionesDelCurso)
                <tr>
                    <td>{{ $curso }}</td>
                    <td>{{ $evaluacionesDelCurso->count() }}</td>
                    <td>{{ number_format($evaluacionesDelCurso->avg('nota'), 2) }}</td>
                    <td>{{ $evaluacionesDelCurso->where('nota', '>=', 3.0)->count() }}</td>
                    <td>{{ number_format(($evaluacionesDelCurso->where('nota', '>=', 3.0)->count() / $evaluacionesDelCurso->count()) * 100, 1) }}%</td>
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