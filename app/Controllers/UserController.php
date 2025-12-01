<?php
namespace App\Controllers;

use App\Core\Database;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $this->requireAuth();
        // if superadmin has global view permission
        if ($this->hasPermission('view_all_users')) {
            $stmt = Database::query('SELECT u.*, r.name as role_name, d.name as dept_name FROM users u LEFT JOIN roles r ON u.role_id = r.id LEFT JOIN departments d ON u.department_id = d.id');
            $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } elseif ($this->hasPermission('view_establishment')) {
            $eid = $_SESSION['establishment_id'] ?? null;
            $stmt = Database::query('SELECT u.*, r.name as role_name, d.name as dept_name FROM users u LEFT JOIN roles r ON u.role_id = r.id LEFT JOIN departments d ON u.department_id = d.id WHERE u.establishment_id = :e', ['e' => $eid]);
            $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } elseif ($this->hasPermission('view_department_reports')) {
            $did = $_SESSION['department_id'] ?? null;
            $stmt = Database::query('SELECT u.*, r.name as role_name, d.name as dept_name FROM users u LEFT JOIN roles r ON u.role_id = r.id LEFT JOIN departments d ON u.department_id = d.id WHERE u.department_id = :d', ['d' => $did]);
            $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            // no special view permissions => show only self
            $stmt = Database::query('SELECT u.*, r.name as role_name, d.name as dept_name FROM users u LEFT JOIN roles r ON u.role_id = r.id LEFT JOIN departments d ON u.department_id = d.id WHERE u.id = :id', ['id' => $_SESSION['user_id']]);
            $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        $roles = Database::query('SELECT * FROM roles')->fetchAll(\PDO::FETCH_ASSOC);
        $depts = Database::query('SELECT * FROM departments')->fetchAll(\PDO::FETCH_ASSOC);
        $ests = Database::query('SELECT * FROM establishments')->fetchAll(\PDO::FETCH_ASSOC);
        return $this->view('pages/users/index', ['users' => $users, 'roles' => $roles, 'depts' => $depts, 'ests' => $ests]);
    }

    public function edit()
    {
        $this->requireAuth();
        // only users with manage_users permission can edit; but censeur can edit users within his establishment
        $this->requirePermission('manage_users');
        $id = $_GET['id'] ?? null;
        if (!$id) redirect('users');
        $stmt = Database::query('SELECT * FROM users WHERE id = :id', ['id' => $id]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$user) redirect('users');
        // If the current user is a censeur (establishment admin) restrict editing to the same establishment
        if ($this->hasPermission('view_establishment') && ! $this->hasPermission('manage_roles')) {
            $eid = $_SESSION['establishment_id'] ?? null;
            if ($user['establishment_id'] != $eid) {
                die('403 Forbidden - you cannot edit users from other establishments.');
            }
        }
        $roles = Database::query('SELECT * FROM roles')->fetchAll(\PDO::FETCH_ASSOC);
        $depts = Database::query('SELECT * FROM departments')->fetchAll(\PDO::FETCH_ASSOC);
        return $this->view('pages/users/edit', ['user' => $user, 'roles' => $roles, 'depts' => $depts]);
    }

    public function update()
    {
        $this->requireAuth();
        $this->requirePermission('manage_users');
        $this->validateCsrf();
        $this->validateCsrf();
        $id = $_POST['id'] ?? null;
        $role = $_POST['role_id'] ?? 1;
        $dept = $_POST['department_id'] ?? null;
        $est = $_POST['establishment_id'] ?? null;
        // If the current user is a censeur, force establishment to the censeur's establishment
        if ($this->hasPermission('view_establishment') && ! $this->hasPermission('manage_roles')) {
            $est = $_SESSION['establishment_id'] ?? $est;
        }
        // Check for permission overrides submitted (meta)
        $meta = null;
        if (isset($_POST['extra_permissions']) && is_array($_POST['extra_permissions'])) {
            // meta format: { "permissions": ["perm_a", "perm_b"] }
            $meta = json_encode(['permissions' => array_values($_POST['extra_permissions'])]);
        }
        // if the users table has a 'meta' column we update it, otherwise skip meta
        $columnsStmt = Database::query("SHOW COLUMNS FROM users LIKE 'meta'");
        $hasMeta = ($columnsStmt->rowCount() > 0);
        if ($hasMeta) {
            Database::query('UPDATE users SET role_id = :r, department_id = :d, establishment_id = :e, meta = :m WHERE id = :id', ['r' => $role, 'd' => $dept, 'e' => $est, 'm' => $meta, 'id' => $id]);
        } else {
            Database::query('UPDATE users SET role_id = :r, department_id = :d, establishment_id = :e WHERE id = :id', ['r' => $role, 'd' => $dept, 'e' => $est, 'id' => $id]);
        }
        redirect('users');
    }

    public function store()
    {
        $this->requireAuth();
        $this->requirePermission('manage_users');
        $this->validateCsrf();

        $full_name = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        $role = $_POST['role_id'] ?? 1;
        $dept = $_POST['department_id'] ?? null;
        $est = $_POST['establishment_id'] ?? null;

        // If censeur, set establishment to censeur's establishment
        if ($this->hasPermission('view_establishment') && ! $this->hasPermission('manage_roles')) {
            $est = $_SESSION['establishment_id'] ?? $est;
        }

        // extra permissions
        $meta = null;
        if (isset($_POST['extra_permissions']) && is_array($_POST['extra_permissions'])) {
            $meta = json_encode(['permissions' => array_values($_POST['extra_permissions'])]);
        }

        // save user, password hash
        $hash = $password ? password_hash($password, PASSWORD_BCRYPT) : null;
        // if meta column exists, include it
        $columnsStmt = Database::query("SHOW COLUMNS FROM users LIKE 'meta'");
        $hasMeta = ($columnsStmt->rowCount() > 0);
        if ($hasMeta) {
            Database::query('INSERT INTO users (full_name, email, password_hash, role_id, department_id, establishment_id, meta) VALUES (:n, :e, :p, :r, :d, :est, :m)', ['n' => $full_name, 'e' => $email, 'p' => $hash, 'r' => $role, 'd' => $dept, 'est' => $est, 'm' => $meta]);
        } else {
            Database::query('INSERT INTO users (full_name, email, password_hash, role_id, department_id, establishment_id) VALUES (:n, :e, :p, :r, :d, :est)', ['n' => $full_name, 'e' => $email, 'p' => $hash, 'r' => $role, 'd' => $dept, 'est' => $est]);
        }

        redirect('users');
    }
}
