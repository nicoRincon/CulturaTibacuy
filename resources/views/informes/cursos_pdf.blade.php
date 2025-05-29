<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Cursos</title>
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
            font-size: 10px;
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
            font-size: 9px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Informe de Cursos</h1>
        <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        <p><strong>Generado por:</strong> {{ Auth::user()->primer_nombre }} {{ Auth::user()->primer_apellido }}</p>
    </div>
    
    <!-- Resumen -->
    <div class="summary">
        <h3>Resumen del Informe</h3>
        <p><strong>Total de cursos:</strong> {{ $cursos->count() }}</p>
        <p><strong>Total de cupos:</strong> {{ $cursos->sum('cupos') }}</p>
        <p><strong>Total de estudiantes inscritos:</strong> {{ $cursos->sum('cantidad_alumnos') }}</p>
        <p><strong>Cupos disponibles:</strong> {{ $cursos->sum('cupos') - $cursos->sum('cantidad_alumnos') }}</p>
    </div>
    
    <!-- Tabla de cursos -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Curso</th>
                <th>Instructor</th>
                <th>Nivel</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Cupos</th>
                <th>Inscritos</th>
                <th>Disponibles</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cursos as $curso)
            <tr>
                <td>{{ $curso->id_curso }}</td>
                <td>{{ $curso->curso }}</td>
                <td>
                    {{ $curso->instructor->primer_nombre ?? 'Sin instructor' }} 
                    {{ $curso->instructor->primer_apellido ?? '' }}
                </td>
                <td>{{ $curso->nivel->nivel ?? 'Sin nivel' }}</td>
                <td>
                    {{ $curso->fecha_inicio instanceof \Carbon\Carbon ? $curso->fecha_inicio->format('d/m/Y') : $curso->fecha_inicio }}
                </td>
                <td>
                    {{ $curso->fecha_fin instanceof \Carbon\Carbon ? $curso->fecha_fin->format('d/m/Y') : $curso->fecha_fin }}
                </td>
                <td>{{ $curso->cupos }}</td>
                <td>{{ $curso->cantidad_alumnos }}</td>
                <td>{{ $curso->cupos - $curso->cantidad_alumnos }}</td>
                <td>
                    @php
                        $hoy = now();
                        $inicio = $curso->fecha_inicio instanceof \Carbon\Carbon ? $curso->fecha_inicio : \Carbon\Carbon::parse($curso->fecha_inicio);
                        $fin = $curso->fecha_fin instanceof \Carbon\Carbon ? $curso->fecha_fin : \Carbon\Carbon::parse($curso->fecha_fin);
                    @endphp
                    @if($hoy->lt($inicio))
                        <span class="badge badge-info">Próximo</span>
                    @elseif($hoy->between($inicio, $fin))
                        <span class="badge badge-success">Activo</span>
                    @else
                        <span class="badge badge-warning">Finalizado</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Estadísticas por nivel -->
    @php
        $cursosPorNivel = $cursos->groupBy(function($curso) {
            return $curso->nivel->nivel ?? 'Sin nivel';
        });
    @endphp
    
    @if($cursosPorNivel->count() > 0)
    <div style="margin-top: 30px;">
        <h3>Distribución por Niveles</h3>
        <table style="width: 60%;">
            <thead>
                <tr>
                    <th>Nivel</th>
                    <th>Cantidad de Cursos</th>
                    <th>Total Cupos</th>
                    <th>Total Inscritos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cursosPorNivel as $nivel => $cursosDelNivel)
                <tr>
                    <td>{{ $nivel }}</td>
                    <td>{{ $cursosDelNivel->count() }}</td>
                    <td>{{ $cursosDelNivel->sum('cupos') }}</td>
                    <td>{{ $cursosDelNivel->sum('cantidad_alumnos') }}</td>
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