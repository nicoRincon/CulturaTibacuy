# Gestión de personal (Secretaría de Cultura)
```mermaid
%%{init: {'theme': 'neutral', 'fontFamily': 'Arial'}}%%
graph TD
    A[Inicio] --> B[Iniciar sesión como Secretaría de Cultura]
    B --> C[Acceder al módulo\nde gestión de personal]
    C --> D[Seleccionar acción: Registrar, Modificar o Eliminar]
    D --> E{¿Qué acción desea realizar?}
    
    %% Flujo de registro
    E -->|Registrar| F[Ingresar datos del nuevo personal]
    F --> G[Verificar validez de los datos]
    G -->|Válido| H[Guardar nuevo registro]
    G -->|No válido| I[Mostrar mensaje de error]
    I --> F
    H --> J[Enviar notificación: Nuevo personal registrado]
    J --> L[Mostrar mensaje de confirmación]

    %% Flujo de modificación
    E -->|Modificar| M[Seleccionar personal y editar información]
    M --> N[Verificar permisos de edición]
    N -->|Permiso válido| O[Guardar cambios]
    N -->|Permiso no válido| P[Mostrar mensaje de error: Sin permiso]
    O --> Q[Enviar notificación: Personal modificado]
    Q --> L

    %% Flujo de eliminación
    E -->|Eliminar| R[Seleccionar personal y confirmar eliminación]
    R --> S{¿Confirmar eliminación?}
    S -->|Sí| T[Eliminar registro del sistema]
    S -->|No| U[Cancelar eliminación]
    T --> V[Enviar notificación: Personal eliminado]
    U --> W[Mostrar mensaje: Eliminación cancelada]
    V --> L
    W --> L

    %% Fin del proceso
    L --> X[Fin del proceso]

    %% Estilos
    style A fill:#f9f,stroke:#333
    style I,P fill:#ffcccc,stroke:#f66
    style L,V,U fill:#0f0,stroke:#333
    style X fill:#0f0,stroke:#333

