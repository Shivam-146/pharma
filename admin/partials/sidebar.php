<?php
// admin/partials/sidebar.php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">M</div>
        <div class="sidebar-logo-text">
            <span class="brand">MaasCure</span>
            <span class="sub">Admin Panel</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-section-label">Main</div>

        <a href="categories.php" class="sidebar-link <?= ($currentPage === 'categories.php') ? 'active' : '' ?>">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2h2z"/>
            </svg>
            Categories
        </a>

        <a href="products.php" class="sidebar-link <?= in_array($currentPage, ['products.php','product-form.php']) ? 'active' : '' ?>">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            Products
        </a>

        <div class="sidebar-section-label" style="margin-top:16px">Site</div>

        <a href="../products.php" target="_blank" class="sidebar-link">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            View Products Page
        </a>

        <a href="../index.html" target="_blank" class="sidebar-link">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Visit Website
        </a>

        <div class="sidebar-section-label" style="margin-top:16px">Account</div>
        <a href="logout.php" class="sidebar-link text-red-600 hover:bg-red-50 hover:text-red-700">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-red-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Logout
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="../index.html" target="_blank">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:16px;height:16px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            MaasCure Pharma
        </a>
    </div>
</aside>
