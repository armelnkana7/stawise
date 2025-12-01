<?php

namespace App\Controllers;

use App\Core\Database;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLoginForm()
    {
        // If already authenticated, redirect to dashboard
        if (isset($_SESSION['user_id'])) {
            redirect('dashboard');
        }

        // Le nom du fichier de vue est 'pages/auth/login'
        return $this->view('pages/auth/login');
    }

    /**
     * Handle a login request to the application.
     */
    public function login()
    {
        // Récupérer les données du formulaire de manière sécurisée
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        // (Validation simple pour l'exemple)
        if (empty($email) || empty($password)) {
            // Rediriger avec une erreur
            // Pour l'instant, on affiche une erreur simple
            die('Email and password are required.');
        }

        // Récupérer l'utilisateur
        $user = User::findByEmail($email);

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($password, $user->password_hash)) {
            // Démarrer la session et stocker les infos de l'utilisateur (la session est déjà démarrée dans index.php)
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->full_name;
            $_SESSION['email'] = $user->email;
            $_SESSION['department_id'] = $user->department_id;
            $_SESSION['establishment_id'] = $user->establishment_id;
            // Store role id for authorization checks
            $_SESSION['role_id'] = $user->role_id ?? null;

            // Rediriger vers le tableau de bord en utilisant le helper
            redirect('dashboard');
        } else {
            // Rediriger vers la page de login avec un message d'erreur
            // Pour l'instant, on affiche une erreur simple
            die('Invalid credentials.');
        }
    }

    /**
     * Log the user out of the application.
     */
    public function logout()
    {
        // session started earlier in index; just destroy and redirect
        session_unset();
        session_destroy();

        redirect('login');
    }
}
