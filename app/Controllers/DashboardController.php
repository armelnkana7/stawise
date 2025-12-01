<?php

namespace App\Controllers;

use App\Core\Database;

class DashboardController extends Controller
{

    public function index()
    {
        // Require auth (redirect to login if not authenticated)
        $this->requireAuth();

        // Some simple counts to show on the dashboard
        $usersCountStmt = Database::query('SELECT COUNT(*) as c FROM users');
        $usersCount = $usersCountStmt->fetch(\PDO::FETCH_ASSOC)['c'];

        $data = [
            'user_name' => $_SESSION['user_name'] ?? 'Utilisateur',
            'user_email' => $_SESSION['email'] ?? 'Email non disponible',
            'users_count' => $usersCount
        ];

        return $this->view('pages/dashboard', $data);
    }
}
