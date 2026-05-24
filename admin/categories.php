<?php
require_once __DIR__ . '/auth.php';
requireAdmin();
require_once __DIR__ . '/../db.php';

$pdo = getPDO();
$flash = '';

// Handle Add / Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $id   = (int)($_POST['id'] ?? 0);

    if ($name !== '') {
        $slug = generateSlug($name);
        $slug = uniqueSlug($pdo, 'categories', $slug, $id);

        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE categories SET name=?, slug=? WHERE id=?");
            $stmt->execute([$name, $slug, $id]);
            $flash = ['type' => 'success', 'msg' => 'Category updated successfully.'];
        } else {
            $stmt = $pdo->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
            $stmt->execute([$name, $slug]);
            $flash = ['type' => 'success', 'msg' => 'Category created successfully.'];
        }
    } else {
        $flash = ['type' => 'danger', 'msg' => 'Category name is required.'];
    }
    header('Location: categories.php?flash=' . urlencode($flash['msg']) . '&type=' . $flash['type']);
    exit;
}

// Read flash from redirect
if (isset($_GET['flash'])) {
    $flash = ['type' => $_GET['type'] ?? 'info', 'msg' => $_GET['flash']];
}

// Fetch edit record
$editRecord = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id=?");
    $stmt->execute([(int)$_GET['edit']]);
    $editRecord = $stmt->fetch();
}

// List all categories with product count
$categories = $pdo->query("
    SELECT c.*, COUNT(p.id) AS product_count
    FROM categories c
    LEFT JOIN products p ON p.category_id = c.id
    GROUP BY c.id
    ORDER BY c.created_at DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories | MaasCure Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<?php require_once __DIR__ . '/partials/sidebar.php'; ?>

<div class="admin-main">
    <!-- Top Bar -->
    <div class="admin-topbar">
        <div>
            <div class="topbar-title">Categories</div>
            <div class="topbar-breadcrumb">Admin → Categories</div>
        </div>
        <a href="?add=1" class="btn btn-primary">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Add Category
        </a>
    </div>

    <div class="admin-content">
        <?php if ($flash): ?>
        <div class="alert alert-<?= htmlspecialchars($flash['type']) ?>">
            <?= htmlspecialchars($flash['msg']) ?>
        </div>
        <?php endif; ?>

        <div style="display:grid;grid-template-columns:1fr 360px;gap:24px;align-items:start;">

            <!-- Categories Table -->
            <div class="card">
                <div class="card-header">
                    <span class="card-title">All Categories</span>
                    <span class="badge badge-teal"><?= count($categories) ?> total</span>
                </div>
                <div class="table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Products</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($categories)): ?>
                            <tr>
                                <td colspan="6" style="text-align:center;padding:32px;color:#94a3b8;">
                                    No categories yet. Add your first one →
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($categories as $i => $cat): ?>
                            <tr>
                                <td class="text-muted text-sm"><?= $i + 1 ?></td>
                                <td class="fw-700"><?= htmlspecialchars($cat['name']) ?></td>
                                <td><code style="font-size:12px;background:#f1f5f9;padding:2px 8px;border-radius:6px;"><?= htmlspecialchars($cat['slug']) ?></code></td>
                                <td>
                                    <span class="badge <?= $cat['product_count'] > 0 ? 'badge-teal' : 'badge-gray' ?>">
                                        <?= $cat['product_count'] ?>
                                    </span>
                                </td>
                                <td class="text-muted text-sm"><?= date('d M Y', strtotime($cat['created_at'])) ?></td>
                                <td>
                                    <div class="flex gap-3">
                                        <a href="?edit=<?= $cat['id'] ?>" class="btn btn-ghost btn-sm">
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </a>
                                        <button onclick="confirmDelete(<?= $cat['id'] ?>, '<?= htmlspecialchars($cat['name'], ENT_QUOTES) ?>')" class="btn btn-danger btn-sm">
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

            <!-- Add / Edit Form -->
            <div class="card">
                <div class="card-header">
                    <span class="card-title"><?= $editRecord ? 'Edit Category' : 'Add Category' ?></span>
                    <?php if ($editRecord): ?>
                    <a href="categories.php" class="btn btn-ghost btn-sm">Cancel</a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <?php if ($editRecord): ?>
                        <input type="hidden" name="id" value="<?= $editRecord['id'] ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="form-label">
                                Category Name <span class="required">*</span>
                            </label>
                            <input
                                type="text"
                                name="name"
                                id="catName"
                                class="form-control"
                                placeholder="e.g. Tablets, Syrups, Injectables"
                                value="<?= htmlspecialchars($editRecord['name'] ?? '') ?>"
                                required
                                autocomplete="off"
                            >
                            <div class="slug-preview" id="slugPreview" style="margin-top:8px;<?= !$editRecord ? 'display:none' : '' ?>">
                                🔗 <?= $editRecord ? htmlspecialchars($editRecord['slug']) : '' ?>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%;">
                            <?= $editRecord ? 'Update Category' : 'Create Category' ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirm Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-title">Delete Category?</div>
        <div class="modal-body" id="deleteMsg">This will unlink all products from this category. Are you sure?</div>
        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal()">Cancel</button>
            <form method="POST" action="delete-category.php" style="display:inline">
                <input type="hidden" name="id" id="deleteId">
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </form>
        </div>
    </div>
</div>

<script>
// Slug preview
const catName = document.getElementById('catName');
const slugPreview = document.getElementById('slugPreview');
catName.addEventListener('input', () => {
    const slug = catName.value.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/[\s-]+/g,'-').replace(/^-+|-+$/g,'');
    if (slug) {
        slugPreview.style.display = 'inline-block';
        slugPreview.textContent = '🔗 ' + slug;
    } else {
        slugPreview.style.display = 'none';
    }
});

function confirmDelete(id, name) {
    document.getElementById('deleteId').value = id;
    document.getElementById('deleteMsg').textContent = `Delete category "${name}"? Products in this category will be unlinked.`;
    document.getElementById('deleteModal').classList.add('open');
}
function closeModal() {
    document.getElementById('deleteModal').classList.remove('open');
}
document.getElementById('deleteModal').addEventListener('click', e => {
    if (e.target === e.currentTarget) closeModal();
});
</script>
</body>
</html>
