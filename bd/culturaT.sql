-- Crear la base de datos
CREATE DATABASE EscuelasDB;
USE EscuelasDB;

-- Tabla de Escuelas
CREATE TABLE Escuelas (
    Id_Escuela INT PRIMARY KEY,
    Nombre VARCHAR(100),
    Descripcion VARCHAR(255)
);

-- Tabla de Tipos Escuela
CREATE TABLE Tipos_Escuela (
    Id_Tipo_Escuela INT PRIMARY KEY,
    Tipos_Escuela VARCHAR(100)
);

-- Tabla de Usuarios
CREATE TABLE Usuarios (
    Id_Usuario INT PRIMARY KEY,
    Primer_Nombre VARCHAR(50),
    Segundo_Nombre VARCHAR(50),
    Primer_Apellido VARCHAR(50),
    Segundo_Apellido VARCHAR(50),
    Id_Documento INT,
    Id_Estado INT,
    Num_Documento VARCHAR(20),
    Fecha_Nacimiento DATE,
    Id_L_Nacimiento INT,
    Id_Genero INT,
    Id_Rol INT,
    Id_Contacto INT,
    Id_Especialidad INT,
    FOREIGN KEY (Id_Documento) REFERENCES Documento_de_Identificacion(Id_Documento),
    FOREIGN KEY (Id_Estado) REFERENCES Estados(Id_Estado),
    FOREIGN KEY (Id_Genero) REFERENCES Generos(Id_Genero),
    FOREIGN KEY (Id_Rol) REFERENCES Roles(Id_Rol),
    FOREIGN KEY (Id_Contacto) REFERENCES Contactos(Id_Contacto),
    FOREIGN KEY (Id_Especialidad) REFERENCES Especialidades(Id_Especialidad),
    FOREIGN KEY (Id_L_Nacimiento) REFERENCES Lugar_de_Nacimiento(Id_L_Nacimiento)
);

-- Tabla de Lugar de Nacimiento
CREATE TABLE Lugar_de_Nacimiento (
    Id_L_Nacimiento INT PRIMARY KEY,
    Id_País INT,
    Id_Dpto INT,
    Id_Mpio INT,
    FOREIGN KEY (Id_País) REFERENCES País(Id_País),
    FOREIGN KEY (Id_Dpto) REFERENCES Departamentos(Id_Dpto),
    FOREIGN KEY (Id_Mpio) REFERENCES Municipios(Id_Mpio)
);

-- Tabla de Documento de Identificación
CREATE TABLE Documento_de_Identificacion (
    Id_Documento INT PRIMARY KEY,
    Tipo_Documento VARCHAR(50)
);

-- Tabla de Generos
CREATE TABLE Generos (
    Id_Genero INT PRIMARY KEY,
    Genero VARCHAR(20)
);

-- Tabla de Roles
CREATE TABLE Roles (
    Id_Rol INT PRIMARY KEY,
    Rol VARCHAR(50)
);

-- Tabla de Cursos
CREATE TABLE Cursos (
    Id_Curso INT PRIMARY KEY,
    Curso VARCHAR(100),
    Id_Recurso INT,
    Id_Horario INT,
    Fecha_Inicio DATE,
    Fecha_Fin DATE,
    Objetivo VARCHAR(255),
    Id_Nivel INT,
    Cupos INT,
    Cantidad_Alumnos INT,
    Id_Usuario INT,
    FOREIGN KEY (Id_Recurso) REFERENCES Recursos(Id_Recurso),
    FOREIGN KEY (Id_Horario) REFERENCES Horarios(Id_Horario),
    FOREIGN KEY (Id_Nivel) REFERENCES Niveles(Id_Nivel),
    FOREIGN KEY (Id_Usuario) REFERENCES Usuarios(Id_Usuario)
);

-- Tabla de Contactos
CREATE TABLE Contactos (
    Id_Contacto INT PRIMARY KEY,
    Telefono VARCHAR(20),
    Correo VARCHAR(100),
    Direccion VARCHAR(150)
);

-- Tabla de Especialidades
CREATE TABLE Especialidades (
    Id_Especialidad INT PRIMARY KEY,
    Especialidad VARCHAR(100)
);

-- Tabla de Niveles
CREATE TABLE Niveles (
    Id_Nivel INT PRIMARY KEY,
    Nivel VARCHAR(50)
);

-- Tabla de Horarios
CREATE TABLE Horarios (
    Id_Horario INT PRIMARY KEY,
    Dia VARCHAR(20),
    Hora_Inicio TIME,
    Hora_Fin TIME
);

-- Tabla de Ubicaciones
CREATE TABLE Ubicaciones (
    Id_Ubicacion INT PRIMARY KEY,
    Ubicación VARCHAR(150)
);

-- Tabla de Programa de Formación
CREATE TABLE Programa_De_formación (
    Id_Programa INT PRIMARY KEY,
    Id_Tipo_Escuela INT,
    Id_Escuela INT,
    Id_Ubicacion INT,
    Id_Curso INT,
    Id_Usuario INT,
    FOREIGN KEY (Id_Tipo_Escuela) REFERENCES Tipos_Escuela(Id_Tipo_Escuela),
    FOREIGN KEY (Id_Escuela) REFERENCES Escuelas(Id_Escuela),
    FOREIGN KEY (Id_Ubicacion) REFERENCES Ubicaciones(Id_Ubicacion),
    FOREIGN KEY (Id_Curso) REFERENCES Cursos(Id_Curso),
    FOREIGN KEY (Id_Usuario) REFERENCES Usuarios(Id_Usuario)
);

-- Tabla de Recursos
CREATE TABLE Recursos (
    Id_Recurso INT PRIMARY KEY,
    Recurso VARCHAR(100)
);

-- Tabla de Estados
CREATE TABLE Estados (
    Id_Estado INT PRIMARY KEY,
    Estado VARCHAR(50)
);

-- Tabla de Permisos
CREATE TABLE Permisos (
    Id_Permiso INT PRIMARY KEY,
    Permiso VARCHAR(100),
    Descripcion VARCHAR(255)
);

-- Tabla de Historial de Cambios
CREATE TABLE Historial_de_Cambios (
    Id INT PRIMARY KEY,
    Tabla VARCHAR(50),
    Id_Registro INT,
    Campo VARCHAR(50),
    Dato_Anterior VARCHAR(255),
    Dato_Nuevo VARCHAR(255),
    Fecha_Cambio DATETIME,
    Id_Usuario INT,
    FOREIGN KEY (Id_Usuario) REFERENCES Usuarios(Id_Usuario)
);

-- Tabla de Seguridad
CREATE TABLE Seguridad (
    Id INT PRIMARY KEY,
    Id_Usuario INT,
    Accion VARCHAR(100),
    Fecha DATETIME,
    FOREIGN KEY (Id_Usuario) REFERENCES Usuarios(Id_Usuario)
);

-- Tabla de País
CREATE TABLE País (
    Id_País INT PRIMARY KEY,
    País VARCHAR(50)
);

-- Tabla de Departamentos
CREATE TABLE Departamentos (
    Id_Dpto INT PRIMARY KEY,
    Id_País INT,
    Departamento VARCHAR(50),
    FOREIGN KEY (Id_País) REFERENCES País(Id_País)
);

-- Tabla de Municipios
CREATE TABLE Municipios (
    Id_Mpio INT PRIMARY KEY,
    Id_País INT,
    Id_Dpto INT,
    Municipio VARCHAR(50),
    FOREIGN KEY (Id_País) REFERENCES País(Id_País),
    FOREIGN KEY (Id_Dpto) REFERENCES Departamentos(Id_Dpto)
);

-- Tabla de Inscripciones
CREATE TABLE Inscripciones (
    Id_Inscripcion INT PRIMARY KEY,
    Id_Usuario INT,
    Id_Curso INT,
    Fecha_Inscripcion DATE,
    FOREIGN KEY (Id_Usuario) REFERENCES Usuarios(Id_Usuario),
    FOREIGN KEY (Id_Curso) REFERENCES Cursos(Id_Curso)
);

-- Tabla de Evaluaciones
CREATE TABLE Evaluaciones (
    Id_Evaluacion INT PRIMARY KEY,
    Id_Usuario INT,
    Id_Curso INT,
    Fecha_Evaluacion DATE,
    Nota DECIMAL(5,2),
    Comentarios VARCHAR(255),
    FOREIGN KEY (Id_Usuario) REFERENCES Usuarios(Id_Usuario),
    FOREIGN KEY (Id_Curso) REFERENCES Cursos(Id_Curso)
);

-- Tabla de Nota Final
CREATE TABLE Nota_Final (
    Id_Nota_Final INT PRIMARY KEY,
    Id_Usuario INT,
    Id_Curso INT,
    Nota_Final DECIMAL(5,2),
    FOREIGN KEY (Id_Usuario) REFERENCES Usuarios(Id_Usuario),
    FOREIGN KEY (Id_Curso) REFERENCES Cursos(Id_Curso)
);

-- Tabla de Roles y Permisos
CREATE TABLE Roles_Permisos (
    Id_Rol INT,
    Id_Permiso INT,
    Fecha_Asignacion DATETIME,
    PRIMARY KEY (Id_Rol, Id_Permiso),
    FOREIGN KEY (Id_Rol) REFERENCES Roles(Id_Rol),
    FOREIGN KEY (Id_Permiso) REFERENCES Permisos(Id_Permiso)
);

-- Tabla de Lista de Espera
CREATE TABLE Lista_de_Espera (
    Id_Lista_Espera INT PRIMARY KEY, -- Identificador único para la lista de espera
    Id_Usuario INT,                 -- Usuario en espera
    Id_Curso INT,                   -- Curso al que desea inscribirse
    Fecha_Solicitud DATE,           -- Fecha en la que se solicitó la inscripción
    FOREIGN KEY (Id_Usuario) REFERENCES Usuarios(Id_Usuario),
    FOREIGN KEY (Id_Curso) REFERENCES Cursos(Id_Curso)
);