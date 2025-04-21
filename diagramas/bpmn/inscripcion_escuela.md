```mermaid
flowchart TD
    A[Inicio del proceso de inscripción] --> B[Mostrar escuelas culturales disponibles]
    B --> C[Seleccionar escuela a inscribirse]
    C --> D[Verificar límite de 2 escuelas]
    D -->|Límite no superado| E[Registrar inscripción en la base de datos]
    D -->|Límite alcanzado| F[Mostrar mensaje: solo se permiten 2 escuelas]
    E --> G[Confirmar inscripción al estudiante]
    F --> H[Fin del proceso sin inscripción]
    G --> I[Fin del proceso con inscripción]
