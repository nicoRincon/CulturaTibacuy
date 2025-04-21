```mermaid

%%{init: {'theme': 'neutral', 'fontFamily': 'Arial'}}%%
graph TD
    A[Inicio] --> B[Iniciar sesión\nSecretaría]
    B --> C[Acceder módulo]
    C --> D[Seleccionar escuela/clase]
    D --> E[Ver estudiantes]
    E --> F{¿Hay estudiantes\ndisponibles?}
    F -->|Sí| G[Seleccionar]
    F -->|No| H[Notificar sin cupos]
    H --> K[Fin]
    G --> I{¿Docente tiene\ncupo?}
    I -->|Sí| J[Asignar]
    I -->|No| L[Notificar sobrecupo]
    L --> M[Seleccionar otro docente]
    M --> I
    J --> N[Guardar asignación]
    N --> O[Mostrar confirmación]
    O --> K[Fin]

    style A fill:#f9f,stroke:#333
    style K fill:#0f0,stroke:#333
    style H,L fill:#ffcccc,stroke:#f66