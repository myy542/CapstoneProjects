<?php
session_start();
require_once __DIR__ . "/../admin/config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../authentication/login.php");
    exit;
}

$user_id = (int)$_SESSION["user_id"];

$stmt = $conn->prepare("SELECT first_name, last_name FROM user_table WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    session_destroy();
    header("Location: ../authentication/login.php");
    exit;
}

$first = trim($user["first_name"] ?? "");
$last  = trim($user["last_name"] ?? "");

$displayName = trim($first . " " . $last);
$initials = "";

if ($first && $last) {
    $initials = strtoupper($first[0] . $last[0]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thesis Archive - Dashboard</title>
  <link rel="stylesheet" href="css/base.css?v=<?= time() ?>">
  <link rel="stylesheet" href="css/student_dashboard.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="layout">

  <aside class="sidebar">
    <div class="sidebar-header">
      <div class="logo-wrapper">
        <div class="logo">TAP</div>
        <span>ARCHIVE</span>
      </div>
      <p>Student Portal</p>
    </div>

    <nav class="sidebar-nav">
      <a href="student_dashboard.php" class="nav-link active">
        <i class="fas fa-home"></i> Dashboard
      </a>
      <a href="projects.php" class="nav-link">
        <i class="fas fa-folder"></i> My Projects
      </a>
      <a href="#" class="nav-link">
        <i class="fas fa-comment-dots"></i> Feedback <span class="badge">4</span>
      </a>
      <div class="sidebar-section-title">RESOURCES</div>
      <a href="#" class="nav-link">
        <i class="fas fa-book-open"></i> Guidelines
      </a>
      <a href="#" class="nav-link">
        <i class="fas fa-cog"></i> Settings
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
      <a href="../authentication/logout.php" class="nav-link logout">
        <i class="fas fa-sign-out-alt"></i> Sign Out
      </a>
    </div>
  </aside>

  <main class="main-content">

    <header class="welcome-header">
      <h1>Welcome back, <?= htmlspecialchars($displayName) ?></h1>
      <div class="student-id-container">
        <span class="notification-bell"><i class="fas fa-bell"></i><sup>2</sup></span>
        STUDENT ID <strong>DU</strong> #2024-002
      </div>
    </header>

    <section class="project-hub">
      <h2>Project Hub</h2>
      <p class="subtitle">Track your academic progress and thesis milestones.</p>

      <div class="hub-grid">
        <!-- Center - Big Progress Card -->
        <div class="project-main-card">
          <div class="progress-circle-wrapper">
            <div class="progress-circle">
              <svg viewBox="0 0 140 140">
                <circle class="bg" cx="70" cy="70" r="62"></circle>
                <circle class="fg" cx="70" cy="70" r="62"></circle>
              </svg>
              <div class="progress-text">
                <span>70</span>
                <small>COMPLETE</small>
              </div>
            </div>
          </div>

          <div class="project-text-content">
            <h3>Deep Learning in Urban Traffic</h3>
            <div class="final-status">FINAL THESIS SUBMISSION</div>
            <p>Your project is currently in the final review stage. Please check for feedback.</p>

            <div class="action-tags">
              <span class="tag high">PRIORITY: HIGH</span>
              <span class="tag due">DUE: MAY 12</span>
            </div>
          </div>
        </div>

        <!-- Right - Supervisor Card -->
        <div class="supervisor-card">
          <div class="supervisor-avatar">AV</div>
          <div class="supervisor-name">Dr. Alistair Vance</div>
          <div class="supervisor-role">Head Research Coordinator</div>
          <button class="btn send-message">SEND MESSAGE</button>
        </div>
      </div>

      <button class="btn upload-btn">+ Upload New Thesis</button>
    </section>

    <div class="records-deadlines-grid">
      <div class="card historical">
        <div class="card-header">
          <h3>Historical Records</h3>
          <a href="#" class="view-all">VIEW ALL →</a>
        </div>
        <table class="records-table">
          <thead>
            <tr>
              <th>TITLE</th>
              <th>STATUS</th>
              <th>SCORE</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Cybersecurity Protocols<br><small>Submitted Feb 10, 2024</small></td>
              <td><span class="status verified">Verified</span></td>
              <td>A+</td>
            </tr>
            <tr>
              <td>Ethical AI Frameworks<br><small>Submitted Jan 14, 2024</small></td>
              <td><span class="status action">Action Req.</span></td>
              <td>N/A</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="card deadlines">
        <div class="card-header">
          <h3>DEADLINES</h3>
        </div>
        <div class="deadline-item">
          <span class="date">24</span>
          <div>
            <strong>Proposal Defense</strong>
            <small>Main Auditorium • 10:00 AM</small>
          </div>
        </div>
        <div class="deadline-item">
          <span class="date">05</span>
          <div>
            <strong>First Draft Due</strong>
            <small>Digital Submission Portal</small>
          </div>
        </div>
      </div>
    </div>

  </main>
</div>

<script>
// Dark mode toggle (unchanged)
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