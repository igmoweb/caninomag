# Canino Theme

## Instalación

- Instalar nodejs
- Clonar este repositorio
- Ejecutar `npm install`. Esto instalará todas las dependencias de Bower y npm. También generará los archivos `js` y `css` por primera vez.

### Qué instala
- [Foundation 6](http://foundation.zurb.com/sites.html)
- [Foundation Icons](http://zurb.com/playground/foundation-icon-fonts-3)
- [Cookie Law Info](https://es.wordpress.org/plugins/cookie-law-info/) Sólo como dependencia para el desarrollo.
Canino incluye el JS y CSS de dicho plugin de forma inline. Dicha carpeta (`bower_components/cookie-law-info`) no aparecerá en el build.
- [Webpack](https://webpack.js.org/). Se encarga de generar CSS y JS  partir del fichero de configuración, `webpack.config.js`
 
## Modificación de estilos
### Estructura
- Todo lo relativo a estilos se encuentra en la carpeta `scss`.
- `_settings.scss` contiene toda la configuración de Foundation.
- `app.scss` es el archivo de carga del SCSS principal
- `scss/canino` contiene los estilos específicos para Canino
- `scss/wordpress` contiene los estilos específicos para WordPress
- `editor-style.scss` Los estilos para el editor de WP.

### Compilar Sass
Canino Theme tiene todo preparado y automatizado para compilar todos los estilos Sass (.scss). Para ello simplemente ejecuta `npm run watch`. Webpack escuchará cambios en los ficheros `.scss` y generará un build de desarrollo.

## Cambios a producción
No es necesario mover toda la carpeta del Tema. `npm run build` creará una carpeta nueva, `build`, que incluye todo lo necesario para que el tema funcione en producción, obviando varios archivos que sólo sirven durante el desarrollo.
El contenido de `build` es lo único que hay que mover a producción. 