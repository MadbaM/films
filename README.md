# Films

Films es un ejemplo de aplicación realizada con EasyAdmin, más concretamente con la versión 4.1 del mismo. Consta de 3 secciones:
 - **Películas:** Muestra todas las peliculas que hay en base de datos.
 - **Actores:** Página desde la que se muestran todos los Actores que hay en base de datos y además permite  crear/editar/eliminar cada uno de ellos.
 - **Directores:** Página desde la que se muestran todos los Directores que hay en base de datos y además permite  crear/editar/eliminar cada uno de ellos.

Cuenta a parte con un comando para la importación de películas mediante un ficheros CSV

## Instalación

Comandos para poner en marcha el proyecto.

```bash
> composer install
> php bin/console do:mi:mi
> symfony server:start
```

## Uso del comando de importación

```bash
> php bin/console add-movies "ruta de nuestro fichero"
