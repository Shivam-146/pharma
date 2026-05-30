<?php
require_once __DIR__ . '/auth.php';
requireAdmin();
require_once __DIR__ . '/../db.php';
$pdo = getPDO();

$flash = isset($_GET['flash']) ? ['type' => $_GET['type'] ?? 'info', 'msg' => $_GET['flash']] : null;

// Filters
$statusFilter = $_GET['status'] ?? '';
$search       = trim($_GET['q'] ?? '');

$where = ['1=1'];
$params = [];

$allowedStatuses = ['New', 'Contacted', 'Completed'];
if (in_array($statusFilter, $allowedStatuses)) {
    $where[] = 'status = ?';
    $params[] = $statusFilter;
}

if ($search !== '') {
    $where[] = '(name LIKE ? OR email LIKE ? OR phone LIKE ? OR message LIKE ? OR product_name LIKE ?)';
    $like = '%' . $search . '%';
    $params = array_merge($params, [$like, $like, $like, $like, $like]);
}

$sql = "SELECT * FROM inquiries 
        WHERE " . implode(' AND ', $where) . "
        ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$inquiries = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Enquiries | MaasCure Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        .badge-new { background: rgba(245,158,11,.10); color: #d97706; }
        .badge-contacted { background: rgba(37,99,235,.10); color: #2563eb; }
        .badge-completed { background: rgba(34,197,94,.10); color: #16a34a; }
    </style>
</head>
<body>

<?php require_once __DIR__ . '/partials/sidebar.php'; ?>

<div class="admin-main">
    <div class="admin-topbar">
        <div>
            <div class="topbar-title">Customer Enquiries</div>
            <div class="topbar-breadcrumb">Admin → Enquiries</div>
        </div>
    </div>

    <div class="admin-content">
        <?php if ($flash): ?>
        <div class="alert alert-<?= htmlspecialchars($flash['type']) ?>">
            <?= htmlspecialchars($flash['msg']) ?>
        </div>
        <?php endif; ?>

        <!-- Filters Form -->
        <form method="GET" class="card mb-6" style="padding:16px 20px;">
            <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
                <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="🔍 Search inquiries (name, email, phone, msg)..." class="form-control" style="flex:1;min-width:260px;margin-bottom:0;">
                <select name="status" class="form-control" style="width:180px;margin-bottom:0;">
                    <option value="">All Statuses</option>
                    <option value="New" <?= $statusFilter === 'New' ? 'selected' : '' ?>>New</option>
                    <option value="Contacted" <?= $statusFilter === 'Contacted' ? 'selected' : '' ?>>Contacted</option>
                    <option value="Completed" <?= $statusFilter === 'Completed' ? 'selected' : '' ?>>Completed</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="inquiries.php" class="btn btn-ghost">Clear</a>
            </div>
        </form>

        <!-- Enquiries List -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">All Customer Enquiries</span>
                <span class="badge badge-teal"><?= count($inquiries) ?> enquiries</span>
            </div>
            <div class="table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Contact Person</th>
                            <th>Product Reference</th>
                            <th>Message Preview</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($inquiries)): ?>
                        <tr>
                            <td colspan="6" style="text-align:center;padding:40px;color:#94a3b8;">
                                No customer enquiries found matching your filters.
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($inquiries as $inq): ?>
                        <?php 
                        $statusClass = 'badge-new';
                        if ($inq['status'] === 'Contacted') $statusClass = 'badge-contacted';
                        if ($inq['status'] === 'Completed') $statusClass = 'badge-completed';
                        ?>
                        <tr>
                            <td class="text-muted text-sm whitespace-nowrap">
                                <?= date('d M Y H:i', strtotime($inq['created_at'])) ?>
                            </td>
                            <td style="max-width:200px;">
                                <div class="fw-700 text-slate-800"><?= htmlspecialchars($inq['name']) ?></div>
                                <div class="text-muted text-xs"><?= htmlspecialchars($inq['email']) ?></div>
                                <div class="text-slate-500 text-xs mt-0.5"><?= htmlspecialchars($inq['phone']) ?></div>
                            </td>
                            <td>
                                <?php if ($inq['product_name']): ?>
                                <span class="badge badge-blue font-bold"><?= htmlspecialchars($inq['product_name']) ?></span>
                                <?php else: ?>
                                <span class="text-muted text-xs italic">General Enquiry</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-sm text-slate-600" style="max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                <?= htmlspecialchars($inq['message']) ?>
                            </td>
                            <td>
                                <span class="badge <?= $statusClass ?>"><?= htmlspecialchars($inq['status']) ?></span>
                            </td>
                            <td>
                                <div class="flex gap-3">
                                    <button onclick="viewEnquiry(<?= htmlspecialchars(json_encode($inq)) ?>)" class="btn btn-ghost btn-sm">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        View Details
                                    </button>
                                    <button onclick="confirmDelete(<?= $inq['id'] ?>, '<?= htmlspecialchars($inq['name'], ENT_QUOTES) ?>')" class="btn btn-danger btn-sm">
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

<!-- Details View Modal -->
<div class="modal-overlay" id="detailsModal">
    <div class="modal" style="max-width: 580px;">
        <div class="modal-title" style="border-bottom:1px solid #e2e8f0;padding-bottom:14px;margin-bottom:18px;display:flex;justify-content:between;align-items:center;">
            <span>Enquiry Details</span>
            <span class="badge" id="modalStatusBadge" style="font-size:11px;">Status</span>
        </div>
        <div class="modal-body" style="font-size:14px;color:#334155;margin-bottom:20px;max-height:60vh;overflow-y:auto;text-align:left;">
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px;">
                <div>
                    <div style="font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">Customer Name</div>
                    <div style="font-weight:700;font-size:15px;color:#0f172a;" id="modalName">Name</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">Date Submitted</div>
                    <div style="font-weight:500;color:#0f172a;" id="modalDate">Date</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">Email Address</div>
                    <div style="font-weight:600;"><a href="" id="modalEmail" class="text-blue-600 hover:underline">email</a></div>
                </div>
                <div>
                    <div style="font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">Phone Number</div>
                    <div style="font-weight:600;color:#0f172a;" id="modalPhone">Phone</div>
                </div>
            </div>

            <div style="margin-bottom:18px;padding:12px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
                <div style="font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Product Reference</div>
                <div id="modalProduct" style="font-weight:700;color:#0f172a;">None</div>
            </div>

            <div style="margin-bottom:24px;">
                <div style="font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Message / Enquiry Content</div>
                <div style="background:#f1f5f9;padding:16px;border-radius:12px;white-space:pre-wrap;font-family:inherit;line-height:1.6;color:#1e293b;border:1px solid #e2e8f0;" id="modalMessage">
                    Message
                </div>
            </div>

            <hr style="border-color:#e2e8f0;margin-bottom:18px;">

            <div>
                <div style="font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;">Update Enquiry Status</div>
                <form method="POST" action="update-inquiry-status.php" style="display:flex;gap:10px;align-items:center;">
                    <input type="hidden" name="id" id="statusInquiryId">
                    <select name="status" id="modalStatusSelect" class="form-control" style="margin-bottom:0;width:180px;">
                        <option value="New">New</option>
                        <option value="Contacted">Contacted</option>
                        <option value="Completed">Completed</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm" style="padding:10px 16px;">Update Status</button>
                </form>
            </div>

        </div>
        <div class="modal-footer" style="border-top:1px solid #e2e8f0;padding-top:14px;">
            <button class="btn btn-ghost" onclick="closeDetailsModal()">Close</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-title">Delete Enquiry?</div>
        <div class="modal-body" id="deleteMsg">Are you sure you want to delete this enquiry?</div>
        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeDeleteModal()">Cancel</button>
            <form method="POST" action="delete-inquiry.php" style="display:inline">
                <input type="hidden" name="id" id="deleteId">
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </form>
        </div>
    </div>
</div>

<script>
// Details View Modal
function viewEnquiry(inq) {
    document.getElementById('modalName').textContent = inq.name;
    document.getElementById('modalDate').textContent = new Date(inq.created_at).toLocaleString('en-US', {
        day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
    });
    
    const emailLink = document.getElementById('modalEmail');
    emailLink.textContent = inq.email;
    emailLink.href = 'mailto:' + inq.email;
    
    document.getElementById('modalPhone').textContent = inq.phone;
    
    const modalProduct = document.getElementById('modalProduct');
    if (inq.product_name) {
        modalProduct.textContent = inq.product_name;
        modalProduct.className = "text-blue-600 font-bold";
    } else {
        modalProduct.textContent = "General Enquiry (No specific product)";
        modalProduct.className = "text-slate-400 italic font-normal";
    }
    
    document.getElementById('modalMessage').textContent = inq.message;
    document.getElementById('statusInquiryId').value = inq.id;
    document.getElementById('modalStatusSelect').value = inq.status;
    
    // Status Badge Styling in Modal
    const badge = document.getElementById('modalStatusBadge');
    badge.textContent = inq.status;
    badge.className = 'badge';
    if (inq.status === 'New') badge.classList.add('badge-new');
    if (inq.status === 'Contacted') badge.classList.add('badge-contacted');
    if (inq.status === 'Completed') badge.classList.add('badge-completed');

    document.getElementById('detailsModal').classList.add('open');
}

function closeDetailsModal() {
    document.getElementById('detailsModal').classList.remove('open');
}

// Delete Confirmation Modal
function confirmDelete(id, name) {
    document.getElementById('deleteId').value = id;
    document.getElementById('deleteMsg').textContent = `Permanently delete enquiry from "${name}"? This cannot be undone.`;
    document.getElementById('deleteModal').classList.add('open');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('open');
}

// Close modals when clicking outside
document.getElementById('detailsModal').addEventListener('click', e => {
    if (e.target === e.currentTarget) closeDetailsModal();
});
document.getElementById('deleteModal').addEventListener('click', e => {
    if (e.target === e.currentTarget) closeDeleteModal();
});
</script>
</body>
</html>
