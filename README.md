# 🐾 API de Gestión de Personas y Mascotas - Laravel + JWT

API RESTful desarrollada en Laravel que permite gestionar personas y sus mascotas, con autenticación basada en JWT, validaciones robustas, documentación Swagger y consumo de APIs externas como TheDogAPI y TheCatAPI.

---

## 📦 Tecnologías Utilizadas

- **Laravel 12.x**
- **PHP 8.2**
- **MySQL**
- **JWT Authentication** (`tymon/jwt-auth`)
- **Swagger (L5 Swagger)**
- **Eloquent ORM**
- Arquitectura limpia con:
  - Controladores
  - Services
  - Repositories
  - Form Request
  - API Resources

---

## 🚀 Instalación del Proyecto

### 1. Clonar el repositorio

```bash
git clone https://github.com/tuusuario/laravel-mascotas-api.git
cd laravel-mascotas-api
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

### 2.Configura tu base de datos en .env:
```bash

DB_DATABASE=mascotas
DB_USERNAME=root
DB_PASSWORD=secret
```


### 3.Migrar y poblar base de datos:
```bash
php artisan migrate --seed
```


### 4. Levantar el servidor local:
```bash
 php artisan serve
```

##✅ Generación de pruebas unitarias

```bash
php artisan test
```


##📚 Documentación de la API
##✅ Generación Swagger
La documentación fue generada con Swagger usando el paquete L5-Swagger.
Para regenerar la documentación (opcional):
```bash
php artisan l5-swagger:generate
```


##📖 Acceso a la documentación:

```bash
http://localhost:8000/api/documentation
```

##🧪 Cómo probar con Postman
Haz una petición POST /api/register o usa el usuario de prueba (ver abajo).
Luego, usa POST /api/login para obtener un token JWT.
Copia el token retornado y colócalo en el header:
```bash
Authorization: Bearer TU_TOKEN
```
Puedes usar todos los endpoints protegidos como:

```bash
GET /api/user
GET /api/personas
POST /api/mascotas, etc.
```

##👤 Usuario de Prueba
```bash
{
  "email": "juan@example.com",
  "password": "12345678"
}
```


