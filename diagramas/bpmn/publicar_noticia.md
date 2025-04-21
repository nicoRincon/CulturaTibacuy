```mermaid
%%{init: {'theme': 'neutral', 'fontFamily': 'Arial'}}%%
flowchart TD
    A[Inicio del proceso] --> B[Iniciar sesión como Secretaría de Cultura]
    B --> C[Acceder al módulo de noticias]
    
    C --> D{¿Seleccionar opción 'Crear noticia'?}
    D -->|Sí| E[Escribir título, contenido y categoría]
    D -->|No| F[Cancelar o regresar al inicio]
    
    E --> G[Subir imagen opcional]
    
    G --> H{¿Imagen subida correctamente?}
    H -->|Sí| I[Guardar noticia en el sistema]
    H -->|No| J[Mostrar mensaje de error: 'Imagen no válida']
    
    I --> K[Mostrar mensaje de confirmación: 'Noticia publicada con éxito']
    J --> L[Fin del proceso con error]
    K --> M[Fin del proceso con éxito]
    
    style A fill:#f9f,stroke:#333
    style F fill:#ffcccc,stroke:#f66
    style I,K,M fill:#0f0,stroke:#333
    style J,L fill:#ffcccc,stroke:#f66
