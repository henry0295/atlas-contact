# Contact Center MVC

Sistema de gestión de comunicaciones multicanal desarrollado en PHP con arquitectura MVC.

## 📋 Características

- Envío de SMS (individual y masivo)
- Gestión de correos electrónicos
- Sistema de audio mensajes
- Panel de administración
- Registro de actividades
- Interfaz moderna y responsiva

## 🚀 Instalación

### Requisitos previos

- PHP 8.0 o superior
- MySQL 5.7 o superior
- Composer
- Laragon o servidor web similar

### Pasos de instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/tu-usuario/contact-center-mvc.git
cd contact-center-mvc
```

2. Instalar dependencias:
```bash
composer install
```

3. Configurar la base de datos:
- Crear una base de datos MySQL
- Importar el archivo `database/schema.sql`
- Configurar las credenciales en `app/config/config.php`

4. Configurar el archivo `.env`:
```env
# Base de datos
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=contact2

# API de SMS (360NRS)
SMS_API_URL=https://dashboard.360nrs.com/api/rest/sms
SMS_API_KEY=your_api_key
SMS_SENDER_ID=Atlas

# API de Email (360NRS)
EMAIL_API_URL=https://dashboard.360nrs.com/api/rest/mailing
EMAIL_API_KEY=your_api_key

# Configuración de SMTP
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
```

## 📦 Estructura del Proyecto

```
app/
├── config/         # Configuración de la aplicación
├── controllers/    # Controladores
├── core/          # Núcleo del framework MVC
├── models/        # Modelos
└── views/         # Vistas
    ├── auth/      # Autenticación
    ├── sms/       # Gestión de SMS
    ├── email/     # Gestión de correos
    ├── audio/     # Gestión de audio
    └── layouts/   # Plantillas
database/
└── schema.sql     # Estructura de la base de datos
public/
└── index.php      # Punto de entrada
```

## 🔧 Configuración

### Configuración de APIs

#### SMS API (360NRS)
```php
// app/config/config.php
define('SMS_API_KEY', 'your_api_key');
define('SMS_API_SECRET', 'your_api_secret');
```

El sistema utiliza la API de 360NRS para el envío de SMS con las siguientes características:
- Soporte para mensajes Unicode
- División automática de mensajes largos
- Confirmación de entrega
- Registro de estado de envío

#### Email API
```php
// app/config/config.php
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', '');
define('MAIL_PASSWORD', '');
define('MAIL_ENCRYPTION', 'tls');
```

### Base de Datos

La estructura de la base de datos incluye las siguientes tablas principales:
- users: Gestión de usuarios
- sms_logs: Registro de envíos de SMS
- email_logs: Registro de correos enviados
- audio_logs: Registro de mensajes de audio

## 📱 Funcionalidades

### Gestión de SMS

1. **Envío Individual**
   - Validación de números
   - Soporte para caracteres especiales
   - Límite de 160 caracteres por mensaje
   - División automática para mensajes largos

2. **Envío Masivo**
   - Carga de archivo CSV
   - Validación de números en lote
   - Reporte de estado de envío
   - Historial de campañas

### Seguridad

- Autenticación de usuarios
- Sesiones seguras
- Protección contra CSRF
- Validación de datos de entrada
- Encriptación de contraseñas

## 👥 Usuarios

El sistema incluye un usuario administrador por defecto:
- Usuario: admin
- Contraseña: admin123

Se recomienda cambiar estas credenciales después de la primera instalación.

## 🛠 Desarrollo

### Convenciones de Código

- PSR-4 para autoloading
- PSR-12 para estilo de código
- Nombres de clases en PascalCase
- Nombres de métodos en camelCase
- Nombres de variables en snake_case

### Manejo de Errores

El sistema incluye un sistema robusto de logging y manejo de errores:
- Logs de errores de API
- Registro de intentos fallidos de autenticación
- Monitoreo de envíos fallidos

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 🤝 Contribución

Las contribuciones son bienvenidas. Por favor, asegúrate de actualizar las pruebas según corresponda.
