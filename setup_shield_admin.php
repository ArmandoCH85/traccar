<?php

// Script para configurar Filament Shield y crear usuario administrador

use App\Models\User;
use Spatie\Permission\Models\Role;

// Crear usuario administrador si no existe
$user = User::firstOrCreate(
    ['email' => 'admin@trackar.com'],
    [
        'name' => 'Administrador',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
    ]
);

// Crear roles básicos si no existen
$superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
$adminRole = Role::firstOrCreate(['name' => 'admin']);
$userRole = Role::firstOrCreate(['name' => 'user']);

// Asignar rol super_admin al usuario
if (!$user->hasRole('super_admin')) {
    $user->assignRole('super_admin');
    echo "✅ Usuario administrador creado con rol super_admin\n";
} else {
    echo "✅ Usuario administrador ya existe con rol super_admin\n";
}

echo "📧 Email: admin@trackar.com\n";
echo "🔑 Password: password\n";
echo "🎯 Roles disponibles: super_admin, admin, user\n";
echo "✅ Configuración de Shield completada\n";