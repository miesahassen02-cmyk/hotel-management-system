<?php
require_once __DIR__ . '/../includes/auth.php';
requireRole('customer');
require_once __DIR__ . '/../config/db.php';

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$userId]);
$user = $stmt->fetch();

$uploadDir = __DIR__ . '/../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$profileFilename = null;
foreach (glob($uploadDir . 'profile_' . $userId . '.*') as $existingFile) {
    $profileFilename = basename($existingFile);
    break;
}
$profileImageUrl = $profileFilename ? SITE_URL . 'uploads/' . $profileFilename : SITE_URL . 'assets/images/avatar-placeholder.svg';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['profile_image']['tmp_name']) && is_uploaded_file($_FILES['profile_image']['tmp_name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed, true)) {
            $uploadedName = 'profile_' . $userId . '.' . $ext;
            $targetPath = $uploadDir . $uploadedName;
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetPath);
            $profileFilename = $uploadedName;
            $profileImageUrl = SITE_URL . 'uploads/' . $profileFilename;
            $success = 'Profile image updated successfully.';
        } else {
            $error = 'Only JPG, PNG, GIF, or WEBP images are allowed.';
        }
    }
    $stmt = $pdo->prepare('UPDATE users SET full_name = ?, email = ?, phone = ? WHERE id = ?');
    $stmt->execute([$_POST['full_name'], $_POST['email'], $_POST['phone'], $userId]);
    $success = isset($success) ? $success : 'Profile updated.';
    $user['full_name'] = $_POST['full_name'];
    $user['email'] = $_POST['email'];
    $user['phone'] = $_POST['phone'];
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <div class="col-md-9">
        <div class="profile-card card p-4">
            <form method="post" enctype="multipart/form-data" class="row gy-4">
                <div class="row g-4 align-items-center">
                    <div class="col-md-3 text-center">
                        <div class="profile-avatar mb-3">
                            <img id="profilePreview" src="<?php echo htmlspecialchars($profileImageUrl); ?>" alt="Profile picture">
                        </div>
                        <label class="form-label fw-semibold" for="profileImageInput">Upload Photo</label>
                        <input class="form-control form-control-sm" type="file" id="profileImageInput" name="profile_image" accept="image/*">
                    </div>
                    <div class="col-md-9">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h2>Profile</h2>
                                <p class="text-muted">Use the form to update your account details and optionally choose a profile image.</p>
                            </div>
                        </div>
                        <?php if (!empty($success)): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
                        <?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
                        <div class="row gy-3">
                            <div class="col-md-6"><label class="form-label">Full Name</label><input class="form-control" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>"></div>
                            <div class="col-md-6"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"></div>
                            <div class="col-md-6"><label class="form-label">Phone</label><input class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"></div>
                        </div>
                        <div class="mt-4"><button class="btn btn-primary">Update Profile</button></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
