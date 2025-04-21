```mermaid
flowchart TD
    A[Inicio del Registro] --> B[Llenar formulario de registro]
    B --> C[Verificar datos ingresados]
    C --> D{¿Datos válidos?}
    D -- Sí --> E[Guardar usuario en la base de datos]
    D -- No --> F[Mostrar mensaje de error]
    E --> G[Registro exitoso]
    F --> H[Fin del proceso]
