<?php

namespace App\Controllers;

use App\Core\Database;

class SchoolYearController extends Controller
{
    public function __construct()
    {
        // Only users with 'manage_school_years' permission can access SchoolYearController actions
        $this->requireAuth();
        $this->requirePermission('manage_school_years');
    }

    public function index()
    {
        $this->requireAuth();
        $stmt = Database::query('SELECT * FROM school_years ORDER BY start_date DESC');
        $years = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $roles = Database::query('SELECT * FROM roles')->fetchAll(\PDO::FETCH_ASSOC);
        return $this->view('pages/years/index', ['years' => $years, 'roles' => $roles]);
    }

    public function create()
    {
        $this->requireAuth();
        $this->requirePermission('manage_school_years');
        return $this->view('pages/years/create');
    }

    public function store()
    {
        $this->requireAuth();
        $this->requirePermission('manage_school_years');
        $this->validateCsrf();
        $title = $_POST['title'] ?? '';
        $start = $_POST['start_date'] ?? null;
        $end = $_POST['end_date'] ?? null;
        $errors = [];
        if (trim($title) === '') $errors[] = 'Le titre est requis.';
        if (empty($start)) $errors[] = "La date de début est requise.";
        if (empty($end)) $errors[] = "La date de fin est requise.";
        if (!empty($start) && !empty($end) && strtotime($start) > strtotime($end)) $errors[] = "La date de début doit être antérieure à la date de fin.";
        if (!empty($errors)) {
            return $this->view('pages/years/create', ['errors' => $errors, 'old' => $_POST]);
        }
        Database::query('INSERT INTO school_years (title, start_date, end_date) VALUES (:title, :s, :e)', ['title' => $title, 's' => $start, 'e' => $end]);
        set_flash('success', 'Année scolaire créée avec succès.');
        redirect('years');
    }

    public function edit()
    {
        $this->requireAuth();
        $this->requirePermission('manage_school_years');
        $id = $_GET['id'] ?? null;
        if (!$id) redirect('years');
        $stmt = Database::query('SELECT * FROM school_years WHERE id = :id', ['id' => $id]);
        $year = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$year) redirect('years');
        return $this->view('pages/years/edit', ['year' => $year]);
    }

    public function update()
    {
        $this->requireAuth();
        $this->requirePermission('manage_school_years');
        $this->validateCsrf();
        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $start = $_POST['start_date'] ?? null;
        $end = $_POST['end_date'] ?? null;
        $errors = [];
        if (!$id) redirect('years');
        if (trim($title) === '') $errors[] = 'Le titre est requis.';
        if (empty($start)) $errors[] = "La date de début est requise.";
        if (empty($end)) $errors[] = "La date de fin est requise.";
        if (!empty($start) && !empty($end) && strtotime($start) > strtotime($end)) $errors[] = "La date de début doit être antérieure à la date de fin.";
        if (!empty($errors)) {
            return $this->view('pages/years/edit', ['errors' => $errors, 'year' => ['id' => $id, 'title' => $title, 'start_date' => $start, 'end_date' => $end]]);
        }
        Database::query('UPDATE school_years SET title = :title, start_date = :s, end_date = :e WHERE id = :id', ['title' => $title, 's' => $start, 'e' => $end, 'id' => $id]);
        set_flash('success', 'Année scolaire mise à jour.');
        redirect('years');
    }

    public function delete()
    {
        $this->requireAuth();
        $this->requirePermission('manage_school_years');
        $this->validateCsrf();
        $id = $_POST['id'] ?? null;
        if (!$id) redirect('years');
        Database::query('DELETE FROM school_years WHERE id = :id', ['id' => $id]);
        set_flash('success', 'Année scolaire supprimée.');
        redirect('years');
    }
}
