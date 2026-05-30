<?php
require_once __DIR__ . '/db.php';
$pdo = getPDO();

$slug = trim($_GET['slug'] ?? '');
if ($slug === '') {
    header('Location: products.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT p.*, c.name AS category_name, c.slug AS category_slug
    FROM products p
    LEFT JOIN categories c ON c.id = p.category_id
    WHERE p.slug = ?
");
$stmt->execute([$slug]);
$product = $stmt->fetch();

if (!$product) {
    http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Not Found | MaasCure</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <div style="font-size:5rem;margin-bottom:16px">🔍</div>
        <h1 class="text-3xl font-black text-slate-800 mb-3">Product Not Found</h1>
        <p class="text-slate-500 mb-6">The product you're looking for doesn't exist.</p>
        <a href="products.php" class="px-8 py-3 bg-blue-600 text-white rounded-2xl font-bold inline-block">Browse Products</a>
    </div>
</body>
</html>
<?php 
    exit; 
}

// Fetch related products
$categoryId = $product['category_id'] ? (int)$product['category_id'] : 0;
$productId = (int)$product['id'];

$relatedProducts = [];
if ($categoryId > 0) {
    $relatedStmt = $pdo->prepare("
        SELECT p.*, c.name AS category_name
        FROM products p
        LEFT JOIN categories c ON c.id = p.category_id
        WHERE p.category_id = ? AND p.id != ?
        LIMIT 4
    ");
    $relatedStmt->execute([$categoryId, $productId]);
    $relatedProducts = $relatedStmt->fetchAll();
}

if (count($relatedProducts) < 4) {
    $excludeIds = [$productId];
    foreach ($relatedProducts as $rp) {
        $excludeIds[] = (int)$rp['id'];
    }
    $placeholders = implode(',', array_fill(0, count($excludeIds), '?'));
    $backfillLimit = 4 - count($relatedProducts);
    
    // In case the DB has fewer total products than the backfill limit, check total products count
    $totalCount = (int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    $actualLimit = min($backfillLimit, max(0, $totalCount - count($excludeIds)));
    
    if ($actualLimit > 0) {
        $backfillStmt = $pdo->prepare("
            SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            WHERE p.id NOT IN ($placeholders)
            LIMIT $actualLimit
        ");
        $backfillStmt->execute($excludeIds);
        $backfillProducts = $backfillStmt->fetchAll();
        $relatedProducts = array_merge($relatedProducts, $backfillProducts);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> | MaasCure Pharmaceutical</title>
    <meta name="description" content="<?= htmlspecialchars(substr($product['composition'] ?? $product['uses'] ?? '', 0, 160)) ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
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

    <!-- Page Hero / Breadcrumbs -->
    <section class="relative min-h-[50vh] flex items-center justify-center text-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="assets/products_hero.png" alt="Product Specification Hero" class="w-full h-full object-cover scale-110">
            <!-- Multi-layer overlay -->
            <div class="absolute inset-0 bg-gradient-to-b from-blue-950/80 via-blue-900/60 to-slate-900/40"></div>
            <div class="absolute inset-0" style="background: radial-gradient(circle at center, rgba(37,99,235,0.15) 0%, transparent 70%);"></div>
        </div>
        
        <div class="relative z-10 container mx-auto px-6 pt-32 pb-16 flex flex-col items-center">
            <!-- Breadcrumbs -->
            <nav class="flex items-center justify-center space-x-2 text-xs font-semibold text-slate-300 uppercase tracking-widest mb-6">
                <a href="index.html" class="hover:text-green-400 transition-colors">Home</a>
                <span class="text-slate-500">/</span>
                <a href="products.php" class="hover:text-green-400 transition-colors">Products</a>
                <?php if ($product['category_name']): ?>
                    <span class="text-slate-500">/</span>
                    <a href="products.php?cat=<?= $product['category_id'] ?>" class="hover:text-green-400 transition-colors"><?= htmlspecialchars($product['category_name']) ?></a>
                <?php endif; ?>
                <span class="text-slate-500">/</span>
                <span class="text-white"><?= htmlspecialchars($product['name']) ?></span>
            </nav>
            
            <h1 class="text-3xl sm:text-4xl md:text-6xl font-black text-white italic tracking-tight leading-none">
                Product <span class="text-green-400">Specification</span>
            </h1>
        </div>
    </section>
    
    <!-- Main Content Container -->
    <section class="py-12 md:py-20 bg-slate-50 relative overflow-hidden">
        <!-- Biological Background Watermarks (Absolute elements) -->
        <!-- Molecule 1 (Top Left) -->
        <svg class="absolute top-10 -left-16 w-96 h-96 text-blue-600/[0.02] pointer-events-none select-none z-0 hidden lg:block" viewBox="0 0 200 200" fill="currentColor">
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
        <svg class="absolute bottom-10 -right-20 w-[32rem] h-[32rem] text-emerald-500/[0.02] pointer-events-none select-none z-0 hidden lg:block" viewBox="0 0 200 200" fill="currentColor">
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

        <div class="container mx-auto px-6 relative z-10">
            
            <!-- Top Section: Image Gallery & Primary Details (7/5 Split) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start mb-16">
                
                <!-- Left Column: Gallery (7 Columns) -->
                <div class="lg:col-span-7">
                    <div class="bg-white rounded-3xl md:rounded-[2.5rem] p-4 sm:p-6 border border-slate-100 shadow-xl shadow-slate-100/50">
                        <!-- Gallery Thumbnails & Main Image Preparation -->
                        <?php
                        $additionalImages = [];
                        if (!empty($product['additional_images'])) {
                            $additionalImages = json_decode($product['additional_images'], true) ?: [];
                        }

                        // Determine primary display image
                        $mainImgSrc = $product['image'];
                        if (empty($mainImgSrc) && !empty($additionalImages)) {
                            $mainImgSrc = $additionalImages[0];
                        }

                        // Build full gallery array (main image at start if present)
                        $galleryImages = $additionalImages;
                        if ($product['image'] && !in_array($product['image'], $galleryImages)) {
                            array_unshift($galleryImages, $product['image']);
                        }
                        ?>

                        <div class="relative group rounded-3xl overflow-hidden bg-slate-50 border border-slate-100">
                            <?php if ($mainImgSrc): ?>
                                <img id="mainProductImg" 
                                     src="<?= htmlspecialchars($mainImgSrc) ?>" 
                                     alt="<?= htmlspecialchars($product['name']) ?>"
                                     class="w-full h-[24rem] md:h-[32rem] object-contain transition-all duration-300 p-6 hover:scale-[1.02] cursor-zoom-in">
                            <?php else: ?>
                                <div id="mainProductImgPlaceholder" class="w-full h-[24rem] md:h-[32rem] flex items-center justify-center bg-gradient-to-br from-blue-50 to-teal-50">
                                    <span style="font-size:8rem;">💊</span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($product['badge']): ?>
                                <div class="absolute top-6 right-6 bg-blue-600 text-white text-[10px] font-black px-5 py-2 rounded-full uppercase tracking-widest shadow-lg">
                                    <?= htmlspecialchars($product['badge']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Gallery Thumbnails Switcher Grid -->
                        <?php if (count($galleryImages) > 1): ?>
                            <div class="flex flex-wrap gap-3 mt-6 justify-center sm:justify-start">
                                <?php foreach ($galleryImages as $idx => $imgUrl): ?>
                                    <button onclick="changeMainImg('<?= htmlspecialchars($imgUrl) ?>', this)" 
                                            class="gallery-thumb-btn w-20 h-20 rounded-2xl overflow-hidden border-2 <?= ($imgUrl === $mainImgSrc) ? 'border-blue-600 shadow-md' : 'border-slate-100 hover:border-slate-300' ?> bg-slate-50 transition-all duration-300 focus:outline-none">
                                        <img src="<?= htmlspecialchars($imgUrl) ?>" class="w-full h-full object-cover">
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Column: Primary Details Card (5 Columns) -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-3xl md:rounded-[2.5rem] p-6 sm:p-8 md:p-10 border border-slate-100 shadow-xl shadow-slate-100/50 space-y-6">
                        <div>
                            <?php if ($product['category_name']): ?>
                                <span class="inline-block px-4 py-1.5 mb-3 bg-teal-50 text-teal-700 border border-teal-100 rounded-full text-xs font-black uppercase tracking-wider">
                                    <?= htmlspecialchars($product['category_name']) ?>
                                </span>
                            <?php endif; ?>
                            
                            <h2 class="text-3xl lg:text-4xl font-black text-slate-800 italic leading-tight mb-2 tracking-tight">
                                <?= htmlspecialchars($product['name']) ?>
                            </h2>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">MaasCure Clinical Portfolio</p>
                        </div>

                        <hr class="border-slate-100">

                        <?php if ($product['composition']): ?>
                            <div class="space-y-2">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Composition</h4>
                                <p class="text-slate-700 text-sm leading-relaxed font-semibold border-l-4 border-teal-500 pl-4 bg-slate-50 p-4 rounded-2xl">
                                    <?= nl2br(htmlspecialchars($product['composition'])) ?>
                                </p>
                            </div>
                        <?php endif; ?>

                        <?php if ($product['uses']): ?>
                            <div class="space-y-2">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Primary Indications</h4>
                                <p class="text-slate-600 text-sm leading-relaxed bg-slate-50 p-4 rounded-2xl">
                                    <?= nl2br(htmlspecialchars($product['uses'])) ?>
                                </p>
                            </div>
                        <?php endif; ?>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-2">
                            <?php if ($product['brochure']): ?>
                                <a href="<?= htmlspecialchars($product['brochure']) ?>" download 
                                   class="flex-1 py-4 bg-white border border-slate-200 hover:border-blue-600 hover:text-blue-600 text-slate-800 font-bold rounded-2xl transition-all uppercase text-xs tracking-widest text-center flex items-center justify-center gap-2 shadow-sm">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Brochure
                                </a>
                            <?php endif; ?>

                            <a href="contact.html?product=<?= urlencode($product['name']) ?>" 
                               class="flex-1 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-2xl transition-all uppercase text-xs tracking-widest text-center flex items-center justify-center gap-2 shadow-lg shadow-blue-600/20">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Inquiry
                            </a>
                        </div>

                        <!-- Trust Seals -->
                        <div class="grid grid-cols-3 gap-3 pt-4 border-t border-slate-100 text-center">
                            <div class="space-y-1 bg-slate-50 p-2.5 rounded-2xl border border-slate-100">
                                <div class="text-lg">🛡️</div>
                                <div class="text-[8px] font-black text-slate-400 uppercase tracking-wider leading-none">GMP Cert.</div>
                            </div>
                            <div class="space-y-1 bg-slate-50 p-2.5 rounded-2xl border border-slate-100">
                                <div class="text-lg">🧬</div>
                                <div class="text-[8px] font-black text-slate-400 uppercase tracking-wider leading-none">Tested</div>
                            </div>
                            <div class="space-y-1 bg-slate-50 p-2.5 rounded-2xl border border-slate-100">
                                <div class="text-lg">🔒</div>
                                <div class="text-[8px] font-black text-slate-400 uppercase tracking-wider leading-none">Safe Storage</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section: Detailed Specifications Tabs & Quick Inquiry Form (7/5 Split) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start pt-16 border-t border-slate-200/60">
                
                <!-- Left Column: Specs Tabs (7 Columns) -->
                <div class="lg:col-span-7 space-y-8">
                    <div class="bg-white rounded-3xl md:rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-100/50 p-6 sm:p-8 md:p-10">
                        <div class="flex border-b border-slate-100 mb-8 overflow-x-auto" id="productTabs" role="tablist">
                            <!-- Tab 1: Overview -->
                            <button class="tab-btn active py-4 px-6 font-bold text-xs uppercase tracking-wider text-blue-600 border-b-2 border-blue-600 transition-all focus:outline-none flex items-center gap-2 whitespace-nowrap" 
                                    onclick="switchTab(event, 'tab-indication')">
                                <span>💊</span> Specifications & Composition
                            </button>
                            
                            <!-- Tab 2: Dosage & Storage -->
                            <?php if ($product['dosage'] || $product['storage']): ?>
                            <button class="tab-btn py-4 px-6 font-bold text-xs uppercase tracking-wider text-slate-400 hover:text-slate-600 border-b-2 border-transparent hover:border-slate-200 transition-all focus:outline-none flex items-center gap-2 whitespace-nowrap" 
                                    onclick="switchTab(event, 'tab-admin')">
                                <span>⏱️</span> Dosage & Storage
                            </button>
                            <?php endif; ?>
                            
                            <!-- Tab 3: Safety & Origin -->
                            <?php if ($product['safety_information'] || $product['manufacturer_details']): ?>
                            <button class="tab-btn py-4 px-6 font-bold text-xs uppercase tracking-wider text-slate-400 hover:text-slate-600 border-b-2 border-transparent hover:border-slate-200 transition-all focus:outline-none flex items-center gap-2 whitespace-nowrap" 
                                    onclick="switchTab(event, 'tab-safety')">
                                <span>⚠️</span> Safety & Origin
                            </button>
                            <?php endif; ?>
                        </div>

                        <div class="tab-content-wrapper min-h-[16rem]">
                           <!-- Tab 1 Panel -->
                           <div id="tab-indication" class="tab-panel space-y-8 fade-in">
                               <?php if ($product['composition']): ?>
                               <div>
                                   <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Chemical Composition Details</h4>
                                   <p class="text-slate-700 text-sm leading-relaxed font-semibold bg-slate-50 p-5 rounded-2xl border border-slate-100">
                                       <?= nl2br(htmlspecialchars($product['composition'])) ?>
                                   </p>
                               </div>
                               <?php endif; ?>

                               <?php if ($product['uses']): ?>
                               <div>
                                   <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Indications & Clinical Uses</h4>
                                   <div class="text-slate-600 text-sm leading-relaxed bg-slate-50 p-5 rounded-2xl border border-slate-100 space-y-3">
                                       <?= nl2br(htmlspecialchars($product['uses'])) ?>
                                   </div>
                               </div>
                               <?php endif; ?>

                               <?php if (!$product['composition'] && !$product['uses']): ?>
                                   <p class="text-slate-400 text-sm italic">No specific indication parameters available.</p>
                               <?php endif; ?>
                           </div>

                           <!-- Tab 2 Panel -->
                           <div id="tab-admin" class="tab-panel hidden space-y-8 fade-in">
                               <?php if ($product['dosage']): ?>
                               <div>
                                   <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Dosage Guidelines</h4>
                                   <p class="text-slate-600 text-sm leading-relaxed bg-blue-50/20 p-5 rounded-2xl border border-blue-100/50 font-medium">
                                       <?= nl2br(htmlspecialchars($product['dosage'])) ?>
                                   </p>
                               </div>
                               <?php endif; ?>

                               <?php if ($product['storage']): ?>
                               <div>
                                   <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Storage Specifications</h4>
                                   <p class="text-slate-600 text-sm leading-relaxed bg-slate-50 p-5 rounded-2xl border border-slate-100">
                                       <?= nl2br(htmlspecialchars($product['storage'])) ?>
                                   </p>
                               </div>
                               <?php endif; ?>
                           </div>

                           <!-- Tab 3 Panel -->
                           <div id="tab-safety" class="tab-panel hidden space-y-8 fade-in">
                               <?php if ($product['safety_information']): ?>
                               <div class="p-5 rounded-2xl bg-amber-50/50 border border-amber-100 text-amber-900 text-sm">
                                   <h4 class="text-[10px] font-black text-amber-800 uppercase tracking-widest mb-3">⚠️ Safety Cautions & Warnings</h4>
                                   <div class="leading-relaxed font-medium">
                                       <?= nl2br(htmlspecialchars($product['safety_information'])) ?>
                                   </div>
                               </div>
                               <?php endif; ?>

                               <?php if ($product['manufacturer_details']): ?>
                               <div>
                                   <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Manufacturer Details</h4>
                                   <p class="text-slate-600 text-sm leading-relaxed bg-slate-50 p-5 rounded-2xl border border-slate-100">
                                       <?= nl2br(htmlspecialchars($product['manufacturer_details'])) ?>
                                   </p>
                               </div>
                               <?php endif; ?>
                           </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Quick Inquiry Sidebar Form (5 Columns) -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white rounded-3xl md:rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-100/50 p-6 sm:p-8 space-y-6">
                        <div>
                            <h3 class="text-xl font-black text-slate-800 italic">Quick <span class="text-blue-600">Inquiry</span></h3>
                            <p class="text-slate-400 text-[10px] font-bold leading-relaxed mt-1">Get immediate pricing, availability, and ordering documentation.</p>
                        </div>
                        
                        <form id="quick-inquiry-form" class="space-y-4">
                            <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']) ?>">
                            
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Full Name</label>
                                <input type="text" name="name" required placeholder="John Doe" 
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-100 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 rounded-xl text-xs font-semibold text-slate-700 placeholder-slate-300 transition-all duration-300">
                            </div>

                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Email</label>
                                <input type="email" name="email" required placeholder="john@example.com" 
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-100 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 rounded-xl text-xs font-semibold text-slate-700 placeholder-slate-300 transition-all duration-300">
                            </div>

                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Phone</label>
                                <input type="tel" name="phone" required placeholder="+91..." 
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-100 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 rounded-xl text-xs font-semibold text-slate-700 placeholder-slate-300 transition-all duration-300">
                            </div>

                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Message</label>
                                <textarea name="message" rows="3" required
                                          class="w-full px-4 py-3 bg-slate-50 border border-slate-100 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 rounded-xl text-xs font-semibold text-slate-700 placeholder-slate-300 transition-all duration-300">I am interested in inquiry details for: <?= htmlspecialchars($product['name']) ?>.</textarea>
                            </div>
                            
                            <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-black text-[10px] uppercase tracking-widest rounded-xl transition-all shadow-md shadow-blue-600/10 hover:shadow-lg hover:shadow-blue-600/20 duration-300">
                                Submit Inquiry
                            </button>
                        </form>
                        
                        <div id="quick-success-msg" class="hidden p-4 bg-green-50 text-green-700 rounded-2xl border border-green-100 flex items-start space-x-2 shadow-inner">
                            <div class="w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center shrink-0">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4" /></svg>
                            </div>
                            <div>
                                <div class="font-bold text-xs text-green-800">Sent Successfully!</div>
                                <p class="text-[10px] text-green-600 mt-0.5 leading-relaxed font-medium">Thank you. We will contact you soon.</p>
                            </div>
                        </div>

                        <a href="products.php" class="text-[10px] font-bold text-slate-400 hover:text-blue-600 uppercase tracking-widest transition-colors block text-center pt-2">
                            &larr; Browse All Products
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php if (!empty($relatedProducts)): ?>
    <!-- Related Products Section -->
    <section class="py-16 md:py-24 bg-white border-t border-slate-200/60 relative overflow-hidden">
        <!-- Biological Background Watermarks (Absolute elements) -->
        <!-- Molecule 3 (Middle Right) -->
        <svg class="absolute top-1/4 -right-10 w-80 h-80 text-blue-600/[0.02] pointer-events-none select-none z-0 hidden xl:block" viewBox="0 0 100 100" fill="currentColor">
            <path d="M10,20 Q30,5 50,20 T90,20" stroke="currentColor" stroke-width="1" fill="none"/>
            <path d="M10,40 Q30,55 50,40 T90,40" stroke="currentColor" stroke-width="1" fill="none"/>
            <line x1="20" y1="28" x2="20" y2="32" stroke="currentColor" stroke-width="1"/>
            <line x1="35" y1="18" x2="35" y2="42" stroke="currentColor" stroke-width="1"/>
            <line x1="50" y1="20" x2="50" y2="40" stroke="currentColor" stroke-width="1"/>
            <line x1="65" y1="28" x2="65" y2="32" stroke="currentColor" stroke-width="1"/>
            <line x1="80" y1="18" x2="80" y2="42" stroke="currentColor" stroke-width="1"/>
        </svg>
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-12">
                <h3 class="text-teal-500 font-black tracking-widest uppercase text-xs mb-3">Therapeutic Alternatives</h3>
                <h2 class="text-3xl md:text-5xl font-black text-slate-800 italic">Related <span class="text-blue-600">Products</span></h2>
                <div class="w-16 h-1 bg-blue-600 mx-auto rounded mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                <?php foreach ($relatedProducts as $idx => $rp): ?>
                <div class="reveal group bg-white rounded-2xl overflow-hidden hover:shadow-[0_15px_45px_rgba(37,99,235,0.07)] border border-slate-100 hover:border-blue-100 transition-all duration-500 transform hover:-translate-y-1.5 flex flex-col justify-between h-full" style="transition-delay: <?= ($idx % 4) * 100 ?>ms;">
                    <div>
                        <!-- Image Container with Padding and Light Grey Background -->
                        <div class="w-full aspect-[4/3] bg-slate-50/50 flex items-center justify-center p-5 relative overflow-hidden border-b border-slate-100/60">
                            <?php if ($rp['image']): ?>
                            <img src="<?= htmlspecialchars($rp['image']) ?>" alt="<?= htmlspecialchars($rp['name']) ?>"
                                class="max-w-full max-h-full object-contain transition-transform duration-500 group-hover:scale-105">
                            <?php else: ?>
                            <div class="w-full h-full bg-gradient-to-br from-blue-50 to-teal-50 flex items-center justify-center rounded-xl">
                                <span style="font-size:3rem;">💊</span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($rp['badge']): ?>
                            <div class="absolute top-4 right-4 bg-blue-600 text-white text-[9px] font-extrabold px-2.5 py-1 rounded-lg uppercase tracking-wider shadow-sm">
                                <?= htmlspecialchars($rp['badge']) ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Card Body -->
                        <div class="pt-5 px-5 pb-3">
                            <?php if ($rp['category_name']): ?>
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mb-1.5 block">
                                <?= htmlspecialchars($rp['category_name']) ?>
                            </span>
                            <?php endif; ?>
                            
                            <h4 class="text-base font-bold text-slate-800 mb-2.5 group-hover:text-blue-600 transition-colors line-clamp-1">
                                <?= htmlspecialchars($rp['name']) ?>
                            </h4>
                            
                            <?php if ($rp['composition']): ?>
                            <div class="space-y-0.5">
                                <span class="text-[9px] font-semibold text-slate-400 uppercase tracking-widest block">Composition</span>
                                <p class="text-slate-500 text-xs font-medium leading-relaxed line-clamp-2">
                                    <?= htmlspecialchars(substr($rp['composition'], 0, 75)) . (strlen($rp['composition']) > 75 ? '...' : '') ?>
                                </p>
                            </div>
                            <?php else: ?>
                            <p class="text-slate-400 text-xs leading-relaxed line-clamp-2">High-quality pharmaceutical solution.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- CTA Section -->
                    <div class="px-5 pb-5 pt-0">
                        <a href="product.php?slug=<?= urlencode($rp['slug']) ?>"
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
        </div>
    </section>
    <?php endif; ?>


        <!-- Footer Placeholder -->
    <div id="footer-placeholder"></div>

    <script src="js/main.js"></script>
    <script>
        // Gallery switcher function
        function changeMainImg(src, btn) {
            const mainImg = document.getElementById('mainProductImg');
            if (mainImg) {
                mainImg.style.opacity = '0';
                setTimeout(() => {
                    mainImg.src = src;
                    mainImg.style.opacity = '1';
                }, 150);
            }
            
            document.querySelectorAll('.gallery-thumb-btn').forEach(el => {
                el.classList.remove('border-blue-600', 'shadow-md');
                el.classList.add('border-slate-100');
            });
            btn.classList.remove('border-slate-100');
            btn.classList.add('border-blue-600', 'shadow-md');
        }

        // Tabs switcher function
        function switchTab(evt, tabId) {
            document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.add('hidden'));
            document.getElementById(tabId).classList.remove('hidden');
            
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active', 'text-blue-600', 'border-blue-600');
                btn.classList.add('text-slate-400', 'border-transparent');
            });
            
            const currentBtn = evt.currentTarget;
            currentBtn.classList.remove('text-slate-400', 'border-transparent');
            currentBtn.classList.add('active', 'text-blue-600', 'border-blue-600');
        }

        // Quick inquiry form handle
        document.addEventListener('DOMContentLoaded', () => {
            const quickForm = document.getElementById('quick-inquiry-form');
            const quickSuccess = document.getElementById('quick-success-msg');
            if (quickForm) {
                quickForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    
                    const formData = new FormData(quickForm);
                    
                    fetch('submit-enquiry.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            quickForm.classList.add('hidden');
                            quickSuccess.classList.remove('hidden');
                        } else {
                            alert(data.errors ? data.errors.join("\n") : (data.error || 'Submission failed.'));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('An unexpected error occurred. Please try again.');
                    });
                });
            }
        });
    </script>
</body>
</html>
