<?php

namespace App\Exports;

use App\Models\ProgramaFormacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProgramasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $idEscuela;

    public function __construct($idEscuela = null)
    {
        $this->idEscuela = $idEscuela;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = ProgramaFormacion::with([
            'tipoEscuela',
            'escuela',
            'ubicacion',
            'curso.instructor',
            'curso.nivel',
            'responsable'
        ]);
        
        // Filtro por escuela
        if ($this->idEscuela) {
            $query->where('id_escuela', $this->idEscuela);
        }
        
        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Programa',
            'Escuela',
            'Tipo de Escuela',
            'Ubicación',
            'Curso',
            'Objetivo del Curso',
            'Nivel',
            'Instructor',
            'Responsable del Programa',
            'Fecha Inicio',
            'Fecha Fin',
            'Cupos',
            'Inscritos',
            'Estado del Curso',
            'Fecha Creación'
        ];
    }

    /**
     * @param mixed $programa
     * @return array
     */
    public function map($programa): array
    {
        $today = now();
        $inicio = $programa->curso->fecha_inicio ?? null;
        $fin = $programa->curso->fecha_fin ?? null;
        
        // Determinar estado del curso
        $estadoCurso = 'Sin definir';
        if ($inicio && $fin) {
            if ($today < $inicio) {
                $estadoCurso = 'Próximo';
            } elseif ($today >= $inicio && $today <= $fin) {
                $estadoCurso = 'En Ejecución';
            } else {
                $estadoCurso = 'Finalizado';
            }
        }
        
        return [
            $programa->id_programa,
            $programa->escuela->nombre ?? '',
            $programa->tipoEscuela->tipos_escuela ?? '',
            $programa->ubicacion->ubicacion ?? '',
            $programa->curso->curso ?? '',
            $programa->curso->objetivo ?? '',
            $programa->curso->nivel->nivel ?? '',
            ($programa->curso->instructor->primer_nombre ?? '') . ' ' . ($programa->curso->instructor->primer_apellido ?? ''),
            ($programa->responsable->primer_nombre ?? '') . ' ' . ($programa->responsable->primer_apellido ?? ''),
            $inicio,
            $fin,
            $programa->curso->cupos ?? 0,
            $programa->curso->cantidad_alumnos ?? 0,
            $estadoCurso,
            $programa->created_at
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
                    'startColor' => ['rgb' => '6F42C1']
                ]
            ],
        ];
    }
}