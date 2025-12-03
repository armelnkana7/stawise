<?php

// Redirige la racine vers la page de connexion

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\SchoolYearController;
use App\Controllers\EstablishmentController;
use App\Controllers\UserController;
use App\Controllers\ClassController;
use App\Controllers\DepartmentController;
use App\Controllers\RoleController;
use App\Controllers\ReportController;
use App\Controllers\ProgramController;

$router->get('', [AuthController::class, 'showLoginForm']);
$router->get('/', [AuthController::class, 'showLoginForm']);

// Routes d'authentification
$router->get('login', [AuthController::class, 'showLoginForm']);
$router->post('login', [AuthController::class, 'login']);
$router->get('logout', [AuthController::class, 'logout']);

// Tableau de bord (protégé)
$router->get('dashboard', [DashboardController::class, 'index']);

// School years
$router->get('years', [SchoolYearController::class, 'index']);
$router->get('years/create', [SchoolYearController::class, 'create']);
$router->post('years', [SchoolYearController::class, 'store']);
$router->get('years/edit', [SchoolYearController::class, 'edit']);
$router->post('years/update', [SchoolYearController::class, 'update']);
$router->post('years/delete', [SchoolYearController::class, 'delete']);

// Establishments
$router->get('establishments', [EstablishmentController::class, 'index']);
$router->get('establishments/create', [EstablishmentController::class, 'create']);
$router->post('establishments', [EstablishmentController::class, 'store']);
$router->get('establishments/edit', [EstablishmentController::class, 'edit']);
$router->post('establishments/update', [EstablishmentController::class, 'update']);
$router->post('establishments/delete', [EstablishmentController::class, 'delete']);
// Switch active establishment (for superadmin)
$router->post('establishments/switch', [EstablishmentController::class, 'switch']);

// Users
$router->get('users', [UserController::class, 'index']);
$router->post('users', [UserController::class, 'store']);
$router->get('users/edit', [UserController::class, 'edit']);
$router->post('users/update', [UserController::class, 'update']);

// Classes
$router->get('classes', [ClassController::class, 'index']);
$router->get('classes/create', [ClassController::class, 'create']);
$router->post('classes', [ClassController::class, 'store']);
$router->post('classes/update', [ClassController::class, 'update']);
$router->post('classes/delete', [ClassController::class, 'delete']);

// Class subjects (matières par classe)
$router->get('classes/subjects', [App\Controllers\ClassSubjectController::class, 'index']);
$router->post('classes/subjects', [App\Controllers\ClassSubjectController::class, 'store']);
$router->post('classes/subjects/delete', [App\Controllers\ClassSubjectController::class, 'delete']);


// Departments
$router->get('departments', [DepartmentController::class, 'index']);
$router->get('departments/create', [DepartmentController::class, 'create']);
$router->post('departments', [DepartmentController::class, 'store']);
$router->get('departments', 'DepartmentController@index');
$router->post('departments/store', 'DepartmentController@store');
$router->post('departments/update', 'DepartmentController@update');
$router->post('departments/delete', 'DepartmentController@delete');


// Roles
$router->get('roles', [RoleController::class, 'index']);
$router->get('roles/create', [RoleController::class, 'create']);
$router->post('roles', [RoleController::class, 'store']);

// Reports (weekly coverage)
$router->get('reports', [ReportController::class, 'index']);
$router->get('reports/consult', [ReportController::class, 'consult']);
$router->get('reports/view', [ReportController::class, 'consult']);
$router->get('reports/create', [ReportController::class, 'create']);
$router->post('reports', [ReportController::class, 'store']);
$router->get('reports/edit', [ReportController::class, 'edit']);
$router->post('reports/update', [ReportController::class, 'update']);
$router->post('reports/delete', [ReportController::class, 'delete']);

// Export
$router->get('reports/export', [ReportController::class, 'export']);
// Generate specific report
$router->post('reports/generate', [ReportController::class, 'generate']);


// Programs (class - subject planning)
$router->get('programs', [ProgramController::class, 'index']);
$router->post('programs', [ProgramController::class, 'store']);
$router->get('programs/edit', [ProgramController::class, 'edit']);
$router->post('programs/update', [ProgramController::class, 'update']);
$router->post('programs/delete', [ProgramController::class, 'delete']);
// Return JSON list of programs for AJAX
$router->get('programs/list', [ProgramController::class, 'list']);
$router->get('classes/programs', [App\Controllers\ClassSubjectController::class, 'index']);
$router->post('classes/programs/store', [App\Controllers\ClassSubjectController::class, 'store']);
$router->post('classes/programs/update', [App\Controllers\ClassSubjectController::class, 'update']);
$router->post('classes/programs/delete', [App\Controllers\ClassSubjectController::class, 'delete']);


// Subjects (matières)
$router->get('subjects', [App\Controllers\SubjectController::class, 'index']);
$router->get('subjects/create', [App\Controllers\SubjectController::class, 'create']);
$router->post('subjects', [App\Controllers\SubjectController::class, 'store']);
$router->get('subjects/edit', [App\Controllers\SubjectController::class, 'edit']);
$router->post('subjects/update', [App\Controllers\SubjectController::class, 'update']);
$router->post('subjects/delete', [App\Controllers\SubjectController::class, 'delete']);
$router->get('subjects/list', [App\Controllers\SubjectController::class, 'list']);

// Une fois connecté, on pourrait avoir un tableau de bord
// $router->get('dashboard', 'DashboardController@index');
