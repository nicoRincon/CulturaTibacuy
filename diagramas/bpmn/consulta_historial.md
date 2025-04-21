# Consulta de historial del estudiante
```mermaid
%%{init: {'theme': 'neutral', 'fontFamily': 'Arial'}}%%
graph TD
    A[Inicio] --> B[Iniciar sesión\ncomo estudiante]
    B --> C[Acceder al módulo\nde historial]
    C --> D{¿Se cargó el historial?}
    D -->|Sí| E[Visualizar clases asistidas]
    D -->|No| F[Mostrar mensaje\nde error]
    F --> G[Regresar al módulo]
    G --> C

    E --> H[Consultar actividades realizadas]
    H --> I{¿Desea descargar o imprimir?}
    I -->|Sí| J[Descargar/Imprimir historial]
    I -->|No| K[Seguir navegando]
    J --> L[Fin]
    K --> L

    style A fill:#f9f,stroke:#333
    style F,G fill:#ffcccc,stroke:#f66
    style L fill:#0f0,stroke:#333
