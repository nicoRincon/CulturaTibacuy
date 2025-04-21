```mermaid
<<<<<<< HEAD
=======
%%{init: {'theme': 'neutral', 'fontFamily': 'Arial'}}%%
>>>>>>> d2b9af204403328e05ad8c8874715dd225339ffa
flowchart TD
    A[Inicio del proceso de inscripción] --> B[Mostrar escuelas culturales disponibles]
    B --> C[Seleccionar escuela a inscribirse]
    C --> D[Verificar límite de 2 escuelas]
    D -->|Límite no superado| E[Registrar inscripción en la base de datos]
<<<<<<< HEAD
    D -->|Límite alcanzado| F[Mostrar mensaje: solo se permiten 2 escuelas]
    E --> G[Confirmar inscripción al estudiante]
    F --> H[Fin del proceso sin inscripción]
    G --> I[Fin del proceso con inscripción]
=======
    D -->|Límite alcanzado| F[Mostrar mensaje: Solo se permiten 2 escuelas]
    E --> G[Confirmar inscripción al estudiante]
    F --> H[Fin del proceso sin inscripción]
    G --> I[Mostrar mensaje: Inscripción confirmada]
    I --> J[Fin del proceso con inscripción]
    H --> J
    style A fill:#f9f,stroke:#333
    style I,J fill:#0f0,stroke:#333
    style H,F fill:#ffcccc,stroke:#f66
>>>>>>> d2b9af204403328e05ad8c8874715dd225339ffa
