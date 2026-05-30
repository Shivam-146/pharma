<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
    exit;
}

// Support both standard form POST and JSON raw body
$input = $_POST;
if (empty($input)) {
    $rawBody = file_get_contents('php://input');
    $input = json_decode($rawBody, true) ?: [];
}

$name = trim($input['name'] ?? '');
$email = trim($input['email'] ?? '');
$phone = trim($input['phone'] ?? '');
$message = trim($input['message'] ?? '');
$productName = trim($input['product_name'] ?? '');

$errors = [];
if ($name === '') $errors[] = 'Full name is required.';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email address is required.';
if ($phone === '') $errors[] = 'Phone number is required.';
if ($message === '') $errors[] = 'Message is required.';

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

try {
    $pdo = getPDO();
    $stmt = $pdo->prepare("
        INSERT INTO inquiries (name, email, phone, product_name, message, status)
        VALUES (?, ?, ?, ?, ?, 'New')
    ");
    $stmt->execute([$name, $email, $phone, $productName !== '' ? $productName : null, $message]);

    echo json_encode(['success' => true, 'message' => 'Enquiry submitted successfully.']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to save enquiry. Please try again later.']);
}
