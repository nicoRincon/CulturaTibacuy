@extends('layouts.dashboard')

@section('title', 'Informe de Usuarios')

@section('actions')
<a href="{{ route('informes.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
@endsection

@section('content')
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Rol</th>
                <th>Correo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->Id_Usuario }}</td>
                <td>{{ $usuario->Primer_Nombre }} {{ $usuario->Segundo_Nombre }} {{ $usuario->Primer_Apellido }} {{ $usuario->Segundo_Apellido }}</td>
                <td>{{ $usuario->documento->Tipo_Documento }}: {{ $usuario->Num_Documento }}</td>
                <td>{{ $usuario->rol->Rol }}</td>
                <td>{{ $usuario->contacto->Correo }}</td>
                <td>{{ $usuario->estado->Estado }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

<!-- resources/views/informes/usuarios_pdf.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
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
        <h1>Informe de Usuarios</h1>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Rol</th>
                <th>Correo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->Id_Usuario }}</td>
                <td>{{ $usuario->Primer_Nombre }} {{ $usuario->Segundo_Nombre }} {{ $usuario->Primer_Apellido }} {{ $usuario->Segundo_Apellido }}</td>
                <td>{{ $usuario->documento->Tipo_Documento }}: {{ $usuario->Num_Documento }}</td>
                <td>{{ $usuario->rol->Rol }}</td>
                <td>{{ $usuario->contacto->Correo }}</td>
                <td>{{ $usuario->estado->Estado }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>© {{ date('Y') }} {{ config('app.name') }} - Todos los derechos reservados</p>
    </div>
</body>
</html>