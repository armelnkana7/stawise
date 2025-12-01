<?php

namespace App\Controllers;

use App\Core\Database;

class EstablishmentController extends Controller
{
    public function __construct()
    {
        // Only users with 'manage_establishments' permission can access EstablishmentController actions
        $this->requireAuth();
        $this->requirePermission('manage_establishments');
    }
    public function index()
    {
        $this->requireAuth();
        $stmt = Database::query('SELECT * FROM establishments ORDER BY id DESC');
        $est = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->view('pages/establishments/index', ['establishments' => $est]);
    }

    public function create()
    {
        $this->requireAuth();
        return $this->view('pages/establishments/create');
    }

    public function store()
    {
        $this->requireAuth();
        $this->requirePermission('manage_establishments');
        $this->validateCsrf();
        $name = $_POST['name'] ?? '';
        if (trim($name) === '') {
            return $this->view('pages/establishments/create', ['errors' => ['Le nom est requis.'], 'old' => $_POST]);
        }
        Database::query('INSERT INTO establishments (name) VALUES (:name)', ['name' => $name]);
        set_flash('success', 'Etablissement créé.');
        redirect('establishments');
    }

    public function edit()
    {
        $this->requireAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) redirect('establishments');
        $stmt = Database::query('SELECT * FROM establishments WHERE id = :id', ['id' => $id]);
        $est = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$est) redirect('establishments');
        return $this->view('pages/establishments/edit', ['est' => $est]);
    }

    public function update()
    {
        $this->requireAuth();
        $this->requirePermission('manage_establishments');
        $this->validateCsrf();
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        if (!$id) redirect('establishments');
        if (trim($name) === '') {
            return $this->view('pages/establishments/edit', ['errors' => ['Le nom est requis.'], 'est' => ['id' => $id, 'name' => $name]]);
        }
        Database::query('UPDATE establishments SET name = :n WHERE id = :id', ['n' => $name, 'id' => $id]);
        set_flash('success', 'Etablissement mis à jour.');
        redirect('establishments');
    }

    public function delete()
    {
        $this->requireAuth();
        $this->requirePermission('manage_establishments');
        $this->validateCsrf();
        $id = $_POST['id'] ?? null;
        if (!$id) redirect('establishments');
        Database::query('DELETE FROM establishments WHERE id = :id', ['id' => $id]);
        set_flash('success', 'Etablissement supprimé.');
        redirect('establishments');
    }

    /**
     * Switch the active establishment in the session.
     * Only allowed for users with switch_establishment permission (superadmin)
     */
    public function switch()
    {
        $this->requireAuth();
        $this->requirePermission('switch_establishment');
        $this->validateCsrf();
        $id = $_POST['establishment_id'] ?? null;
        if (!$id) {
            redirect('dashboard');
        }
        // validate existence
        $stmt = Database::query('SELECT id FROM establishments WHERE id = :id', ['id' => $id]);
        if (!$stmt->fetch()) {
            set_flash('error', 'Etablissement invalide.');
            redirect('dashboard');
        }
        $_SESSION['establishment_id'] = (int)$id;
        set_flash('success', 'Etablissement actif changé.');
        // back to referring page
        $back = $_SERVER['HTTP_REFERER'] ?? url('dashboard');
        header('Location: ' . $back);
        exit;
    }
}
