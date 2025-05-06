<?php

namespace Core\entity;

class Auth
{
    public static function requireAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
    }

    public static function requireAdmin(): void
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            http_response_code(403);
            echo "Access denied";
            exit();
        }
    }
}