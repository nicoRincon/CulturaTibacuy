<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use http\Models\User;

class SampleDataSeeder extends Seeder
{
    /**
     * Crear datos de ejemplo para desarrollo y pruebas.
     * Este seeder es OPCIONAL y se ejecuta por separado.
     */
    public function run(): void
    {
        $this->command->info('🎭 Creando datos de ejemplo...');
        
        $this->command->info('📚 Creando cursos de ejemplo...');
        $this->createSampleCourses();
        
        $this->command->info('📝 Creando inscripciones de ejemplo...');
        $this->createSampleEnrollments();
        
        $this->command->info('⭐ Creando evaluaciones de ejemplo...');
        $this->createSampleEvaluations();
        
        $this->command->info('🎓 Creando programas de formación de ejemplo...');
        $this->createSamplePrograms();
        
        $this->command->info('✅ ¡Datos de ejemplo creados exitosamente!');
    }

    private function createSampleCourses(): void
    {
        // Obtener instructor existente (del DatabaseSeeder principal)
        $instructor = DB::table('usuarios')
            ->join('roles', 'usuarios.id_rol', '=', 'roles.id_rol')
            ->where('roles.rol', 'Instructor')
            ->select('usuarios.*')
            ->first();
        
        if (!$instructor) {
            $this->command->warn('No se encontraron instructores. Saltando creación de cursos adicionales...');
            return;
        }
        
        $salon = DB::table('recursos')->where('recurso', 'Salón Principal')->first();
        $aula = DB::table('recursos')->where('recurso', 'Aula Múltiple')->first();
        $biblioteca = DB::table('recursos')->where('recurso', 'Biblioteca Municipal')->first();
        
        $horario_lunes = DB::table('horarios')->where('dia', 'Lunes')->first();
        $horario_miercoles = DB::table('horarios')->where('dia', 'Miércoles')->first();
        $horario_viernes = DB::table('horarios')->where('dia', 'Viernes')->first();
        
        $nivel_inicial = DB::table('niveles')->where('nivel', 'Inicial')->first();
        $nivel_intermedio = DB::table('niveles')->where('nivel', 'Intermedio')->first();

        if (!$salon || !$horario_lunes || !$nivel_inicial) {
            $this->command->warn('No se pudieron crear cursos: faltan datos básicos requeridos');
            return;
        }

        // Cursos adicionales de ejemplo
        $cursos = [
            [
                'curso' => 'Canto Lírico',
                'objetivo' => 'Desarrollar técnicas de canto lírico y expresión vocal',
                'cupos' => 12,
                'id_recurso' => $salon->id_recurso,
                'id_horario' => $horario_lunes->id_horario,
                'id_nivel' => $nivel_inicial->id_nivel,
                'fecha_inicio' => now()->addDays(30)->format('Y-m-d'),
                'fecha_fin' => now()->addMonths(8)->format('Y-m-d'),
            ],
            [
                'curso' => 'Teatro Juvenil',
                'objetivo' => 'Iniciación en las artes dramáticas para jóvenes',
                'cupos' => 18,
                'id_recurso' => $aula ? $aula->id_recurso : $salon->id_recurso,
                'id_horario' => $horario_miercoles ? $horario_miercoles->id_horario : $horario_lunes->id_horario,
                'id_nivel' => $nivel_inicial->id_nivel,
                'fecha_inicio' => now()->addDays(45)->format('Y-m-d'),
                'fecha_fin' => now()->addMonths(7)->format('Y-m-d'),
            ],
            [
                'curso' => 'Guitarra Intermedia',
                'objetivo' => 'Perfeccionar técnicas intermedias de guitarra acústica',
                'cupos' => 10,
                'id_recurso' => $biblioteca ? $biblioteca->id_recurso : $salon->id_recurso,
                'id_horario' => $horario_viernes ? $horario_viernes->id_horario : $horario_lunes->id_horario,
                'id_nivel' => $nivel_intermedio ? $nivel_intermedio->id_nivel : $nivel_inicial->id_nivel,
                'fecha_inicio' => now()->addDays(60)->format('Y-m-d'),
                'fecha_fin' => now()->addMonths(9)->format('Y-m-d'),
            ]
        ];

        foreach ($cursos as $curso) {
            $existe = DB::table('cursos')->where('curso', $curso['curso'])->exists();
            if ($existe) {
                $this->command->info("Curso {$curso['curso']} ya existe, saltando...");
                continue;
            }

            DB::table('cursos')->insert([
                'curso' => $curso['curso'],
                'id_recurso' => $curso['id_recurso'],
                'id_horario' => $curso['id_horario'],
                'fecha_inicio' => $curso['fecha_inicio'],
                'fecha_fin' => $curso['fecha_fin'],
                'objetivo' => $curso['objetivo'],
                'id_nivel' => $curso['id_nivel'],
                'cupos' => $curso['cupos'],
                'cantidad_alumnos' => 0,
                'id_usuario' => $instructor->id_usuario,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function createSampleEnrollments(): void
    {
        // Obtener estudiantes existentes
        $estudiantes = DB::table('usuarios')
            ->join('roles', 'usuarios.id_rol', '=', 'roles.id_rol')
            ->where('roles.rol', 'Estudiante')
            ->select('usuarios.*')
            ->get();
            
        if ($estudiantes->isEmpty()) {
            $this->command->warn('No se encontraron estudiantes. Saltando inscripciones de ejemplo...');
            return;
        }

        // Obtener cursos disponibles (con cupos)
        $cursos = DB::table('cursos')
            ->whereRaw('cupos > cantidad_alumnos')
            ->get();

        if ($cursos->isEmpty()) {
            $this->command->warn('No hay cursos con cupos disponibles');
            return;
        }

        // Crear algunas inscripciones de ejemplo
        foreach ($estudiantes as $estudiante) {
            // Inscribir cada estudiante a máximo 2 cursos aleatorios
            $cursosAleatorios = $cursos->random(min(2, $cursos->count()));
            
            foreach ($cursosAleatorios as $curso) {
                $existe = DB::table('inscripciones')
                    ->where('id_usuario', $estudiante->id_usuario)
                    ->where('id_curso', $curso->id_curso)
                    ->exists();
                    
                if (!$existe) {
                    DB::table('inscripciones')->insert([
                        'id_usuario' => $estudiante->id_usuario,
                        'id_curso' => $curso->id_curso,
                        'fecha_inscripcion' => now()->subDays(rand(1, 30))->format('Y-m-d'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Actualizar cantidad de alumnos
                    DB::table('cursos')->where('id_curso', $curso->id_curso)
                        ->increment('cantidad_alumnos');
                        
                    $this->command->info("Inscripción creada: {$estudiante->primer_nombre} en {$curso->curso}");
                }
            }
        }
    }

    private function createSampleEvaluations(): void
    {
        // Obtener inscripciones existentes
        $inscripciones = DB::table('inscripciones')
            ->join('usuarios', 'inscripciones.id_usuario', '=', 'usuarios.id_usuario')
            ->join('cursos', 'inscripciones.id_curso', '=', 'cursos.id_curso')
            ->select('inscripciones.*', 'usuarios.primer_nombre', 'cursos.curso')
            ->get();
        
        if ($inscripciones->isEmpty()) {
            $this->command->warn('No hay inscripciones para crear evaluaciones');
            return;
        }

        foreach ($inscripciones as $inscripcion) {
            // Crear 1-3 evaluaciones por inscripción
            $numEvaluaciones = rand(1, 3);
            
            for ($i = 0; $i < $numEvaluaciones; $i++) {
                $fechaEvaluacion = now()->subDays(rand(5, 60))->format('Y-m-d');
                
                $existe = DB::table('evaluaciones')
                    ->where('id_usuario', $inscripcion->id_usuario)
                    ->where('id_curso', $inscripcion->id_curso)
                    ->where('fecha_evaluacion', $fechaEvaluacion)
                    ->exists();
                    
                if (!$existe) {
                    $nota = rand(25, 50) / 10; // Notas entre 2.5 y 5.0
                    
                    $comentarios = [
                        'Excelente progreso y dedicación',
                        'Buen desempeño, continúa practicando',
                        'Necesita reforzar algunos conceptos básicos',
                        'Muy creativo en sus interpretaciones',
                        'Muestra gran potencial artístico',
                        'Requiere más práctica en casa',
                        'Destacado en trabajo grupal'
                    ];
                    
                    DB::table('evaluaciones')->insert([
                        'id_usuario' => $inscripcion->id_usuario,
                        'id_curso' => $inscripcion->id_curso,
                        'fecha_evaluacion' => $fechaEvaluacion,
                        'nota' => $nota,
                        'comentarios' => $comentarios[array_rand($comentarios)],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            
            // Calcular y crear/actualizar nota final
            $notaPromedio = DB::table('evaluaciones')
                ->where('id_usuario', $inscripcion->id_usuario)
                ->where('id_curso', $inscripcion->id_curso)
                ->avg('nota');
                
            if ($notaPromedio) {
                DB::table('nota_final')->updateOrInsert(
                    [
                        'id_usuario' => $inscripcion->id_usuario,
                        'id_curso' => $inscripcion->id_curso,
                    ],
                    [
                        'nota_final' => round($notaPromedio, 2),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }

    private function createSamplePrograms(): void
    {
        $tipo_formal = DB::table('tipos_escuela')->where('tipos_escuela', 'Formal')->first();
        $tipo_no_formal = DB::table('tipos_escuela')->where('tipos_escuela', 'No Formal')->first();
        $tipo_taller = DB::table('tipos_escuela')->where('tipos_escuela', 'Taller Corto')->first();
        
        $escuela_musica = DB::table('escuelas')->where('nombre', 'Escuela de Música')->first();
        $escuela_danza = DB::table('escuelas')->where('nombre', 'Escuela de Danza')->first();
        $escuela_teatro = DB::table('escuelas')->where('nombre', 'Escuela de Teatro')->first();
        
        $ubicacion_centro = DB::table('ubicaciones')->where('ubicacion', 'Centro Cultural')->first();
        $ubicacion_biblioteca = DB::table('ubicaciones')->where('ubicacion', 'Biblioteca Municipal')->first();
        
        // Obtener cursos y responsables
        $cursos = DB::table('cursos')->get();
        $instructores = DB::table('usuarios')
            ->join('roles', 'usuarios.id_rol', '=', 'roles.id_rol')
            ->where('roles.rol', 'Instructor')
            ->select('usuarios.*')
            ->get();

        if ($cursos->isEmpty() || $instructores->isEmpty()) {
            $this->command->warn('No hay cursos o instructores disponibles para crear programas');
            return;
        }

        // Programas de ejemplo
        $programas = [
            [
                'id_tipo_escuela' => $tipo_formal ? $tipo_formal->id_tipo_escuela : null,
                'id_escuela' => $escuela_musica ? $escuela_musica->id_escuela : null,
                'id_ubicacion' => $ubicacion_centro ? $ubicacion_centro->id_ubicacion : null,
            ],
            [
                'id_tipo_escuela' => $tipo_no_formal ? $tipo_no_formal->id_tipo_escuela : null,
                'id_escuela' => $escuela_danza ? $escuela_danza->id_escuela : null,
                'id_ubicacion' => $ubicacion_biblioteca ? $ubicacion_biblioteca->id_ubicacion : null,
            ],
            [
                'id_tipo_escuela' => $tipo_taller ? $tipo_taller->id_tipo_escuela : null,
                'id_escuela' => $escuela_teatro ? $escuela_teatro->id_escuela : null,
                'id_ubicacion' => $ubicacion_centro ? $ubicacion_centro->id_ubicacion : null,
            ]
        ];

        foreach ($programas as $index => $programa) {
            // Saltar si faltan datos requeridos
            if (!$programa['id_tipo_escuela'] || !$programa['id_escuela'] || !$programa['id_ubicacion']) {
                continue;
            }
            
            // Asignar curso y responsable
            $curso = $cursos->get($index % $cursos->count());
            $responsable = $instructores->get($index % $instructores->count());
            
            $existe = DB::table('programa_de_formacion')
                ->where('id_curso', $curso->id_curso)
                ->where('id_escuela', $programa['id_escuela'])
                ->exists();
                
            if (!$existe) {
                DB::table('programa_de_formacion')->insert([
                    'id_tipo_escuela' => $programa['id_tipo_escuela'],
                    'id_escuela' => $programa['id_escuela'],
                    'id_ubicacion' => $programa['id_ubicacion'],
                    'id_curso' => $curso->id_curso,
                    'id_usuario' => $responsable->id_usuario,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}