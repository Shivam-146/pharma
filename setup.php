<?php
require_once __DIR__ . '/db.php';

try {
    // Create the database if not exists
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';charset=' . DB_CHARSET,
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `" . DB_NAME . "`");

    // Categories table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `categories` (
        `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name`       VARCHAR(255) NOT NULL,
        `slug`       VARCHAR(255) NOT NULL UNIQUE,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Products table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `products` (
        `id`                   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `category_id`          INT UNSIGNED NULL,
        `name`                 VARCHAR(255) NOT NULL,
        `slug`                 VARCHAR(255) NOT NULL UNIQUE,
        `image`                VARCHAR(500) NULL COMMENT 'Path relative to project root',
        `additional_images`    TEXT NULL COMMENT 'JSON array of paths relative to project root',
        `composition`          TEXT NULL,
        `uses`                 TEXT NULL,
        `dosage`               TEXT NULL,
        `safety_information`   TEXT NULL,
        `storage`              TEXT NULL,
        `manufacturer_details` TEXT NULL,
        `brochure`             VARCHAR(500) NULL COMMENT 'Path relative to project root',
        `badge`                VARCHAR(100) NULL COMMENT 'e.g. Best Seller, New',
        `created_at`           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Dynamic migration for existing databases
    try {
        $pdo->exec("ALTER TABLE `products` ADD COLUMN `additional_images` TEXT NULL AFTER `image`");
    } catch (PDOException $e) {
        // Ignore error if column already exists
    }

    // Admins table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `admins` (
        `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `username`   VARCHAR(100) NOT NULL UNIQUE,
        `password`   VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Inquiries table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `inquiries` (
        `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name`         VARCHAR(255) NOT NULL,
        `email`        VARCHAR(255) NOT NULL,
        `phone`        VARCHAR(50) NOT NULL,
        `product_name` VARCHAR(255) NULL,
        `message`      TEXT NOT NULL,
        `status`       VARCHAR(50) DEFAULT 'New',
        `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Seed default admin if empty
    $adminCount = $pdo->query("SELECT COUNT(*) FROM `admins`")->fetchColumn();
    if ($adminCount == 0) {
        $username = 'admin';
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $insertAdmin = $pdo->prepare("INSERT INTO `admins` (username, password) VALUES (?, ?)");
        $insertAdmin->execute([$username, $password]);
    }

    // Create upload directories
    $dirs = [
        __DIR__ . '/uploads',
        __DIR__ . '/uploads/products',
        __DIR__ . '/uploads/brochures',
    ];
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    echo '<!DOCTYPE html><html><head><title>Setup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{font-family:sans-serif;max-width:600px;margin:60px auto;padding:20px;}
    .ok{color:#16a34a;}.info{color:#2563eb;}</style></head><body>';
    echo '<h2>✅ Setup Complete</h2>';
    echo '<p class="ok">Database <strong>' . DB_NAME . '</strong> created/verified.</p>';
    echo '<p class="ok">Tables <code>categories</code>, <code>products</code>, and <code>admins</code> created/verified/seeded.</p>';
    echo '<p class="ok">Upload directories created/verified.</p>';
    echo '<p class="info"><a href="admin/index.php">→ Go to Admin Panel</a></p>';
    echo '</body></html>';

} catch (PDOException $e) {
    echo '<!DOCTYPE html><html><head><title>Setup Failed</title><script src="https://cdn.tailwindcss.com"></script></head><body class="p-6 bg-slate-50">';
    echo '<h2>❌ Setup Failed</h2>';
    echo '<pre style="color:red">' . htmlspecialchars($e->getMessage()) . '</pre>';
    echo '<p>Make sure XAMPP MySQL is running and credentials in <code>db.php</code> are correct.</p>';
    echo '</body></html>';
}
