<?php
$pageTitle = "Edit Profile";

// Example current data
$dean = [
    'full_name'   => 'Maria Santos',
    'email'       => 'maria.santos@university.edu.ph',
    'phone'       => '+63 917 555 0123',
    'position'    => 'Dean, College of Computer Studies',
    'department'  => 'College of Computer Studies',
    'avatar'      => null,
];

$initials = strtoupper(substr($dean['full_name'], 0, 1) . substr(explode(' ', $dean['full_name'])[1] ?? '', 0, 1));

// Handle form submission (demo - add real save later)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Here you would:
    // 1. Validate data
    // 2. Handle file upload if any
    // 3. Save to database
    // 4. Redirect back
    header("Location: deanProfile.php?updated=1");
    exit;
}
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
<link rel="stylesheet" href="css/editprofiledean.css"> <!-- overrides + form styles -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="layout">

  <aside class="sidebar">
    <!-- same sidebar as deanProfile.php -->
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
      <h1>Edit Profile</h1>
      <div class="user-info">
        <div class="user-details">
          <span class="user-name">Dean <?= htmlspecialchars(explode(' ', $dean['full_name'])[0]) ?></span>
          <span class="user-role">Administrator</span>
        </div>
        <div class="avatar"><?= htmlspecialchars($initials) ?></div>
      </div>
    </header>

    <div class="profile-card edit-mode">

      <h2 class="form-title">Update Your Information</h2>

      <form action="" method="post" enctype="multipart/form-data">

        <div class="avatar-upload-section">
          <label class="upload-label">Profile Picture</label>
          <div class="current-avatar">
            <?php if ($dean['avatar']): ?>
              <img src="<?= htmlspecialchars($dean['avatar']) ?>" alt="">
            <?php else: ?>
              <div class="avatar-placeholder"><?= htmlspecialchars($initials) ?></div>
            <?php endif; ?>
          </div>
          <input type="file" id="avatar" name="avatar" accept="image/*" hidden>
          <button type="button" class="btn secondary choose-file-btn" onclick="document.getElementById('avatar').click()">
            <i class="fas fa-upload"></i> Choose New Photo
          </button>
          <p class="photo-info">Recommended: JPG, PNG • max 2 MB • 200×200 px</p>
        </div>

        <div class="form-fields">
          <div class="field-group">
            <label>Full Name</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($dean['full_name']) ?>" required>
          </div>

          <div class="field-group">
            <label>Email Address</label>
            <input type="email" name="email" value="<?= htmlspecialchars($dean['email']) ?>" required>
          </div>

          <div class="field-group">
            <label>Phone Number</label>
            <input type="tel" name="phone" value="<?= htmlspecialchars($dean['phone']) ?>">
          </div>

          <div class="field-group">
            <label>Position / Title</label>
            <input type="text" name="position" value="<?= htmlspecialchars($dean['position']) ?>" required>
          </div>

          <div class="field-group">
            <label>Department / College</label>
            <input type="text" name="department" value="<?= htmlspecialchars($dean['department']) ?>" required>
          </div>
        </div>

        <div class="form-buttons">
          <button type="submit" class="btn primary save-btn">
            <i class="fas fa-save"></i> Save Changes
          </button>
          <a href="deanProfile.php" class="btn cancel-btn">Cancel</a>
        </div>

      </form>
    </div>
  </main>
</div>

<script>
// Dark mode (same as other pages)
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