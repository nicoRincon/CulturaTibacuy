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
        .summary h3 {
            margin: 0 0 10px 0;
            color: #2c3e50;
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
        <h1>Informe de Usuarios</h1>
        <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        <p><strong>Generado por:</strong> {{ Auth::user()->primer_nombre }} {{ Auth::user()->primer_apellido }}</p>
    </div>
    
    <!-- Resumen -->
    <div class="summary">
        <h3>Resumen del Informe</h3>
        <p><strong>Total de usuarios:</strong> {{ $usuarios->count() }}</p>
        <p><strong>Usuarios activos:</strong> {{ $usuarios->where('id_estado', 1)->count() }}</p>
        <p><strong>Usuarios inactivos:</strong> {{ $usuarios->where('id_estado', '!=', 1)->count() }}</p>
    </div>
    
    <!-- Tabla de usuarios -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Documento</th>
                <th>Rol</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Especialidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id_usuario }}</td>
                <td>
                    {{ $usuario->primer_nombre }} 
                    {{ $usuario->segundo_nombre }} 
                    {{ $usuario->primer_apellido }} 
                    {{ $usuario->segundo_apellido }}
                </td>
                <td>
                    {{ $usuario->documento->tipo_documento ?? 'N/A' }}: 
                    {{ $usuario->num_documento }}
                </td>
                <td>{{ $usuario->rol->rol ?? 'Sin rol' }}</td>
                <td>{{ $usuario->contacto->email ?? 'Sin email' }}</td>
                <td>{{ $usuario->contacto->telefono ?? 'Sin teléfono' }}</td>
                <td>
                    @if($usuario->id_estado == 1)
                        <span class="badge badge-success">Activo</span>
                    @else
                        <span class="badge badge-danger">Inactivo</span>
                    @endif
                </td>
                <td>{{ $usuario->especialidad->especialidad ?? 'Sin especialidad' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Estadísticas por rol -->
    @php
        $usuariosPorRol = $usuarios->groupBy(function($user) {
            return $user->rol->rol ?? 'Sin rol';
        });
    @endphp
    
    @if($usuariosPorRol->count() > 0)
    <div style="margin-top: 30px;">
        <h3>Distribución por Roles</h3>
        <table style="width: 50%;">
            <thead>
                <tr>
                    <th>Rol</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuariosPorRol as $rol => $usuariosDelRol)
                <tr>
                    <td>{{ $rol }}</td>
                    <td>{{ $usuariosDelRol->count() }}</td>
                    <td>{{ number_format(($usuariosDelRol->count() / $usuarios->count()) * 100, 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    
    <div class="footer">
        <p>© {{ date('Y') }} {{ config('app.name', 'Sistema Escolar') }} - Todos los derechos reservados</p>
        <p>Este informe contiene información confidencial y está destinado únicamente para uso interno</p>
    </div>
</body>
</html>