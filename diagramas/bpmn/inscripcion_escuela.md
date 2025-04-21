```mermaid
%%{init: {'theme': 'neutral', 'fontFamily': 'Arial'}}%%
flowchart TD
    A[Inicio del proceso de inscripción] --> B[Mostrar escuelas culturales disponibles]
    B --> C[Seleccionar escuela a inscribirse]
    C --> D[Verificar límite de 2 escuelas]
    D -->|Límite no superado| E[Registrar inscripción en la base de datos]
    D -->|Límite alcanzado| F[Mostrar mensaje: Solo se permiten 2 escuelas]
    E --> G[Confirmar inscripción al estudiante]
    F --> H[Fin del proceso sin inscripción]
    G --> I[Mostrar mensaje: Inscripción confirmada]
    I --> J[Fin del proceso con inscripción]
    H --> J
    style A fill:#f9f,stroke:#333
    style I,J fill:#0f0,stroke:#333
    style H,F fill:#ffcccc,stroke:#f66