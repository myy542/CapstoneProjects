<?php
$pageTitle = "Edit Profile";

$faculty = [
    'full_name'   => 'Dr. Anna Reyes',
    'email'       => 'anna.reyes@university.edu.ph',
    'phone'       => '+63 917 123 4567',
    'position'    => 'Associate Professor',
    'department'  => 'College of Computer Studies',
    'avatar'      => null,
];

$initials = strtoupper(
    substr($faculty['full_name'], 0, 1) .
    substr(explode(' ', $faculty['full_name'])[1] ?? '', 0, 1)
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= htmlspecialchars($pageTitle) ?> - Theses Archiving System</title>
    <link rel="stylesheet" href="css/base.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/facultyProfileEdit.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="layout">

    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-wrapper">
                <div class="logo">TAP</div>
                <span>ARCHIVE</span>
            </div>
            <p>Faculty Portal</p>
        </div>

        <nav class="sidebar-nav">
            <a href="facultyDashboard.php" class="nav-link">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="facultyProfile.php" class="nav-link">
                <i class="fas fa-user"></i> Profile
            </a>
            <a href="reviewThesis.php" class="nav-link">
                <i class="fas fa-book-reader"></i> Review Theses
            </a>
            <a href="facultyFeedback.php" class="nav-link">
                <i class="fas fa-comment-dots"></i> My Feedback
            </a>
            <a href="logout.php" class="nav-link logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="theme-toggle">
                <input type="checkbox" id="darkmode" />
                <label for="darkmode" class="toggle-label">
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </aside>

    <main class="main-content">

        <header class="welcome-header">
            <h1>Edit Profile</h1>
            <div class="student-id-container">
                <span class="notification-bell"><i class="fas fa-bell"></i><sup>2</sup></span>
                FACULTY ID <strong>FU</strong> #2024-001
            </div>
        </header>

        <section class="edit-section">
            <div class="profile-card edit-card">

                <div class="avatar-upload-section">
                    <div class="current-avatar" id="preview-container">
                        <?php if ($faculty['avatar']): ?>
                            <img src="<?= htmlspecialchars($faculty['avatar']) ?>" alt="Profile">
                        <?php else: ?>
                            <div class="avatar-placeholder"><?= htmlspecialchars($initials) ?></div>
                        <?php endif; ?>
                    </div>
                    <label for="avatar" class="btn btn-secondary" style="display:inline-block;">
                        <i class="fas fa-upload"></i> Choose New Photo
                    </label>
                    <input type="file" id="avatar" name="avatar" accept="image/*" hidden>
                    <p class="help-text">Supported formats: JPG, PNG (max 2MB)</p>
                </div>

                <form class="edit-form" method="post" action="">
                    <div class="form-grid">
                        <div class="field">
                            <label for="full_name">Full Name</label>
                            <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($faculty['full_name']) ?>" required>
                        </div>
                        <div class="field">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($faculty['email']) ?>" required>
                        </div>
                        <div class="field">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($faculty['phone']) ?>">
                        </div>
                        <div class="field">
                            <label for="position">Position</label>
                            <input type="text" id="position" name="position" value="<?= htmlspecialchars($faculty['position']) ?>" required>
                        </div>
                        <div class="field full-span">
                            <label for="department">Department / College</label>
                            <input type="text" id="department" name="department" value="<?= htmlspecialchars($faculty['department']) ?>" required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                        <a href="facultyProfile.php" class="btn secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </section>

    </main>
</div>

<script>
const toggle = document.getElementById('darkmode');
if (toggle) {
    toggle.addEventListener('change', () => {
        document.body.classList.toggle('dark-mode');
        localStorage.setItem('darkMode', toggle.checked);
    });
    if (localStorage.getItem('darkMode') === 'true') {
        toggle.checked = true;
        document.body.classList.add('dark-mode');
    }
}

// Live avatar preview
document.getElementById('avatar')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('preview-container').innerHTML = 
                `<img src="${ev.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
        };
        reader.readAsDataURL(file);
    }
});
</script>
</body>
</html>