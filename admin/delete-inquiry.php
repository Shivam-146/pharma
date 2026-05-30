<?php
require_once __DIR__ . '/auth.php';
requireAdmin();
require_once __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        try {
            $pdo = getPDO();
            $stmt = $pdo->prepare("DELETE FROM inquiries WHERE id = ?");
            $stmt->execute([$id]);
            header('Location: inquiries.php?flash=Enquiry+deleted+successfully.&type=success');
            exit;
        } catch (Exception $e) {
            header('Location: inquiries.php?flash=Failed+to+delete+enquiry.&type=danger');
            exit;
        }
    }
}
header('Location: inquiries.php');
exit;
