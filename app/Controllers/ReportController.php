<?php

namespace App\Controllers;

use App\Core\Database;

class ReportController extends Controller
{
    public function __construct()
    {
        // Require authentication for all ReportController actions
        $this->requireAuth();
    }
    public function index()
    {
        $this->requireAuth();
        $q = $_GET['q'] ?? null;

        // Charger les rapports avec les infos liées
        $sql = 'SELECT r.*, p.classe_id, p.subject_id, p.nbr_hours, p.nbr_lesson, p.nbr_lesson_dig, p.nbr_tp, p.nbr_tp_dig, 
                   c.name as class_name, s.name as subject_name, u.full_name as recorded_by 
            FROM weekly_coverage_reports r 
            LEFT JOIN programs p ON r.program_id = p.id 
            LEFT JOIN classes c ON p.classe_id = c.id 
            LEFT JOIN subjects s ON p.subject_id = s.id 
            LEFT JOIN users u ON r.recorded_by_user_id = u.id';
        $params = [];
        // Apply role-based filters
        $where = [];
        if ($q) {
            $where[] = '(c.name LIKE :q OR s.name LIKE :q OR u.full_name LIKE :q)';
            $params['q'] = "%$q%";
        }
        // If user can view all reports, no extra filter
        if ($this->hasPermission('view_all_reports')) {
            // no filter
        } elseif ($this->hasPermission('view_establishment')) {
            $eid = $_SESSION['establishment_id'] ?? null;
            if ($eid) {
                $where[] = 'c.establishment_id = :est';
                $params['est'] = $eid;
            }
        } elseif ($this->hasPermission('view_department_reports')) {
            $did = $_SESSION['department_id'] ?? null;
            if ($did) {
                $where[] = '(c.department_id = :d OR s.department_id = :d)';
                $params['d'] = $did;
            }
        } else {
            // default: show only reports recorded by current user
            $uid = $_SESSION['user_id'] ?? null;
            if ($uid) {
                $where[] = 'r.recorded_by_user_id = :uid';
                $params['uid'] = $uid;
            }
        }

        if (count($where) > 0) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' ORDER BY r.created_at DESC';
        $reports = Database::query($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);

        // Charger les programmes pour les modals (édition / création)
        $programs = Database::query(
            'SELECT p.*, c.name AS class_name, s.name AS subject_name 
         FROM programs p 
         JOIN classes c ON p.classe_id = c.id 
         JOIN subjects s ON p.subject_id = s.id
         ORDER BY c.name, s.name'
        )->fetchAll(\PDO::FETCH_ASSOC);

        return $this->view('pages/reports/index', [
            'reports' => $reports,
            'programs' => $programs
        ]);
    }

    public function create()
    {
        $this->requireAuth();
        if (!($this->hasPermission('record_reports') || $this->hasPermission('manage_reports'))) {
            die('403 Forbidden - insufficient permissions to create reports.');
        }
        // Programs available for report should be filtered by role scope
        $sql = 'SELECT p.*, c.name as class_name, s.name as subject_name FROM programs p JOIN classes c ON p.classe_id = c.id JOIN subjects s ON p.subject_id = s.id';
        $params = [];
        // chef_departement: show only programs for department; censeur: show establishment programs; superadmin: all
        if ($this->hasPermission('view_department_reports')) {
            $d = $_SESSION['department_id'] ?? null;
            if ($d) {
                $sql .= ' WHERE c.department_id = :d';
                $params['d'] = $d;
            }
        } elseif ($this->hasPermission('view_establishment')) {
            $e = $_SESSION['establishment_id'] ?? null;
            if ($e) {
                $sql .= ' WHERE c.establishment_id = :e';
                $params['e'] = $e;
            }
        }
        $programs = Database::query($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);
        return $this->view('pages/reports/create', ['programs' => $programs]);
    }

    public function store()
    {
        $this->requireAuth();
        if (!($this->hasPermission('record_reports') || $this->hasPermission('manage_reports'))) {
            die('403 Forbidden - insufficient permissions to create reports.');
        }
        $this->validateCsrf();

        $program_id = $_POST['program_id'] ?? null;
        $nbr_hours_do = max(0, intval($_POST['nbr_hours_do'] ?? 0));
        $nbr_lesson_do = max(0, intval($_POST['nbr_lesson_do'] ?? 0));
        $nbr_lesson_dig_do = max(0, intval($_POST['nbr_lesson_dig_do'] ?? 0));
        $nbr_tp_do = max(0, intval($_POST['nbr_tp_do'] ?? 0));
        $nbr_tp_dig_do = max(0, intval($_POST['nbr_tp_dig_do'] ?? 0));
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$program_id) {
            set_flash('error', 'Programme non sélectionné.');
            redirect('reports/create');
        }

        $stmt = Database::query('SELECT id FROM programs WHERE id = :id', ['id' => $program_id]);
        $exists = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$exists) {
            set_flash('error', 'Programme invalide.');
            redirect('reports/create');
        }

        Database::query('INSERT INTO weekly_coverage_reports (program_id, recorded_by_user_id, nbr_hours_do, nbr_lesson_do, nbr_lesson_dig_do, nbr_tp_do, nbr_tp_dig_do) VALUES (:p, :u, :h, :l, :ld, :tp, :tpd)', ['p' => $program_id, 'u' => $user_id, 'h' => $nbr_hours_do, 'l' => $nbr_lesson_do, 'ld' => $nbr_lesson_dig_do, 'tp' => $nbr_tp_do, 'tpd' => $nbr_tp_dig_do]);

        redirect('reports');
    }

    public function edit()
    {
        $this->requireAuth();
        $id = $_GET['id'] ?? null;
        if (!$id)
            redirect('reports');
        $stmt = Database::query('SELECT r.*, p.classe_id, p.subject_id, r.recorded_by_user_id FROM weekly_coverage_reports r JOIN programs p ON r.program_id = p.id WHERE r.id = :id', ['id' => $id]);
        $report = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$report)
            redirect('reports');
        // Only allow edit for users with manage_reports permission or the original author
        $uid = $_SESSION['user_id'] ?? null;
        if (!$this->hasPermission('manage_reports') && ($uid != $report['recorded_by_user_id'])) {
            die('403 Forbidden - insufficient permissions to edit this report.');
        }
        // We will return a view showing edit modal content
        $programs = Database::query('SELECT p.*, c.name as class_name, s.name as subject_name FROM programs p JOIN classes c ON p.classe_id = c.id JOIN subjects s ON p.subject_id = s.id')->fetchAll(\PDO::FETCH_ASSOC);
        return $this->view('pages/reports/edit', ['report' => $report, 'programs' => $programs]);
    }

    public function update()
    {
        $this->requireAuth();
        $this->requirePermission('manage_reports');
        $this->validateCsrf();
        $id = $_POST['id'] ?? null;
        $program_id = $_POST['program_id'] ?? null;
        $nbr_hours_do = intval($_POST['nbr_hours_do'] ?? 0);
        $nbr_lesson_do = intval($_POST['nbr_lesson_do'] ?? 0);
        $nbr_lesson_dig_do = intval($_POST['nbr_lesson_dig_do'] ?? 0);
        $nbr_tp_do = intval($_POST['nbr_tp_do'] ?? 0);
        $nbr_tp_dig_do = intval($_POST['nbr_tp_dig_do'] ?? 0);
        if (!$id)
            redirect('reports');
        Database::query('UPDATE weekly_coverage_reports SET program_id = :p, nbr_hours_do = :h, nbr_lesson_do = :l, nbr_lesson_dig_do = :ld, nbr_tp_do = :tp, nbr_tp_dig_do = :tpd WHERE id = :id', ['p' => $program_id, 'h' => $nbr_hours_do, 'l' => $nbr_lesson_do, 'ld' => $nbr_lesson_dig_do, 'tp' => $nbr_tp_do, 'tpd' => $nbr_tp_dig_do, 'id' => $id]);
        set_flash('success', 'Rapport mis à jour.');
        redirect('reports');
    }

    public function delete()
    {
        $this->requireAuth();
        $this->requirePermission('manage_reports');
        $this->validateCsrf();
        $id = $_POST['id'] ?? null;
        if (!$id)
            redirect('reports');
        Database::query('DELETE FROM weekly_coverage_reports WHERE id = :id', ['id' => $id]);
        set_flash('success', 'Rapport supprimé.');
        redirect('reports');
    }

    public function export()
    {
        $this->requireAuth();
        $q = $_GET['q'] ?? null;
        $base = 'SELECT r.*, p.classe_id, p.subject_id, p.nbr_hours, p.nbr_lesson, p.nbr_lesson_dig, p.nbr_tp, p.nbr_tp_dig, c.name as class_name, s.name as subject_name, u.full_name as recorded_by FROM weekly_coverage_reports r LEFT JOIN programs p ON r.program_id = p.id LEFT JOIN classes c ON p.classe_id = c.id LEFT JOIN subjects s ON p.subject_id = s.id LEFT JOIN users u ON r.recorded_by_user_id = u.id';
        $params = [];
        $where = [];
        if ($q) {
            $where[] = '(c.name LIKE :q OR s.name LIKE :q OR u.full_name LIKE :q)';
            $params['q'] = "%$q%";
        }
        if ($this->hasPermission('view_all_reports')) {
            // nothing
        } elseif ($this->hasPermission('view_establishment')) {
            $eid = $_SESSION['establishment_id'] ?? null;
            if ($eid) {
                $where[] = 'c.establishment_id = :est';
                $params['est'] = $eid;
            }
        } elseif ($this->hasPermission('view_department_reports')) {
            $did = $_SESSION['department_id'] ?? null;
            if ($did) {
                $where[] = '(c.department_id = :d OR s.department_id = :d)';
                $params['d'] = $did;
            }
        } else {
            $uid = $_SESSION['user_id'] ?? null;
            if ($uid) {
                $where[] = 'r.recorded_by_user_id = :uid';
                $params['uid'] = $uid;
            }
        }
        if (count($where)) {
            $base .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql = $base . ' ORDER BY r.created_at DESC';
        $stmt = Database::query($sql, $params);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="reports.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID', 'classe', 'subject', 'created_at', 'planned_hours', 'hours_done', 'lessons_planned', 'lessons_done', 'lessons_dig_planned', 'lessons_dig_done', 'tp_planned', 'tp_done', 'tp_dig_done', 'recorded_by']);
        foreach ($rows as $r) {
            fputcsv($out, [$r['id'], $r['class_name'], $r['subject_name'], $r['created_at'], $r['nbr_hours'], $r['nbr_hours_do'], $r['nbr_lesson'], $r['nbr_lesson_do'], $r['nbr_lesson_dig'], $r['nbr_lesson_dig_do'], $r['nbr_tp'], $r['nbr_tp_do'], $r['nbr_tp_dig_do'], $r['recorded_by']]);
        }
        fclose($out);
        exit;
    }
}
