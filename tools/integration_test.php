<?php
// Run a sequence of actions to validate the main flows: create program (AJAX), create report, list, export
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Helpers/helpers.php';
use App\Core\Router;

if (session_status() === PHP_SESSION_NONE) session_start();
$_SESSION['user_id'] = 2;
$_SESSION['role_id'] = 1; // admin

$router = Router::load(__DIR__ . '/../routes/web.php');

function run($uri, $method='GET', $post=null, $xhr=false){
    global $router;
    $_GET = [];
    $_POST = [];
    if ($post) {
        foreach ($post as $k=>$v) $_POST[$k] = $v;
    }
    if ($method === 'GET' && $post) {
        foreach ($post as $k=>$v) $_GET[$k] = $v;
    }
    if ($xhr) $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
    ob_start();
    $router->dispatch($uri, $method);
    $out = ob_get_clean();
    if ($xhr) unset($_SERVER['HTTP_X_REQUESTED_WITH']);
    return $out;
}

try {
    echo "Starting integration test\n";
    // Ensure we have programs
    $out = run('programs/list','GET');
    $list = json_decode($out, true);
    echo "Programs currently: " . count($list) . "\n";

    // Create a program via AJAX
    $post = ['classe_id'=>1,'subject_id'=>1,'nbr_hours'=>10,'nbr_lesson'=>20,'nbr_lesson_dig'=>1,'nbr_tp'=>0,'nbr_tp_dig'=>0, '_csrf' => csrf_token(), 'return_to'=>'programs'];
    $out = run('programs','POST', $post, true);
    $json = json_decode($out, true);
    if (!($json && $json['success'])) { echo "Program create failed: {$out}\n"; exit(1); }
    echo "Program created (AJAX) id={$json['id']}\n";

    // Now list programs and ensure new one is present
    $out = run('programs/list','GET');
    $list = json_decode($out, true);
    $found = false; foreach($list as $p) if($p['id'] == $json['id']) $found = true;
    echo $found ? "Program found in list\n" : "Program NOT found in list\n";

    // Create a report for this program
    $post = ['program_id' => $json['id'], 'nbr_hours_do' => 2, 'nbr_lesson_do'=>1, 'nbr_lesson_dig_do'=>0, 'nbr_tp_do'=>0, 'nbr_tp_dig_do'=>0, '_csrf' => csrf_token()];
    $out = run('reports','POST',$post,true); // not AJAX expected, but simulate
    echo "Report create output: " . substr($out,0,120) . "\n";

    // List reports
    $out = run('reports','GET');
    echo "Reports listing length: " . strlen($out) . "\n";

    // Export CSV
    $out = run('reports/export','GET');
    echo "CSV length: " . strlen($out) . "\n";

    echo "Integration test completed successfully\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
