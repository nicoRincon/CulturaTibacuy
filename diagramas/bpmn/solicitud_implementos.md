```mermaid
flowchart TD
    A[Inicio del proceso] --> B[Iniciar sesión como estudiante]
    B --> C[Acceder al módulo de solicitud de implementos]
    C --> D[Seleccionar clase y tipo de implemento]
    D --> E[Validar disponibilidad del implemento]
    E -->|Disponible| F[Registrar solicitud en el sistema]
    E -->|No disponible| G[Mostrar mensaje de no disponibilidad]
    F --> H[Mostrar mensaje de solicitud exitosa]
    G --> I[Fin del proceso sin solicitud]
    H --> J[Fin del proceso con solicitud]
