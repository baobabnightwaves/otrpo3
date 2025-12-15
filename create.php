    <?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\City;

$admin = User::where('email', 'admin@example.com')->first();

if (!$admin) {
    $admin = User::create([
        'name' => 'Администратор',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('admin'),
        'is_admin' => true,
    ]);
} else {
    $admin->is_admin = true;
    $admin->save();
}
