# Generación de informe de actividades
```mermaid
<<<<<<< HEAD
flowchart TD
    A[Inicio del proceso] --> B[Iniciar sesión como Secretaría de Cultura]
    B --> C[Seleccionar tipo de informe a generar]
    C --> D[Filtrar por fechas, escuelas o docentes]
    D --> E[Recopilar datos del sistema]
    E --> F[Generar informe de actividades]
    F --> G[Visualizar o descargar informe]
    G --> H[Fin del proceso]
=======
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
>>>>>>> d2b9af204403328e05ad8c8874715dd225339ffa
