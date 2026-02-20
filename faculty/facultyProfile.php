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
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/facultyProfile.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="layout">

  <aside class="sidebar">
    <div class="sidebar-header">
      <h2>Theses Archive</h2>
      <p>Faculty Portal</p>
    </div>

    <nav class="sidebar-nav">
      <a href="facultyDashboard.php" class="nav-link">
        <i class="fas fa-home"></i> Dashboard
      </a>
      <a href="facultyProfile.php" class="nav-link active">
        <i class="fas fa-user-circle"></i> Profile
      </a>
      <a href="reviewThesis.php" class="nav-link">
        <i class="fas fa-book-reader"></i> Review Theses
      </a>
      <a href="facultyFeedback.php" class="nav-link">
        <i class="fas fa-comment-dots"></i> My Feedback
      </a>
      <a href="#" class="nav-link">
        <i class="fas fa-calendar-check"></i> Schedule
      </a>
      <a href="#" class="nav-link">
        <i class="fas fa-chart-line"></i> Statistics
      </a>
    </nav>

    <div class="sidebar-footer">
      <div class="theme-toggle">
        <input type="checkbox" id="darkmode" />
        <label for="darkmode" class="toggle-label">
          <i class="fas fa-sun"></i>
          <i class="fas fa-moon"></i>
          <span class="slider"></span>
        </label>
      </div>
      <a href="../logout.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </aside>

  <main class="main-content">
    <header class="topbar">
      <h1>My Profile</h1>
      <div class="user-info">
        <span class="user-name">Dr. Anna Reyes</span>
        <div class="avatar"><?= htmlspecialchars($initials) ?></div>
      </div>
    </header>

    <div class="profile-card">
      <div class="avatar-section">
        <?php if ($faculty['avatar']): ?>
          <img src="<?= htmlspecialchars($faculty['avatar']) ?>" alt="Profile Photo">
        <?php else: ?>
          <div class="avatar-placeholder"><?= htmlspecialchars($initials) ?></div>
        <?php endif; ?>
      </div>

      <h2 class="profile-name"><?= htmlspecialchars($faculty['full_name']) ?></h2>

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
          <span class="label">Department / College</span>
          <span class="value"><?= htmlspecialchars($faculty['department']) ?></span>
        </div>
      </div>

      <div class="profile-actions">
        <a href="facultyEditProfile.php" class="btn primary">
          <i class="fas fa-edit"></i> Edit Profile
        </a>
      </div>
    </div>
  </main>
</div>

<script>
const toggle = document.getElementById('darkmode');
if (toggle) {
  if (localStorage.getItem('darkMode') === 'true') {
    toggle.checked = true;
    document.body.classList.add('dark-mode');
  }
  toggle.addEventListener('change', () => {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', toggle.checked);
  });
}
</script>
</body>
</html>