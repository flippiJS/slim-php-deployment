> **⚠️ Atención** Esta opción dejó de ser gratuita debido a cambios en la plataforma de Railway. [Mas info](https://railway.app/).

🚀 Aplicación Slim Framework 4 PHP con despliegue automático.
==============================

## 📝 Introducción
El principal objetivo de este repositorio es poder desplegar de forma automática nuestra aplicación PHP Slim Framework 4 en un servidor en la nube. En esta ocación vamos a utilizar la versión gratuita de Railway, que nos permite vincular nuestro repositorio de github con la plataforma, poder desplegar automáticamente nuesto código y quedar disponible en la web.

## 1⃣ Forkear proyecto
Como primer paso, debemos hacer un fork de este proyecto desde el boton ubicado en la parte superior derecha de la pagina del repositorio.

## 2⃣ Subimos nuestro código (opcional si agregan código)
Una vez forkeado, clonamos el repo con `git clone <url del repo>` y agregamos nuestro codigo PHP (SLIM Framework).
Luego comiteamos y pusheamos los cambios.

```sh
git add .
git commit -m "first commit"
git push -u origin main
```

## 3⃣ Creamos y configuramos la aplicación en el servidor remoto

Para poder desplegar nuestro código en un servidor remoto, necesitamos una plataforma que nos permita gestionar uno. Para ello, nos dirigimos a la página de Railway https://railway.app/, iniciamos sesión con nuestra cuenta de Github.

![Railway2](https://i.ibb.co/XSj7ppS/railway-2.png)

Railway al iniciar sesión nos muestra su dashboard, aquí haremos clic en **Deploy from Github repo**

![Railway1](https://i.ibb.co/q9570sL/railway-1.png)

En esta sección buscamos por el nombre de nuestro repo forkeado. Ej.: **slim-php**

![Railway3](https://i.ibb.co/Yf2Fnx6/railway-3.png)

Una vez hecho esto, va a comenzar a clonar y desplegar nuestro repositorio en el servidor remoto. Este paso puede demorar unos minutos.

![Railway4](https://i.ibb.co/XxsR518/railway-4.png)

Una vez que termine vamos a poder ir a la sección **Settings** y elegir la rama de github que queremos deplegar con nuestra aplicación, en nuestro caso `main`. De esta forma, cada vez que se haga una modificación a esta rama, Railway va actualizar automáticamente la aplicación.

![Railway5](https://i.ibb.co/CVk5fLR/railway-5.png)

En esa misma sección podemos verificar si el depliegue se hizo con exito y la url para acceder en **Domains**. 

https://slim-php-deployment-production.up.railway.app/

Accedemos a la URL de la app desplegada y si todo funcionó correctamente veremos el siguiente mensaje:

``` {"method":"GET","msg":"Bienvenido a SlimFramework 2023"} ```

## Requisitos para correr localmente

- Instalar PHP o XAMPP (https://www.php.net/downloads.php o https://www.apachefriends.org/es/download.html)
- Instalar Composer desde https://getcomposer.org/download/ o por medio de CLI:

```sh
php -r "copy('//getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
```

## 📂 Correr localmente via XAMPP

- Copiar proyecto dentro de la carpeta htdocs

```sh
C:\xampp\htdocs\
```
- Acceder por linea de comandos a la carpeta del proyecto y luego instalar Slim framework via Compose

```sh
cd C:\xampp\htdocs\<ruta-del-repo-clonado>
composer update
```
- En el archivo index.php agregar la siguiente linea debajo de `AppFactory::create();`, deberán colocar los subniveles que existan hasta llegar al archivo index.php. Si colocamos el proyecto dentro de subcarpetas por ejemplo, dentro de la carpeta `app` :

```sh
// Set base path
$app->setBasePath('/app');
```
- Abrir desde http://localhost/ ó http://localhost:8080/ (depende del puerto configurado en el panel del XAMPP)

## 📁 Correr localmente via PHP

- Acceder por linea de comandos a la carpeta del proyecto y luego instalar Slim framework via Compose

```sh
cd C:\<ruta-del-repo-clonado>
composer update
php -S localhost:666 -t app
```

- Abrir desde http://localhost:666/

## Ayuda
Cualquier duda o consulta por el canal de slack

### 2023 - UTN FRA
