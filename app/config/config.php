<?php
// Configuración de la aplicación
define('DEBUG', true); // Cambiar a false en producción
define('BASE_URL', 'http://localhost/contact-center-mvc/');
define('APPROOT', dirname(dirname(__FILE__)));
define('URLROOT', 'http://localhost/contact-center-mvc');
define('SITENAME', 'Contact Center Atlas');

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'contact2');

// Configuración de correo
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', '');
define('MAIL_PASSWORD', '');
define('MAIL_ENCRYPTION', 'tls');

// Configuración de SMS
define('SMS_API_KEY', '');
define('SMS_API_SECRET', '');

// Configuración de sesión
define('SESSION_NAME', 'contact_center_session');
define('SESSION_LIFETIME', 7200); // 2 horas
