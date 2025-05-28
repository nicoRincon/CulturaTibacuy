<?php

namespace App\Exports;

use App\Models\Evaluacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Color;

class EvaluacionesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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
        $query = Evaluacion::with(['curso.instructor', 'usuario.documento']);
        
        // Filtro por curso
        if ($this->idCurso) {
            $query->where('id_curso', $this->idCurso);
        }
        
        // Filtro por fecha
        if ($this->fechaDesde) {
            $query->where('fecha_evaluacion', '>=', $this->fechaDesde);
        }
        
        if ($this->fechaHasta) {
            $query->where('fecha_evaluacion', '<=', $this->fechaHasta);
        }
        
        return $query->orderBy('fecha_evaluacion', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Evaluación',
            'Estudiante',
            'Documento',
            'Curso',
            'Instructor',
            'Fecha Evaluación',
            'Nota',
            'Estado',
            'Comentarios',
            'Rango Calificación'
        ];
    }

    /**
     * @param mixed $evaluacion
     * @return array
     */
    public function map($evaluacion): array
    {
        // Determinar estado de la nota
        $estado = $evaluacion->nota >= 3.0 ? 'Aprobado' : 'Reprobado';
        
        // Determinar rango de calificación
        if ($evaluacion->nota >= 4.5) {
            $rango = 'Excelente';
        } elseif ($evaluacion->nota >= 4.0) {
            $rango = 'Sobresaliente';
        } elseif ($evaluacion->nota >= 3.5) {
            $rango = 'Bueno';
        } elseif ($evaluacion->nota >= 3.0) {
            $rango = 'Aceptable';
        } else {
            $rango = 'Insuficiente';
        }
        
        return [
            $evaluacion->id_evaluacion,
            ($evaluacion->usuario->primer_nombre ?? '') . ' ' . ($evaluacion->usuario->primer_apellido ?? ''),
            $evaluacion->usuario->num_documento ?? '',
            $evaluacion->curso->curso ?? '',
            ($evaluacion->curso->instructor->primer_nombre ?? '') . ' ' . ($evaluacion->curso->instructor->primer_apellido ?? ''),
            $evaluacion->fecha_evaluacion,
            $evaluacion->nota,
            $estado,
            $evaluacion->comentarios ?? '',
            $rango
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Obtener el rango de datos
        $highestRow = $sheet->getHighestRow();
        
        return [
            // Estilo para la fila de encabezados
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'DC3545']
                ]
            ],
            // Formato condicional para las notas
            'G2:G' . $highestRow => [
                'conditionalStyles' => [
                    [
                        'ranges' => ['G2:G' . $highestRow],
                        'style' => [
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'D4EDDA']
                            ]
                        ],
                        'condition' => [
                            'conditionType' => Conditional::CONDITION_CELLIS,
                            'operatorType' => Conditional::OPERATOR_GREATERTHANOREQUAL,
                            'operand1' => '3.0'
                        ]
                    ],
                    [
                        'ranges' => ['G2:G' . $highestRow],
                        'style' => [
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'F8D7DA']
                            ]
                        ],
                        'condition' => [
                            'conditionType' => Conditional::CONDITION_CELLIS,
                            'operatorType' => Conditional::OPERATOR_LESSTHAN,
                            'operand1' => '3.0'
                        ]
                    ]
                ]
            ]
        ];
    }
}