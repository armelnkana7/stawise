<?php
namespace App\Controllers;

use App\Core\Database;

class ProgramController extends Controller
{
    public function index()
    {
        $this->requireAuth();
        $q = $_GET['q'] ?? null;
        if ($q) {
            $stmt = Database::query('SELECT p.*, c.name as class_name, s.name as subject_name FROM programs p JOIN classes c ON p.classe_id = c.id JOIN subjects s ON p.subject_id = s.id WHERE c.name LIKE :q OR s.name LIKE :q', ['q' => "%$q%"]);
        } else {
            $stmt = Database::query('SELECT p.*, c.name as class_name, s.name as subject_name FROM programs p JOIN classes c ON p.classe_id = c.id JOIN subjects s ON p.subject_id = s.id');
        }
        $programs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->view('pages/programs/index', ['programs' => $programs]);
    }

    // Return JSON list of programs (used for AJAX refresh)
    public function list()
    {
        $this->requireAuth();
        $deptFilter = $_SESSION['department_id'] ?? null;
        $sql = 'SELECT p.*, c.name as class_name, s.name as subject_name FROM programs p JOIN classes c ON p.classe_id = c.id JOIN subjects s ON p.subject_id = s.id';
        $params = [];
        if ($deptFilter) {
            $sql .= ' WHERE c.department_id = :d';
            $params['d'] = $deptFilter;
        }
        $rows = Database::query($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($rows);
        return;
    }

    public function store()
    {
        $this->requireAuth();
        $this->requirePermission('manage_programs'); // only permitted roles can add programs
        $this->validateCsrf();
        $classe_id = $_POST['classe_id'] ?? null;
        $subject_id = $_POST['subject_id'] ?? null;
        $nbr_hours = intval($_POST['nbr_hours'] ?? 0);
        $nbr_lesson = intval($_POST['nbr_lesson'] ?? 0);
        $nbr_lesson_dig = intval($_POST['nbr_lesson_dig'] ?? 0);
        $nbr_tp = intval($_POST['nbr_tp'] ?? 0);
        $nbr_tp_dig = intval($_POST['nbr_tp_dig'] ?? 0);
        $errors = [];
        if (!$classe_id) $errors[] = 'La classe est requise.';
        if (!$subject_id) $errors[] = 'La matière est requise.';
        if (!empty($errors)) {
            set_flash('error', implode('; ', $errors));
            redirect('programs');
        }
        Database::query('INSERT INTO programs (classe_id, subject_id, nbr_hours, nbr_lesson, nbr_lesson_dig, nbr_tp, nbr_tp_dig) VALUES (:c, :s, :h, :l, :ld, :tp, :tpd)', ['c' => $classe_id, 's' => $subject_id, 'h' => $nbr_hours, 'l' => $nbr_lesson, 'ld' => $nbr_lesson_dig, 'tp' => $nbr_tp, 'tpd' => $nbr_tp_dig]);
        set_flash('success', 'Programme créé.');
        $returnTo = $_POST['return_to'] ?? 'programs';
        // If AJAX (X-Requested-With header), return JSON
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $id = Database::connect()->lastInsertId();
            $stmt = Database::query('SELECT c.name as class_name, s.name as subject_name FROM programs p JOIN classes c ON p.classe_id = c.id JOIN subjects s ON p.subject_id = s.id WHERE p.id = :id', ['id' => $id]);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'id' => $id, 'class_id' => $classe_id, 'subject_id' => $subject_id, 'class_name' => $row['class_name'] ?? '', 'subject_name' => $row['subject_name'] ?? '', 'nbr_hours' => intval($_POST['nbr_hours'] ?? 0), 'nbr_lesson' => intval($_POST['nbr_lesson'] ?? 0), 'nbr_lesson_dig' => intval($_POST['nbr_lesson_dig'] ?? 0), 'nbr_tp' => intval($_POST['nbr_tp'] ?? 0), 'nbr_tp_dig' => intval($_POST['nbr_tp_dig'] ?? 0)]);
            return;
        }
        redirect($returnTo);
    }

    public function edit()
    {
        $this->requireAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) redirect('programs');
        $stmt = Database::query('SELECT * FROM programs WHERE id = :id', ['id' => $id]);
        $program = $stmt->fetch(\PDO::FETCH_ASSOC);
        $classes = Database::query('SELECT id, name FROM classes')->fetchAll(\PDO::FETCH_ASSOC);
        $subjects = Database::query('SELECT id, name FROM subjects')->fetchAll(\PDO::FETCH_ASSOC);
        return $this->view('pages/programs/edit', ['program' => $program, 'classes' => $classes, 'subjects' => $subjects]);
    }

    public function update()
    {
        $this->requireAuth();
        $this->requirePermission('manage_programs');
        $this->validateCsrf();
        $id = $_POST['id'] ?? null;
        $classe_id = $_POST['classe_id'] ?? null;
        $subject_id = $_POST['subject_id'] ?? null;
        $nbr_hours = intval($_POST['nbr_hours'] ?? 0);
        $nbr_lesson = intval($_POST['nbr_lesson'] ?? 0);
        $nbr_lesson_dig = intval($_POST['nbr_lesson_dig'] ?? 0);
        $nbr_tp = intval($_POST['nbr_tp'] ?? 0);
        $nbr_tp_dig = intval($_POST['nbr_tp_dig'] ?? 0);
        if (!$id) redirect('programs');
        Database::query('UPDATE programs SET classe_id = :c, subject_id = :s, nbr_hours = :h, nbr_lesson = :l, nbr_lesson_dig = :ld, nbr_tp = :tp, nbr_tp_dig = :tpd WHERE id = :id', ['c' => $classe_id, 's' => $subject_id, 'h' => $nbr_hours, 'l' => $nbr_lesson, 'ld' => $nbr_lesson_dig, 'tp' => $nbr_tp, 'tpd' => $nbr_tp_dig, 'id' => $id]);
        set_flash('success', 'Programme mis à jour.');
        redirect('programs');
    }

    public function delete()
    {
        $this->requireAuth();
        $this->requirePermission('manage_programs');
        $this->validateCsrf();
        $id = $_POST['id'] ?? null;
        if (!$id) redirect('programs');
        Database::query('DELETE FROM programs WHERE id = :id', ['id' => $id]);
        set_flash('success', 'Programme supprimé.');
        redirect('programs');
    }
}
