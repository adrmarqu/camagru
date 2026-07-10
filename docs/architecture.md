# Arquitectura y Convenciones de Código - Camagru

## Estructura del Proyecto (Seguridad MVC)
### src/public/
Único punto de entrada index.php accesible desde la URL. El Frontend

### src/app/
Dondes està todo el código del servidor. El backend

- app/Controllers: Clases controladoras
- app/Models: Logica de base de datos con PDO
- app/Views: Plantillas personalizadas .tpl

## Reglas de Nomenclatura (Estilo PSR-4)
### Constantes define y const

- Han de ser todo mayuscula y separado por guiones bajos

### PascalCase

- Carpetas que contengan clases
- Archivos que sean clases
- Clases

### camelCase

- Metodos de una clase
- Funciones
- Variables
- Carpetas que no tengan clases

### camel_case

- Variables de session, cookies...
- Variables de templates
    - Variables: {{::%s::}}
    - Includes: [[::%s::]]


## Checklist de Seguridad Obligatoria
- [ ] **Inyección SQL:** Usar SIEMPRE `PDO::prepare()` y ejecutar con arrays.
- [ ] **XSS:** Escapar variables en el motor `.tpl` usando `htmlspecialchars($v, ENT_QUOTES, 'UTF-8')`.
- [ ] **CSRF:** Validar tokens aleatorios en `$_SESSION` para cada formulario que modifique datos.
- [ ] **Subidas:** Renombrar archivos con `uniqid()` y validar tipo real con `mime_content_type()`.