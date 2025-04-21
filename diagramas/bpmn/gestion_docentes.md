# Gestión de personal (Secretaría de Cultura)
```mermaid
flowchart TD
    A[Inicio del proceso] --> B[Iniciar sesión como Secretaría de Cultura]
    B --> C[Acceder al módulo de gestión de personal]
    C --> D[Seleccionar acción: Registrar, Modificar o Eliminar]
    D --> E{¿Qué acción desea realizar?}
    
    E -->|Registrar| F[Ingresar datos del nuevo personal]
    F --> I[Guardar nuevo registro]
    I --> L[Mostrar mensaje de confirmación]

    E -->|Modificar| G[Seleccionar personal y editar información]
    G --> J[Guardar cambios]
    J --> L

    E -->|Eliminar| H[Seleccionar personal y confirmar eliminación]
    H --> K[Eliminar registro del sistema]
    K --> L

    L --> M[Fin del proceso]
