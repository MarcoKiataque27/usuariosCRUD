# 👤 CRUD de Usuarios - API REST & Frontend

Este proyecto consiste en un sistema de gestión de usuarios (CRUD) desarrollado con una arquitectura desacoplada: un **Backend en PHP** que funciona como API REST y un **Frontend dinámico** basado en HTML5, CSS3 (Bootstrap 5) y JavaScript (Fetch API).

## 🚀 Características

* [cite_start]**Arquitectura MVC**: Separación clara entre Modelos, Controladores y Vistas[cite: 23, 54, 85].
* [cite_start]**API RESTful**: Endpoints preparados para operaciones GET y POST que simulan el comportamiento CRUD [cite: 3-11].
* [cite_start]**Persistencia**: Conexión a base de datos MariaDB mediante **PDO** con soporte para transacciones seguras[cite: 17, 18].
* [cite_start]**Interfaz Responsiva**: Diseño basado en **Bootstrap 5** para una experiencia óptima en móviles y escritorio[cite: 85].

## 📂 Estructura del Proyecto

```plaintext
usuariosCRUD/
├── config/
│   ├── Database.php      # Conexión Singleton a MariaDB 
│   └── Render.php        # Helper para renderizado de vistas [cite: 22]
├── controllers/
│   └── UsuarioController.php # Lógica de negocio y control de flujo [cite: 23]
├── models/
│   └── Usuario.php       # Capa de datos y consultas SQL [cite: 54]
├── views/
│   ├── usuarios/         # Plantillas específicas (index, edit, show, create) [cite: 24, 27, 28, 39]
│   └── layout.php        # Estructura HTML base y alertas [cite: 85]
├── .htaccess             # Reglas de reescritura para rutas amigables
└── index.php             # Front Controller (Enrutador principal) [cite: 1]

🛠️ Tecnologías Utilizadas

    Backend: PHP 8.x 

Base de Datos: MariaDB / MySQL 

Servidor Web: Apache (con mod_rewrite habilitado)

Frontend: JavaScript (Fetch API), HTML5, Bootstrap 5 

⚙️ Configuración e Instalación
1. Base de Datos

Importar el siguiente esquema en tu servidor MariaDB (Base de datos db01 ):

SQL

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    celular VARCHAR(30),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

2. Conexión (config/Database.php)

Asegúrate de que las credenciales coincidan con tu entorno de red (Docker/Podman):
PHP

private static $host = '192.168.56.250'; // IP de tu servidor 
private static $dbname = 'db01';
private static $username = 'root';
private static $password = 'Marco6366546.';

3. Servidor Apache

Es indispensable que el archivo .htaccess esté presente en la raíz para habilitar el enrutamiento:
Apache

RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [L,QSA]

🔌 Endpoints de la Aplicación
Método	Endpoint	Descripción
GET	/usuarios	

Listado general de usuarios

GET	/usuarios/show/{id}	

Detalle de un usuario específico

POST	/usuarios/store	

Persistencia de nuevo usuario

POST	/usuarios/update/{id}	

Actualización de datos

POST	/usuarios/delete/{id}	

Eliminación de registro

📝 Notas de Desarrollo (Actividad 02)

Durante la implementación en el entorno MiniOS se resolvieron desafíos técnicos clave:

    Manejo de Errores: Implementación de bloques try-catch para capturar excepciones de PDO y devolver respuestas estructuradas en JSON con códigos de estado HTTP 500 .

Validación: Control de correos duplicados y campos obligatorios directamente en el controlador antes de la persistencia .

Rutas: Ajuste de rutas amigables para evitar el error "404 Not Found" en servidores Apache configurados en subdirectorios.
