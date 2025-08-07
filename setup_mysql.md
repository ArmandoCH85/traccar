# Configuración MySQL para Trackar

## Problema Actual
MySQL 8.0 en Ubuntu usa autenticación unix_socket para root, lo que impide la conexión desde Laravel.

## Solución 1: Crear un usuario específico para Laravel

Ejecuta estos comandos en MySQL como root:

```bash
sudo mysql
```

Luego ejecuta estos comandos SQL:

```sql
CREATE DATABASE IF NOT EXISTS trackar;
CREATE USER IF NOT EXISTS 'trackar_user'@'localhost' IDENTIFIED BY 'password123';
GRANT ALL PRIVILEGES ON trackar.* TO 'trackar_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

Después actualiza el archivo .env:
```env
DB_DATABASE=trackar
DB_USERNAME=trackar_user
DB_PASSWORD=password123
```

## Solución 2: Cambiar autenticación del usuario root

```bash
sudo mysql
```

```sql
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'nueva_password';
FLUSH PRIVILEGES;
EXIT;
```

Luego actualiza .env:
```env
DB_PASSWORD=nueva_password
```

## Después de cualquier solución:

```bash
php artisan config:clear
php artisan migrate:fresh
php artisan tinker --execute="App\Models\User::factory()->create(['name' => 'Admin', 'email' => 'admin@trackar.com', 'password' => bcrypt('password')]);"
```