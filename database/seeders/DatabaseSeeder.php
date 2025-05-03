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
        $colombiaId = DB::table('pais')->insertGetId([
            'pais' => 'Colombia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear departamentos
        $cundinamarcaId = DB::table('Departamentos')->insertGetId([
            'Id_pais' => $colombiaId,
            'Departamento' => 'Cundinamarca',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $boyacaId = DB::table('Departamentos')->insertGetId([
            'Id_pais' => $colombiaId,
            'Departamento' => 'Boyacá',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear municipios
        $bogotaId = DB::table('Municipios')->insertGetId([
            'Id_pais' => $colombiaId,
            'Id_Dpto' => $cundinamarcaId,
            'Municipio' => 'Bogotá D.C.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tibacuyId = DB::table('Municipios')->insertGetId([
            'Id_pais' => $colombiaId,
            'Id_Dpto' => $cundinamarcaId,
            'Municipio' => 'Tibacuy',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear lugar de nacimiento
        $lugarNacimientoBogotaId = DB::table('Lugar_de_Nacimiento')->insertGetId([
            'Id_pais' => $colombiaId,
            'Id_Dpto' => $cundinamarcaId,
            'Id_Mpio' => $bogotaId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $lugarNacimientoTibacuyId = DB::table('Lugar_de_Nacimiento')->insertGetId([
            'Id_pais' => $colombiaId,
            'Id_Dpto' => $cundinamarcaId,
            'Id_Mpio' => $tibacuyId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear tipos de documento
        $cedulaId = DB::table('Documento_de_Identificacion')->insertGetId([
            'Tipo_Documento' => 'Cédula de Ciudadanía',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tiId = DB::table('Documento_de_Identificacion')->insertGetId([
            'Tipo_Documento' => 'Tarjeta de Identidad',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $pasaporteId = DB::table('Documento_de_Identificacion')->insertGetId([
            'Tipo_Documento' => 'Pasaporte',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear géneros
        $masculinoId = DB::table('Generos')->insertGetId([
            'Genero' => 'Masculino',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $femeninoId = DB::table('Generos')->insertGetId([
            'Genero' => 'Femenino',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $otroId = DB::table('Generos')->insertGetId([
            'Genero' => 'Otro',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear roles
        $adminId = DB::table('Roles')->insertGetId([
            'Rol' => 'Administrador',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $instructorId = DB::table('Roles')->insertGetId([
            'Rol' => 'Instructor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $estudianteId = DB::table('Roles')->insertGetId([
            'Rol' => 'Estudiante',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear estados
        $activoId = DB::table('Estados')->insertGetId([
            'Estado' => 'Activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $inactivoId = DB::table('Estados')->insertGetId([
            'Estado' => 'Inactivo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $suspendidoId = DB::table('Estados')->insertGetId([
            'Estado' => 'Suspendido',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear especialidades
        $administracionId = DB::table('Especialidades')->insertGetId([
            'Especialidad' => 'Administración',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $musicaId = DB::table('Especialidades')->insertGetId([
            'Especialidad' => 'Música',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $danzaId = DB::table('Especialidades')->insertGetId([
            'Especialidad' => 'Danza',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $pinturaId = DB::table('Especialidades')->insertGetId([
            'Especialidad' => 'Pintura',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $teatroId = DB::table('Especialidades')->insertGetId([
            'Especialidad' => 'Teatro',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $deporteId = DB::table('Especialidades')->insertGetId([
            'Especialidad' => 'Deporte',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear contactos
        $contactoAdminId = DB::table('Contactos')->insertGetId([
            'Telefono' => '3001234567',
            'Correo' => 'admin@culturatibacuy.com',
            'Direccion' => 'Calle 123 # 45-67',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $contactoInstructorId = DB::table('Contactos')->insertGetId([
            'Telefono' => '3112345678',
            'Correo' => 'instructor@culturatibacuy.com',
            'Direccion' => 'Carrera 45 # 67-89',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $contactoEstudianteId = DB::table('Contactos')->insertGetId([
            'Telefono' => '3223456789',
            'Correo' => 'estudiante@culturatibacuy.com',
            'Direccion' => 'Avenida 67 # 89-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $contactoInstructor2Id = DB::table('Contactos')->insertGetId([
            'Telefono' => '3334567890',
            'Correo' => 'instructor2@culturatibacuy.com',
            'Direccion' => 'Diagonal 89 # 01-23',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $contactoEstudiante2Id = DB::table('Contactos')->insertGetId([
            'Telefono' => '3445678901',
            'Correo' => 'estudiante2@culturatibacuy.com',
            'Direccion' => 'Transversal 01 # 23-45',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear usuarios
        $adminUserId = DB::table('Usuarios')->insertGetId([
            'Primer_Nombre' => 'Admin',
            'Segundo_Nombre' => 'Sistema',
            'Primer_Apellido' => 'Tibacuy',
            'Segundo_Apellido' => 'Cultural',
            'Id_Documento' => $cedulaId,
            'Id_Estado' => $activoId,
            'Num_Documento' => '1000000001',
            'Fecha_Nacimiento' => '1990-01-01',
            'Id_L_Nacimiento' => $lugarNacimientoBogotaId,
            'Id_Genero' => $masculinoId,
            'Id_Rol' => $adminId,
            'Id_Contacto' => $contactoAdminId,
            'Id_Especialidad' => $administracionId,
            'password' => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $instructorUserId = DB::table('Usuarios')->insertGetId([
            'Primer_Nombre' => 'Carlos',
            'Segundo_Nombre' => 'Andrés',
            'Primer_Apellido' => 'Martínez',
            'Segundo_Apellido' => 'López',
            'Id_Documento' => $cedulaId,
            'Id_Estado' => $activoId,
            'Num_Documento' => '1000000002',
            'Fecha_Nacimiento' => '1985-05-15',
            'Id_L_Nacimiento' => $lugarNacimientoBogotaId,
            'Id_Genero' => $masculinoId,
            'Id_Rol' => $instructorId,
            'Id_Contacto' => $contactoInstructorId,
            'Id_Especialidad' => $musicaId,
            'password' => Hash::make('instructor123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $instructor2UserId = DB::table('Usuarios')->insertGetId([
            'Primer_Nombre' => 'María',
            'Segundo_Nombre' => 'Fernanda',
            'Primer_Apellido' => 'Gómez',
            'Segundo_Apellido' => 'Ramírez',
            'Id_Documento' => $cedulaId,
            'Id_Estado' => $activoId,
            'Num_Documento' => '1000000004',
            'Fecha_Nacimiento' => '1988-08-10',
            'Id_L_Nacimiento' => $lugarNacimientoTibacuyId,
            'Id_Genero' => $femeninoId,
            'Id_Rol' => $instructorId,
            'Id_Contacto' => $contactoInstructor2Id,
            'Id_Especialidad' => $danzaId,
            'password' => Hash::make('instructor123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $estudianteUserId = DB::table('Usuarios')->insertGetId([
            'Primer_Nombre' => 'Laura',
            'Segundo_Nombre' => 'Sofía',
            'Primer_Apellido' => 'Rodríguez',
            'Segundo_Apellido' => 'García',
            'Id_Documento' => $tiId,
            'Id_Estado' => $activoId,
            'Num_Documento' => '1000000003',
            'Fecha_Nacimiento' => '2005-10-20',
            'Id_L_Nacimiento' => $lugarNacimientoTibacuyId,
            'Id_Genero' => $femeninoId,
            'Id_Rol' => $estudianteId,
            'Id_Contacto' => $contactoEstudianteId,
            'Id_Especialidad' => $danzaId,
            'password' => Hash::make('estudiante123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $estudiante2UserId = DB::table('Usuarios')->insertGetId([
            'Primer_Nombre' => 'Juan',
            'Segundo_Nombre' => 'David',
            'Primer_Apellido' => 'Torres',
            'Segundo_Apellido' => 'Muñoz',
            'Id_Documento' => $tiId,
            'Id_Estado' => $activoId,
            'Num_Documento' => '1000000005',
            'Fecha_Nacimiento' => '2007-03-25',
            'Id_L_Nacimiento' => $lugarNacimientoTibacuyId,
            'Id_Genero' => $masculinoId,
            'Id_Rol' => $estudianteId,
            'Id_Contacto' => $contactoEstudiante2Id,
            'Id_Especialidad' => $musicaId,
            'password' => Hash::make('estudiante123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear recursos
        $salonId = DB::table('Recursos')->insertGetId([
            'Recurso' => 'Salón Principal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $aulaId = DB::table('Recursos')->insertGetId([
            'Recurso' => 'Aula Múltiple',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $teatroId = DB::table('Recursos')->insertGetId([
            'Recurso' => 'Teatro Municipal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $plazaId = DB::table('Recursos')->insertGetId([
            'Recurso' => 'Plaza Central',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $bibliotecaId = DB::table('Recursos')->insertGetId([
            'Recurso' => 'Biblioteca Municipal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear niveles
        $inicialId = DB::table('Niveles')->insertGetId([
            'Nivel' => 'Inicial',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $intermedioId = DB::table('Niveles')->insertGetId([
            'Nivel' => 'Intermedio',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $avanzadoId = DB::table('Niveles')->insertGetId([
            'Nivel' => 'Avanzado',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear horarios
        $horarioLunesId = DB::table('Horarios')->insertGetId([
            'Dia' => 'Lunes',
            'Hora_Inicio' => '14:00:00',
            'Hora_Fin' => '16:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $horarioMiercolesId = DB::table('Horarios')->insertGetId([
            'Dia' => 'Miércoles',
            'Hora_Inicio' => '14:00:00',
            'Hora_Fin' => '16:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $horarioViernesId = DB::table('Horarios')->insertGetId([
            'Dia' => 'Viernes',
            'Hora_Inicio' => '15:00:00',
            'Hora_Fin' => '17:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $horarioSabadoId = DB::table('Horarios')->insertGetId([
            'Dia' => 'Sábado',
            'Hora_Inicio' => '09:00:00',
            'Hora_Fin' => '12:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear escuelas
        $escuelaMusicaId = DB::table('Escuelas')->insertGetId([
            'Nombre' => 'Escuela de Música',
            'Descripcion' => 'Formación musical para todas las edades',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $escuelaDanzaId = DB::table('Escuelas')->insertGetId([
            'Nombre' => 'Escuela de Danza',
            'Descripcion' => 'Formación en danza tradicional y contemporánea',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $escuelaArteId = DB::table('Escuelas')->insertGetId([
            'Nombre' => 'Escuela de Artes Plásticas',
            'Descripcion' => 'Formación en dibujo, pintura y escultura',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $escuelaTeatroId = DB::table('Escuelas')->insertGetId([
            'Nombre' => 'Escuela de Teatro',
            'Descripcion' => 'Formación en artes dramáticas y expresión corporal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear tipos de escuela
        $formalId = DB::table('Tipos_Escuela')->insertGetId([
            'Tipos_Escuela' => 'Formal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $noFormalId = DB::table('Tipos_Escuela')->insertGetId([
            'Tipos_Escuela' => 'No Formal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tallerCortoId = DB::table('Tipos_Escuela')->insertGetId([
            'Tipos_Escuela' => 'Taller Corto',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $semilleroId = DB::table('Tipos_Escuela')->insertGetId([
            'Tipos_Escuela' => 'Semillero',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear ubicaciones
        $ubicacionCentroId = DB::table('Ubicaciones')->insertGetId([
            'ubicacion' => 'Centro Cultural',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $ubicacionBibliotecaId = DB::table('Ubicaciones')->insertGetId([
            'ubicacion' => 'Biblioteca Municipal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ubicacionPlazaId = DB::table('Ubicaciones')->insertGetId([
            'ubicacion' => 'Plaza Principal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ubicacionCampusMunicipalId = DB::table('Ubicaciones')->insertGetId([
            'ubicacion' => 'Campus Municipal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear cursos
        $cursoMusicaId = DB::table('Cursos')->insertGetId([
            'Curso' => 'Iniciación Musical',
            'Id_Recurso' => $salonId,
            'Id_Horario' => $horarioLunesId,
            'Fecha_Inicio' => '2023-01-15',
            'Fecha_Fin' => '2023-06-15',
            'Objetivo' => 'Introducir a los estudiantes en los conceptos básicos de la música',
            'Id_Nivel' => $inicialId,
            'Cupos' => 20,
            'Cantidad_Alumnos' => 0,
            'Id_Usuario' => $instructorUserId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $cursoDanzaId = DB::table('Cursos')->insertGetId([
            'Curso' => 'Danza Folclórica',
            'Id_Recurso' => $aulaId,
            'Id_Horario' => $horarioMiercolesId,
            'Fecha_Inicio' => '2023-02-01',
            'Fecha_Fin' => '2023-07-01',
            'Objetivo' => 'Enseñar las danzas tradicionales colombianas',
            'Id_Nivel' => $inicialId,
            'Cupos' => 15,
            'Cantidad_Alumnos' => 0,
            'Id_Usuario' => $instructor2UserId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $cursoGuitarraId = DB::table('Cursos')->insertGetId([
            'Curso' => 'Guitarra Acústica',
            'Id_Recurso' => $bibliotecaId,
            'Id_Horario' => $horarioViernesId,
            'Fecha_Inicio' => '2023-03-10',
            'Fecha_Fin' => '2023-08-10',
            'Objetivo' => 'Aprender técnicas básicas e intermedias de guitarra acústica',
            'Id_Nivel' => $intermedioId,
            'Cupos' => 12,
            'Cantidad_Alumnos' => 0,
            'Id_Usuario' => $instructorUserId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $cursoPinturaId = DB::table('Cursos')->insertGetId([
            'Curso' => 'Pintura al Óleo',
            'Id_Recurso' => $salonId,
            'Id_Horario' => $horarioSabadoId,
            'Fecha_Inicio' => '2023-04-01',
            'Fecha_Fin' => '2023-09-01',
            'Objetivo' => 'Desarrollar habilidades en la técnica de pintura al óleo',
            'Id_Nivel' => $inicialId,
            'Cupos' => 10,
            'Cantidad_Alumnos' => 0,
            'Id_Usuario' => $instructor2UserId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear programas de formación
        $programaMusicaId = DB::table('Programa_De_formacion')->insertGetId([
            'Id_Tipo_Escuela' => $formalId,
            'Id_Escuela' => $escuelaMusicaId,
            'Id_Ubicacion' => $ubicacionCentroId,
            'Id_Curso' => $cursoMusicaId,
            'Id_Usuario' => $instructorUserId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $programaDanzaId = DB::table('Programa_De_formacion')->insertGetId([
            'Id_Tipo_Escuela' => $formalId,
            'Id_Escuela' => $escuelaDanzaId,
            'Id_Ubicacion' => $ubicacionBibliotecaId,
            'Id_Curso' => $cursoDanzaId,
            'Id_Usuario' => $instructor2UserId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $programaGuitarraId = DB::table('Programa_De_formacion')->insertGetId([
            'Id_Tipo_Escuela' => $noFormalId,
            'Id_Escuela' => $escuelaMusicaId,
            'Id_Ubicacion' => $ubicacionBibliotecaId,
            'Id_Curso' => $cursoGuitarraId,
            'Id_Usuario' => $instructorUserId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $programaPinturaId = DB::table('Programa_De_formacion')->insertGetId([
            'Id_Tipo_Escuela' => $tallerCortoId,
            'Id_Escuela' => $escuelaArteId,
            'Id_Ubicacion' => $ubicacionCentroId,
            'Id_Curso' => $cursoPinturaId,
            'Id_Usuario' => $instructor2UserId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear permisos
        $crearUsuariosId = DB::table('Permisos')->insertGetId([
            'Permiso' => 'Crear usuarios',
            'Descripcion' => 'Permite crear nuevos usuarios en el sistema',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $editarUsuariosId = DB::table('Permisos')->insertGetId([
            'Permiso' => 'Editar usuarios',
            'Descripcion' => 'Permite editar usuarios existentes',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $eliminarUsuariosId = DB::table('Permisos')->insertGetId([
            'Permiso' => 'Eliminar usuarios',
            'Descripcion' => 'Permite eliminar usuarios del sistema',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $gestionarCursosId = DB::table('Permisos')->insertGetId([
            'Permiso' => 'Gestionar cursos',
            'Descripcion' => 'Permite crear, editar y eliminar cursos',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $gestionarEscuelasId = DB::table('Permisos')->insertGetId([
            'Permiso' => 'Gestionar escuelas',
            'Descripcion' => 'Permite crear, editar y eliminar escuelas',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $gestionarProgramasId = DB::table('Permisos')->insertGetId([
            'Permiso' => 'Gestionar programas',
            'Descripcion' => 'Permite crear, editar y eliminar programas de formación',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $evaluarEstudiantesId = DB::table('Permisos')->insertGetId([
            'Permiso' => 'Evaluar estudiantes',
            'Descripcion' => 'Permite evaluar a los estudiantes',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $generarInformesId = DB::table('Permisos')->insertGetId([
            'Permiso' => 'Generar informes',
            'Descripcion' => 'Permite generar informes del sistema',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Asignar permisos a roles
        // Administrador tiene todos los permisos
        DB::table('Roles_Permisos')->insert([
            [
                'Id_Rol' => $adminId,
                'Id_Permiso' => $crearUsuariosId,
                'Fecha_Asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Rol' => $adminId,
                'Id_Permiso' => $editarUsuariosId,
                'Fecha_Asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Rol' => $adminId,
                'Id_Permiso' => $eliminarUsuariosId,
                'Fecha_Asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Rol' => $adminId,
                'Id_Permiso' => $gestionarCursosId,
                'Fecha_Asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Rol' => $adminId,
                'Id_Permiso' => $gestionarEscuelasId,
                'Fecha_Asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Rol' => $adminId,
                'Id_Permiso' => $gestionarProgramasId,
                'Fecha_Asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Rol' => $adminId,
                'Id_Permiso' => $evaluarEstudiantesId,
                'Fecha_Asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Rol' => $adminId,
                'Id_Permiso' => $generarInformesId,
                'Fecha_Asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Instructor tiene algunos permisos
        DB::table('Roles_Permisos')->insert([
            [
                'Id_Rol' => $instructorId,
                'Id_Permiso' => $gestionarCursosId,
                'Fecha_Asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Rol' => $instructorId,
                'Id_Permiso' => $evaluarEstudiantesId,
                'Fecha_Asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Rol' => $instructorId,
                'Id_Permiso' => $generarInformesId,
                'Fecha_Asignacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Inscribir al estudiante en un curso
        $inscripcionId = DB::table('Inscripciones')->insertGetId([
            'Id_Usuario' => $estudianteUserId,
            'Id_Curso' => $cursoMusicaId,
            'Fecha_Inscripcion' => '2023-01-20',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Inscribir al segundo estudiante en dos cursos
        $inscripcion2Id = DB::table('Inscripciones')->insertGetId([
            'Id_Usuario' => $estudiante2UserId,
            'Id_Curso' => $cursoMusicaId,
            'Fecha_Inscripcion' => '2023-01-21',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $inscripcion3Id = DB::table('Inscripciones')->insertGetId([
            'Id_Usuario' => $estudiante2UserId,
            'Id_Curso' => $cursoDanzaId,
            'Fecha_Inscripcion' => '2023-02-05',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Actualizar cantidad de alumnos en los cursos
        DB::table('Cursos')
            ->where('Id_Curso', $cursoMusicaId)
            ->update([
                'Cantidad_Alumnos' => DB::raw('Cantidad_Alumnos + 2'),
                'updated_at' => now(),
            ]);

        DB::table('Cursos')
            ->where('Id_Curso', $cursoDanzaId)
            ->update([
                'Cantidad_Alumnos' => DB::raw('Cantidad_Alumnos + 1'),
                'updated_at' => now(),
            ]);

        // Crear evaluaciones para los estudiantes
        $evaluacionId = DB::table('Evaluaciones')->insertGetId([
            'Id_Usuario' => $estudianteUserId,
            'Id_Curso' => $cursoMusicaId,
            'Fecha_Evaluacion' => '2023-02-15',
            'Nota' => 4.5,
            'Comentarios' => 'Excelente desempeño en la primera evaluación',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $evaluacion2Id = DB::table('Evaluaciones')->insertGetId([
            'Id_Usuario' => $estudianteUserId,
            'Id_Curso' => $cursoMusicaId,
            'Fecha_Evaluacion' => '2023-03-15',
            'Nota' => 4.2,
            'Comentarios' => 'Buen desempeño, pero necesita practicar más lectura musical',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $evaluacion3Id = DB::table('Evaluaciones')->insertGetId([
            'Id_Usuario' => $estudiante2UserId,
            'Id_Curso' => $cursoMusicaId,
            'Fecha_Evaluacion' => '2023-02-15',
            'Nota' => 3.8,
            'Comentarios' => 'Desempeño aceptable, necesita más práctica',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $evaluacion4Id = DB::table('Evaluaciones')->insertGetId([
            'Id_Usuario' => $estudiante2UserId,
            'Id_Curso' => $cursoDanzaId,
            'Fecha_Evaluacion' => '2023-03-10',
            'Nota' => 4.7,
            'Comentarios' => 'Excelente ritmo y expresión corporal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear notas finales para los estudiantes
        $notaFinal1Id = DB::table('Nota_Final')->insertGetId([
            'Id_Usuario' => $estudianteUserId,
            'Id_Curso' => $cursoMusicaId,
            'Nota_Final' => 4.35, // Promedio de las evaluaciones
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $notaFinal2Id = DB::table('Nota_Final')->insertGetId([
            'Id_Usuario' => $estudiante2UserId,
            'Id_Curso' => $cursoMusicaId,
            'Nota_Final' => 3.8, // Solo hay una evaluación por ahora
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $notaFinal3Id = DB::table('Nota_Final')->insertGetId([
            'Id_Usuario' => $estudiante2UserId,
            'Id_Curso' => $cursoDanzaId,
            'Nota_Final' => 4.7, // Solo hay una evaluación por ahora
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Registrar algunos eventos de seguridad
        DB::table('Seguridad')->insert([
            [
                'Id_Usuario' => $adminUserId,
                'Accion' => 'Inicio de sesión',
                'Fecha' => now()->subDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Usuario' => $adminUserId,
                'Accion' => 'Creación de usuario',
                'Fecha' => now()->subDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Usuario' => $instructorUserId,
                'Accion' => 'Inicio de sesión',
                'Fecha' => now()->subDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Usuario' => $instructorUserId,
                'Accion' => 'Registro de evaluación',
                'Fecha' => now()->subDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Usuario' => $estudianteUserId,
                'Accion' => 'Inicio de sesión',
                'Fecha' => now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Usuario' => $estudianteUserId,
                'Accion' => 'Consulta de notas',
                'Fecha' => now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Registrar algunos cambios en el historial
        DB::table('Historial_de_Cambios')->insert([
            [
                'Tabla' => 'Usuarios',
                'Id_Registro' => $estudianteUserId,
                'Campo' => 'Telefono',
                'Dato_Anterior' => '3223456780',
                'Dato_Nuevo' => '3223456789',
                'Fecha_Cambio' => now()->subDays(4),
                'Id_Usuario' => $adminUserId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Tabla' => 'Cursos',
                'Id_Registro' => $cursoMusicaId,
                'Campo' => 'Cupos',
                'Dato_Anterior' => '15',
                'Dato_Nuevo' => '20',
                'Fecha_Cambio' => now()->subDays(5),
                'Id_Usuario' => $adminUserId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Tabla' => 'Evaluaciones',
                'Id_Registro' => $evaluacionId,
                'Campo' => 'Nota',
                'Dato_Anterior' => '4.2',
                'Dato_Nuevo' => '4.5',
                'Fecha_Cambio' => now()->subDays(3),
                'Id_Usuario' => $instructorUserId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}