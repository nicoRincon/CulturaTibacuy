<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear paises
        $colombia_id = DB::table('pais')->insertGetId([
            'pais' => 'Colombia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear departamentos
        $cundinamarca_id = DB::table('departamentos')->insertGetId([
            'id_pais' => $colombia_id,
            'departamento' => 'Cundinamarca',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $boyaca_id = DB::table('departamentos')->insertGetId([
            'id_pais' => $colombia_id,
            'departamento' => 'Boyacá',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear municipios
        $bogota_id = DB::table('municipios')->insertGetId([
            'id_pais' => $colombia_id,
            'id_dpto' => $cundinamarca_id,
            'municipio' => 'Bogotá D.C.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tibacuy_id = DB::table('municipios')->insertGetId([
            'id_pais' => $colombia_id,
            'id_dpto' => $cundinamarca_id,
            'municipio' => 'Tibacuy',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear lugar de nacimiento
        $lugar_nacimiento_bogota_id = DB::table('lugar_de_nacimiento')->insertGetId([
            'id_pais' => $colombia_id,
            'id_dpto' => $cundinamarca_id,
            'id_mpio' => $bogota_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $lugar_nacimiento_tibacuy_id = DB::table('lugar_de_nacimiento')->insertGetId([
            'id_pais' => $colombia_id,
            'id_dpto' => $cundinamarca_id,
            'id_mpio' => $tibacuy_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear tipos de documento
        $cedula_id = DB::table('documento_de_identificacion')->insertGetId([
            'tipo_documento' => 'Cédula de Ciudadanía',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ti_id = DB::table('documento_de_identificacion')->insertGetId([
            'tipo_documento' => 'Tarjeta de Identidad',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $pasaporte_id = DB::table('documento_de_identificacion')->insertGetId([
            'tipo_documento' => 'Pasaporte',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear géneros
        $masculino_id = DB::table('generos')->insertGetId([
            'genero' => 'Masculino',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $femenino_id = DB::table('generos')->insertGetId([
            'genero' => 'Femenino',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $otro_id = DB::table('generos')->insertGetId([
            'genero' => 'Otro',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear roles
        $admin_id = DB::table('roles')->insertGetId([
            'rol' => 'Administrador',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $instructor_id = DB::table('roles')->insertGetId([
            'rol' => 'Instructor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $estudiante_id = DB::table('roles')->insertGetId([
            'rol' => 'Estudiante',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear estados
        $activo_id = DB::table('estados')->insertGetId([
            'estado' => 'Activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $inactivo_id = DB::table('estados')->insertGetId([
            'estado' => 'Inactivo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $suspendido_id = DB::table('estados')->insertGetId([
            'estado' => 'Suspendido',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear especialidades
        $administracion_id = DB::table('especialidades')->insertGetId([
            'especialidad' => 'Administración',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $musica_id = DB::table('especialidades')->insertGetId([
            'especialidad' => 'Música',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $danza_id = DB::table('especialidades')->insertGetId([
            'especialidad' => 'Danza',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $pintura_id = DB::table('especialidades')->insertGetId([
            'especialidad' => 'Pintura',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $teatro_id = DB::table('especialidades')->insertGetId([
            'especialidad' => 'Teatro',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $deporte_id = DB::table('especialidades')->insertGetId([
            'especialidad' => 'Deporte',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear contactos
        $contacto_admin_id = DB::table('contactos')->insertGetId([
            'telefono' => '3001234567',
            'email' => 'admin@culturatibacuy.com',
            'direccion' => 'Calle 123 # 45-67',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $contacto_instructor_id = DB::table('contactos')->insertGetId([
            'telefono' => '3112345678',
            'email' => 'instructor@culturatibacuy.com',
            'direccion' => 'Carrera 45 # 67-89',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $contacto_estudiante_id = DB::table('contactos')->insertGetId([
            'telefono' => '3223456789',
            'email' => 'estudiante@culturatibacuy.com',
            'direccion' => 'Avenida 67 # 89-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $contacto_instructor2_id = DB::table('contactos')->insertGetId([
            'telefono' => '3334567890',
            'email' => 'instructor2@culturatibacuy.com',
            'direccion' => 'Diagonal 89 # 01-23',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $contacto_estudiante2_id = DB::table('contactos')->insertGetId([
            'telefono' => '3445678901',
            'email' => 'estudiante2@culturatibacuy.com',
            'direccion' => 'Transversal 01 # 23-45',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear usuarios
        $admin_user_id = DB::table('usuarios')->insertGetId([
            'primer_nombre' => 'Admin',
            'segundo_nombre' => 'Sistema',
            'primer_apellido' => 'Tibacuy',
            'segundo_apellido' => 'Cultural',
            'id_documento' => $cedula_id,
            'id_estado' => $activo_id,
            'num_documento' => '1000000001',
            'fecha_nacimiento' => '1990-01-01',
            'id_lugar_nacimiento' => $lugar_nacimiento_bogota_id,
            'id_genero' => $masculino_id,
            'id_rol' => $admin_id,
            'id_contacto' => $contacto_admin_id,
            'id_especialidad' => $administracion_id,
            'password' => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $instructor_user_id = DB::table('usuarios')->insertGetId([
            'primer_nombre' => 'Carlos',
            'segundo_nombre' => 'Andrés',
            'primer_apellido' => 'Martínez',
            'segundo_apellido' => 'López',
            'id_documento' => $cedula_id,
            'id_estado' => $activo_id,
            'num_documento' => '1000000002',
            'fecha_nacimiento' => '1985-05-15',
            'id_lugar_nacimiento' => $lugar_nacimiento_bogota_id,
            'id_genero' => $masculino_id,
            'id_rol' => $instructor_id,
            'id_contacto' => $contacto_instructor_id,
            'id_especialidad' => $musica_id,
            'password' => Hash::make('instructor123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $instructor2_user_id = DB::table('usuarios')->insertGetId([
            'primer_nombre' => 'María',
            'segundo_nombre' => 'Fernanda',
            'primer_apellido' => 'Gómez',
            'segundo_apellido' => 'Ramírez',
            'id_documento' => $cedula_id,
            'id_estado' => $activo_id,
            'num_documento' => '1000000004',
            'fecha_nacimiento' => '1988-08-10',
            'id_lugar_nacimiento' => $lugar_nacimiento_tibacuy_id,
            'id_genero' => $femenino_id,
            'id_rol' => $instructor_id,
            'id_contacto' => $contacto_instructor2_id,
            'id_especialidad' => $danza_id,
            'password' => Hash::make('instructor123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $estudiante_user_id = DB::table('usuarios')->insertGetId([
            'primer_nombre' => 'Laura',
            'segundo_nombre' => 'Sofía',
            'primer_apellido' => 'Rodríguez',
            'segundo_apellido' => 'García',
            'id_documento' => $ti_id,
            'id_estado' => $activo_id,
            'num_documento' => '1000000003',
            'fecha_nacimiento' => '2005-10-20',
            'id_lugar_nacimiento' => $lugar_nacimiento_tibacuy_id,
            'id_genero' => $femenino_id,
            'id_rol' => $estudiante_id,
            'id_contacto' => $contacto_estudiante_id,
            'id_especialidad' => $danza_id,
            'password' => Hash::make('estudiante123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $estudiante2_user_id = DB::table('usuarios')->insertGetId([
            'primer_nombre' => 'Juan',
            'segundo_nombre' => 'David',
            'primer_apellido' => 'Torres',
            'segundo_apellido' => 'Muñoz',
            'id_documento' => $ti_id,
            'id_estado' => $activo_id,
            'num_documento' => '1000000005',
            'fecha_nacimiento' => '2007-03-25',
            'id_lugar_nacimiento' => $lugar_nacimiento_tibacuy_id,
            'id_genero' => $masculino_id,
            'id_rol' => $estudiante_id,
            'id_contacto' => $contacto_estudiante2_id,
            'id_especialidad' => $musica_id,
            'password' => Hash::make('estudiante123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear recursos
        $salon_id = DB::table('recursos')->insertGetId([
            'recurso' => 'Salón Principal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $aula_id = DB::table('recursos')->insertGetId([
            'recurso' => 'Aula Múltiple',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $teatro_id = DB::table('recursos')->insertGetId([
            'recurso' => 'Teatro Municipal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $plaza_id = DB::table('recursos')->insertGetId([
            'recurso' => 'Plaza Central',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $biblioteca_id = DB::table('recursos')->insertGetId([
            'recurso' => 'Biblioteca Municipal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear niveles
        $inicial_id = DB::table('niveles')->insertGetId([
            'nivel' => 'Inicial',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $intermedio_id = DB::table('niveles')->insertGetId([
            'nivel' => 'Intermedio',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $avanzado_id = DB::table('niveles')->insertGetId([
            'nivel' => 'Avanzado',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear horarios
        $horario_lunes_id = DB::table('horarios')->insertGetId([
            'dia' => 'Lunes',
            'hora_inicio' => '14:00:00',
            'hora_fin' => '16:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $horario_miercoles_id = DB::table('horarios')->insertGetId([
            'dia' => 'Miércoles',
            'hora_inicio' => '14:00:00',
            'hora_fin' => '16:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $horario_viernes_id = DB::table('horarios')->insertGetId([
            'dia' => 'Viernes',
            'hora_inicio' => '15:00:00',
            'hora_fin' => '17:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $horario_sabado_id = DB::table('horarios')->insertGetId([
            'dia' => 'Sábado',
            'hora_inicio' => '09:00:00',
            'hora_fin' => '12:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear escuelas
        $escuela_musica_id = DB::table('escuelas')->insertGetId([
            'nombre' => 'Escuela de Música',
            'descripcion' => 'Formación musical para todas las edades',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $escuela_danza_id = DB::table('escuelas')->insertGetId([
            'nombre' => 'Escuela de Danza',
            'descripcion' => 'Formación en danza tradicional y contemporánea',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $escuela_arte_id = DB::table('escuelas')->insertGetId([
            'nombre' => 'Escuela de Artes Plásticas',
            'descripcion' => 'Formación en dibujo, pintura y escultura',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $escuela_teatro_id = DB::table('escuelas')->insertGetId([
            'nombre' => 'Escuela de Teatro',
            'descripcion' => 'Formación en artes dramáticas y expresión corporal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear tipos de escuela
        $formal_id = DB::table('tipos_escuela')->insertGetId([
            'tipos_escuela' => 'Formal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $no_formal_id = DB::table('tipos_escuela')->insertGetId([
            'tipos_escuela' => 'No Formal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $taller_corto_id = DB::table('tipos_escuela')->insertGetId([
            'tipos_escuela' => 'Taller Corto',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $semillero_id = DB::table('tipos_escuela')->insertGetId([
            'tipos_escuela' => 'Semillero',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear ubicaciones
        $ubicacion_centro_id = DB::table('ubicaciones')->insertGetId([
            'ubicacion' => 'Centro Cultural',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $ubicacion_biblioteca_id = DB::table('ubicaciones')->insertGetId([
            'ubicacion' => 'Biblioteca Municipal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ubicacion_plaza_id = DB::table('ubicaciones')->insertGetId([
            'ubicacion' => 'Plaza Principal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ubicacion_campus_municipal_id = DB::table('ubicaciones')->insertGetId([
            'ubicacion' => 'Campus Municipal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear cursos
        $curso_musica_id = DB::table('cursos')->insertGetId([
            'curso' => 'Iniciación Musical',
            'id_recurso' => $salon_id,
            'id_horario' => $horario_lunes_id,
            'fecha_inicio' => '2023-01-15',
            'fecha_fin' => '2023-06-15',
            'objetivo' => 'Introducir a los estudiantes en los conceptos básicos de la música',
            'id_nivel' => $inicial_id,
            'cupos' => 20,
            'cantidad_alumnos' => 0,
            'id_usuario' => $instructor_user_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $curso_danza_id = DB::table('cursos')->insertGetId([
            'curso' => 'Danza Folclórica',
            'id_recurso' => $aula_id,
            'id_horario' => $horario_miercoles_id,
            'fecha_inicio' => '2023-02-01',
            'fecha_fin' => '2023-07-01',
            'objetivo' => 'Enseñar las danzas tradicionales colombianas',
            'id_nivel' => $inicial_id,
            'cupos' => 15,
            'cantidad_alumnos' => 0,
            'id_usuario' => $instructor2_user_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $curso_guitarra_id = DB::table('cursos')->insertGetId([
            'curso' => 'Guitarra Acústica',
            'id_recurso' => $biblioteca_id,
            'id_horario' => $horario_viernes_id,
            'fecha_inicio' => '2023-03-10',
            'fecha_fin' => '2023-08-10',
            'objetivo' => 'Aprender técnicas básicas e intermedias de guitarra acústica',
            'id_nivel' => $intermedio_id,
            'cupos' => 12,
            'cantidad_alumnos' => 0,
            'id_usuario' => $instructor_user_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $curso_pintura_id = DB::table('cursos')->insertGetId([
            'curso' => 'Pintura al Óleo',
            'id_recurso' => $salon_id,
            'id_horario' => $horario_sabado_id,
            'fecha_inicio' => '2023-04-01',
            'fecha_fin' => '2023-09-01',
            'objetivo' => 'Desarrollar habilidades en la técnica de pintura al óleo',
            'id_nivel' => $inicial_id,
            'cupos' => 10,
            'cantidad_alumnos' => 0,
            'id_usuario' => $instructor2_user_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear programas de formación
        $programa_musica_id = DB::table('programa_de_formacion')->insertGetId([
            'id_tipo_escuela' => $formal_id,
            'id_escuela' => $escuela_musica_id,
            'id_ubicacion' => $ubicacion_centro_id,
            'id_curso' => $curso_musica_id,
            'id_usuario' => $instructor_user_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $programa_danza_id = DB::table('programa_de_formacion')->insertGetId([
            'id_tipo_escuela' => $formal_id,
            'id_escuela' => $escuela_danza_id,
            'id_ubicacion' => $ubicacion_biblioteca_id,
            'id_curso' => $curso_danza_id,
            'id_usuario' => $instructor2_user_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $programa_guitarra_id = DB::table('programa_de_formacion')->insertGetId([
            'id_tipo_escuela' => $no_formal_id,
            'id_escuela' => $escuela_musica_id,
            'id_ubicacion' => $ubicacion_biblioteca_id,
            'id_curso' => $curso_guitarra_id,
            'id_usuario' => $instructor_user_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $programa_pintura_id = DB::table('programa_de_formacion')->insertGetId([
            'id_tipo_escuela' => $taller_corto_id,
            'id_escuela' => $escuela_arte_id,
            'id_ubicacion' => $ubicacion_centro_id,
            'id_curso' => $curso_pintura_id,
            'id_usuario' => $instructor2_user_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear permisos
        $crear_usuarios_id = DB::table('permisos')->insertGetId([
            'permiso' => 'Crear usuarios',
            'descripcion' => 'Permite crear nuevos usuarios en el sistema',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $editar_usuarios_id = DB::table('permisos')->insertGetId([
            'permiso' => 'Editar usuarios',
            'descripcion' => 'Permite editar usuarios existentes',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $eliminar_usuarios_id = DB::table('permisos')->insertGetId([
            'permiso' => 'Eliminar usuarios',
            'descripcion' => 'Permite eliminar usuarios del sistema',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $gestionar_cursos_id = DB::table('permisos')->insertGetId([
            'permiso' => 'Gestionar cursos',
            'descripcion' => 'Permite crear, editar y eliminar cursos',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $gestionar_escuelas_id = DB::table('permisos')->insertGetId([
            'permiso' => 'Gestionar escuelas',
            'descripcion' => 'Permite crear, editar y eliminar escuelas',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $gestionar_programas_id = DB::table('permisos')->insertGetId([
            'permiso' => 'Gestionar programas',
            'descripcion' => 'Permite crear, editar y eliminar programas de formación',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $evaluar_estudiantes_id = DB::table('permisos')->insertGetId([
            'permiso' => 'Evaluar estudiantes',
            'descripcion' => 'Permite evaluar a los estudiantes',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $generar_informes_id = DB::table('permisos')->insertGetId([
            'permiso' => 'Generar informes',
            'descripcion' => 'Permite generar informes del sistema',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Asignar permisos a roles
        // Administrador tiene todos los permisos
        DB::table('roles_permisos')->insert([
            [
                'id_rol' => $admin_id,
                'id_permiso' => $crear_usuarios_id,
                'fecha_asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_rol' => $admin_id,
                'id_permiso' => $editar_usuarios_id,
                'fecha_asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_rol' => $admin_id,
                'id_permiso' => $eliminar_usuarios_id,
                'fecha_asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_rol' => $admin_id,
                'id_permiso' => $gestionar_cursos_id,
                'fecha_asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_rol' => $admin_id,
                'id_permiso' => $gestionar_escuelas_id,
                'fecha_asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_rol' => $admin_id,
                'id_permiso' => $gestionar_programas_id,
                'fecha_asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_rol' => $admin_id,
                'id_permiso' => $evaluar_estudiantes_id,
                'fecha_asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_rol' => $admin_id,
                'id_permiso' => $generar_informes_id,
                'fecha_asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Instructor tiene algunos permisos
        DB::table('roles_permisos')->insert([
            [
                'id_rol' => $instructor_id,
                'id_permiso' => $gestionar_cursos_id,
                'fecha_asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_rol' => $instructor_id,
                'id_permiso' => $evaluar_estudiantes_id,
                'fecha_asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_rol' => $instructor_id,
                'id_permiso' => $generar_informes_id,
                'fecha_asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Inscribir al estudiante en un curso
        $inscripcion_id = DB::table('inscripciones')->insertGetId([
            'id_usuario' => $estudiante_user_id,
            'id_curso' => $curso_musica_id,
            'fecha_inscripcion' => '2023-01-20',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Inscribir al segundo estudiante en dos cursos
        $inscripcion2_id = DB::table('inscripciones')->insertGetId([
            'id_usuario' => $estudiante2_user_id,
            'id_curso' => $curso_musica_id,
            'fecha_inscripcion' => '2023-01-21',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $inscripcion3_id = DB::table('inscripciones')->insertGetId([
            'id_usuario' => $estudiante2_user_id,
            'id_curso' => $curso_danza_id,
            'fecha_inscripcion' => '2023-02-05',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Actualizar cantidad de alumnos en los cursos
        DB::table('cursos')
            ->where('id_curso', $curso_musica_id)
            ->update([
            'cantidad_alumnos' => DB::raw('cantidad_alumnos + 2'),
            'updated_at' => now(),
            ]);

        DB::table('cursos')
            ->where('id_curso', $curso_danza_id)
            ->update([
            'cantidad_alumnos' => DB::raw('cantidad_alumnos + 1'),
            'updated_at' => now(),
            ]);

        // Crear evaluaciones para los estudiantes
        $evaluacion_id = DB::table('evaluaciones')->insertGetId([
            'id_usuario' => $estudiante_user_id,
            'id_curso' => $curso_musica_id,
            'fecha_evaluacion' => '2023-02-15',
            'nota' => 4.5,
            'comentarios' => 'Excelente desempeño en la primera evaluación',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $evaluacion2_id = DB::table('evaluaciones')->insertGetId([
            'id_usuario' => $estudiante_user_id,
            'id_curso' => $curso_musica_id,
            'fecha_evaluacion' => '2023-03-15',
            'nota' => 4.2,
            'comentarios' => 'Buen desempeño, pero necesita practicar más lectura musical',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $evaluacion3_id = DB::table('evaluaciones')->insertGetId([
            'id_usuario' => $estudiante2_user_id,
            'id_curso' => $curso_musica_id,
            'fecha_evaluacion' => '2023-02-15',
            'nota' => 3.8,
            'comentarios' => 'Desempeño aceptable, necesita más práctica',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $evaluacion4_id = DB::table('evaluaciones')->insertGetId([
            'id_usuario' => $estudiante2_user_id,
            'id_curso' => $curso_danza_id,
            'fecha_evaluacion' => '2023-03-10',
            'nota' => 4.7,
            'comentarios' => 'Excelente ritmo y expresión corporal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear notas finales para los estudiantes
        $nota_final1_id = DB::table('nota_final')->insertGetId([
            'id_usuario' => $estudiante_user_id,
            'id_curso' => $curso_musica_id,
            'nota_final' => 4.35, // Promedio de las evaluaciones
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $nota_final2_id = DB::table('nota_final')->insertGetId([
            'id_usuario' => $estudiante2_user_id,
            'id_curso' => $curso_musica_id,
            'nota_final' => 3.8, // Solo hay una evaluación por ahora
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $nota_final3_id = DB::table('nota_final')->insertGetId([
            'id_usuario' => $estudiante2_user_id,
            'id_curso' => $curso_danza_id,
            'nota_final' => 4.7, // Solo hay una evaluación por ahora
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Registrar algunos eventos de seguridad
        DB::table('seguridad')->insert([
            [
                'id_usuario' => $admin_user_id,
                'accion' => 'Inicio de sesión',
                'fecha' => now()->subDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_usuario' => $admin_user_id,
                'accion' => 'Creación de usuario',
                'fecha' => now()->subDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_usuario' => $instructor_user_id,
                'accion' => 'Inicio de sesión',
                'fecha' => now()->subDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_usuario' => $instructor_user_id,
                'accion' => 'Registro de evaluación',
                'fecha' => now()->subDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_usuario' => $estudiante_user_id,
                'accion' => 'Inicio de sesión',
                'fecha' => now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_usuario' => $estudiante_user_id,
                'accion' => 'Consulta de notas',
                'fecha' => now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Registrar algunos cambios en el historial
        DB::table('historial_de_cambios')->insert([
            [
                'tabla' => 'usuarios',
                'id_registro' => $estudiante_user_id,
                'campo' => 'telefono',
                'dato_anterior' => '3223456780',
                'dato_nuevo' => '3223456789',
                'fecha_cambio' => now()->subDays(4),
                'id_usuario' => $admin_user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tabla' => 'cursos',
                'id_registro' => $curso_musica_id,
                'campo' => 'cupos',
                'dato_anterior' => '15',
                'dato_nuevo' => '20',
                'fecha_cambio' => now()->subDays(5),
                'id_usuario' => $admin_user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tabla' => 'evaluaciones',
                'id_registro' => $evaluacion_id,
                'campo' => 'nota',
                'dato_anterior' => '4.2',
                'dato_nuevo' => '4.5',
                'fecha_cambio' => now()->subDays(3),
                'id_usuario' => $instructor_user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
