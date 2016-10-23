# Canino Theme

## Instalación

- Instalar bower y nodejs
- Clonar este repositorio
- Ejecutar `bower install` y `npm install`. Esto instalará todas las dependencias de Bower y npm

### Qué instala
- [Foundation 6](http://foundation.zurb.com/sites.html)
- [Foundation Icons](http://zurb.com/playground/foundation-icon-fonts-3)

## Modificación de estilos
### Estructura
- Todo lo relativo a estilos se encuentra en la carpeta `scss`.
- `_settings.scss` contiene toda la configuración de Foundation.
- `app.scss` es el archivo de carga del SCSS principal
- `scss/canino` contiene los estilos específicos para Canino
- `scss/wordpress` contiene los estilos específicos para WordPress

### Compilar Sass
Canino Theme tiene todo preparado y automatizado para compilar todos los estilos Sass (.scss). Para ello simplemente ejecuta `gulp`. Gulp se encarga de compilar todo en el fichero `css/app.css`

## Cambios a producción
No es necesario mover toda la carpeta del Tema. `gulp build` creará una carpeta nueva, `build` que incluye todo lo necesario para que el tema funcione en producción, obviando varios archivos que sólo sirven durante el desarrollo.
El contenido de `build` es lo único que hay que mover a producción. 