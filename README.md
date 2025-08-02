# pruebaNexura
Prueba Nexura

Aplicación simple de gestión de Empleados, Áreas y Roles desarrollada en PHP puro (POO) con PDO y Bootstrap 5.

Permite:

CRUD completo de empleados (nombre, email, sexo, área, descripción, boletín, roles).

Gestión de áreas mediante un modal dinámico.

Asignación múltiple de roles a empleados (tabla pivote).

Validación cliente- y servidor-lado.

Flash-messages de éxito/error.

Requisitos

PHP ≥ 7.4 con extensiones PDO y pdo_mysql

MySQL ≥ 5.7

Composer

Servidor web (Apache/Nginx) o Laragon/XAMPP/WAMP

Instalación

Clona el repositorio:

git clone https://github.com/agoniagiron/pruebaNexura.git
cd pruebaNexura

Instala dependencias con Composer:

composer install

Renombra el archivo de entorno:

cp .env.example .env

Edita .env y ajusta las credenciales de conexión a tu base de datos:

DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=nexura
DB_USER=root
DB_PASS=
DB_CHARSET=utf8mb4
APP_ENV=development
APP_DEBUG=true

Configurar la base de datos

Crea la base de datos y tablas ejecutando el script:

mysql -u <usuario> -p < schema.sql

Verifica que existan las tablas:

SHOW TABLES;

Levantar la aplicación

Con Laragon / Virtual Host

Apunta el vhost a D:/PruebaNexura/public.

Accede en el navegador a http://pruebanexura.test/.

Con servidor embebido de PHP

cd public
php -S localhost:8000

Luego abre en el navegador http://localhost:8000.

Estructura de carpetas

PruebaNexura/
├── .env.example          # Variables de entorno de ejemplo
├── composer.json
├── composer.lock
├── schema.sql            # Script para crear las tablas
├── config/
│   └── config.php        # Carga .env y devuelve settings
├── public/
│   ├── index.php         # Front-controller
│   └── assets/           # CSS/JS públicos
├── src/
│   ├── Database.php      # Clase de conexión PDO
│   └── Models/
│       └── EmpleadoModel.php
├── views/
│   ├── plantillas/       # header.php y footer.php
│   ├── form.php          # Formulario para create/edit
│   └── list.php          # Tabla de listado
└── vendor/               # Dependencias de Composer

Contribuir

Haz un fork del proyecto.

Crea tu rama: git checkout -b feat/mi-nueva-funcionalidad.

Realiza cambios y commitea: git commit -m 'Añade ...'.

Push a la rama: git push origin feat/mi-nueva-funcionalidad.

Abre un Pull Request.

Licencia

MIT © Andrés Girón