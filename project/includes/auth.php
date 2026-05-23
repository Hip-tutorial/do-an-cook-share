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
        header('Location: /pages/login.php');
        exit;
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

function baseUrl(string $path = ''): string
{
    return '/' . ltrim($path, '/');
}

function imageUrl(?string $image): string
{
    if (!empty($image)) {
        return baseUrl('uploads/' . $image);
    }

    return baseUrl('assets/images/placeholder.svg');
}
