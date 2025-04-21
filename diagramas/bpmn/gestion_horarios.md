# Gestión de horarios para escuelas
```mermaid
<<<<<<< HEAD
=======
%%{init: {'theme': 'neutral', 'fontFamily': 'Arial'}}%%
>>>>>>> d2b9af204403328e05ad8c8874715dd225339ffa
flowchart TD
    A[Inicio del proceso] --> B[Iniciar sesión como Secretaría de Cultura]
    B --> C[Acceder al módulo de horarios]
    C --> D[Seleccionar escuela cultural]
    D --> E[Agregar o editar horario de clases]
    E --> F[Validar disponibilidad del docente]
    F -->|Disponible| G[Guardar horario en el sistema]
<<<<<<< HEAD
    F -->|No disponible| H[Mostrar mensaje de conflicto]
    G --> I[Mostrar mensaje de confirmación]
    H --> J[Fin del proceso sin guardar]
    I --> K[Fin del proceso con éxito]
=======
    F -->|No disponible| H[Mostrar mensaje de conflicto: Docente no disponible]
    G --> I[Mostrar mensaje de confirmación: Horario guardado con éxito]
    H --> J[Mostrar mensaje: Conflicto no resuelto]
    J --> K[Fin del proceso sin guardar]
    I --> L[Fin del proceso con éxito]
    style A fill:#f9f,stroke:#333
    style I,L fill:#0f0,stroke:#333
    style J,H fill:#ffcccc,stroke:#f66
>>>>>>> d2b9af204403328e05ad8c8874715dd225339ffa
