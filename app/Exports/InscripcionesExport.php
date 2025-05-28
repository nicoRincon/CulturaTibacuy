<?php

namespace App\Exports;

use App\Models\Inscripcion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InscripcionesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $idCurso;
    protected $fechaDesde;
    protected $fechaHasta;

    public function __construct($idCurso = null, $fechaDesde = null, $fechaHasta = null)
    {
        $this->idCurso = $idCurso;
        $this->fechaDesde = $fechaDesde;
        $this->fechaHasta = $fechaHasta;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Inscripcion::with(['curso.instructor', 'usuario.documento', 'usuario.contacto']);
        
        // Filtro por curso
        if ($this->idCurso) {
            $query->where('id_curso', $this->idCurso);
        }
        
        // Filtro por fecha
        if ($this->fechaDesde) {
            $query->where('fecha_inscripcion', '>=', $this->fechaDesde);
        }
        
        if ($this->fechaHasta) {
            $query->where('fecha_inscripcion', '<=', $this->fechaHasta);
        }
        
        return $query->orderBy('fecha_inscripcion', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Inscripción',
            'Estudiante',
            'Documento',
            'Email',
            'Teléfono',
            'Curso',
            'Instructor',
            'Nivel',
            'Fecha Inscripción',
            'Estado del Curso',
            'Cupos Totales',
            'Alumnos Inscritos'
        ];
    }

    /**
     * @param mixed $inscripcion
     * @return array
     */
    public function map($inscripcion): array
    {
        $today = now();
        $inicio = $inscripcion->curso->fecha_inicio;
        $fin = $inscripcion->curso->fecha_fin;
        
        // Determinar estado del curso
        if ($today < $inicio) {
            $estadoCurso = 'Próximo';
        } elseif ($today >= $inicio && $today <= $fin) {
            $estadoCurso = 'En Curso';
        } else {
            $estadoCurso = 'Finalizado';
        }
        
        return [
            $inscripcion->id_inscripcion,
            ($inscripcion->usuario->primer_nombre ?? '') . ' ' . ($inscripcion->usuario->primer_apellido ?? ''),
            ($inscripcion->usuario->documento->tipo_documento ?? '') . ': ' . ($inscripcion->usuario->num_documento ?? ''),
            $inscripcion->usuario->contacto->email ?? '',
            $inscripcion->usuario->contacto->telefono ?? '',
            $inscripcion->curso->curso ?? '',
            ($inscripcion->curso->instructor->primer_nombre ?? '') . ' ' . ($inscripcion->curso->instructor->primer_apellido ?? ''),
            $inscripcion->curso->nivel->nivel ?? '',
            $inscripcion->fecha_inscripcion,
            $estadoCurso,
            $inscripcion->curso->cupos ?? 0,
            $inscripcion->curso->cantidad_alumnos ?? 0
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
                    'startColor' => ['rgb' => 'FFC107']
                ]
            ],
        ];
    }
}