# Gestión de horarios para escuelas
```mermaid
flowchart TD
    A[Inicio del proceso] --> B[Iniciar sesión como Secretaría de Cultura]
    B --> C[Acceder al módulo de horarios]
    C --> D[Seleccionar escuela cultural]
    D --> E[Agregar o editar horario de clases]
    E --> F[Validar disponibilidad del docente]
    F -->|Disponible| G[Guardar horario en el sistema]
    F -->|No disponible| H[Mostrar mensaje de conflicto]
    G --> I[Mostrar mensaje de confirmación]
    H --> J[Fin del proceso sin guardar]
    I --> K[Fin del proceso con éxito]
