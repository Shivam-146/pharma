<?php
header('Content-Type: application/json');

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
    $enquiriesFile = __DIR__ . '/enquiries.json';
    
    // Read existing enquiries
    $enquiries = [];
    if (file_exists($enquiriesFile)) {
        $data = file_get_contents($enquiriesFile);
        $enquiries = json_decode($data, true) ?: [];
    }
    
    // Append new enquiry
    $newEnquiry = [
        'id' => count($enquiries) + 1,
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'product_name' => $productName !== '' ? $productName : null,
        'message' => $message,
        'status' => 'New',
        'created_at' => date('Y-m-d H:i:s')
    ];
    $enquiries[] = $newEnquiry;
    
    // Save back to file
    file_put_contents($enquiriesFile, json_encode($enquiries, JSON_PRETTY_PRINT));

    echo json_encode(['success' => true, 'message' => 'Enquiry submitted successfully.']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to save enquiry. Please try again later.']);
}

