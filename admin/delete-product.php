<?php
require_once __DIR__ . '/auth.php';
requireAdmin();
require_once __DIR__ . '/../db.php';
$pdo = getPDO();

$id = (int)($_POST['id'] ?? 0);
if ($id > 0) {
    // Optionally delete uploaded files
    $stmt = $pdo->prepare("SELECT image, brochure, additional_images FROM products WHERE id=?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if ($row) {
        foreach (['image', 'brochure'] as $field) {
            if ($row[$field]) {
                $path = __DIR__ . '/../' . $row[$field];
                if (file_exists($path)) @unlink($path);
            }
        }
        if ($row['additional_images']) {
            $images = json_decode($row['additional_images'], true);
            if (is_array($images)) {
                foreach ($images as $img) {
                    $path = __DIR__ . '/../' . $img;
                    if (file_exists($path)) @unlink($path);
                }
            }
        }
    }
    $pdo->prepare("DELETE FROM products WHERE id=?")->execute([$id]);
}
header('Location: products.php?flash=Product+deleted+successfully.&type=success');
exit;
