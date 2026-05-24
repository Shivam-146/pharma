<?php
require_once __DIR__ . '/auth.php';
requireAdmin();
require_once __DIR__ . '/../db.php';
$pdo = getPDO();

$flash = isset($_GET['flash']) ? ['type' => $_GET['type'] ?? 'info', 'msg' => $_GET['flash']] : null;

// Fetch categories for filter
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

// Filter
$catFilter = (int)($_GET['cat'] ?? 0);
$search    = trim($_GET['q'] ?? '');

$where = ['1=1'];
$params = [];

if ($catFilter > 0) {
    $where[] = 'p.category_id = ?';
    $params[] = $catFilter;
}
if ($search !== '') {
    $where[] = 'p.name LIKE ?';
    $params[] = '%' . $search . '%';
}

$sql = "SELECT p.*, c.name AS category_name
        FROM products p
        LEFT JOIN categories c ON c.id = p.category_id
        WHERE " . implode(' AND ', $where) . "
        ORDER BY p.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | MaasCure Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<?php require_once __DIR__ . '/partials/sidebar.php'; ?>

<div class="admin-main">
    <div class="admin-topbar">
        <div>
            <div class="topbar-title">Products</div>
            <div class="topbar-breadcrumb">Admin → Products</div>
        </div>
        <a href="product-form.php" class="btn btn-primary">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Add Product
        </a>
    </div>

    <div class="admin-content">
        <?php if ($flash): ?>
        <div class="alert alert-<?= htmlspecialchars($flash['type']) ?>">
            <?= htmlspecialchars($flash['msg']) ?>
        </div>
        <?php endif; ?>

        <!-- Filters -->
        <form method="GET" class="card mb-6" style="padding:16px 20px;">
            <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
                <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="🔍 Search products..." class="form-control" style="flex:1;min-width:180px;margin-bottom:0;">
                <select name="cat" class="form-control" style="width:200px;margin-bottom:0;">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $catFilter == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="products.php" class="btn btn-ghost">Clear</a>
            </div>
        </form>

        <!-- Table -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">All Products</span>
                <span class="badge badge-teal"><?= count($products) ?> results</span>
            </div>
            <div class="table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Slug</th>
                            <th>Badge</th>
                            <th>Brochure</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="8" style="text-align:center;padding:40px;color:#94a3b8;">
                                No products found.
                                <a href="product-form.php" style="color:#14b8a6;font-weight:600;margin-left:6px;">Add your first product →</a>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($products as $p): ?>
                        <tr>
                            <td>
                                <?php if ($p['image']): ?>
                                <img src="../<?= htmlspecialchars($p['image']) ?>" class="table-image" alt="">
                                <?php else: ?>
                                <div class="table-image" style="background:#f1f5f9;display:flex;align-items:center;justify-content:center;color:#cbd5e1;font-size:20px;">📦</div>
                                <?php endif; ?>
                            </td>
                            <td class="fw-700" style="max-width:180px;">
                                <?= htmlspecialchars($p['name']) ?>
                            </td>
                            <td>
                                <?php if ($p['category_name']): ?>
                                <span class="badge badge-blue"><?= htmlspecialchars($p['category_name']) ?></span>
                                <?php else: ?>
                                <span class="text-muted text-sm">—</span>
                                <?php endif; ?>
                            </td>
                            <td><code style="font-size:11px;background:#f1f5f9;padding:2px 7px;border-radius:6px;"><?= htmlspecialchars($p['slug']) ?></code></td>
                            <td>
                                <?php if ($p['badge']): ?>
                                <span class="badge badge-orange"><?= htmlspecialchars($p['badge']) ?></span>
                                <?php else: ?>—<?php endif; ?>
                            </td>
                            <td>
                                <?php if ($p['brochure']): ?>
                                <a href="../<?= htmlspecialchars($p['brochure']) ?>" target="_blank" class="badge badge-teal" style="text-decoration:none;">📄 PDF</a>
                                <?php else: ?>—<?php endif; ?>
                            </td>
                            <td class="text-muted text-sm"><?= date('d M Y', strtotime($p['created_at'])) ?></td>
                            <td>
                                <div class="flex gap-3">
                                    <a href="../product.php?slug=<?= urlencode($p['slug']) ?>" target="_blank" class="btn btn-ghost btn-sm" title="View">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        View
                                    </a>
                                    <a href="product-form.php?id=<?= $p['id'] ?>" class="btn btn-ghost btn-sm">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                    <button onclick="confirmDelete(<?= $p['id'] ?>, '<?= htmlspecialchars($p['name'], ENT_QUOTES) ?>')" class="btn btn-danger btn-sm">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-title">Delete Product?</div>
        <div class="modal-body" id="deleteMsg"></div>
        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal()">Cancel</button>
            <form method="POST" action="delete-product.php" style="display:inline">
                <input type="hidden" name="id" id="deleteId">
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('deleteId').value = id;
    document.getElementById('deleteMsg').textContent = `Permanently delete "${name}"? This cannot be undone.`;
    document.getElementById('deleteModal').classList.add('open');
}
function closeModal() { document.getElementById('deleteModal').classList.remove('open'); }
document.getElementById('deleteModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeModal(); });
</script>
</body>
</html>
