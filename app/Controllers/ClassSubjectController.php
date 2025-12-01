<?php

namespace App\Controllers;

use App\Core\Database;

class ClassSubjectController extends Controller
{
    public function index()
    {
        $this->requireAuth();

        try {
            $classId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (!$classId) {
                set_flash('error', 'Classe non spécifiée.');
                redirect('classes');
            }

            // établissement actif dans la session
            $est = $_SESSION['establishment_id'] ?? null;
            if (! $est) {
                set_flash('error', "Aucun établissement actif.");
                redirect('dashboard');
            }

            // Vérifier que la classe existe et appartient à l'établissement
            $stmt = Database::query('SELECT * FROM classes WHERE id = :id AND establishment_id = :est LIMIT 1', [
                'id'  => $classId,
                'est' => $est,
            ]);
            $class = $stmt->fetch(\PDO::FETCH_ASSOC);
            if (! $class) {
                set_flash('error', 'Classe introuvable ou non autorisée pour cet établissement.');
                redirect('classes');
            }

            // Récupérer les programmes assignés (uniquement pour la même établissement et la classe donnée)
            $assignedStmt = Database::query(
                'SELECT p.*, s.name AS subject_name 
             FROM programs p
             JOIN subjects s ON p.subject_id = s.id
             WHERE p.classe_id = :class_id
               AND p.establishment_id = :est
               AND s.establishment_id = :est',
                [
                    'class_id' => $classId,
                    'est'      => $est,
                ]
            );
            $assigned = $assignedStmt->fetchAll(\PDO::FETCH_ASSOC);

            // Extraire les subject_id déjà assignés
            $assignedIds = array_column($assigned, 'subject_id');

            // Récupérer les subjects de l'établissement NON assignés à cette classe
            if (empty($assignedIds)) {
                // Aucun sujet assigné -> on prend tous les sujets de l'établissement
                $subjectsStmt = Database::query(
                    'SELECT * FROM subjects WHERE establishment_id = :est',
                    ['est' => $est]
                );
                $subjects = $subjectsStmt->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                // Construire des placeholders sécurisés pour les ids assignés
                $placeholders = implode(',', array_fill(0, count($assignedIds), '?'));
                // Préparer les paramètres : establishment_id en premier, puis les assignedIds pour le NOT IN
                $params = array_merge([$est], $assignedIds);

                $subjectsStmt = Database::query(
                    "SELECT * FROM subjects WHERE establishment_id = ? AND id NOT IN ($placeholders)",
                    $params
                );
                $subjects = $subjectsStmt->fetchAll(\PDO::FETCH_ASSOC);
            }

            // Pour affichage global (tous les sujets de l'établissement) si besoin
            $subjectsAllStmt = Database::query(
                'SELECT * FROM subjects WHERE establishment_id = :est',
                ['est' => $est]
            );
            $subjects2 = $subjectsAllStmt->fetchAll(\PDO::FETCH_ASSOC);

            return $this->view('pages/classes/subjects', [
                'class'     => $class,
                'subjects'  => $subjects,
                'subjects2' => $subjects2,
                'assigned'  => $assigned,
            ]);
        } catch (\Throwable $th) {
            // En dev vous pouvez logger $th->getMessage() puis rethrow ou afficher une page d'erreur
            throw $th;
        }
    }


    public function store()
    {
        $this->requireAuth();
        $this->requirePermission('manage_programs');
        $this->validateCsrf();

        $data = [
            'classe_id' => $_POST['classe_id'] ?? null,
            'subject_id' => $_POST['subject_id'] ?? null,
            'nbr_hours' => intval($_POST['nbr_hours'] ?? 0),
            'nbr_lesson' => intval($_POST['nbr_lesson'] ?? 0),
            'nbr_tp' => intval($_POST['nbr_tp'] ?? 0),
            'nbr_lesson_dig' => intval($_POST['nbr_lesson_dig'] ?? 0),
            'nbr_tp_dig' => intval($_POST['nbr_tp_dig'] ?? 0),
            'establishment_id' => $_SESSION['establishment_id'] ?? null,
        ];

        // Champs obligatoires
        if (!$data['classe_id'] || !$data['subject_id']) {
            set_flash('error', 'Paramètres manquants.');
            redirect('classes/programs?id=' . $data['classe_id']);
        }

        // Vérifie doublon
        $stmt = Database::query(
            'SELECT id FROM programs WHERE classe_id = :classe_id AND subject_id = :subject_id',
            [
                'classe_id' => $data['classe_id'],
                'subject_id' => $data['subject_id']
            ]
        );

        if ($stmt->fetch()) {
            set_flash('error', 'Programme déjà existant.');
            redirect('classes/programs?id=' . $data['classe_id']);
        }

        // Ajout du programme
        // If user has establishment scope (censeur) restrict to the same establishment
        if ($this->hasPermission('view_establishment') && ! $this->hasPermission('manage_roles')) {
            $est = $_SESSION['establishment_id'] ?? null;
            $stmt = Database::query('SELECT id FROM classes WHERE id = :id AND establishment_id = :est', ['id' => $data['classe_id'], 'est' => $est]);
            if (!$stmt->fetch()) {
                set_flash('error', 'Classe non autorisée.');
                redirect('classes');
            }
        }
        Database::query(
            'INSERT INTO programs 
            (classe_id, subject_id, nbr_hours, nbr_lesson, nbr_tp, nbr_lesson_dig, nbr_tp_dig, establishment_id)
         VALUES 
            (:classe_id, :subject_id, :nbr_hours, :nbr_lesson, :nbr_tp, :nbr_lesson_dig, :nbr_tp_dig, :establishment_id)',
            $data
        );

        set_flash('success', 'Programme ajouté avec succès.');
        redirect('classes/programs?id=' . $data['classe_id']);
    }


    public function update()
    {
        $this->requireAuth();
        $this->requirePermission('manage_programs');
        $this->validateCsrf();

        $data = [
            'id'              => $_POST['id'] ?? null,
            'classe_id'       => $_POST['classe_id'] ?? null,
            'nbr_hours'       => intval($_POST['nbr_hours'] ?? 0),
            'nbr_lesson'      => intval($_POST['nbr_lesson'] ?? 0),
            'nbr_tp'          => intval($_POST['nbr_tp'] ?? 0),
            'nbr_lesson_dig'  => intval($_POST['nbr_lesson_dig'] ?? 0),
            'nbr_tp_dig'      => intval($_POST['nbr_tp_dig'] ?? 0),
        ];

        if (!$data['id'] || !$data['classe_id']) {
            set_flash('error', 'Paramètres manquants.');
            redirect('classes/programs?id=' . $data['classe_id']);
        }

        Database::query(
            'UPDATE programs 
         SET 
            nbr_hours = :nbr_hours, 
            nbr_lesson = :nbr_lesson, 
            nbr_tp = :nbr_tp,
            nbr_lesson_dig = :nbr_lesson_dig,
            nbr_tp_dig = :nbr_tp_dig
         WHERE id = :id AND classe_id = :classe_id',
            $data
        );

        set_flash('success', 'Programme mis à jour.');
        redirect('classes/programs?id=' . $data['classe_id']);
    }


    public function delete()
    {
        $this->requireAuth();
        $this->requirePermission('manage_programs');
        $this->validateCsrf();

        $id = $_POST['id'] ?? null;
        $classeId = $_POST['classe_id'] ?? null;
        if (!$id) {
            set_flash('error', 'Paramètres manquants.');
            redirect('classes/programs?id=' . $classeId);
        }

        Database::query('DELETE FROM programs WHERE id = :id AND classe_id = :classe', [
            'id' => $id,
            'classe' => $classeId
        ]);

        set_flash('success', 'Programme supprimé.');
        redirect('classes/programs?id=' . $classeId);
    }
}
