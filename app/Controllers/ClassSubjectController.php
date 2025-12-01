<?php

namespace App\Controllers;

use App\Core\Database;

class ClassSubjectController extends Controller
{
    public function index()
    {
        $this->requireAuth();

        try {
            $classId = $_GET['id'] ?? null;
            if (!$classId) {
                set_flash('error', 'Classe non spécifiée.');
                redirect('classes');
            }

            $class = Database::query('SELECT * FROM classes WHERE id = :id', ['id' => $classId])
                ->fetch(\PDO::FETCH_ASSOC);
            if (!$class) {
                set_flash('error', 'Classe introuvable.');
                redirect('classes');
            }

            // die(print_r($class, true));

            $est = $_SESSION['establishment_id'] ?? null;

            $assigned = Database::query(
                'SELECT p.*, s.name as subject_name 
                 FROM programs p 
                 JOIN subjects s ON p.subject_id = s.id 
                 WHERE p.classe_id = :class',
                ['class' => $classId]
            )->fetchAll(\PDO::FETCH_ASSOC);

            $assignedIds = array_column($assigned, 'subject_id'); // récupère les IDs déjà assignés

            $placeholders = implode(',', array_fill(0, count($assignedIds), '?'));
            // die(print_r($placeholders, true));
            if (empty($assignedIds)) {
                $placeholders = '0'; // Pour éviter une erreur SQL si aucun sujet n'est assigné
            }
            $subjects = Database::query(
                "SELECT * FROM subjects WHERE establishment_id = ? AND id NOT IN ($placeholders)",
                array_merge([$est], $assignedIds)
            )->fetchAll(\PDO::FETCH_ASSOC);

            $subjects2 = Database::query(
                'SELECT * FROM subjects WHERE establishment_id = :est',
                ['est' => $est]
            )->fetchAll(\PDO::FETCH_ASSOC);



            return $this->view('pages/classes/subjects', [
                'class' => $class,
                'subjects' => $subjects,
                'subjects2' => $subjects2,
                'assigned' => $assigned
            ]);
        } catch (\Throwable $th) {
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
            (classe_id, subject_id, nbr_hours, nbr_lesson, nbr_tp, nbr_lesson_dig, nbr_tp_dig)
         VALUES 
            (:classe_id, :subject_id, :nbr_hours, :nbr_lesson, :nbr_tp, :nbr_lesson_dig, :nbr_tp_dig)',
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
