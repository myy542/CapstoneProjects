<?php
$pageTitle = "My Profile";

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
    <link rel="stylesheet" href="css/facultyProfile.css?v=<?= time() ?>">
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
            <a href="facultyProfile.php" class="nav-link active">
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
            <h1>My Profile</h1>
            <div class="student-id-container">
                <span class="notification-bell"><i class="fas fa-bell"></i><sup>2</sup></span>
                FACULTY ID <strong>FU</strong> #2024-001
            </div>
        </header>

        <section class="profile-section">
            <div class="profile-card">
                <div class="profile-header">
                    <?php if ($faculty['avatar']): ?>
                        <img src="<?= htmlspecialchars($faculty['avatar']) ?>" class="big-avatar" alt="Profile">
                    <?php else: ?>
                        <div class="big-avatar-placeholder"><?= htmlspecialchars($initials) ?></div>
                    <?php endif; ?>
                </div>

                <h1 class="profile-name"><?= htmlspecialchars($faculty['full_name']) ?></h1>

                <div class="profile-details">
                    <div class="detail-row">
                        <span class="label">Email</span>
                        <span class="value"><?= htmlspecialchars($faculty['email']) ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Phone</span>
                        <span class="value"><?= htmlspecialchars($faculty['phone']) ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Position</span>
                        <span class="value"><?= htmlspecialchars($faculty['position']) ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Department</span>
                        <span class="value"><?= htmlspecialchars($faculty['department']) ?></span>
                    </div>
                </div>

                <div class="profile-actions">
                    <a href="facultyEditProfile.php" class="btn primary">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                </div>
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
</script>
</body>
</html>