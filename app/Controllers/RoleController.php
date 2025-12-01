<?php

namespace App\Controllers;

use App\Core\Database;

class RoleController extends Controller
{
    public function __construct()
    {
        // Only users with 'manage_roles' permission can access RoleController actions
        $this->requireAuth();
        $this->requirePermission('manage_roles');
    }

    public function index()
    {
        $this->requireAuth();
        $stmt = Database::query('SELECT * FROM roles');
        $roles = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->view('pages/roles/index', ['roles' => $roles]);
    }

    public function create()
    {
        $this->requireAuth();
        return $this->view('pages/roles/create');
    }

    public function store()
    {
        $this->requireAuth();
        // Only users with 'manage_roles' permission can create roles
        $this->requirePermission('manage_roles');
        $this->validateCsrf();
        $name = $_POST['name'] ?? '';
        Database::query('INSERT INTO roles (name) VALUES (:n)', ['n' => $name]);
        redirect('roles');
    }
}
