<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;

echo "Seeding DB...\n";

try {
    // Add admin role if not exists
    $stmt = Database::query("SELECT id FROM roles WHERE name = :n", ['n' => 'admin']);
    $role = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$role) {
        Database::query("INSERT INTO roles (name, description) VALUES (:n, :d)", ['n' => 'admin', 'd' => 'Administrateur']);
        $role_id = Database::connect()->lastInsertId();
        echo "Created role 'admin' (id={$role_id})\n";
    } else {
        $role_id = $role['id'];
        echo "Role 'admin' already exists (id={$role_id})\n";
    }

    // Create an establishment if none exists
    $stmt = Database::query("SELECT id FROM establishments LIMIT 1");
    $est = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$est) {
        Database::query("INSERT INTO establishments (name) VALUES (:name)", ['name' => 'StatWise Demo']);
        $establishment_id = Database::connect()->lastInsertId();
        echo "Created establishment id={$establishment_id}\n";
    } else {
        $establishment_id = $est['id'];
        echo "Establishment exists id={$establishment_id}\n";
    }

    // Add admin user if not exists
    $email = 'admin@statwise.local';
    $stmt = Database::query("SELECT id FROM users WHERE email = :email", ['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        $password = password_hash('password', PASSWORD_DEFAULT);
        Database::query(
            "INSERT INTO users (establishment_id, role_id, full_name, email, username, password_hash) VALUES (:est, :role, :full, :email, :username, :pass)",
            ['est' => $establishment_id, 'role' => $role_id, 'full' => 'Admin Demo', 'email' => $email, 'username' => 'admin', 'pass' => $password]
        );
        $uid = Database::connect()->lastInsertId();
        echo "Created admin user id={$uid} email={$email}\n";
    } else {
        echo "Admin user already exists (id={$user['id']})\n";
    }

    // Ensure at least one program exists
    $stmt = Database::query('SELECT id FROM programs LIMIT 1');
    $prog = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$prog) {
        // Use existing class id and subject id as default
        $classStmt = Database::query('SELECT id FROM classes LIMIT 1');
        $classname = $classStmt->fetch(PDO::FETCH_ASSOC);
        $class_id = $classname['id'] ?? 1;
        $subjectStmt = Database::query('SELECT id FROM subjects LIMIT 1');
        $subjectname = $subjectStmt->fetch(PDO::FETCH_ASSOC);
        $subject_id = $subjectname['id'] ?? 1;
        Database::query('INSERT INTO programs (classe_id, subject_id, nbr_hours, nbr_lesson, nbr_lesson_dig, nbr_tp, nbr_tp_dig) VALUES (:c, :s, :h, :l, :ld, :tp, :tpd)', ['c' => $class_id, 's' => $subject_id, 'h' => 10, 'l' => 20, 'ld' => 2, 'tp' => 0, 'tpd' => 0]);
        echo "Created sample program for class {$class_id} subject {$subject_id}\n";
    } else {
        echo "Program exists id={$prog['id']}\n";
    }

    echo "Done.\n";
} catch (Exception $e) {
    echo 'Error seeding DB: ' . $e->getMessage() . "\n";
}
