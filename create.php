<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\City;

echo "Создание администратора...\n";

// Удаляем существующего администратора если есть
$existingAdmin = User::where('email', 'admin@admin.com')->first();
if ($existingAdmin) {
    echo "Администратор уже существует, обновляем...\n";
    $existingAdmin->update([
        'is_admin' => true,
        'password' => bcrypt('password')
    ]);
    $admin = $existingAdmin;
} else {
    // Создаем нового администратора
    $admin = new User();
    $admin->name = 'Администратор';
    $admin->email = 'admin@admin.com';
    $admin->password = bcrypt('password');
    $admin->is_admin = true;
    $admin->save();
    
    echo "Администратор создан.\n";
}

// Проверяем
$checkAdmin = User::where('email', 'admin@admin.com')->first();
echo "Проверка:\n";
echo "ID: " . $checkAdmin->id . "\n";
echo "Имя: " . $checkAdmin->name . "\n";
echo "Email: " . $checkAdmin->email . "\n";
echo "is_admin: " . ($checkAdmin->is_admin ? 'true' : 'false') . "\n";

echo "\nГотово!\n";