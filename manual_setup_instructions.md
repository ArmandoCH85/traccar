# 📋 Instrucciones de Configuración Manual de MySQL

## ⚠️ Configuración de MySQL Requerida

Para completar la configuración, necesitas ejecutar estos comandos manualmente:

### **1. Configurar MySQL Root**

```bash
# Acceder a MySQL como administrador
sudo mysql

# Dentro de MySQL, ejecutar:
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '123456';
CREATE DATABASE IF NOT EXISTS trackar;
FLUSH PRIVILEGES;
EXIT;
```

### **2. Verificar Conexión**
```bash
mysql -u root -p123456 -e "SHOW DATABASES;"
```

### **3. Completar Setup de Laravel**
Una vez configurado MySQL, ejecutar:

```bash
# Limpiar cache
php artisan config:clear

# Ejecutar migraciones
php artisan migrate:fresh

# Generar permisos de Shield
php artisan shield:generate --all

# Crear usuario administrador
php artisan tinker --execute="require 'setup_shield_admin.php';"

# Iniciar aplicación
php artisan serve
```

## 🎯 Tablas que se Crearán

### **Tablas de Laravel:**
- `migrations` - Control de migraciones
- `users` - Usuarios del sistema
- `cache`, `cache_locks` - Sistema de cache
- `jobs`, `job_batches`, `failed_jobs` - Sistema de colas
- `sessions` - Sesiones de usuario
- `password_reset_tokens` - Recuperación de contraseñas

### **Tablas de Spatie Permission (Shield):**
- `roles` - Roles del sistema
- `permissions` - Permisos individuales
- `model_has_permissions` - Relación modelo-permisos
- `model_has_roles` - Relación modelo-roles
- `role_has_permissions` - Relación rol-permisos

### **Tablas del Proyecto Trackar:**
- `devices` - Dispositivos GPS
- `positions` - Posiciones/ubicaciones

### **Total: ~13-15 tablas**

## ✅ Resultado Final

Después de la configuración tendrás:
- ✅ Base de datos MySQL configurada
- ✅ Sistema completo de usuarios y permisos
- ✅ Integración con Traccar
- ✅ Admin: admin@trackar.com / password