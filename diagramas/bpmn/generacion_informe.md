# Generación de informe de actividades
```mermaid
%%{init: {'theme': 'neutral', 'fontFamily': 'Arial'}}%%
graph TD
    A[Inicio] --> B[Iniciar sesión\ncomo Secretaría de Cultura]
    B --> C[Seleccionar tipo de informe]
    C --> D[Filtrar por fechas,\nescuelas o docentes]
    D --> E{¿Datos encontrados?}
    E -->|Sí| F[Recopilar datos del sistema]
    E -->|No| G[Mensaje: No hay datos]
    G --> H[Modificar filtros]
    H --> D

    F --> I[Generar informe]
    I --> J[Incluir resumen de actividades:\nclases, talleres, eventos]
    J --> K[Incluir participación por escuela y docente]
    K --> L[Incluir estadísticas:\nasistencia, cumplimiento de metas]
    L --> M[Incluir observaciones y recomendaciones]
    M --> N{¿Desea visualizar o descargar?}
    N -->|Visualizar| O[Mostrar informe en pantalla]
    N -->|Descargar| P[Descargar informe PDF/Excel]
    O --> Q[Fin]
    P --> Q

    style A fill:#f9f,stroke:#333
    style G,H fill:#ffcccc,stroke:#f66
    style Q fill:#0f0,stroke:#333
