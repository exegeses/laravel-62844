# Instalación del pack de idioma español para Laravel

> Este pack de idiomas contiene la traducción de los mensajes de:

1. Autenticación 
2. Paginado 
3. Contraseñas
4. Validación

## Paso a paso: 

### Instalar el pack de idiomas:

    composer require laraveles/spanish  

> En el sitio oficial del pack de iciomas se explica el detalle 
> https://packagist.org/packages/laraveles/spanish#user-content-instalar

### Configurar archivo 'config.app'

> Dentro del directorio /config tenemos el archivo 'config.app'.
> En dicho archivo, en el apartado de  Application Service Providers, agregarmos: 

    Laraveles\Spanish\SpanishServiceProvider::class,  

> Y finalmente en el mismo archivo 'config.app' en el apartado Application Locale Configuration
> agregarmos: 

'locale' => 'es',

