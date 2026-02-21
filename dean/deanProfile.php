<?php
$pageTitle = "Profile Settings";

// Example data (later from session or database)
$dean = [
    'full_name'   => 'Maria Santos',
    'email'       => 'maria.santos@university.edu.ph',
    'phone'       => '+63 917 555 0123',
    'position'    => 'Dean, College of Computer Studies',
    'department'  => 'College of Computer Studies',
    'avatar'      => null,   // null = show initials
];

$initials = strtoupper(substr($dean['full_name'], 0, 1) . substr(explode(' ', $dean['full_name'])[1] ?? '', 0, 1));
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($pageTitle) ?> - Theses Archiving System</title>
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/deanDashboard.css">
  <link rel="stylesheet" href="css/deanProfile.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="layout">

  <aside class="sidebar">
    <div class="sidebar-header">
      <h2>Theses Archive</h2>
      <p>Dean Portal</p>
    </div>
    <nav class="sidebar-nav">
      <a href="deanDashboard.php" class="nav-link">
        <i class="fas fa-home"></i> Dashboard
      </a>
      <a href="finalApproved.php" class="nav-link">
        <i class="fas fa-check-double"></i> Final Approval
      </a>
      <a href="deanProfile.php" class="nav-link active">
        <i class="fas fa-user"></i> Profile
      </a>
      <a href="#" class="nav-link">
        <i class="fas fa-chart-bar"></i> Reports
      </a>
      <div class="sidebar-divider">Settings</div>
      <div class="dark-mode-toggle">
        <span>Dark Mode</span>
        <input type="checkbox" id="darkmode" hidden />
        <label for="darkmode" class="toggle-label">
          <i class="fas fa-sun"></i>
          <i class="fas fa-moon"></i>
          <div class="slider"></div>
        </label>
      </div>
      <a href="logout.php" class="nav-link logout">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </nav>
  </aside>

  <main class="main-content">
    <header class="topbar">
      <h1>Profile Settings</h1>
      <div class="user-info">
        <div class="user-details">
          <span class="user-name">Dean <?= htmlspecialchars(explode(' ', $dean['full_name'])[0]) ?></span>
          <span class="user-role">Administrator</span>
        </div>
        <div class="avatar"><?= htmlspecialchars($initials) ?></div>
      </div>
    </header>

    <div class="profile-card">
      <div class="avatar-container">
        <?php if ($dean['avatar']): ?>
          <img src="<?= htmlspecialchars($dean['avatar']) ?>" alt="Profile" class="profile-avatar">
        <?php else: ?>
          <div class="profile-avatar initials"><?= htmlspecialchars($initials) ?></div>
        <?php endif; ?>
      </div>

      <h2 class="profile-name"><?= htmlspecialchars($dean['full_name']) ?></h2>

      <div class="profile-details">
        <div class="detail-item">
          <span class="label">Email</span>
          <span class="value"><?= htmlspecialchars($dean['email']) ?></span>
        </div>
        <div class="detail-item">
          <span class="label">Phone</span>
          <span class="value"><?= htmlspecialchars($dean['phone']) ?></span>
        </div>
        <div class="detail-item">
          <span class="label">Position</span>
          <span class="value"><?= htmlspecialchars($dean['position']) ?></span>
        </div>
        <div class="detail-item">
          <span class="label">Department / College</span>
          <span class="value"><?= htmlspecialchars($dean['department']) ?></span>
        </div>
      </div>

      <div class="action-area">
        <a href="editProfileDean.php" class="btn primary edit-btn">
          <i class="fas fa-edit"></i> Edit Profile
        </a>
      </div>
    </div>
  </main>
</div>

<script>
// Dark mode
const toggle = document.getElementById('darkmode');
if (localStorage.getItem('darkMode') === 'enabled') {
  document.body.classList.add('dark-mode');
  toggle.checked = true;
}
toggle.addEventListener('change', () => {
  if (toggle.checked) {
    document.body.classList.add('dark-mode');
    localStorage.setItem('darkMode', 'enabled');
  } else {
    document.body.classList.remove('dark-mode');
    localStorage.setItem('darkMode', 'disabled');
  }
});
</script>
</body>
</html>