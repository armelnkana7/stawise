<?php
namespace App\Controllers;

use App\Core\Database;

class SubjectController extends Controller
{
    public function index()
    {
        $this->requireAuth();
        $est = $_SESSION['establishment_id'] ?? null;
        if ($est) {
            $stmt = Database::query('SELECT s.*, d.name AS department_name, e.name as establishment_name FROM subjects s LEFT JOIN departments d ON s.department_id = d.id LEFT JOIN establishments e ON s.establishment_id = e.id WHERE s.establishment_id = :est', ['est' => $est]);
        } else {
            $stmt = Database::query('SELECT s.*, d.name AS department_name, e.name as establishment_name FROM subjects s LEFT JOIN departments d ON s.department_id = d.id LEFT JOIN establishments e ON s.establishment_id = e.id');
        }
        $subjects = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $depts = Database::query('SELECT id, name FROM departments')->fetchAll(\PDO::FETCH_ASSOC);
        $ests = Database::query('SELECT id, name FROM establishments')->fetchAll(\PDO::FETCH_ASSOC);
        return $this->view('pages/subjects/index', ['subjects' => $subjects, 'depts' => $depts, 'ests' => $ests]);
    }

    public function create()
    {
        $this->requireAuth();
        $depts = Database::query('SELECT id, name FROM departments')->fetchAll(\PDO::FETCH_ASSOC);
        $ests = Database::query('SELECT id, name FROM establishments')->fetchAll(\PDO::FETCH_ASSOC);
        return $this->view('pages/subjects/create', ['depts' => $depts, 'ests' => $ests]);
    }

    public function store()
    {
        $this->requireAuth();
        $this->requirePermission('manage_subjects');
        $this->validateCsrf();
        $name = $_POST['name'] ?? '';
        $code = $_POST['code'] ?? null;
        $desc = $_POST['description'] ?? null;
        $department_id = !empty($_POST['department_id']) ? $_POST['department_id'] : null;
        $establishment_id = !empty($_POST['establishment_id']) ? $_POST['establishment_id'] : null;
        if (!$name) {
            set_flash('error', 'Le nom de la matière est requis.');
            redirect('subjects');
        }
        // If the current user has limited scope (censeur), ensure establishment matches
        if ($this->hasPermission('view_establishment') && ! $this->hasPermission('manage_roles')) {
            $establishment_id = $_SESSION['establishment_id'] ?? $establishment_id;
        }
        Database::query('INSERT INTO subjects (name, code, description, department_id, establishment_id) VALUES (:name, :code, :desc, :dept, :est)', ['name' => $name, 'code' => $code, 'desc' => $desc, 'dept' => $department_id, 'est' => $establishment_id]);
        set_flash('success', 'Matière créée.');
        redirect('subjects');
    }

    public function edit()
    {
        $this->requireAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) redirect('subjects');
        $stmt = Database::query('SELECT * FROM subjects WHERE id = :id', ['id' => $id]);
        $subject = $stmt->fetch(\PDO::FETCH_ASSOC);
        $depts = Database::query('SELECT id, name FROM departments')->fetchAll(\PDO::FETCH_ASSOC);
        $ests = Database::query('SELECT id, name FROM establishments')->fetchAll(\PDO::FETCH_ASSOC);
        return $this->view('pages/subjects/edit', ['subject' => $subject, 'depts' => $depts, 'ests' => $ests]);
    }

    public function update()
    {
        $this->requireAuth();
        $this->requirePermission('manage_subjects');
        $this->validateCsrf();
        $id = $_POST['id'] ?? null;
        if (!$id) redirect('subjects');
        $name = $_POST['name'] ?? '';
        $code = $_POST['code'] ?? null;
        $desc = $_POST['description'] ?? null;
        $department_id = !empty($_POST['department_id']) ? $_POST['department_id'] : null;
        $establishment_id = !empty($_POST['establishment_id']) ? $_POST['establishment_id'] : null;
        if ($this->hasPermission('view_establishment') && ! $this->hasPermission('manage_roles')) {
            $establishment_id = $_SESSION['establishment_id'] ?? $establishment_id;
        }
        Database::query('UPDATE subjects SET name = :name, code = :code, description = :desc, department_id = :dept, establishment_id = :est WHERE id = :id', ['name' => $name, 'code' => $code, 'desc' => $desc, 'dept' => $department_id, 'est' => $establishment_id, 'id' => $id]);
        set_flash('success', 'Matière mise à jour.');
        redirect('subjects');
    }

    public function delete()
    {
        $this->requireAuth();
        $this->requirePermission('manage_subjects');
        $this->validateCsrf();
        $id = $_POST['id'] ?? null;
        if (!$id) redirect('subjects');
        Database::query('DELETE FROM subjects WHERE id = :id', ['id' => $id]);
        set_flash('success', 'Matière supprimée.');
        redirect('subjects');
    }

    // list in JSON
    public function list()
    {
        $this->requireAuth();
        $est = $_SESSION['establishment_id'] ?? null;
        $sql = 'SELECT id, name, department_id, establishment_id FROM subjects';
        $params = [];
        if ($est) {
            $sql .= ' WHERE establishment_id = :est';
            $params['est'] = $est;
        }
        $rows = Database::query($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($rows);
        return;
    }
}
