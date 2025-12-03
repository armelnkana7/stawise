<?php

namespace App\Controllers;

use App\Core\Database;
use Dompdf\Dompdf;

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

        // Recherche sécurisée
        $q = $_GET['q'] ?? null;
        $qParam = $q ? "%{$q}%" : null;

        // Récupération establishment & user depuis la session
        $est = isset($_SESSION['establishment_id']) ? (int) $_SESSION['establishment_id'] : null;
        $uid = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
        $did = isset($_SESSION['department_id']) ? (int) $_SESSION['department_id'] : null;

        // Requête de base pour les rapports
        $sql = 'SELECT r.*, p.classe_id, p.subject_id, p.nbr_hours, p.nbr_lesson, p.nbr_lesson_dig, p.nbr_tp, p.nbr_tp_dig, 
                   c.name AS class_name, s.name AS subject_name, u.full_name AS recorded_by
            FROM weekly_coverage_reports r
            LEFT JOIN programs p ON r.program_id = p.id
            LEFT JOIN classes c ON p.classe_id = c.id
            LEFT JOIN subjects s ON p.subject_id = s.id
            LEFT JOIN users u ON r.recorded_by_user_id = u.id';

        $where = [];
        $params = [];

        // Search clause
        if ($qParam) {
            $where[] = '(c.name LIKE :q OR s.name LIKE :q OR u.full_name LIKE :q)';
            $params['q'] = $qParam;
        }

        // Role-based and establishment filtering
        if ($this->hasPermission('view_all_reports')) {
            // No global establishment filter

            // If user cannot view all reports, restrict at least to their establishment (if available)
            if ($est) {
                $where[] = 'r.establishment_id = :est';
                $params['est'] = $est;
            }

            if ($this->hasPermission('view_establishment')) {
                // Already restricted by r.establishment_id above
                // Nothing extra needed here
            } elseif ($this->hasPermission('view_department_reports')) {
                if ($did) {
                    // limit to department for class or subject
                    $where[] = '(c.department_id = :d OR s.department_id = :d)';
                    $params['d'] = $did;
                }
            } else {
                // default: only reports recorded by current user
                if ($uid) {
                    $where[] = 'r.recorded_by_user_id = :uid';
                    $params['uid'] = $uid;
                }
            }
        }

        if ($this->hasPermission('view_department_reports')) {
            if ($did) {
                // limit to department for class or subject
                $where[] = '(c.department_id = :d OR s.department_id = :d)';
                $params['d'] = $did;
            }
        }

        if (count($where) > 0) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $sql .= ' ORDER BY r.created_at DESC';

        $reports = Database::query($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);

        // Charger les programmes pour les modals (édition / création)
        // On filtre les programmes par establishment si l'utilisateur n'a pas view_all_reports
        $programParams = [];
        $programSql = '
        SELECT p.*, c.name AS class_name, s.name AS subject_name
        FROM programs p
        JOIN classes c ON p.classe_id = c.id
        JOIN subjects s ON p.subject_id = s.id
    ';

        $departments = Database::query(
            "SELECT id, name FROM departments WHERE establishment_id = :est",
            ['est' => $_SESSION['establishment_id']]
        )->fetchAll(\PDO::FETCH_ASSOC);
        // If user cannot view all reports, only give programs belonging to the same establishment

        $programSql .= ' WHERE p.establishment_id = :p_est AND c.establishment_id = :p_est AND s.establishment_id = :p_est';

        if ($this->hasPermission('view_department_reports')) {
            if ($did) {
                $programSql .= ' AND (c.department_id = :pd OR s.department_id = :pd)';
                $programParams['pd'] = $did;

                $departments = Database::query(
                    "SELECT id, name FROM departments WHERE establishment_id = :est AND id = :pd",
                    ['est' => $_SESSION['establishment_id'], 'pd' => $did]
                )->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
        $programParams['p_est'] = $est;

        $programSql .= ' ORDER BY c.name, s.name';

        $programs = Database::query($programSql, $programParams)->fetchAll(\PDO::FETCH_ASSOC);



        return $this->view('pages/reports/index', [
            'reports' => $reports,
            'programs' => $programs,
            'departments' => $departments,
        ]);
    }

    public function consult()
    {
        $this->requireAuth();

        // Recherche sécurisée
        $q = $_GET['q'] ?? null;
        $qParam = $q ? "%{$q}%" : null;

        // Récupération establishment & user depuis la session
        $est = isset($_SESSION['establishment_id']) ? (int) $_SESSION['establishment_id'] : null;
        $uid = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
        $did = isset($_SESSION['department_id']) ? (int) $_SESSION['department_id'] : null;

        // Requête de base pour les rapports
        $sql = 'SELECT r.*, p.classe_id, p.subject_id, p.nbr_hours, p.nbr_lesson, p.nbr_lesson_dig, p.nbr_tp, p.nbr_tp_dig, 
                   c.name AS class_name, s.name AS subject_name, u.full_name AS recorded_by
            FROM weekly_coverage_reports r
            LEFT JOIN programs p ON r.program_id = p.id
            LEFT JOIN classes c ON p.classe_id = c.id
            LEFT JOIN subjects s ON p.subject_id = s.id
            LEFT JOIN users u ON r.recorded_by_user_id = u.id';

        $where = [];
        $params = [];

        // Search clause
        if ($qParam) {
            $where[] = '(c.name LIKE :q OR s.name LIKE :q OR u.full_name LIKE :q)';
            $params['q'] = $qParam;
        }

        // Role-based and establishment filtering
        if ($this->hasPermission('view_all_reports')) {
            // No global establishment filter

            // If user cannot view all reports, restrict at least to their establishment (if available)
            if ($est) {
                $where[] = 'r.establishment_id = :est';
                $params['est'] = $est;
            }

            if ($this->hasPermission('view_establishment')) {
                // Already restricted by r.establishment_id above
                // Nothing extra needed here
            } elseif ($this->hasPermission('view_department_reports')) {
                if ($did) {
                    // limit to department for class or subject
                    $where[] = '(c.department_id = :d OR s.department_id = :d)';
                    $params['d'] = $did;
                }
            } else {
                // default: only reports recorded by current user
                if ($uid) {
                    $where[] = 'r.recorded_by_user_id = :uid';
                    $params['uid'] = $uid;
                }
            }
        }

        if ($this->hasPermission('view_department_reports')) {
            if ($did) {
                // limit to department for class or subject
                $where[] = '(c.department_id = :d OR s.department_id = :d)';
                $params['d'] = $did;
            }
        }

        if (count($where) > 0) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $sql .= ' ORDER BY r.created_at DESC';

        $reports = Database::query($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);

        // Charger les programmes pour les modals (édition / création)
        // On filtre les programmes par establishment si l'utilisateur n'a pas view_all_reports
        $programParams = [];
        $programSql = '
        SELECT p.*, c.name AS class_name, s.name AS subject_name
        FROM programs p
        JOIN classes c ON p.classe_id = c.id
        JOIN subjects s ON p.subject_id = s.id
    ';

        $departments = Database::query(
            "SELECT id, name FROM departments WHERE establishment_id = :est",
            ['est' => $_SESSION['establishment_id']]
        )->fetchAll(\PDO::FETCH_ASSOC);
        // If user cannot view all reports, only give programs belonging to the same establishment

        $school_years = Database::query(
            "SELECT id, title, start_date, end_date FROM school_years ORDER BY start_date DESC"
        )->fetchAll(\PDO::FETCH_ASSOC);


        $programSql .= ' WHERE p.establishment_id = :p_est AND c.establishment_id = :p_est AND s.establishment_id = :p_est';

        if ($this->hasPermission('view_department_reports')) {
            if ($did) {
                $programSql .= ' AND (c.department_id = :pd OR s.department_id = :pd)';
                $programParams['pd'] = $did;

                $departments = Database::query(
                    "SELECT id, name FROM departments WHERE establishment_id = :est AND id = :pd",
                    ['est' => $_SESSION['establishment_id'], 'pd' => $did]
                )->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
        $programParams['p_est'] = $est;

        $programSql .= ' ORDER BY c.name, s.name';

        $programs = Database::query($programSql, $programParams)->fetchAll(\PDO::FETCH_ASSOC);

        // Récupérer les couvertures groupées par semaine (pour le select multiple)
        $coverageParams = [];
        $coverageSql = "SELECT YEAR(r.created_at) AS yr, WEEK(r.created_at, 1) AS wk, MIN(DATE(r.created_at)) AS week_start, MAX(DATE(r.created_at)) AS week_end, SUM(r.nbr_hours_do) AS total_hours"
            . " FROM weekly_coverage_reports r"
            . " WHERE 1=1";

        if ($est) {
            $coverageSql .= ' AND r.establishment_id = :est';
            $coverageParams['est'] = $est;
        }

        $coverageSql .= ' GROUP BY yr, wk ORDER BY yr DESC, wk DESC';
        $coverageStmt = Database::query($coverageSql, $coverageParams);
        $coverages = [];
        while ($row = $coverageStmt->fetch(\PDO::FETCH_ASSOC)) {
            $weekKey = $row['yr'] . '-W' . str_pad($row['wk'], 2, '0', STR_PAD_LEFT);
            $coverages[] = [
                'key' => $weekKey,
                'start' => $row['week_start'],
                'end' => $row['week_end'],
                'total_hours' => $row['total_hours']
            ];
        }

        return $this->view('pages/reports/consult', [
            'reports' => $reports,
            'programs' => $programs,
            'departments' => $departments,
            'coverages' => $coverages,
            'school_years' => $school_years,
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

    public function generate()
    {
        $this->requireAuth();
        $this->requirePermission('view_all_reports');
        $this->validateCsrf();

        $period = $_POST['period'] ?? null;
        $department_id = intval($_POST['department_id'] ?? 0);
        $report_type = $_POST['report_type'] ?? null;

        if (!$period || !$department_id || !in_array($report_type, ['pdf', 'excel'])) {
            set_flash('error', 'Paramètres invalides.');
            redirect('reports');
        }

        // Query reports for the department and period (assuming period is start of week)
        $sql = 'SELECT r.*, p.classe_id, p.subject_id, p.nbr_hours, p.nbr_lesson, p.nbr_lesson_dig, p.nbr_tp, p.nbr_tp_dig,
                   c.name AS class_name, s.name AS subject_name, u.full_name AS recorded_by, d.name AS department_name
            FROM weekly_coverage_reports r
            LEFT JOIN programs p ON r.program_id = p.id
            LEFT JOIN classes c ON p.classe_id = c.id
            LEFT JOIN subjects s ON p.subject_id = s.id
            LEFT JOIN users u ON r.recorded_by_user_id = u.id
            LEFT JOIN departments d ON c.department_id = d.id
            WHERE c.department_id = :dept AND DATE(r.created_at) >= :period
            ORDER BY r.created_at DESC';

        $params = ['dept' => $department_id, 'period' => $period];
        $reports = Database::query($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);

        if ($report_type === 'pdf') {
            ob_start();
            include __DIR__ . '/../../views/reports/pdf_template.php';
            $html = ob_get_clean();
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream('report_' . $period . '.pdf');
        } elseif ($report_type === 'excel') {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="report_' . $period . '.xls"');
            ob_start();
            include __DIR__ . '/../../views/reports/excel_template.php';
            $html = ob_get_clean();
            echo $html;
        }
        exit;
    }

    private function generatePdfHtml($reports, $period, $department_id)
    {
        $html = '<h1>Rapport de Couverture Hebdomadaire</h1>';
        $html .= '<p>Période: ' . $period . '</p>';
        $html .= '<p>Département ID: ' . $department_id . '</p>';
        $html .= '<table border="1" style="width:100%;">';
        $html .= '<tr><th>ID</th><th>Classe</th><th>Matière</th><th>Heures Ftes</th><th>Leçons Ftes</th><th>Leçons Dig Ftes</th><th>TP Fts</th><th>TP Dig Fts</th><th>Date</th><th>Enregistré par</th></tr>';
        foreach ($reports as $r) {
            $html .= '<tr>';
            $html .= '<td>' . $r['id'] . '</td>';
            $html .= '<td>' . htmlspecialchars($r['class_name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($r['subject_name']) . '</td>';
            $html .= '<td>' . $r['nbr_hours_do'] . '</td>';
            $html .= '<td>' . $r['nbr_lesson_do'] . '</td>';
            $html .= '<td>' . $r['nbr_lesson_dig_do'] . '</td>';
            $html .= '<td>' . $r['nbr_tp_do'] . '</td>';
            $html .= '<td>' . $r['nbr_tp_dig_do'] . '</td>';
            $html .= '<td>' . $r['created_at'] . '</td>';
            $html .= '<td>' . htmlspecialchars($r['recorded_by']) . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }
}
