👤 CRUD de Usuarios - API REST & FrontendEste proyecto consiste en un sistema de gestión de usuarios (CRUD) desarrollado con una arquitectura desacoplada: un Backend en PHP que funciona como API REST y un Frontend dinámico basado en HTML5, CSS3 (Bootstrap) y JavaScript (Fetch API).🚀 CaracterísticasArquitectura MVC: Separación clara entre Modelos, Controladores y Vistas.API RESTful: Endpoints para operaciones GET, POST, PUT y DELETE.Persistencia: Conexión a base de datos MariaDB mediante PDO.Interfaz Responsiva: Diseño basado en Bootstrap 5.📂 Estructura del ProyectoPlaintextusuariosCRUD/
├── config/
│   └── database.php      # Conexión PDO a MariaDB
├── controllers/
│   └── UsuarioController.php # Lógica de negocio
├── models/
│   └── Usuario.php       # Consultas SQL (Capa de datos)
├── public/
│   └── style.css         # Estilos personalizados
├── .htaccess             # Reglas de reescritura de Apache
├── index.php             # Front Controller (Enrutador)
└── index.html            # Interfaz de usuario (Frontend)
🛠️ Tecnologías UtilizadasBackend: PHP 8.xBase de Datos: MariaDB / MySQLServidor Web: Apache (con mod_rewrite habilitado)Frontend: JavaScript (ES6+), HTML5, Bootstrap 5⚙️ Configuración e Instalación1. Base de DatosImportar el archivo db01.sql en tu servidor MariaDB. La tabla principal debe ser usuarios:SQLCREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    celular VARCHAR(30),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
2. Conexión (database.php)Asegurar que la IP y credenciales coincidan con tu entorno de MiniOS/Docker:PHPdefine('DB_HOST', '192.168.100.223');
define('DB_NAME', 'db01');
define('DB_USER', 'root');
define('DB_PASS', '123456');
3. Servidor ApacheEl archivo .htaccess es requerido para que las rutas de la API funcionen correctamente:Redirige /api/usuarios hacia index.php.🔌 Endpoints de la APIMétodoEndpointDescripciónGET/api/usuariosListar todos los usuariosGET/api/usuarios/{id}Obtener un usuario por IDPOST/api/usuariosCrear un nuevo usuarioPUT/api/usuarios/{id}Actualizar un usuario existenteDELETE/api/usuarios/{id}Eliminar un usuario📝 Notas de Depuración (Actividad 02)Durante el desarrollo se corrigieron los siguientes puntos críticos:Rutas Relativas: Ajuste de _DIR_ para la carga de dependencias en el Front Controller.CORS: Implementación de cabeceras para permitir peticiones desde diferentes orígenes.Manejo de Errores: Implementación de bloques try-catch para capturar excepciones de PDO y devolver respuestas JSON con código de estado 500 en caso de fallo.