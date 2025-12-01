<?php

namespace App\Controllers;

use App\Core\Database;

class ClassController extends Controller
{
    public function __construct()
    {
        // Only users with 'manage_classes' permission can access ClassController actions
        $this->requireAuth();
        $this->requirePermission('manage_classes');
    }

    public function index()
    {
        $this->requireAuth();

        $establishmentId = $_SESSION['establishment_id'] ?? null;

        if (!$establishmentId) {
            set_flash('error', 'Aucun établissement sélectionné.');
            redirect('dashboard');
        }

        // Pas d'alias "c", donc on enlève le préfixe
        $sql = 'SELECT * FROM classes WHERE establishment_id = :est';

        $stmt = Database::query($sql, ['est' => $establishmentId]);
        $classes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // die(print_r($classes, true));
        return $this->view('pages/classes/index', [
            'classes' => $classes
        ]);
    }

    public function create()
    {
        $this->requireAuth();
        $depts = Database::query('SELECT id, name FROM departments')->fetchAll(\PDO::FETCH_ASSOC);
        $ests = Database::query('SELECT id, name FROM establishments')->fetchAll(\PDO::FETCH_ASSOC);
        return $this->view('pages/classes/create', ['depts' => $depts, 'ests' => $ests]);
    }

    public function store()
    {
        $this->requireAuth();
        $this->requirePermission('manage_classes');
        $this->validateCsrf();
        $name = $_POST['name'] ?? '';
        $est = $_SESSION['establishment_id'] ?? null;
        $code = $_POST['code'] ?? null;
        $section = $_POST['section'] ?? null;
        // If user has establishment scope, ensure classes are created for the session's establishment
        if ($this->hasPermission('view_establishment') && ! $this->hasPermission('manage_roles')) {
            $est = $_SESSION['establishment_id'] ?? $est;
        }
        Database::query('INSERT INTO classes (establishment_id, code, section, name) VALUES (:est, :code, :section, :name)', ['est' => $est, 'code' => $code, 'section' => $section, 'name' => $name]);
        redirect('classes');
    }

    public function update()
    {
        $this->requireAuth();
        $this->requirePermission('manage_classes');
        $this->validateCsrf();

        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $code = $_POST['code'] ?? '';
        $section = $_POST['section'] ?? null;

        $establishmentId = $_SESSION['establishment_id'] ?? null;

        if (!$id || !$establishmentId) {
            set_flash('error', 'Requête invalide.');
            redirect('classes');
        }

        // Vérifier que la classe appartient bien à l'établissement connecté
        $class = Database::query(
            'SELECT id FROM classes WHERE id = :id AND establishment_id = :est',
            ['id' => $id, 'est' => $establishmentId]
        )->fetch();

        if (!$class) {
            set_flash('error', 'Classe introuvable ou non autorisée.');
            redirect('classes');
        }

        // Mise à jour
        Database::query(
            'UPDATE classes SET name = :name, code = :code, section = :section WHERE id = :id',
            [
                'name' => $name,
                'code' => $code,
                'section' => $section,
                'id' => $id
            ]
        );

        set_flash('success', 'Classe mise à jour avec succès.');
        redirect('classes');
    }

    public function delete()
    {
        $this->requireAuth();
        $this->requirePermission('manage_classes');
        $this->validateCsrf();

        $id = $_POST['id'] ?? null;
        $establishmentId = $_SESSION['establishment_id'] ?? null;

        if (!$id || !$establishmentId) {
            set_flash('error', 'Requête invalide.');
            redirect('classes');
        }

        $class = Database::query(
            'SELECT id FROM classes WHERE id = :id AND establishment_id = :est',
            ['id' => $id, 'est' => $establishmentId]
        )->fetch();

        if (!$class) {
            set_flash('error', 'Classe introuvable ou non autorisée.');
            redirect('classes');
        }

        Database::query('DELETE FROM classes WHERE id = :id', ['id' => $id]);

        set_flash('success', 'Classe supprimée avec succès.');
        redirect('classes');
    }
}
