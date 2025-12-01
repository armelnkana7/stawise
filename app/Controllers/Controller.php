<?php

namespace App\Controllers;

use App\Models\User;

class Controller
{
    /**
     * Render a view.
     *
     * @param string $view The view file to render.
     * @param array $data The data to pass to the view.
     */
    protected function view($view, $data = [])
    {
        extract($data);

        require __DIR__ . '/../../views/' . $view . '.php';
    }

    /**
     * Require authentication for a controller action.
     * If the user is not authenticated, redirect to the login page.
     */
    protected function requireAuth()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        } else {
            // Optionally, you can load user data here if needed
            // Récupérer l'utilisateur
            $user = User::findByEmail($_SESSION['email']);

            // Démarrer la session et stocker les infos de l'utilisateur (la session est déjà démarrée dans index.php)
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->full_name;
            $_SESSION['email'] = $user->email;
            $_SESSION['department_id'] = $user->department_id;
            $_SESSION['establishment_id'] = $user->establishment_id;
            // Store role id for authorization checks
            $_SESSION['role_id'] = $user->role_id ?? null;
        }
    }

    /**
     * Get the currently authenticated user data stored in session
     */
    protected function authUser()
    {
        if (isset($_SESSION['user_id'])) {
            return [
                'id' => $_SESSION['user_id'],
                'name' => $_SESSION['user_name'] ?? null
            ];
        }

        return null;
    }

    /**
     * Require that the authenticated user has one of the allowed role ids
     * Example usage: $this->requireRole([1]); // admins only
     */
    protected function requireRole(array $roles)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }
        $rid = $_SESSION['role_id'] ?? null;
        if (!$rid || !in_array($rid, $roles)) {
            // You can show a forbidden page or redirect to dashboard
            die('403 Forbidden - insufficient permissions.');
        }
    }

    /**
     * Determine whether current logged user has a permission.
     */
    protected function hasPermission(string $permission)
    {
        $roleId = $_SESSION['role_id'] ?? null;
        if (!$roleId) return false;
        // try to include helper
        if (!function_exists('role_has_permission')) {
            require_once __DIR__ . '/../Helpers/permissions.php';
        }
        // we attempt to load user data
        $user = null;
        if (isset($_SESSION['user_id'])) {
            $stmt = \App\Core\Database::query('SELECT * FROM users WHERE id = :id', ['id' => $_SESSION['user_id']]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return role_has_permission($roleId, $permission, $user);
    }

    /**
     * Require a permission else show 403.
     */
    protected function requirePermission(string $permission)
    {
        if (!$this->hasPermission($permission)) {
            die('403 Forbidden - insufficient permissions.');
        }
    }

    /**
     * Validate CSRF token for POST requests
     */
    protected function validateCsrf()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!function_exists('validate_csrf') || !validate_csrf()) {
                die('Invalid CSRF token.');
            }
        }
    }
}
