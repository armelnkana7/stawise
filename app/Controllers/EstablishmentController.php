<?php

namespace App\Controllers;

use App\Models\User;
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
        // Auth & permissions (vous avez déjà ces helpers)
        $this->requireAuth();
        $this->requirePermission('switch_establishment');
        $this->validateCsrf();

        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Récupérer et valider l'ID (utilisation de filter_input pour sécurité)
        $id = filter_input(INPUT_POST, 'establishment_id', FILTER_VALIDATE_INT);
        if (! $id) {
            set_flash('error', 'Identifiant d\'établissement manquant ou invalide.');
            return redirect('dashboard');
        }

        // Vérifier l'existence de l'établissement (préparé)
        $stmt = Database::query('SELECT id FROM establishments WHERE id = :id LIMIT 1', ['id' => $id]);
        $found = $stmt->fetch();
        if (! $found) {
            set_flash('error', 'Établissement invalide.');
            return redirect('dashboard');
        }

        // Changer l'établissement actif dans la session
        // (int cast pour sécurité)
        $_SESSION['establishment_id'] = (int) $id;


        $sql = 'UPDATE users SET establishment_id = :establishment_id WHERE email = :email';
        $stmt = Database::query($sql, [
            'email' => $_SESSION['email'],
            'establishment_id' => $_SESSION['establishment_id']
        ]);


        // (Optionnel mais recommandé) régénérer l'id de session pour éviter fixation
        // Note: regenération uniquement si PHP >= 5.1.0 (présent partout maintenant)
        session_regenerate_id(true);

        // S'assurer que PHP écrit la session avant le redirect
        session_write_close();

        // message de confirmation puis redirection vers la page précédente ou dashboard
        set_flash('success', 'Établissement actif changé.');

        $back = $_SERVER['HTTP_REFERER'] ?? url('dashboard');
        header('Location: ' . $back);
        exit;
    }
}
