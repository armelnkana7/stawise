<?php

namespace App\Controllers;

use App\Core\Database;

class DepartmentController extends Controller
{
    public function __construct()
    {
        // Only users with 'manage_departments' permission can access DepartmentController actions
        $this->requireAuth();
        $this->requirePermission('manage_departments');
    }
    public function index()
    {
        $this->requireAuth();

        // Charger les départements + nom établissement
        $depts = Database::query(
            "SELECT * FROM departments WHERE establishment_id = :est",
            ['est' => $_SESSION['establishment_id']]
        )->fetchAll(\PDO::FETCH_ASSOC);

        // Charger la liste des établissements pour le modal Edit
        $ests = Database::query('SELECT id, name FROM establishments')->fetchAll(\PDO::FETCH_ASSOC);
        // Charger les matières pour l'établissement en session
        $estSession = $_SESSION['establishment_id'] ?? null;
        $subjects = Database::query('SELECT id, name, department_id FROM subjects WHERE establishment_id = :est', ['est' => $estSession])->fetchAll(\PDO::FETCH_ASSOC);

        $subjects_unassigned = Database::query('SELECT id, name, department_id FROM subjects WHERE department_id IS NULL')->fetchAll(\PDO::FETCH_ASSOC);

        return $this->view('pages/departments/index', [
            'depts' => $depts,
            'ests' => $ests,
            'subjects' => $subjects,
            'subjects_unassigned' => $subjects_unassigned
        ]);
    }

    public function create()
    {
        $this->requireAuth();
        $ests = Database::query('SELECT id, name FROM establishments')->fetchAll(\PDO::FETCH_ASSOC);
        $subjs = Database::query('SELECT id, name FROM subjects')->fetchAll(\PDO::FETCH_ASSOC);
        return $this->view('pages/departments/create', ['ests' => $ests, 'subjects' => $subjs]);
    }

    public function store()
    {
        $this->requireAuth();
        $this->requirePermission('manage_departments');
        $this->validateCsrf();

        $name = $_POST['name'] ?? '';
        $code = $_POST['code'] ?? null;
        $est = $_POST['establishment_id'] ?? null;

        // If session user has limited establishment scope, force the establishment
        if ($this->hasPermission('view_establishment') && ! $this->hasPermission('manage_roles')) {
            $est = $_SESSION['establishment_id'] ?? $est;
        }

        Database::query(
            'INSERT INTO departments (establishment_id, name, code) 
             VALUES (:est, :name, :code)',
            [
                'est' => $est,
                'name' => $name,
                'code' => $code
            ]
        );

        set_flash('success', 'Département créé avec succès.');
        // lier matières sélectionnées au département
        $newDeptId = Database::connect()->lastInsertId();
        if (!empty($_POST['subject_ids']) && is_array($_POST['subject_ids'])) {
            $ids = array_map('intval', $_POST['subject_ids']);
            // Assign selected subjects using named placeholders
            $placeholders = [];
            $params = ['dept' => $newDeptId];
            foreach ($ids as $i => $sid) {
                $k = 'id' . $i;
                $placeholders[] = ':' . $k;
                $params[$k] = $sid;
            }
            Database::query('UPDATE subjects SET department_id = :dept WHERE id IN (' . implode(',', $placeholders) . ')', $params);
        }
        redirect('departments');
    }

    public function update()
    {
        $this->requireAuth();
        $this->requirePermission('manage_departments');
        $this->validateCsrf();

        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $code = $_POST['code'] ?? null;
        $est = $_POST['establishment_id'] ?? null;

        if (!$id) {
            set_flash('error', 'Requête invalide.');
            redirect('departments');
        }

        if ($this->hasPermission('view_establishment') && ! $this->hasPermission('manage_roles')) {
            $est = $_SESSION['establishment_id'] ?? $est;
        }

        Database::query(
            'UPDATE departments SET 
                name = :name,
                code = :code,
                establishment_id = :est
             WHERE id = :id',
            [
                'name' => $name,
                'code' => $code,
                'est' => $est,
                'id' => $id
            ]
        );

        set_flash('success', 'Département modifié avec succès.');
        // Update subject assignments
        if (!empty($_POST['subject_ids']) && is_array($_POST['subject_ids'])) {
            $ids = array_map('intval', $_POST['subject_ids']);
            // Assign selected subjects to this department
            $params = ['dept' => $id];
            $placeholders = [];
            foreach ($ids as $i => $sid) {
                $k = 'id' . $i;
                $placeholders[] = ':' . $k;
                $params[$k] = $sid;
            }
            Database::query('UPDATE subjects SET department_id = :dept WHERE id IN (' . implode(',', $placeholders) . ')', $params);
            // Unassign subjects previously linked to this dept but not in the selection
            $params2 = ['dept' => $id];
            foreach ($ids as $i => $sid) {
                $params2['id' . $i] = $sid;
            }
            Database::query('UPDATE subjects SET department_id = NULL WHERE department_id = :dept AND id NOT IN (' . implode(',', $placeholders) . ')', $params2);
        } else {
            // No subjects selected -> unset all links for this department
            Database::query('UPDATE subjects SET department_id = NULL WHERE department_id = :dept', ['dept' => $id]);
        }
        redirect('departments');
    }

    public function delete()
    {
        $this->requireAuth();
        $this->requirePermission('manage_departments');
        $this->validateCsrf();

        $id = $_POST['id'] ?? null;

        if (!$id) {
            set_flash('error', 'Requête invalide.');
            redirect('departments');
        }

        // Met la date actuelle
        $now = date('Y-m-d H:i:s');

        Database::query(
            'DELETE FROM departments WHERE id = :id',
            [
                'id' => $id
            ]
        );

        set_flash('success', 'Département supprimé avec succès.');
        redirect('departments');
    }
}
