<?php

namespace App\Exports;

use App\Models\Curso;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CursosExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $estadoCurso;

    public function __construct($estadoCurso = 'todos')
    {
        $this->estadoCurso = $estadoCurso;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Curso::with(['recurso', 'horario', 'nivel', 'instructor']);
        
        // Filtro por estado del curso
        if ($this->estadoCurso != 'todos') {
            $today = now()->format('Y-m-d');
            
            if ($this->estadoCurso == 'activos') {
                $query->where('fecha_inicio', '<=', $today)
                      ->where('fecha_fin', '>=', $today);
            } 
            else if ($this->estadoCurso == 'finalizados') {
                $query->where('fecha_fin', '<', $today);
            } 
            else if ($this->estadoCurso == 'proximos') {
                $query->where('fecha_inicio', '>', $today);
            }
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
            'Curso',
            'Objetivo',
            'Nivel',
            'Instructor',
            'Recurso',
            'Horario',
            'Fecha Inicio',
            'Fecha Fin',
            'Cupos',
            'Cantidad Alumnos',
            'Cupos Disponibles',
            'Estado',
            'Porcentaje Ocupación'
        ];
    }

    /**
     * @param mixed $curso
     * @return array
     */
    public function map($curso): array
    {
        $today = now();
        $inicio = $curso->fecha_inicio;
        $fin = $curso->fecha_fin;
        
        // Determinar estado del curso
        if ($today < $inicio) {
            $estado = 'Próximo';
        } elseif ($today >= $inicio && $today <= $fin) {
            $estado = 'Activo';
        } else {
            $estado = 'Finalizado';
        }
        
        // Calcular porcentaje de ocupación
        $porcentajeOcupacion = $curso->cupos > 0 ? 
            round(($curso->cantidad_alumnos / $curso->cupos) * 100, 2) : 0;
        
        return [
            $curso->id_curso,
            $curso->curso,
            $curso->objetivo,
            $curso->nivel->nivel ?? '',
            ($curso->instructor->primer_nombre ?? '') . ' ' . ($curso->instructor->primer_apellido ?? ''),
            $curso->recurso->recurso ?? '',
            ($curso->horario->dia ?? '') . ' ' . ($curso->horario->hora_inicio ?? '') . '-' . ($curso->horario->hora_fin ?? ''),
            $curso->fecha_inicio,
            $curso->fecha_fin,
            $curso->cupos,
            $curso->cantidad_alumnos,
            $curso->cupos - $curso->cantidad_alumnos,
            $estado,
            $porcentajeOcupacion . '%'
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
                    'startColor' => ['rgb' => '28A745']
                ]
            ],
        ];
    }
}