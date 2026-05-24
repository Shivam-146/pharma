<?php
require_once __DIR__ . '/../db.php';
$pdo = getPDO();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: products.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: products.php");
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | MaasCure</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at 10% 20%, #eff6ff 0%, #f0fdf4 90%);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6 relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute w-[500px] h-[500px] rounded-full bg-blue-400/10 blur-3xl -top-40 -left-40 -z-10"></div>
    <div class="absolute w-[500px] h-[500px] rounded-full bg-teal-400/10 blur-3xl -bottom-40 -right-40 -z-10"></div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo / Title -->
        <div class="text-center mb-8">
            <a href="../index.html" class="inline-block mb-3">
                <img src="../assets/logo.png" alt="MaasCure Logo" class="h-20 w-auto object-contain mx-auto transition-transform duration-500 hover:scale-105">
            </a>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Admin Portal Login</h2>
            <p class="text-slate-500 text-sm mt-1">Manage categories, products, and brochures</p>
        </div>

        <!-- Glassmorphism Card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-10 shadow-[0_30px_70px_rgba(0,0,0,0.06)] border border-white/50">
            <?php if ($error): ?>
                <div class="bg-red-50 border border-red-100 text-red-600 rounded-2xl p-4 text-sm font-medium mb-6 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php" class="space-y-6">
                <div>
                    <label for="username" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Username</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <input type="text" name="username" id="username" required
                               class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white text-slate-800 rounded-2xl transition-all outline-none font-medium text-sm shadow-inner"
                               placeholder="Enter your username" autocomplete="username">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Password</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input type="password" name="password" id="password" required
                               class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white text-slate-800 rounded-2xl transition-all outline-none font-medium text-sm shadow-inner"
                               placeholder="Enter your password" autocomplete="current-password">
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-4 bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white font-black rounded-2xl transition-all uppercase text-xs tracking-widest shadow-lg shadow-blue-600/20">
                    Sign In
                </button>
            </form>
        </div>

        <!-- Footnote -->
        <p class="text-center text-slate-400 text-xs mt-8">
            &copy; <?= date('Y') ?> MaasCure. All rights reserved.
        </p>
    </div>
</body>
</html>
