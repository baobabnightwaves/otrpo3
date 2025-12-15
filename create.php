    <?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Установка администратора и владельцев ===\n\n";

use App\Models\User;
use App\Models\City;

// 1. Находим или создаем администратора
$admin = User::where('email', 'admin@example.com')->first();

if (!$admin) {
    $admin = User::create([
        'name' => 'Администратор',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('admin'),
        'is_admin' => true,
    ]);
    echo "✅ Создан новый администратор\n";
} else {
    $admin->is_admin = true;
    $admin->save();
    echo "✅ Существующий пользователь назначен администратором\n";
}

echo "👤 Администратор: {$admin->name} (ID: {$admin->id})\n";

// 2. Назначаем города администратору
$citiesCount = City::count();
$updatedCount = City::whereNull('user_id')->update(['user_id' => $admin->id]);

echo "🏙️  Городов в базе: {$citiesCount}\n";
echo "✅ Назначено владельцев: {$updatedCount}\n";

// 3. Проверяем
echo "\n=== Проверка ===\n";
echo "Городов у администратора: " . $admin->cities()->count() . "\n";

// Проверяем несколько городов
$sampleCities = City::limit(3)->get();
foreach ($sampleCities as $city) {
    $ownerName = $city->user ? $city->user->name : 'Нет владельца';
    echo "Город: {$city->name} | Владелец: {$ownerName}\n";
}

echo "\n✅ Готово!\n";