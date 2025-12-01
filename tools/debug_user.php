<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Helpers/helpers.php';
use App\Core\Database;

$stmt = Database::query('SELECT id, email, password_hash FROM users WHERE email = :e', ['e' => 'admin@statwise.local']);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
var_dump($user);
if ($user) {
    $ok = password_verify('password', $user['password_hash']);
    echo "password_verify('password') => "; var_dump($ok);
}
