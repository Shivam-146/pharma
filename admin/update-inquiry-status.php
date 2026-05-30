<?php
require_once __DIR__ . '/auth.php';
requireAdmin();
require_once __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $status = $_POST['status'] ?? '';
    $allowedStatuses = ['New', 'Contacted', 'Completed'];

    if ($id > 0 && in_array($status, $allowedStatuses)) {
        try {
            $pdo = getPDO();
            $stmt = $pdo->prepare("UPDATE inquiries SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            header('Location: inquiries.php?flash=Enquiry+status+updated+successfully.&type=success');
            exit;
        } catch (Exception $e) {
            header('Location: inquiries.php?flash=Failed+to+update+status.&type=danger');
            exit;
        }
    }
}
header('Location: inquiries.php');
exit;
