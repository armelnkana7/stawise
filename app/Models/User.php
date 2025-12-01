<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    public $id;
    public $full_name;
    public $email;
    public $password_hash;
    public $department_id;
    public $role_id;
    public $establishment_id;

    /**
     * Find a user by their email address.
     *
     * @param string $email The email address to search for.
     * @return self|null The user object or null if not found.
     */
    public static function findByEmail($email)
    {
        $stmt = Database::query(
            "SELECT * FROM users WHERE email = :email",
            ['email' => $email]
        );

        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_data) {
            $user = new self();
            $user->id = $user_data['id'];
            $user->full_name = $user_data['full_name'];
            $user->email = $user_data['email'];
            $user->password_hash = $user_data['password_hash'];
            $user->department_id = $user_data['department_id'] ?? null;
            $user->role_id = $user_data['role_id'] ?? null;
            $user->establishment_id = $user_data['establishment_id'] ?? null;
            return $user;
        }

        return null;
    }
}
