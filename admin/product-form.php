<?php
require_once __DIR__ . '/auth.php';
requireAdmin();
require_once __DIR__ . '/../db.php';
$pdo = getPDO();

// Load existing product for editing
$product = null;
$editId  = (int)($_GET['id'] ?? 0);
if ($editId > 0) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
    $stmt->execute([$editId]);
    $product = $stmt->fetch();
    if (!$product) { header('Location: products.php'); exit; }
}

// Fetch categories
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

// Handle form submit
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id   = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');

    if ($name === '') $errors[] = 'Product name is required.';

    if (empty($errors)) {
        $slug    = generateSlug($name);
        $slug    = uniqueSlug($pdo, 'products', $slug, $id);
        $catId   = (int)($_POST['category_id'] ?? 0) ?: null;
        $badge   = trim($_POST['badge'] ?? '') ?: null;
        $fields  = [
            'composition', 'uses', 'dosage',
            'safety_information', 'storage', 'manufacturer_details'
        ];
        $data = [];
        foreach ($fields as $f) $data[$f] = trim($_POST[$f] ?? '') ?: null;

        // Handle image upload
        $imagePath = $product['image'] ?? null;
        if (!empty($_FILES['image']['name'])) {
            $ext  = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','webp','gif'];
            if (!in_array($ext, $allowed)) {
                $errors[] = 'Image must be JPG, PNG, WEBP, or GIF.';
            } else {
                $filename   = $slug . '_' . time() . '.' . $ext;
                $uploadPath = __DIR__ . '/../uploads/products/' . $filename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $imagePath = 'uploads/products/' . $filename;
                } else {
                    $errors[] = 'Failed to upload image. Check folder permissions.';
                }
            }
        }

        // Handle brochure upload
        $brochurePath = $product['brochure'] ?? null;
        if (!empty($_FILES['brochure']['name'])) {
            $ext2 = strtolower(pathinfo($_FILES['brochure']['name'], PATHINFO_EXTENSION));
            if ($ext2 !== 'pdf') {
                $errors[] = 'Brochure must be a PDF file.';
            } else {
                $fname2     = $slug . '_brochure_' . time() . '.pdf';
                $bPath      = __DIR__ . '/../uploads/brochures/' . $fname2;
                if (move_uploaded_file($_FILES['brochure']['tmp_name'], $bPath)) {
                    $brochurePath = 'uploads/brochures/' . $fname2;
                } else {
                    $errors[] = 'Failed to upload brochure.';
                }
            }
        }

        // Handle additional images upload
        $existingAdditional = json_decode($_POST['existing_additional_images'] ?? '[]', true) ?: [];
        $uploadedAdditional = [];
        if (!empty($_FILES['additional_images']['name'][0])) {
            $files = $_FILES['additional_images'];
            $count = count($files['name']);
            for ($i = 0; $i < $count; $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
                    $allowed = ['jpg','jpeg','png','webp','gif'];
                    if (!in_array($ext, $allowed)) {
                        $errors[] = 'Additional image must be JPG, PNG, WEBP, or GIF.';
                    } else {
                        $filename = $slug . '_gallery_' . $i . '_' . time() . '.' . $ext;
                        $uploadPath = __DIR__ . '/../uploads/products/' . $filename;
                        if (move_uploaded_file($files['tmp_name'][$i], $uploadPath)) {
                            $uploadedAdditional[] = 'uploads/products/' . $filename;
                        } else {
                            $errors[] = 'Failed to upload additional image: ' . htmlspecialchars($files['name'][$i]);
                        }
                    }
                }
            }
        }
        $finalAdditional = array_merge($existingAdditional, $uploadedAdditional);
        $additionalImagesJSON = count($finalAdditional) > 0 ? json_encode($finalAdditional) : null;

        if (empty($errors)) {
            if ($id > 0) {
                $pdo->prepare("
                    UPDATE products SET
                        category_id=?, name=?, slug=?, image=?, additional_images=?,
                        composition=?, uses=?, dosage=?,
                        safety_information=?, storage=?,
                        manufacturer_details=?, brochure=?, badge=?
                    WHERE id=?
                ")->execute([
                    $catId, $name, $slug, $imagePath, $additionalImagesJSON,
                    $data['composition'], $data['uses'], $data['dosage'],
                    $data['safety_information'], $data['storage'],
                    $data['manufacturer_details'], $brochurePath, $badge,
                    $id
                ]);
                header('Location: products.php?flash=Product+updated+successfully.&type=success');
            } else {
                $pdo->prepare("
                    INSERT INTO products
                        (category_id, name, slug, image, additional_images, composition, uses, dosage,
                         safety_information, storage, manufacturer_details, brochure, badge)
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)
                ")->execute([
                    $catId, $name, $slug, $imagePath, $additionalImagesJSON,
                    $data['composition'], $data['uses'], $data['dosage'],
                    $data['safety_information'], $data['storage'],
                    $data['manufacturer_details'], $brochurePath, $badge
                ]);
                header('Location: products.php?flash=Product+created+successfully.&type=success');
            }
            exit;
        }
    }

    // Keep entered values on error
    $product = array_merge($product ?? [], $_POST);
}

$isEdit = isset($product['id']);
$pageTitle = $isEdit ? 'Edit Product' : 'Add Product';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> | MaasCure Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<?php require_once __DIR__ . '/partials/sidebar.php'; ?>

<div class="admin-main">
    <div class="admin-topbar">
        <div>
            <div class="topbar-title"><?= $pageTitle ?></div>
            <div class="topbar-breadcrumb">Admin → Products → <?= $pageTitle ?></div>
        </div>
        <a href="products.php" class="btn btn-ghost">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Products
        </a>
    </div>

    <div class="admin-content">
        <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $e): ?>
            <div>⚠️ <?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= $product['id'] ?>">
            <?php endif; ?>

            <div style="display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start;">

                <!-- Left Column -->
                <div style="display:flex;flex-direction:column;gap:20px;">

                    <!-- Basic Info -->
                    <div class="card">
                        <div class="card-header"><span class="card-title">Basic Information</span></div>
                        <div class="card-body">
                            <div class="grid-2">
                                <div class="form-group">
                                    <label class="form-label">Product Name <span class="required">*</span></label>
                                    <input type="text" name="name" id="productName" class="form-control"
                                        placeholder="e.g. MaasCure Advance Tablets"
                                        value="<?= htmlspecialchars($product['name'] ?? '') ?>" required>
                                    <div class="slug-preview" id="slugPreview" style="margin-top:8px;<?= empty($product['slug']) ? 'display:none' : '' ?>">
                                        🔗 <?= htmlspecialchars($product['slug'] ?? '') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Category</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">— No Category —</option>
                                        <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" <?= ($product['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['name']) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Composition</label>
                                <textarea name="composition" class="form-control form-control-textarea"
                                    placeholder="e.g. Paracetamol 500mg, Ibuprofen 200mg"><?= htmlspecialchars($product['composition'] ?? '') ?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Uses</label>
                                <textarea name="uses" class="form-control form-control-textarea"
                                    placeholder="What this medication is used for..."><?= htmlspecialchars($product['uses'] ?? '') ?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Dosage</label>
                                <textarea name="dosage" class="form-control form-control-textarea"
                                    placeholder="e.g. Adults: 1 tablet twice daily after meals..."><?= htmlspecialchars($product['dosage'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Safety & Storage -->
                    <div class="card">
                        <div class="card-header"><span class="card-title">Safety & Storage</span></div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">Safety Information</label>
                                <textarea name="safety_information" class="form-control form-control-textarea"
                                    placeholder="Warnings, contraindications, side effects..."><?= htmlspecialchars($product['safety_information'] ?? '') ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Storage</label>
                                <textarea name="storage" class="form-control form-control-textarea" style="min-height:80px"
                                    placeholder="e.g. Store below 25°C in a dry place, away from sunlight."><?= htmlspecialchars($product['storage'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Manufacturer -->
                    <div class="card">
                        <div class="card-header"><span class="card-title">Manufacturer Details</span></div>
                        <div class="card-body">
                            <div class="form-group" style="margin-bottom:0">
                                <textarea name="manufacturer_details" class="form-control form-control-textarea"
                                    placeholder="Manufactured by MaasCure Pharmaceutical Pvt. Ltd., Bangalore, Karnataka - 560032. Drug Lic. No.: ..."><?= htmlspecialchars($product['manufacturer_details'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column -->
                <div style="display:flex;flex-direction:column;gap:20px;">

                    <!-- Product Image -->
                    <div class="card">
                        <div class="card-header"><span class="card-title">Product Image</span></div>
                        <div class="card-body">
                            <div class="file-upload-area" id="imageUploadArea">
                                <input type="file" name="image" id="imageInput" accept="image/*" onchange="previewImage(this)">
                                <div id="imageUploadContent">
                                    <div class="file-upload-icon">🖼️</div>
                                    <div class="file-upload-text">
                                        <strong>Click to upload</strong> or drag & drop<br>
                                        <span style="font-size:11px;color:#94a3b8;">JPG, PNG, WEBP · Max 5MB</span>
                                    </div>
                                </div>
                            </div>
                            <div class="image-preview" id="imagePreview" style="<?= !empty($product['image']) ? 'display:block' : '' ?>">
                                <img id="previewImg"
                                    src="<?= !empty($product['image']) ? '../' . htmlspecialchars($product['image']) : '' ?>"
                                    alt="Preview">
                                <div style="font-size:11px;color:#94a3b8;margin-top:6px;" id="previewFileName">
                                    <?= !empty($product['image']) ? basename($product['image']) : '' ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Images -->
                    <div class="card">
                        <div class="card-header"><span class="card-title">Additional Images (Gallery)</span></div>
                        <div class="card-body">
                            <div class="file-upload-area" id="additionalImagesArea" style="margin-bottom:12px;">
                                <input type="file" name="additional_images[]" id="additionalImagesInput" accept="image/*" multiple onchange="previewAdditionalImages(this)">
                                <div id="additionalImagesContent">
                                    <div class="file-upload-icon">📸</div>
                                    <div class="file-upload-text">
                                        <strong>Click to upload multiple</strong> or drag & drop<br>
                                        <span style="font-size:11px;color:#94a3b8;">JPG, PNG, WEBP · Multiple Select</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Preview area -->
                            <div id="additionalImagesPreview" style="display:flex;flex-wrap:wrap;gap:10px;">
                                <?php 
                                $existingAdditional = [];
                                if (!empty($product['additional_images'])) {
                                    $existingAdditional = json_decode($product['additional_images'], true) ?: [];
                                }
                                ?>
                                <?php foreach ($existingAdditional as $idx => $imgUrl): ?>
                                    <div class="additional-img-thumb" style="position:relative;width:70px;height:70px;border-radius:10px;overflow:hidden;border:1px solid #e2e8f0;background:#f8fafc;" data-path="<?= htmlspecialchars($imgUrl) ?>">
                                        <img src="../<?= htmlspecialchars($imgUrl) ?>" style="width:100%;height:100%;object-fit:cover;">
                                        <button type="button" onclick="removeExistingImage(this, '<?= htmlspecialchars($imgUrl) ?>')" style="position:absolute;top:2px;right:2px;background:rgba(239,68,68,0.9);color:white;border:none;border-radius:50%;width:18px;height:18px;font-size:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;line-height:1;">×</button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <!-- Hidden input to track current state of existing images -->
                            <input type="hidden" name="existing_additional_images" id="existingAdditionalImagesInput" value="<?= htmlspecialchars(json_encode($existingAdditional)) ?>">
                        </div>
                    </div>

                    <!-- Brochure -->
                    <div class="card">
                        <div class="card-header"><span class="card-title">Download Brochure (PDF)</span></div>
                        <div class="card-body">
                            <?php if (!empty($product['brochure'])): ?>
                            <div style="margin-bottom:12px;padding:10px 14px;background:#f0fdf4;border-radius:10px;border:1px solid #bbf7d0;display:flex;align-items:center;gap:10px;">
                                <span style="font-size:20px;">📄</span>
                                <div>
                                    <div style="font-size:13px;font-weight:600;color:#166534;">Current Brochure</div>
                                    <a href="../<?= htmlspecialchars($product['brochure']) ?>" target="_blank" style="font-size:11px;color:#14b8a6;">
                                        <?= basename($product['brochure']) ?>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="file-upload-area">
                                <input type="file" name="brochure" accept=".pdf" onchange="showBrochureName(this)">
                                <div class="file-upload-icon">📄</div>
                                <div class="file-upload-text">
                                    <strong>Upload PDF</strong><br>
                                    <span style="font-size:11px;color:#94a3b8;" id="brochureFileName">
                                        <?= !empty($product['brochure']) ? 'Replace existing PDF' : 'No file selected' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Badge -->
                    <div class="card">
                        <div class="card-header"><span class="card-title">Badge / Label</span></div>
                        <div class="card-body">
                            <div class="form-group" style="margin-bottom:0">
                                <label class="form-label">Badge Text <span class="text-muted text-sm">(optional)</span></label>
                                <input type="text" name="badge" class="form-control"
                                    placeholder="e.g. Best Seller, New, Featured"
                                    value="<?= htmlspecialchars($product['badge'] ?? '') ?>">
                                <div class="form-hint">Shown as a label on the product card.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary" style="width:100%;padding:14px;font-size:15px;">
                        <?= $isEdit ? '💾 Save Changes' : '✨ Create Product' ?>
                    </button>

                    <?php if ($isEdit): ?>
                    <a href="products.php" class="btn btn-ghost" style="width:100%;justify-content:center;">Cancel</a>
                    <?php endif; ?>

                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Slug preview
const productName = document.getElementById('productName');
const slugPreview = document.getElementById('slugPreview');
productName.addEventListener('input', () => {
    const slug = productName.value.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/[\s-]+/g, '-')
        .replace(/^-+|-+$/g, '');
    if (slug) {
        slugPreview.style.display = 'inline-block';
        slugPreview.textContent = '🔗 ' + slug;
    } else {
        slugPreview.style.display = 'none';
    }
});

// Image preview
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewFileName').textContent = input.files[0].name;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Preview multiple newly selected additional images
function previewAdditionalImages(input) {
    const previewContainer = document.getElementById('additionalImagesPreview');
    const tempPreviews = previewContainer.querySelectorAll('.temp-preview');
    tempPreviews.forEach(el => el.remove());

    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = e => {
                const wrapper = document.createElement('div');
                wrapper.className = 'additional-img-thumb temp-preview';
                wrapper.style.position = 'relative';
                wrapper.style.width = '70px';
                wrapper.style.height = '70px';
                wrapper.style.borderRadius = '10px';
                wrapper.style.overflow = 'hidden';
                wrapper.style.border = '1px solid #3b82f6';
                wrapper.style.background = '#f8fafc';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                
                const label = document.createElement('div');
                label.textContent = 'New';
                label.style.position = 'absolute';
                label.style.bottom = '0';
                label.style.left = '0';
                label.style.right = '0';
                label.style.background = 'rgba(59,130,246,0.9)';
                label.style.color = 'white';
                label.style.fontSize = '8px';
                label.style.textAlign = 'center';
                label.style.fontWeight = 'bold';
                label.style.padding = '2px 0';
                
                wrapper.appendChild(img);
                wrapper.appendChild(label);
                previewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    }
}

// Remove an existing gallery image
function removeExistingImage(button, imagePath) {
    const wrapper = button.closest('.additional-img-thumb');
    if (wrapper) {
        wrapper.remove();
        
        const keptInput = document.getElementById('existingAdditionalImagesInput');
        let keptImages = JSON.parse(keptInput.value || '[]');
        keptImages = keptImages.filter(path => path !== imagePath);
        keptInput.value = JSON.stringify(keptImages);
    }
}

// Brochure name
function showBrochureName(input) {
    if (input.files && input.files[0]) {
        document.getElementById('brochureFileName').textContent = '📄 ' + input.files[0].name;
    }
}

// Drag over effect
const uploadArea = document.getElementById('imageUploadArea');
if (uploadArea) {
    uploadArea.addEventListener('dragover', e => { e.preventDefault(); uploadArea.classList.add('drag-over'); });
    uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('drag-over'));
    uploadArea.addEventListener('drop', e => { e.preventDefault(); uploadArea.classList.remove('drag-over'); });
}
</script>
</body>
</html>
