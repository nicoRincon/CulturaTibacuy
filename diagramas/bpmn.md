# Diagrama BPMN del Sistema de Gestión Educativa

```mermaid
flowchart TD
    subgraph "Gestión de Usuarios"
        A1[Registro de Usuario] --> A2[Verificar Datos]
        A2 --> A3{¿Datos Correctos?}
        A3 -->|Sí| A4[Asignar Rol]
        A3 -->|No| A1
        A4 --> A5[Asignar Permisos]
        A5 --> A6[Guardar Usuario]
    end

    subgraph "Gestión de Programas"
        B1[Crear Programa] --> B2[Asignar Escuela]
        B2 --> B3[Asignar Tipo Escuela]
        B3 --> B4[Asignar Ubicación]
        B4 --> B5[Asignar Cursos]
        B5 --> B6[Guardar Programa]
    end

    subgraph "Gestión de Cursos"
        C1[Crear Curso] --> C2[Asignar Nivel]
        C2 --> C3[Asignar Recursos]
        C3 --> C4[Establecer Horarios]
        C4 --> C5[Asignar Instructor]
        C5 --> C6[Definir Cupo]
        C6 --> C7[Guardar Curso]
    end

    subgraph "Proceso de Inscripción"
        D1[Solicitar Inscripción] --> D2[Verificar Disponibilidad]
        D2 --> D3{¿Hay Cupo?}
        D3 -->|Sí| D4[Registrar Inscripción]
        D3 -->|No| D5[Lista de Espera]
        D4 --> D6[Actualizar Cantidad Alumnos]
    end

    subgraph "Proceso de Evaluación"
        E1[Crear Evaluación] --> E2[Asignar a Curso]
        E2 --> E3[Calificar Alumnos]
        E3 --> E4[Registrar Notas]
        E4 --> E5[Calcular Nota Final]
        E5 --> E6[Guardar Historial]
    end

    subgraph "Auditoría y Seguridad"
        F1[Acción de Usuario] --> F2[Registrar en Seguridad]
        F1 --> F3{¿Modifica Datos?}
        F3 -->|Sí| F4[Registrar en Historial]
        F3 -->|No| F5[No Registrar]
    end

    A6 --> D1
    C7 --> D2
    B6 --> C1
    D6 --> E1