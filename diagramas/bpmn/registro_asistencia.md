```mermaid
<<<<<<< HEAD
flowchart TD
    A[Inicio del proceso de asistencia] --> B[Iniciar sesión como docente]
    B --> C[Mostrar clases programadas]
    C --> D[Seleccionar clase a registrar]
    D --> E[Registrar asistencia de los estudiantes]
    E --> F[Confirmar y guardar asistencia en la base de datos]
    F --> G[Mostrar mensaje de confirmación]
    G --> H[Fin del proceso]
=======
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
    
    %% Estilo de nodos
    style A fill:#66ff66,stroke:#333,stroke-width:2px 
    style F fill:#ffcccc,stroke:#f66,stroke-width:2px  
    style I fill:#66ff66,stroke:#333,stroke-width:2px  
    style K fill:#66ff66,stroke:#333,stroke-width:2px  
    style M fill:#66ff66,stroke:#333,stroke-width:2px  
    style J fill:#ffcccc,stroke:#f66,stroke-width:2px  
    style L fill:#ffcccc,stroke:#f66,stroke-width:2px  

    %% Comentarios sobre los colores
    %% Verde para el inicio
    %% Rojo suave para la cancelación
    %% Verde para el éxito
    %% Rojo suave para el error
>>>>>>> d2b9af204403328e05ad8c8874715dd225339ffa
