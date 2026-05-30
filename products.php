<?php
require_once __DIR__ . '/db.php';
$pdo = getPDO();

// Fetch all categories
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

// Fetch parameters
$catFilter = (int)($_GET['cat'] ?? 0);
$search = trim($_GET['q'] ?? '');
$sort = $_GET['sort'] ?? 'newest';

// Validate sorting
$allowedSorts = ['newest', 'alpha_az', 'alpha_za'];
if (!in_array($sort, $allowedSorts)) {
    $sort = 'newest';
}

$orderBy = 'p.created_at DESC';
if ($sort === 'alpha_az') {
    $orderBy = 'p.name ASC';
} elseif ($sort === 'alpha_za') {
    $orderBy = 'p.name DESC';
}

$params = [];
$whereClauses = [];

if ($catFilter > 0) {
    $whereClauses[] = 'p.category_id = ?';
    $params[] = $catFilter;
}

if ($search !== '') {
    $whereClauses[] = '(p.name LIKE ? OR p.composition LIKE ?)';
    $params[] = '%' . $search . '%';
    $params[] = '%' . $search . '%';
}

$where = count($whereClauses) > 0 ? implode(' AND ', $whereClauses) : '1=1';

// Get total count of products for pagination
$countStmt = $pdo->prepare("
    SELECT COUNT(*) 
    FROM products p
    WHERE $where
");
$countStmt->execute($params);
$totalProducts = (int)$countStmt->fetchColumn();

// Pagination settings
$limit = 9;
$totalPages = (int)ceil($totalProducts / $limit);
if ($totalPages < 1) {
    $totalPages = 1;
}

// Current page
$page = (int)($_GET['page'] ?? 1);
if ($page < 1) {
    $page = 1;
} elseif ($page > $totalPages) {
    $page = $totalPages;
}

$offset = ($page - 1) * $limit;

// Fetch paginated products
$productsQuery = "
    SELECT p.*, c.name AS category_name
    FROM products p
    LEFT JOIN categories c ON c.id = p.category_id
    WHERE $where
    ORDER BY $orderBy
    LIMIT $limit OFFSET $offset
";
$productsStmt = $pdo->prepare($productsQuery);
$productsStmt->execute($params);
$products = $productsStmt->fetchAll();

// Helper function to build pagination links
function getPageUrl($pageNum, $catFilter, $search = '', $sort = 'newest') {
    $params = [];
    if ($catFilter > 0) {
        $params['cat'] = $catFilter;
    }
    if ($search !== '') {
        $params['q'] = $search;
    }
    if ($sort !== 'newest') {
        $params['sort'] = $sort;
    }
    if ($pageNum > 1) {
        $params['page'] = $pageNum;
    }
    return 'products.php' . ($params ? '?' . http_build_query($params) : '');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Products | MaasCure Pharmaceutical Private Limited</title>
    <meta name="description" content="MaasCure Pharmaceutical Private Limited is a leading healthcare provider committed to innovation, quality, and healthcare solutions.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<body class="bg-slate-50 text-slate-900 overflow-x-hidden">

    <!-- Preloader -->
    <div id="preloader">
        <div class="loader-brand">MaasCure<span>.</span></div>
        <div class="capsule-loader">
            <div class="capsule-half-1"></div>
            <div class="capsule-half-2"></div>
        </div>
    </div>

    <!-- Header Placeholder -->
    <div id="header-placeholder"></div>

    <!-- Page Hero -->
    <section class="relative min-h-[60vh] flex items-center justify-center text-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="assets/products_hero.png" alt="Our Products Hero" class="w-full h-full object-cover scale-110">
            <div class="absolute inset-0 bg-gradient-to-b from-blue-950/80 via-blue-900/60 to-slate-900/40"></div>
            <div class="absolute inset-0" style="background: radial-gradient(circle at center, rgba(37,99,235,0.15) 0%, transparent 70%);"></div>
        </div>
        <div class="relative z-10 container mx-auto px-6 pt-32 pb-36 md:pb-48">
            <span class="inline-block px-4 py-1.5 mb-6 bg-blue-500/20 backdrop-blur-md border border-white/10 rounded-full text-blue-200 text-xs font-bold tracking-widest uppercase">
                Medical Portfolio
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-black text-white mb-6 tracking-tight italic">
                Our <span class="text-green-400">Products</span>
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto font-medium leading-relaxed">
                Explore our comprehensive range of high-quality pharmaceutical solutions, crafted with precision and care.
            </p>
        </div>
    </section>

    <!-- Products Section -->
    <section class="relative z-20 -mt-20 md:-mt-32 pb-16 md:pb-24">
        <div class="container mx-auto px-6">
            <div class="bg-white rounded-3xl md:rounded-[3rem] shadow-[0_40px_100px_rgba(0,0,0,0.1)] p-6 sm:p-12 md:p-16 lg:p-20 border border-slate-100 relative overflow-hidden">
                
                <!-- Biological Background Watermarks (Absolute elements) -->
                <!-- Molecule 1 (Top Left) -->
                <svg class="absolute top-10 -left-16 w-96 h-96 text-blue-600/[0.03] pointer-events-none select-none z-0 hidden lg:block" viewBox="0 0 200 200" fill="currentColor">
                    <circle cx="50" cy="50" r="6" />
                    <circle cx="100" cy="20" r="4" />
                    <circle cx="150" cy="50" r="5" />
                    <circle cx="150" cy="110" r="6" />
                    <circle cx="100" cy="140" r="4" />
                    <circle cx="50" cy="110" r="5" />
                    <circle cx="100" cy="80" r="3" />
                    <line x1="50" y1="50" x2="100" y2="20" stroke="currentColor" stroke-width="1.5" />
                    <line x1="100" y1="20" x2="150" y2="50" stroke="currentColor" stroke-width="1.5" />
                    <line x1="150" y1="50" x2="150" y2="110" stroke="currentColor" stroke-width="1.5" />
                    <line x1="150" y1="110" x2="100" y2="140" stroke="currentColor" stroke-width="1.5" />
                    <line x1="100" y1="140" x2="50" y2="110" stroke="currentColor" stroke-width="1.5" />
                    <line x1="50" y1="110" x2="50" y2="50" stroke="currentColor" stroke-width="1.5" />
                    <line x1="60" y1="55" x2="95" y2="34" stroke="currentColor" stroke-width="1" stroke-dasharray="2,2" />
                    <line x1="140" y1="105" x2="105" y2="126" stroke="currentColor" stroke-width="1" stroke-dasharray="2,2" />
                    <line x1="100" y1="80" x2="50" y2="50" stroke="currentColor" stroke-width="1" />
                    <line x1="100" y1="80" x2="150" y2="50" stroke="currentColor" stroke-width="1" />
                    <line x1="100" y1="80" x2="100" y2="140" stroke="currentColor" stroke-width="1" />
                </svg>

                <!-- Molecule 2 (Bottom Right) -->
                <svg class="absolute bottom-10 -right-20 w-[32rem] h-[32rem] text-emerald-500/[0.03] pointer-events-none select-none z-0 hidden lg:block" viewBox="0 0 200 200" fill="currentColor">
                    <circle cx="30" cy="100" r="4" />
                    <circle cx="70" cy="80" r="5" />
                    <circle cx="110" cy="100" r="4" />
                    <circle cx="150" cy="80" r="6" />
                    <circle cx="190" cy="100" r="4" />
                    <circle cx="110" cy="150" r="5" />
                    <circle cx="70" cy="170" r="3" />
                    <line x1="30" y1="100" x2="70" y2="80" stroke="currentColor" stroke-width="1.2" />
                    <line x1="70" y1="80" x2="110" y2="100" stroke="currentColor" stroke-width="1.2" />
                    <line x1="110" y1="100" x2="150" y2="80" stroke="currentColor" stroke-width="1.2" />
                    <line x1="150" y1="80" x2="190" y2="100" stroke="currentColor" stroke-width="1.2" />
                    <line x1="110" y1="100" x2="110" y2="150" stroke="currentColor" stroke-width="1.2" />
                    <line x1="110" y1="150" x2="70" y2="170" stroke="currentColor" stroke-width="1.2" />
                    <circle cx="150" cy="30" r="3" />
                    <line x1="150" y1="80" x2="150" y2="30" stroke="currentColor" stroke-width="1" />
                    <circle cx="30" cy="150" r="5" />
                    <line x1="30" y1="100" x2="30" y2="150" stroke="currentColor" stroke-width="1" />
                </svg>

                <!-- Molecule 3 (Middle Right) -->
                <svg class="absolute top-1/3 -right-10 w-80 h-80 text-blue-600/[0.02] pointer-events-none select-none z-0 hidden xl:block" viewBox="0 0 100 100" fill="currentColor">
                    <path d="M10,20 Q30,5 50,20 T90,20" stroke="currentColor" stroke-width="1" fill="none"/>
                    <path d="M10,40 Q30,55 50,40 T90,40" stroke="currentColor" stroke-width="1" fill="none"/>
                    <line x1="20" y1="28" x2="20" y2="32" stroke="currentColor" stroke-width="1"/>
                    <line x1="35" y1="18" x2="35" y2="42" stroke="currentColor" stroke-width="1"/>
                    <line x1="50" y1="20" x2="50" y2="40" stroke="currentColor" stroke-width="1"/>
                    <line x1="65" y1="28" x2="65" y2="32" stroke="currentColor" stroke-width="1"/>
                    <line x1="80" y1="18" x2="80" y2="42" stroke="currentColor" stroke-width="1"/>
                </svg>

                <div class="text-center mb-12">
                    <h3 class="text-teal-500 font-black tracking-widest uppercase text-xs mb-4">Precision Medicine</h3>
                    <h2 class="text-2xl sm:text-3xl md:text-5xl font-black text-slate-800 italic">Quality You Can <span class="text-blue-600">Trust</span></h2>
                </div>

                <?php if (!empty($categories)): ?>
                <!-- Category Filter Tabs -->
                <div class="flex flex-wrap justify-center gap-3 mb-8">
                    <a href="<?= getPageUrl(1, 0, $search, $sort) ?>"
                        class="px-5 py-2.5 rounded-2xl text-sm font-bold transition-all duration-300 <?= $catFilter === 0 ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' ?>">
                        All Products
                    </a>
                    <?php foreach ($categories as $cat): ?>
                    <a href="<?= getPageUrl(1, (int)$cat['id'], $search, $sort) ?>"
                        class="px-5 py-2.5 rounded-2xl text-sm font-bold transition-all duration-300 <?= $catFilter === (int)$cat['id'] ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' ?>">
                        <?= htmlspecialchars($cat['name']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Search and Sort Form -->
                <form method="GET" action="products.php" class="mb-12">
                    <!-- Keep the current category filter -->
                    <input type="hidden" name="cat" value="<?= $catFilter ?>">
                    
                    <div class="flex flex-col lg:flex-row gap-4 items-center justify-between bg-slate-50 p-6 rounded-3xl border border-slate-100 shadow-inner">
                        <!-- Search Input -->
                        <div class="relative w-full lg:max-w-xl">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Search by product name or active composition..." 
                                   class="w-full pl-11 pr-10 py-3 bg-white border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all duration-300 shadow-sm text-slate-700 placeholder-slate-400">
                            <?php if ($search !== ''): ?>
                                <a href="<?= getPageUrl(1, $catFilter, '', $sort) ?>" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-red-500 transition-colors" title="Clear Search">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- Sort Select & Reset Controls -->
                        <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto justify-end">
                            <div class="flex items-center gap-2 bg-white px-4 py-3 rounded-2xl border border-slate-200 shadow-sm w-full sm:w-auto">
                                <label for="sort" class="text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Sort By</label>
                                <div class="relative flex items-center w-full">
                                    <select name="sort" id="sort" onchange="this.form.submit()" 
                                            class="bg-transparent text-sm font-semibold text-slate-700 focus:outline-none cursor-pointer pr-8 appearance-none w-full">
                                        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest Arrivals</option>
                                        <option value="alpha_az" <?= $sort === 'alpha_az' ? 'selected' : '' ?>>Alphabetical (A-Z)</option>
                                        <option value="alpha_za" <?= $sort === 'alpha_za' ? 'selected' : '' ?>>Alphabetical (Z-A)</option>
                                    </select>
                                    <span class="absolute right-0 pointer-events-none text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                <button type="submit" class="flex-1 sm:flex-none px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl text-sm transition-all duration-300 shadow-md shadow-blue-600/20 hover:shadow-lg hover:shadow-blue-600/30">
                                    Search
                                </button>

                                <?php if ($search !== '' || $sort !== 'newest' || $catFilter > 0): ?>
                                    <a href="products.php" class="flex-1 sm:flex-none px-5 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-2xl text-sm text-center transition-all duration-300">
                                        Clear All
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>

                <?php if (empty($products)): ?>
                <!-- No products fallback -->
                <div class="text-center py-20 bg-slate-50/50 rounded-[2rem] border border-dashed border-slate-200">
                    <div style="font-size:4rem;margin-bottom:16px;">🔍</div>
                    <h3 class="text-2xl font-black text-slate-700 mb-3">No Products Found</h3>
                    <p class="text-slate-500 mb-6 max-w-md mx-auto">
                        <?php if ($search !== ''): ?>
                            We couldn't find any products matching "<span class="font-semibold text-slate-800"><?= htmlspecialchars($search) ?></span>". Try adjusting your search query or filters.
                        <?php else: ?>
                            There are currently no products available under this category.
                        <?php endif; ?>
                    </p>
                    <?php if ($search !== '' || $catFilter > 0): ?>
                        <a href="products.php" class="inline-block px-6 py-3 bg-blue-600 text-white font-bold rounded-2xl text-sm transition-all duration-300 shadow-md shadow-blue-600/20 hover:shadow-lg hover:shadow-blue-600/30">
                            Clear Filters & View All
                        </a>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <!-- Products Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 lg:gap-10">
                    <?php foreach ($products as $idx => $p): ?>
                    <div class="reveal group bg-white rounded-2xl overflow-hidden hover:shadow-[0_15px_45px_rgba(37,99,235,0.07)] border border-slate-100 hover:border-blue-100 transition-all duration-500 transform hover:-translate-y-1.5 flex flex-col justify-between h-full" style="transition-delay: <?= ($idx % 3) * 100 ?>ms;">
                        <div>
                            <!-- Image Container with Padding and Light Grey Background -->
                            <div class="w-full aspect-[4/3] bg-slate-50/50 flex items-center justify-center p-5 relative overflow-hidden border-b border-slate-100/60">
                                <?php if ($p['image']): ?>
                                <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>"
                                    class="max-w-full max-h-full object-contain transition-transform duration-500 group-hover:scale-105">
                                <?php else: ?>
                                <div class="w-full h-full bg-gradient-to-br from-blue-50 to-teal-50 flex items-center justify-center rounded-xl">
                                    <span style="font-size:3rem;">💊</span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($p['badge']): ?>
                                <div class="absolute top-4 right-4 bg-blue-600 text-white text-[9px] font-extrabold px-2.5 py-1 rounded-lg uppercase tracking-wider shadow-sm">
                                    <?= htmlspecialchars($p['badge']) ?>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Card Body -->
                            <div class="pt-5 px-5 pb-3">
                                <?php if ($p['category_name']): ?>
                                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mb-1.5 block">
                                    <?= htmlspecialchars($p['category_name']) ?>
                                </span>
                                <?php endif; ?>
                                
                                <h4 class="text-base sm:text-lg font-bold text-slate-800 mb-2.5 group-hover:text-blue-600 transition-colors line-clamp-1">
                                    <?= htmlspecialchars($p['name']) ?>
                                </h4>
                                
                                <?php if ($p['composition']): ?>
                                <div class="space-y-0.5">
                                    <span class="text-[9px] font-semibold text-slate-400 uppercase tracking-widest block">Composition</span>
                                    <p class="text-slate-500 text-s font-medium leading-relaxed line-clamp-2">
                                        <?= htmlspecialchars(substr($p['composition'], 0, 95)) . (strlen($p['composition']) > 95 ? '...' : '') ?>
                                    </p>
                                </div>
                                <?php else: ?>
                                <p class="text-slate-400 text-s leading-relaxed line-clamp-2">High-quality pharmaceutical solution manufactured under certified conditions.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- CTA Section -->
                        <div class="px-5 pb-5 pt-0">
                            <a href="product.php?slug=<?= urlencode($p['slug']) ?>"
                                class="flex items-center gap-2 w-full py-4 px-4 bg-slate-50 group-hover:bg-blue-600 group-hover:text-white border border-slate-100 group-hover:border-blue-600 text-slate-700 font-bold rounded-xl transition-all duration-300 text-xs tracking-wider justify-center uppercase shadow-sm">
                                <span>View Details</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <div class="mt-16 flex flex-col sm:flex-row items-center justify-between gap-6 border-t border-slate-100 pt-10">
                    <div class="text-sm text-slate-500 font-medium">
                        Showing page <span class="font-bold text-slate-800"><?= $page ?></span> of <span class="font-bold text-slate-800"><?= $totalPages ?></span> (<span class="font-bold text-slate-800"><?= $totalProducts ?></span> total products)
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <!-- Previous Page Link -->
                        <?php if ($page > 1): ?>
                            <a href="<?= getPageUrl($page - 1, $catFilter, $search, $sort) ?>" 
                               class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white border border-slate-200 text-slate-600 hover:border-blue-600 hover:text-blue-600 transition-all duration-300 shadow-sm hover:shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                        <?php else: ?>
                            <span class="flex items-center justify-center w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 text-slate-300 cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </span>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php
                        $maxVisiblePages = 5;
                        $startPage = max(1, $page - floor($maxVisiblePages / 2));
                        $endPage = min($totalPages, $startPage + $maxVisiblePages - 1);
                        
                        if ($endPage - $startPage + 1 < $maxVisiblePages) {
                            $startPage = max(1, $endPage - $maxVisiblePages + 1);
                        }

                        if ($startPage > 1): ?>
                            <a href="<?= getPageUrl(1, $catFilter, $search, $sort) ?>" 
                               class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white border border-slate-200 text-slate-600 hover:border-blue-600 hover:text-blue-600 transition-all duration-300 font-bold shadow-sm hover:shadow-md">1</a>
                            <?php if ($startPage > 2): ?>
                                <span class="text-slate-400 px-1 font-bold">...</span>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <?php if ($i === $page): ?>
                                <span class="flex items-center justify-center w-12 h-12 rounded-2xl bg-blue-600 text-white font-black shadow-lg shadow-blue-600/30">
                                    <?= $i ?>
                                </span>
                            <?php else: ?>
                                <a href="<?= getPageUrl($i, $catFilter, $search, $sort) ?>" 
                                   class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white border border-slate-200 text-slate-600 hover:border-blue-600 hover:text-blue-600 transition-all duration-300 font-bold shadow-sm hover:shadow-md">
                                    <?= $i ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($endPage < $totalPages): ?>
                            <?php if ($endPage < $totalPages - 1): ?>
                                <span class="text-slate-400 px-1 font-bold">...</span>
                            <?php endif; ?>
                            <a href="<?= getPageUrl($totalPages, $catFilter, $search, $sort) ?>" 
                               class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white border border-slate-200 text-slate-600 hover:border-blue-600 hover:text-blue-600 transition-all duration-300 font-bold shadow-sm hover:shadow-md"><?= $totalPages ?></a>
                        <?php endif; ?>

                        <!-- Next Page Link -->
                        <?php if ($page < $totalPages): ?>
                            <a href="<?= getPageUrl($page + 1, $catFilter, $search, $sort) ?>" 
                               class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white border border-slate-200 text-slate-600 hover:border-blue-600 hover:text-blue-600 transition-all duration-300 shadow-sm hover:shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        <?php else: ?>
                            <span class="flex items-center justify-center w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 text-slate-300 cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <!-- Footer Placeholder -->
    <div id="footer-placeholder"></div>

    <script src="js/main.js"></script>
</body>
</html>
