<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe Académico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h2 {
            color: #333;
        }
        h1 {
            text-align: center;
        }
        h2 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-top: 30px;
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
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .student-info {
            margin-bottom: 20px;
        }
        .student-info p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Informe Académico Estudiantil</h1>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
    
    <div class="student-info">
        <h2>Información del Estudiante</h2>
        <p><strong>Nombre:</strong> {{ $user->Primer_Nombre }} {{ $user->Segundo_Nombre }} {{ $user->Primer_Apellido }} {{ $user->Segundo_Apellido }}</p>
        <p><strong>Documento:</strong> {{ $user->documento->Tipo_Documento }} {{ $user->Num_Documento }}</p>
        <p><strong>Correo:</strong> {{ $user->contacto->Correo }}</p>
        <p><strong>Especialidad:</strong> {{ $user->especialidad->Especialidad }}</p>
    </div>
    
    <h2>Cursos Inscritos</h2>
    <table>
        <thead>
            <tr>
                <th>Curso</th>
                <th>Instructor</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Fecha Inscripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscripciones as $inscripcion)
            <tr>
                <td>{{ $inscripcion->curso->Curso }}</td>
                <td>{{ $inscripcion->curso->instructor->Primer_Nombre }} {{ $inscripcion->curso->instructor->Primer_Apellido }}</td>
                <td>{{ $inscripcion->curso->Fecha_Inicio->format('d/m/Y') }}</td>
                <td>{{ $inscripcion->curso->Fecha_Fin->format('d/m/Y') }}</td>
                <td>{{ $inscripcion->Fecha_Inscripcion->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <h2>Evaluaciones</h2>
    <table>
        <thead>
            <tr>
                <th>Curso</th>
                <th>Fecha Evaluación</th>
                <th>Nota</th>
                <th>Comentarios</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluaciones as $evaluacion)
            <tr>
                <td>{{ $evaluacion->curso->Curso }}</td>
                <td>{{ $evaluacion->Fecha_Evaluacion->format('d/m/Y') }}</td>
                <td>{{ number_format($evaluacion->Nota, 2) }}</td>
                <td>{{ $evaluacion->Comentarios }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <h2>Notas Finales</h2>
    <table>
        <thead>
            <tr>
                <th>Curso</th>
                <th>Nota Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notasFinales as $nota)
            <tr>
                <td>{{ $nota->Curso }}</td>
                <td>{{ number_format($nota->Nota_Final, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>© {{ date('Y') }} {{ config('app.name') }} - Todos los derechos reservados</p>
    </div>
</body>
</html>