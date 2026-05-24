<?php

/**
 * Authentication helpers using PHP sessions.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        redirectTo('pages/login.php');
    }
}

function getCurrentUserId(): ?int
{
    return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
}

function getCurrentUserName(): string
{
    return $_SESSION['fullname'] ?? '';
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function appBasePath(): string
{
    static $base = null;

    if ($base !== null) {
        return $base;
    }

    $docRoot = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? ''), '/');
    $appRoot = rtrim(str_replace('\\', '/', realpath(dirname(__DIR__)) ?: ''), '/');

    $isUnderDocRoot = $docRoot !== '' && (
        PHP_OS_FAMILY === 'Windows'
            ? stripos($appRoot, $docRoot) === 0
            : str_starts_with($appRoot, $docRoot)
    );

    if ($isUnderDocRoot) {
        $base = substr($appRoot, strlen($docRoot));
        $base = rtrim($base, '/');
    } else {
        $base = '';
    }

    return $base;
}

function baseUrl(string $path = ''): string
{
    $base = appBasePath();
    $path = ltrim($path, '/');

    if ($path === '') {
        return $base === '' ? '/' : $base . '/';
    }

    return ($base === '' ? '' : $base) . '/' . $path;
}

function redirectTo(string $path = ''): never
{
    header('Location: ' . baseUrl($path));
    exit;
}

function imageUrl(?string $image): string
{
    if (!empty($image)) {
        return baseUrl('uploads/' . $image);
    }

    return baseUrl('assets/images/placeholder.svg');
}
