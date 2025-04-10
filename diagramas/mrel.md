```mermaid
erDiagram
    Escuelas {
        int Id_Escuela PK
        varchar Nombre
        varchar Descripcion
    }
    Tipos_Escuela {
        int Id_Tipo_Escuela PK
        varchar Tipos_Escuela
    }
    Usuarios {
        int Id_Usuario PK
        varchar Primer_Nombre
        varchar Segundo_Nombre
        varchar Primer_Apellido
        varchar Segundo_Apellido
        int Id_Documento FK
        int Id_Estado FK
        varchar Num_Documento
        date Fecha_Nacimiento
        int Id_L_Nacimiento FK
        int Id_Genero FK
        int Id_Rol FK
        int Id_Contacto FK
        int Id_Especialidad FK
    }
    Lugar_de_Nacimiento {
        int Id_L_Nacimiento PK
        int Id_Pais FK
        int Id_Dpto FK
        int Id_Mpio FK
    }
    Documento_de_Identificacion {
        int Id_Documento PK
        varchar Tipo_Documento
    }
    Generos {
        int Id_Genero PK
        varchar Genero
    }
    Roles {
        int Id_Rol PK
        varchar Rol
    }
    Cursos {
        int Id_Curso PK
        varchar Curso
        int Id_Recurso FK
        int Id_Horario FK
        date Fecha_Inicio
        date Fecha_Fin
        varchar Objetivo
        int Id_Nivel FK
        int Cupos
        int Cantidad_Alumnos
        int Id_Usuario FK
    }
    Contactos {
        int Id_Contacto PK
        varchar Telefono
        varchar Correo
        varchar Direccion
    }
    Especialidades {
        int Id_Especialidad PK
        varchar Especialidad
    }
    Niveles {
        int Id_Nivel PK
        varchar Nivel
    }
    Horarios {
        int Id_Horario PK
        varchar Dia
        time Hora_Inicio
        time Hora_Fin
    }
    Ubicaciones {
        int Id_Ubicacion PK
        varchar Ubicacion
    }
    Programa_De_formacion {
        int Id_Programa PK
        int Id_Tipo_Escuela FK
        int Id_Escuela FK
        int Id_Ubicacion FK
        int Id_Curso FK
        int Id_Usuario FK
    }
    Recursos {
        int Id_Recurso PK
        varchar Recurso
    }
    Estados {
        int Id_Estado PK
        varchar Estado
    }
    Permisos {
        int Id_Permiso PK
        varchar Permiso
        varchar Descripcion
    }
    Historial_de_Cambios {
        int Id PK
        varchar Tabla
        int Id_Registro
        varchar Campo
        varchar Dato_Anterior
        varchar Dato_Nuevo
        datetime Fecha_Cambio
        int Id_Usuario FK
    }
    Seguridad {
        int Id PK
        int Id_Usuario FK
        varchar Accion
        datetime Fecha
    }
    Pais {
        int Id_Pais PK
        varchar Pais
    }
    Departamentos {
        int Id_Dpto PK
        int Id_Pais FK
        varchar Departamento
    }
    Municipios {
        int Id_Mpio PK
        int Id_Pais FK
        int Id_Dpto FK
        varchar Municipio
    }
    Inscripciones {
        int Id_Inscripcion PK
        int Id_Usuario FK
        int Id_Curso FK
        date Fecha_Inscripcion
    }
    Evaluaciones {
        int Id_Evaluacion PK
        int Id_Usuario FK
        int Id_Curso FK
        date Fecha_Evaluacion
        decimal Nota
        varchar Comentarios
    }
    Nota_Final {
        int Id_Nota_Final PK
        int Id_Usuario FK
        int Id_Curso FK
        decimal Nota_Final
    }
    Roles_Permisos {
        int Id_Rol FK
        int Id_Permiso FK
        datetime Fecha_Asignacion
    }

    Usuarios }|--|| Documento_de_Identificacion : ""
    Usuarios }|--|| Generos : ""
    Usuarios }|--|| Roles : ""
    Usuarios }|--|| Contactos : ""
    Usuarios }|--|| Especialidades : ""
    Lugar_de_Nacimiento }|--|| Pais : ""
    Lugar_de_Nacimiento }|--|| Departamentos : ""
    Lugar_de_Nacimiento }|--|| Municipios : ""
    Cursos }|--|| Recursos : ""
    Cursos }|--|| Horarios : ""
    Cursos }|--|| Niveles : ""
    Cursos }|--|| Usuarios : ""
    Programa_De_formacion }|--|| Tipos_Escuela : ""
    Programa_De_formacion }|--|| Escuelas : ""
    Programa_De_formacion }|--|| Ubicaciones : ""
    Programa_De_formacion }|--|| Cursos : ""
    Programa_De_formacion }|--|| Usuarios : ""
    Departamentos }|--|| Pais : ""
    Municipios }|--|| Pais : ""
    Municipios }|--|| Departamentos : ""
    Inscripciones }|--|| Usuarios : ""
    Inscripciones }|--|| Cursos : ""
    Evaluaciones }|--|| Usuarios : ""
    Evaluaciones }|--|| Cursos : ""
    Nota_Final }|--|| Usuarios : ""
    Nota_Final }|--|| Cursos : ""
    Historial_de_Cambios }|--|| Usuarios : ""
    Seguridad }|--|| Usuarios : ""
    Roles_Permisos }|--|| Roles : ""
    Roles_Permisos }|--|| Permisos : ""