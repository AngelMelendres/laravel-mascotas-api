# 🐾 API de Gestión de Personas y Mascotas - Laravel + JWT

API RESTful desarrollada en Laravel que permite gestionar personas y sus mascotas, con autenticación basada en JWT, validaciones robustas, documentación Swagger y consumo de APIs externas como TheDogAPI y TheCatAPI.

---

## 📦 Tecnologías Utilizadas

- **Laravel 12.x**
- **PHP >= 8.2**
- **MySQL o MariaDB**
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

DB_DATABASE=mascotas
DB_USERNAME=root
DB_PASSWORD=secret


### 3.Migrar y poblar base de datos:
```bash
php artisan migrate --seed
```


### 4. Levantar el servidor local:
```bash
 php artisan serve
```



