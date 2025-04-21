```mermaid
flowchart TD
    A[Inicio del proceso de asistencia] --> B[Iniciar sesión como docente]
    B --> C[Mostrar clases programadas]
    C --> D[Seleccionar clase a registrar]
    D --> E[Registrar asistencia de los estudiantes]
    E --> F[Confirmar y guardar asistencia en la base de datos]
    F --> G[Mostrar mensaje de confirmación]
    G --> H[Fin del proceso]
