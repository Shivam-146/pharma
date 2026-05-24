<?php
// admin/auth.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if the admin is logged in
 */
function isAdminLoggedIn(): bool {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Require admin access, redirect to login page if not logged in
 */
function requireAdmin() {
    if (!isAdminLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}
