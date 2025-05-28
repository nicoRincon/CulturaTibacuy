<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Inscripcion;
use App\Models\Evaluacion;
use App\Models\NotaFinal;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EstudianteExport implements WithMultipleSheets
{
    protected $idUsuario;

    public function __construct($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        
        $sheets[] = new EstudianteInfoSheet($this->idUsuario);
        $sheets[] = new EstudianteInscripcionesSheet($this->idUsuario);
        $sheets[] = new EstudianteEvaluacionesSheet($this->idUsuario);
        $sheets[] = new EstudianteNotasFinalesSheet($this->idUsuario);
        
        return $sheets;
    }
}

// Hoja de información del estudiante
class EstudianteInfoSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $idUsuario;

    public function __construct($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function collection()
    {
        return collect([User::with(['documento', 'genero', 'rol', 'especialidad', 'contacto', 'lugarNacimiento.pais', 'lugarNacimiento.departamento', 'lugarNacimiento.municipio'])->find($this->idUsuario)]);
    }

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
            'Lugar Nacimiento',
            'Género',
            'Especialidad',
            'Email',
            'Teléfono',
            'Dirección',
            'Fecha Registro'
        ];
    }

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
            ($usuario->lugarNacimiento->municipio->municipio ?? '') . ', ' . 
            ($usuario->lugarNacimiento->departamento->departamento ?? '') . ', ' . 
            ($usuario->lugarNacimiento->pais->pais ?? ''),
            $usuario->genero->genero ?? '',
            $usuario->especialidad->especialidad ?? '',
            $usuario->contacto->email ?? '',
            $usuario->contacto->telefono ?? '',
            $usuario->contacto->direccion ?? '',
            $usuario->created_at
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4']
                ]
            ],
        ];
    }

    public function title(): string
    {
        return 'Información Personal';
    }
}

// Hoja de inscripciones
class EstudianteInscripcionesSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $idUsuario;

    public function __construct($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function collection()
    {
        return Inscripcion::where('id_usuario', $this->idUsuario)
            ->with(['curso.instructor', 'curso.nivel'])
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Inscripción',
            'Curso',
            'Instructor',
            'Nivel',
            'Fecha Inicio',
            'Fecha Fin',
            'Fecha Inscripción',
            'Estado del Curso'
        ];
    }

    public function map($inscripcion): array
    {
        $today = now();
        $inicio = $inscripcion->curso->fecha_inicio;
        $fin = $inscripcion->curso->fecha_fin;
        
        if ($today < $inicio) {
            $estado = 'Próximo';
        } elseif ($today >= $inicio && $today <= $fin) {
            $estado = 'En Curso';
        } else {
            $estado = 'Finalizado';
        }
        
        return [
            $inscripcion->id_inscripcion,
            $inscripcion->curso->curso ?? '',
            ($inscripcion->curso->instructor->primer_nombre ?? '') . ' ' . ($inscripcion->curso->instructor->primer_apellido ?? ''),
            $inscripcion->curso->nivel->nivel ?? '',
            $inscripcion->curso->fecha_inicio,
            $inscripcion->curso->fecha_fin,
            $inscripcion->fecha_inscripcion,
            $estado
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '28A745']
                ]
            ],
        ];
    }

    public function title(): string
    {
        return 'Inscripciones';
    }
}

// Hoja de evaluaciones
class EstudianteEvaluacionesSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $idUsuario;

    public function __construct($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function collection()
    {
        return Evaluacion::where('id_usuario', $this->idUsuario)
            ->with('curso')
            ->orderBy('fecha_evaluacion', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Evaluación',
            'Curso',
            'Fecha Evaluación',
            'Nota',
            'Estado',
            'Comentarios'
        ];
    }

    public function map($evaluacion): array
    {
        $estado = $evaluacion->nota >= 3.0 ? 'Aprobado' : 'Reprobado';
        
        return [
            $evaluacion->id_evaluacion,
            $evaluacion->curso->curso ?? '',
            $evaluacion->fecha_evaluacion,
            $evaluacion->nota,
            $estado,
            $evaluacion->comentarios ?? ''
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFC107']
                ]
            ],
        ];
    }

    public function title(): string
    {
        return 'Evaluaciones';
    }
}

// Hoja de notas finales
class EstudianteNotasFinalesSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $idUsuario;

    public function __construct($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function collection()
    {
        return NotaFinal::where('id_usuario', $this->idUsuario)
            ->with('curso')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Curso',
            'Nota Final',
            'Estado',
            'Rango'
        ];
    }

    public function map($notaFinal): array
    {
        $estado = $notaFinal->nota_final >= 3.0 ? 'Aprobado' : 'Reprobado';
        
        // Determinar rango
        if ($notaFinal->nota_final >= 4.5) {
            $rango = 'Excelente';
        } elseif ($notaFinal->nota_final >= 4.0) {
            $rango = 'Sobresaliente';
        } elseif ($notaFinal->nota_final >= 3.5) {
            $rango = 'Bueno';
        } elseif ($notaFinal->nota_final >= 3.0) {
            $rango = 'Aceptable';
        } else {
            $rango = 'Insuficiente';
        }
        
        return [
            $notaFinal->curso->curso ?? '',
            $notaFinal->nota_final,
            $estado,
            $rango
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'DC3545']
                ]
            ],
        ];
    }

    public function title(): string
    {
        return 'Notas Finales';
    }
}