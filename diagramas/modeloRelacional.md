```mermaid
classDiagram
    class Escuelas {
        int Id_Escuela
        varchar Nombre
        varchar Descripcion
    }

    class Tipos_Escuela {
        int Id_Tipo_Escuela
        varchar Tipos_Escuela
    }

    class Usuarios {
        int Id_Usuario
        varchar Primer_Nombre
        varchar Segundo_Nombre
        varchar Primer_Apellido
        varchar Segundo_Apellido
        int Id_Documento
        int Id_Estado
        varchar Num_Documento
        date Fecha_Nacimiento
        int Id_L_Nacimiento
        int Id_Genero
        int Id_Rol
        int Id_Contacto
        int Id_Especialidad
    }

    class Lugar_de_Nacimiento {
        int Id_L_Nacimiento
        int Id_País
        int Id_Dpto
        int Id_Mpio
    }

    class Documento_de_Identificacion {
        int Id_Documento
        varchar Tipo_Documento
    }

    class Generos {
        int Id_Genero
        varchar Genero
    }

    class Roles {
        int Id_Rol
        varchar Rol
    }

    class Cursos {
        int Id_Curso
        varchar Curso
        int Id_Recurso
        int Id_Horario
        date Fecha_Inicio
        date Fecha_Fin
        varchar Objetivo
        int Id_Nivel
        int Cupos
        int Cantidad_Alumnos
        int Id_Usuario
    }

    class Contactos {
        int Id_Contacto
        varchar Telefono
        varchar Correo
        varchar Direccion
    }

    class Especialidades {
        int Id_Especialidad
        varchar Especialidad
    }

    class Niveles {
        int Id_Nivel
        varchar Nivel
    }

    class Horarios {
        int Id_Horario
        varchar Dia
        time Hora_Inicio
        time Hora_Fin
    }

    class Ubicaciones {
        int Id_Ubicacion
        varchar Ubicación
    }

    class Programa_De_formación {
        int Id_Programa
        int Id_Tipo_Escuela
        int Id_Escuela
        int Id_Ubicacion
        int Id_Curso
        int Id_Usuario
    }

    class Recursos {
        int Id_Recurso
        varchar Recurso
    }

    class Estados {
        int Id_Estado
        varchar Estado
    }

    class Permisos {
        int Id_Permiso
        varchar Permiso
        varchar Descripcion
    }

    class Historial_de_Cambios {
        int Id
        varchar Tabla
        int Id_Registro
        varchar Campo
        varchar Dato_Anterior
        varchar Dato_Nuevo
        datetime Fecha_Cambio
        int Id_Usuario
    }

    class Seguridad {
        int Id
        int Id_Usuario
        varchar Accion
        datetime Fecha
    }

    class País {
        int Id_País
        varchar País
    }

    class Departamentos {
        int Id_Dpto
        int Id_País
        varchar Departamento
    }

    class Municipios {
        int Id_Mpio
        int Id_País
        int Id_Dpto
        varchar Municipio
    }

    class Inscripciones {
        int Id_Inscripcion
        int Id_Usuario
        int Id_Curso
        date Fecha_Inscripcion
    }

    class Evaluaciones {
        int Id_Evaluacion
        int Id_Usuario
        int Id_Curso
        date Fecha_Evaluacion
        decimal Nota
        varchar Comentarios
    }

    class Nota_Final {
        int Id_Nota_Final
        int Id_Usuario
        int Id_Curso
        decimal Nota_Final
    }

    class Roles_Permisos {
        int Id_Rol
        int Id_Permiso
        datetime Fecha_Asignacion
    }

    %% Relaciones
    Usuarios --> Documento_de_Identificacion : Id_Documento
    Usuarios --> Estados : Id_Estado
    Usuarios --> Generos : Id_Genero
    Usuarios --> Roles : Id_Rol
    Usuarios --> Contactos : Id_Contacto
    Usuarios --> Especialidades : Id_Especialidad
    Usuarios --> Lugar_de_Nacimiento : Id_L_Nacimiento
    Cursos --> Recursos : Id_Recurso
    Cursos --> Horarios : Id_Horario
    Cursos --> Niveles : Id_Nivel
    Cursos --> Usuarios : Id_Usuario
    Programa_De_formación --> Tipos_Escuela : Id_Tipo_Escuela
    Programa_De_formación --> Escuelas : Id_Escuela
    Programa_De_formación --> Ubicaciones : Id_Ubicacion
    Programa_De_formación --> Cursos : Id_Curso
    Programa_De_formación --> Usuarios : Id_Usuario
    Departamentos --> País : Id_País
    Municipios --> País : Id_País
    Municipios --> Departamentos : Id_Dpto
    Inscripciones --> Usuarios : Id_Usuario
    Inscripciones --> Cursos : Id_Curso
    Evaluaciones --> Usuarios : Id_Usuario
    Evaluaciones --> Cursos : Id_Curso
    Nota_Final --> Usuarios : Id_Usuario
    Nota_Final --> Cursos : Id_Curso
    Historial_de_Cambios --> Usuarios : Id_Usuario
    Seguridad --> Usuarios : Id_Usuario
    Roles_Permisos --> Roles : Id_Rol
    Roles_Permisos --> Permisos : Id_Permiso