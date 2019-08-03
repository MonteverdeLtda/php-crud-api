# CRM (MVC) + API REST CRUL - crm-crud-api-php

Seguro que algunos que hayan leído o visto algunos de los tutoriales o ejemplos que pongo sobre programación en PHP con y sin frameworks, pueden no estar de acuerdo conmigo en ciertos detalles, o incluso estar pensando «este chico no está programando verdaderamente orientado a objetos» o «no sigue el paradigma a rajatabla» (todo lo que explico lo hago desde mi punto de vista actual, nunca digo que sea la verdad absoluta o lo más correcto siempre).

Pues bien hoy vamos ver un ejemplo muy bueno de como programar realmente orientado a objetos en PHP puro con MVC. Lo que voy a mostrar hoy perfectamente podría ser la base para construirnos un pequeño framework propio, veremos incluso como hacer un controlador frontal, como crear objetos que representen entidades de la base de datos, etc, por lo tanto lo que voy a enseñar hoy es un ejemplo muy didáctico y muy completo.

## Estructura de directorios

En nuestro «framework» tendremos varios directorios:

#### *crm-admin*

Este contenido se recomienda no ser modificado.

- **config**: aquí irán los ficheros de configuración de la base de datos, globales, etc.
- **controller**: como sabemos en la arquitectura MVC los controladores se encargarán de recibir y filtrar datos que le llegan de las vistas, llamar a los modelos y pasar los datos de estos a las vistas. Pues en este directorio colocaremos los controladores del SISTEMA OBLIGATORIOS
- **core**: aquí colocaremos las clases base de las que heredarán por ejemplo controladores y modelos, y también podríamos colocar más librerías hechas por nosotros o por terceros, esto sería el núcleo del framework.
- **model**: aquí irán los modelos, para ser fieles al paradigma orientado objetos tenemos que tener una clase por cada tabla o entidad de la base de datos(excepto para las tablas pivote) y estas clases servirán para crear objetos de ese tipo de entidad(por ejemplo crear un objeto usuario para crear un usuario en la BD). También tendremos modelos de consulta a la BD que contendrán consultas más complejas que estén relacionadas con una o varias entidades.
- **index.php** será el controlador frontal por el que pasará absolutamente todo en la aplicación.

#### *crm-content*

Aquí se alojan los archivos publicos.

- **modules**: aquí iran los controlladores para los modulos, modelos y todo lo que pertinece al modulo incluyendo las vistas, es decir, donde se imprimirán los datos y lo que verá el usuario.
- **themes**: aquí iran los Temas CSS en caso de querer utilizar aparciencia o codigo mas personalizado.

~~~
.
+-- crm-admin
|   +-- config
|      +-- database.php
|      +-- global.php
|   +-- controller
|      +-- ...
|   +-- core
|      +-- FluentPDO
|      +-- api.php
|      +-- AyudaVistas.php
|      +-- Conectar.php
|      +-- ControladorBase.php
|      +-- ControladorFrontal.func.php
|      +-- EntidadBase.php
|      +-- MenuBase.php
|      +-- ModeloBase.php
|      +-- TemplateBase.php
|      +-- ui.php (BETA)
|   +-- model
|      +-- ...
|   +-- autoload.php
+-- crm-content
|   +-- modules
|      +-- ...
|   +-- themes
|      +-- ...
|   +-- uploads
+-- index.php
~~~

## Modulos

### DEV - Crear modulo

Para crear un modulo nuevo es necesario el controlador.

1. Crear la carpeta con el `alias` del Modulo, en el ejemplo realizaremos `Sistema`
2. Crear el archivo del controlador `SistemaController.php` y crear la clase `SistemaController`.

~~~PHP
class SistemaController extends ControladorBase {	
    public function __construct() {
        parent::__construct();
    }
    public function index(){
		
    }
}
~~~

3. Crear el archivo con los ajustes y configuraciones del modulo, en nuestro caso `Sistema.json`.

~~~JSON
{
	"name": "Sistema",
	"isActive": true,
	"sections": [
		{
			"title": "Escritorio",
			"controller": "Sistema",
			"action": "desktop",
			"tree": [
			]
		},
		{
			"title": "Ajustes",
			"controller": "Sistema",
			"action": null,
			"tree": [
				{
					"title": "Generales",
					"controller": "Sistema",
					"action": "settings",
					"tree": [
					]
				},
				{
					"title": "Privacidad",
					"controller": "Sistema",
					"action": "privacy",
					"tree": [
					]
				},
				{
					"title": "Anuncios",
					"controller": "Sistema",
					"action": "ads",
					"tree": [
					]
				},
				{
					"title": "Header y Footer Scripts",
					"controller": "Sistema",
					"action": "header_and_footer_scripts",
					"tree": [
					]
				}
			]
		},
		{
			"title": "Modulos",
			"controller": "Sistema",
			"action": null,
			"tree": [
				{
					"title": "Modulos instalados",
					"controller": "Sistema",
					"action": "modules_list",
					"tree": [
					]
				},
				{
					"title": "Añadir Modulo",
					"controller": "Sistema",
					"action": "modules_add",
					"tree": [
					]
				},
				{
					"title": "Editor de Modulos",
					"controller": "Sistema",
					"action": "modules_editor",
					"tree": [
					]
				}
			]
		},
		{
			"title": "Usuarios",
			"controller": "Sistema",
			"action": null,
			"tree": [
				{
					"title": "Todos los usuarios",
					"controller": "Sistema",
					"action": "users_list",
					"tree": [
					]
				},
				{
					"title": "Añadir nuevo",
					"controller": "Sistema",
					"action": "modules_add",
					"tree": [
					]
				}
			]
		},
		{
			"title": "Apariencia",
			"controller": "Sistema",
			"action": null,
			"tree": [
				{
					"title": "Temas",
					"controller": "Sistema",
					"action": "theme_list",
					"tree": [
					]
				},
				{
					"title": "Añadir nuevo",
					"controller": "Sistema",
					"action": "modules_add",
					"tree": [
					]
				}
			]
		},
		{
			"title": "Galería y Multimedia",
			"controller": "Sistema",
			"action": null,
			"tree": [
				{
					"title": "Biblioteca",
					"controller": "Sistema",
					"action": "theme_list",
					"tree": [
					]
				},
				{
					"title": "Añadir nuevo",
					"controller": "Sistema",
					"action": "modules_add",
					"tree": [
					]
				}
			]
		}
	]
}
~~~

