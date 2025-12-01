<?php

// Helpers for URL and redirection with base path awareness
if (!function_exists('base_path')) {
    function base_path()
    {
        $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
        $dir = trim(dirname($scriptName), '/');
        if ($dir === '.' || $dir === '') {
            return '';
        }
        return '/' . $dir;
    }
}

if (!function_exists('url')) {
    function url($path = '')
    {
        $path = trim($path, '/');
        $base = base_path();
        if ($base === '') {
            return '/' . $path;
        }
        if ($path === '') {
            return $base === '' ? '/' : $base;
        }
        return $base . '/' . $path;
    }
}

if (!function_exists('redirect')) {
    function redirect($path = '')
    {
        $location = url($path);
        if (php_sapi_name() === 'cli') {
            echo "REDIRECT to: {$location}\n";
            return;
        }
        header('Location: ' . $location);
        exit;
    }
}

// Flash message helpers
if (!function_exists('set_flash')) {
    function set_flash($key, $message)
    {
        if (php_sapi_name() === 'cli') {
            // For CLI, echo messages as info so tests can parse them
            echo strtoupper($key) . ': ' . $message . "\n";
            return;
        }
        if (session_status() !== PHP_SESSION_ACTIVE) {
            @session_start();
        }
        $_SESSION['flash'][$key] = $message;
    }
}

if (!function_exists('get_flash')) {
    function get_flash($key = null)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            @session_start();
        }
        if ($key === null) {
            $flashes = $_SESSION['flash'] ?? [];
            unset($_SESSION['flash']);
            return $flashes;
        }
        $message = $_SESSION['flash'][$key] ?? null;
        if ($message !== null) {
            unset($_SESSION['flash'][$key]);
        }
        return $message;
    }
}

// Convenience alias
if (!function_exists('flash')) {
    function flash($key, $message)
    {
        return set_flash($key, $message);
    }
}

// Helper to access previous POST value (when passing 'old' input explicitly)
if (!function_exists('old')) {
    function old($key, $default = '')
    {
        if (!empty($_POST[$key])) return htmlspecialchars($_POST[$key]);
        return $default;
    }
}

// CSRF helpers
if (!function_exists('csrf_token')) {
    function csrf_token()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) @session_start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field()
    {
        $token = csrf_token();
        return '<input type="hidden" name="_csrf" value="' . htmlspecialchars($token) . '" />';
    }
}

if (!function_exists('validate_csrf')) {
    function validate_csrf($token = null)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) @session_start();
        $token = $token ?? ($_POST['_csrf'] ?? null);
        if (!$token || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            return false;
        }
        return true;
    }
}
