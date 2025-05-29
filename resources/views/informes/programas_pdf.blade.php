<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Programas de Formación</title>
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
        .badge-primary {
            background-color: #cce5ff;
            color: #004085;
        }
        .badge-secondary {
            background-color: #e2e3e5;
            color: #383d41;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Informe de Programas de Formación</h1>
        <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        <p><strong>Generado por:</strong> {{ Auth::user()->primer_nombre }} {{ Auth::user()->primer_apellido }}</p>
    </div>
    
    <!-- Resumen -->
    <div class="summary">
        <h3>Resumen del Informe</h3>
        <p><strong>Total de programas:</strong> {{ $programas->count() }}</p>
        <p><strong>Escuelas diferentes:</strong> {{ $programas->unique('id_escuela')->count() }}</p>
        <p><strong>Tipos de escuela:</strong> {{ $programas->unique('id_tipo_escuela')->count() }}</p>
        <p><strong>Ubicaciones diferentes:</strong> {{ $programas->unique('id_ubicacion')->count() }}</p>
        <p><strong>Total de estudiantes en programas:</strong> {{ $programas->sum(function($programa) { return $programa->curso->cantidad_alumnos ?? 0; }) }}</p>
    </div>
    
    <!-- Tabla de programas -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Escuela</th>
                <th>Tipo Escuela</th>
                <th>Curso</th>
                <th>Ubicación</th>
                <th>Responsable</th>
                <th>Instructor</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Inscritos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($programas as $programa)
            <tr>
                <td>{{ $programa->id_programa }}</td>
                <td>{{ $programa->escuela->nombre ?? 'Sin escuela' }}</td>
                <td>
                    <span class="badge badge-primary">
                        {{ $programa->tipoEscuela->tipos_escuela ?? 'Sin tipo' }}
                    </span>
                </td>
                <td>{{ $programa->curso->curso ?? 'Sin curso' }}</td>
                <td>{{ $programa->ubicacion->ubicacion ?? 'Sin ubicación' }}</td>
                <td>
                    {{ $programa->responsable->primer_nombre ?? 'Sin responsable' }} 
                    {{ $programa->responsable->primer_apellido ?? '' }}
                </td>
                <td>
                    {{ $programa->curso->instructor->primer_nombre ?? 'Sin instructor' }} 
                    {{ $programa->curso->instructor->primer_apellido ?? '' }}
                </td>
                <td>
                    @if($programa->curso)
                        {{ $programa->curso->fecha_inicio instanceof \Carbon\Carbon ? 
                            $programa->curso->fecha_inicio->format('d/m/Y') : 
                            $programa->curso->fecha_inicio }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($programa->curso)
                        {{ $programa->curso->fecha_fin instanceof \Carbon\Carbon ? 
                            $programa->curso->fecha_fin->format('d/m/Y') : 
                            $programa->curso->fecha_fin }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $programa->curso->cantidad_alumnos ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Estadísticas por escuela -->
    @php
        $programasPorEscuela = $programas->groupBy(function($programa) {
            return $programa->escuela->nombre ?? 'Sin escuela';
        });
    @endphp
    
    @if($programasPorEscuela->count() > 0)
    <div style="margin-top: 30px;">
        <h3>Programas por Escuela</h3>
        <table style="width: 70%;">
            <thead>
                <tr>
                    <th>Escuela</th>
                    <th>Cantidad de Programas</th>
                    <th>Total Estudiantes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($programasPorEscuela as $escuela => $programasEscuela)
                <tr>
                    <td>{{ $escuela }}</td>
                    <td>{{ $programasEscuela->count() }}</td>
                    <td>{{ $programasEscuela->sum(function($programa) { return $programa->curso->cantidad_alumnos ?? 0; }) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    
    <!-- Estadísticas por tipo de escuela -->
    @php
        $programasPorTipo = $programas->groupBy(function($programa) {
            return $programa->tipoEscuela->tipos_escuela ?? 'Sin tipo';
        });
    @endphp
    
    @if($programasPorTipo->count() > 0)
    <div style="margin-top: 30px;">
        <h3>Programas por Tipo de Escuela</h3>
        <table style="width: 70%;">
            <thead>
                <tr>
                    <th>Tipo de Escuela</th>
                    <th>Cantidad de Programas</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($programasPorTipo as $tipo => $programasTipo)
                <tr>
                    <td>{{ $tipo }}</td>
                    <td>{{ $programasTipo->count() }}</td>
                    <td>{{ number_format(($programasTipo->count() / $programas->count()) * 100, 1) }}%</td>
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