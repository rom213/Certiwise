# Proyecto Laravel

Este es un proyecto desarrollado con el framework Laravel. A continuación, se detallan los pasos para ejecutarlo en tu entorno local.

## Requisitos previos

Asegúrate de tener instalados los siguientes componentes:

- PHP (versión 7.4 o superior)
- Composer
- Base de datos compatible con Laravel (por ejemplo, MySQL, PostgreSQL)

Puedes instalar xampp al hacer esto te instala

- PHP (versión 7.4 o superior)
- MySQL

tienes que instalar composer.

## Pasos de configuración

1. Clona este repositorio en tu máquina local o descárgalo como archivo ZIP y descomprímelo.
2. Abre una terminal y navega hasta el directorio del proyecto.

## Instalación de dependencias

Ejecuta el siguiente comando para instalar las dependencias del proyecto utilizando Composer:

- composer install

## Configuración del entorno

1. Copia el archivo .env.example y renómbralo como .env.
2. Abre el archivo .env y configura las variables de entorno, como la conexión a la base de datos y las     credenciales SMTP si es necesario.

## Generación de clave de aplicación

Ejecuta el siguiente comando para generar una clave de aplicación única:

- php artisan key:generate

## Ejecución de migraciones y semillas

Para configurar la base de datos, ejecuta las migraciones y los seeders con el siguiente comando:

- php artisan migrate --seed

Esto creará las tablas necesarias en la base de datos y las poblará con datos de prueba si existen semillas configuradas.

## Ejecución de Pruebas

Si estás listo para ejecutar pruebas en tu aplicación, sigue estos pasos para asegurarte de que todo esté configurado correctamente:

1. **Ubicación del Repositorio:**
   Asegúrate de estar en la carpeta raíz del repositorio de tu proyecto. Esto es importante para que las pruebas puedan acceder a todos los archivos y recursos necesarios.

2. **Configuración de la Base de Datos para Pruebas:**
   Abre el archivo `phpunit.xml` en tu proyecto. En este archivo, busca la sección relacionada con la configuración de la base de datos para las pruebas. Deberías encontrar una entrada que te permita especificar la base de datos que deseas utilizar para las pruebas. Asegúrate de proporcionar los detalles correctos de la base de datos que deseas utilizar para las pruebas.

3. **Verificación de la Base de Datos:**
   Antes de ejecutar las pruebas, verifica que la base de datos que especificaste en el archivo `phpunit.xml` exista en MySQL. Puedes hacerlo utilizando un cliente MySQL o una herramienta de administración de bases de datos. Si la base de datos no existe, créala con el mismo nombre y configuración que has especificado en el archivo de configuración.

4. **Ejecución de las Pruebas:**
   Una vez que hayas realizado los pasos anteriores, estás listo para ejecutar las pruebas. Abre tu terminal y navega hasta la carpeta raíz del repositorio. Luego, ejecuta el siguiente comando:

   - php artisan test

   Este comando iniciará la ejecución de las pruebas utilizando el framework de pruebas de Laravel. Verás la salida en la terminal que muestra el progreso y el resultado de las pruebas.
   

## Iniciar servidor de desarrollo

Finalmente, puedes iniciar el servidor de desarrollo de Laravel con el siguiente comando:

- php artisan serve

¡Ahora puedes acceder al proyecto Laravel en tu entorno local a través del servidor de desarrollo!

