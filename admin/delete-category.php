<?php
require_once __DIR__ . '/auth.php';
requireAdmin();
require_once __DIR__ . '/../db.php';
$pdo = getPDO();

$id = (int)($_POST['id'] ?? 0);
if ($id > 0) {
    $pdo->prepare("DELETE FROM categories WHERE id=?")->execute([$id]);
}
header('Location: categories.php?flash=' . urlencode('Category deleted.') . '&type=success');
exit;
