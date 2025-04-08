<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Proyecto Gestion de Informacion Cultura Tibacuy


## Proceso de Instalación

-Instalar Xampp **[LINK DE DESCARGA XAMPP](https://www.apachefriends.org/es/index.html)** 

    1. Una vez instalado, ingresamos a la aplicacion.
    2. Activamos Apache.
    3. Activamos MySQL.
    4. En el modulo "APACHE" en el boton "Config" seleccionamos "PHP(php.ini)" y adentro del .txt usamos "Ctrl + b" y escribimos "zip", encontraremos una linea de codigo así ";extension=zip" y le quitamos unicamente "; (el punto y coma)", luego archivo, guardar y cerramos.
    5. Entramos a "PHPMYADMIN" en el boton "ADMIN" que se encuenta en el modulo "MySQL" (Esto nos lleva a una pestaña en nuestro navegador predeterminado).
    6. Una vez adentro creamos una nueva base de datos con el nombre "culturatibacuy".

-Instalar composer **[LINK DIRECTA DESCARGA COMPOSER](https://getcomposer.org/Composer-Setup.exe)**

-Instalar Node.js **[LINK DIRECTA DESCAR NODE.JS](https://nodejs.org/dist/v22.14.0/node-v22.14.0-x64.msi)**
(Activamos la casilla)


    -Ingresamos a Windows PowerShell como Administrador
    -Ingresamos los siguiente codigo...

    Codigo 1
    ---------------------------------------------------------------------------------
    Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
    ---------------------------------------------------------------------------------
    codigo 2
    ---------------------------------------------------------------------------------
    composer global require laravel/installer
    ---------------------------------------------------------------------------------

-GitHub
    -Entramos a GitHub en nuestro repositorio "CulturaTibacuy"
        -En el boton "< > Code" 
        -Copiamos el siguiente URL (https://github.com/nicoRincon/CulturaTibacuy.git)


-Visual Studio Code
    -En nuestro Pc, Abrimos Visual Studio Code
        -Abrimos nuestra terminal y nos ubicamos en nuestra carpeta "XAMPP", "htdocs" y ahi clomamos el repositorio
        Ingresamos
            git clone https://github.com/nicoRincon/CulturaTibacuy.git

        creamos un new file y le colocamos por nombre ".env" y compiamos lo que tiene el ".env.example"
        
        Vamos a una nueva terminal e ingreamos
            composer require laravel/ui
            npm install ; npm run dev (Una vez instalado y no de mas lineas cancelamos con ctrl + c)
            composer require laravel/sanctum 
            php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
            php artisan key:generate
        

            

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**