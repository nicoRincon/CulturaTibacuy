<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsuariosExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $tipoUsuario;
    protected $estado;

    public function __construct($tipoUsuario = 'todos', $estado = 'todos')
    {
        $this->tipoUsuario = $tipoUsuario;
        $this->estado = $estado;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = User::with(['documento', 'genero', 'rol', 'especialidad', 'contacto', 'estado']);
        
        // Filtro por tipo de usuario (rol)
        if ($this->tipoUsuario != 'todos') {
            $rolMap = [
                'estudiantes' => 'Estudiante',
                'instructores' => 'Instructor',
                'administradores' => 'Administrador',
            ];
            
            $query->whereHas('rol', function($q) use ($rolMap) {
                $q->where('rol', $rolMap[$this->tipoUsuario]);
            });
        }
        
        // Filtro por estado
        if ($this->estado != 'todos') {
            $estadoMap = [
                'activos' => 1,
                'inactivos' => 2,
            ];
            
            $query->where('id_estado', $estadoMap[$this->estado]);
        }
        
        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Primer Nombre',
            'Segundo Nombre',
            'Primer Apellido',
            'Segundo Apellido',
            'Tipo Documento',
            'Número Documento',
            'Fecha Nacimiento',
            'Género',
            'Rol',
            'Especialidad',
            'Email',
            'Teléfono',
            'Dirección',
            'Estado',
            'Fecha Registro'
        ];
    }

    /**
     * @param mixed $usuario
     * @return array
     */
    public function map($usuario): array
    {
        return [
            $usuario->id_usuario,
            $usuario->primer_nombre,
            $usuario->segundo_nombre ?? '',
            $usuario->primer_apellido,
            $usuario->segundo_apellido ?? '',
            $usuario->documento->tipo_documento ?? '',
            $usuario->num_documento,
            $usuario->fecha_nacimiento,
            $usuario->genero->genero ?? '',
            $usuario->rol->rol ?? '',
            $usuario->especialidad->especialidad ?? '',
            $usuario->contacto->email ?? '',
            $usuario->contacto->telefono ?? '',
            $usuario->contacto->direccion ?? '',
            $usuario->estado->estado ?? '',
            $usuario->created_at
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para la fila de encabezados
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4']
                ]
            ],
        ];
    }
}