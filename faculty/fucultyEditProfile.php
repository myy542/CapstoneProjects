<?php
$pageTitle = "Edit Profile";

// Demo data (replace with database later)
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
  <link rel="stylesheet" href="css/facultyProfileEdit.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="layout">

  <!-- Sidebar -->
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
      <h1>Edit Profile</h1>
      <div class="user-info">
        <span class="user-name">Dr. Anna Reyes</span>
        <div class="avatar"><?= htmlspecialchars($initials) ?></div>
      </div>
    </header>

    <div class="profile-card edit-card">
      <h2 class="form-title">Update Your Information</h2>

      <form action="" method="post" enctype="multipart/form-data">
        <div class="avatar-upload-section">
          <label>Profile Picture</label>
          <div class="current-avatar" id="preview-container">
            <?php if ($faculty['avatar']): ?>
              <img src="<?= htmlspecialchars($faculty['avatar']) ?>" alt="">
            <?php else: ?>
              <div class="avatar-placeholder"><?= htmlspecialchars($initials) ?></div>
            <?php endif; ?>
          </div>
          <input type="file" id="avatar" name="avatar" accept="image/*" hidden>
          <button type="button" class="btn secondary" onclick="document.getElementById('avatar').click()">
            <i class="fas fa-upload"></i> Choose New Photo
          </button>
          <p class="help-text">JPG or PNG • max 2 MB • recommended 200×200 px</p>
        </div>

        <div class="form-grid">
          <div class="field">
            <label>Full Name</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($faculty['full_name']) ?>" required>
          </div>
          <div class="field">
            <label>Email Address</label>
            <input type="email" name="email" value="<?= htmlspecialchars($faculty['email']) ?>" required>
          </div>
          <div class="field">
            <label>Phone Number</label>
            <input type="tel" name="phone" value="<?= htmlspecialchars($faculty['phone']) ?>">
          </div>
          <div class="field">
            <label>Position / Title</label>
            <input type="text" name="position" value="<?= htmlspecialchars($faculty['position']) ?>" required>
          </div>
          <div class="field full-width">
            <label>Department / College</label>
            <input type="text" name="department" value="<?= htmlspecialchars($faculty['department']) ?>" required>
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
  </main>
</div>

<script>
// Dark mode
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

// Live avatar preview
document.getElementById('avatar').addEventListener('change', function(e) {
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