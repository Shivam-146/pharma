<?php
require_once __DIR__ . '/auth.php';
requireAdmin();
header('Location: categories.php');
exit;
