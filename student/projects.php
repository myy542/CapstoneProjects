<?php
session_start();
require_once __DIR__ . "/../admin/config.php";

$fullName = "";
$initials = "";

if (isset($_SESSION["user_id"])) {

    $user_id = (int)$_SESSION["user_id"];

    $stmt = $conn->prepare("SELECT first_name, last_name FROM user_table WHERE user_id = ? LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($user) {
        $fullName = trim($user["first_name"] . " " . $user["last_name"]);

        $fi = strtoupper(substr($user["first_name"], 0, 1));
        $li = strtoupper(substr($user["last_name"], 0, 1));
        $initials = $fi . $li;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Projects - Theses Archiving System</title>
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/projects.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<div class="layout">

  <aside class="sidebar">
    <div class="sidebar-header">
      <h2>Theses Archive</h2>
      <p>Student Portal</p>
    </div>

    <nav class="sidebar-nav">
      <a href="student_dashboard.php" class="nav-link">
        <i class="fas fa-home"></i> Dashboard
      </a>
      <a href="profile.php" class="nav-link">
        <i class="fas fa-user"></i> Profile
      </a>
      <a href="projects.php" class="nav-link active">
        <i class="fas fa-folder-open"></i> My Projects
      </a>
      <a href="submission.php" class="nav-link">
                <i class="fas fa-upload"></i> Submit Thesis
            </a>
      <a href="archived.php" class="nav-link">
        <i class="fas fa-archive"></i> Archived Theses
      </a>
      <a href="notifications.php" class="nav-link">
        <i class="fas fa-bell"></i> Notifications
      </a>
    </nav>

    <div class="sidebar-footer">
      <a href="logout.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </aside>

  <main class="main-content">

    <header class="topbar">
      <h1>My Current Projects</h1>
      <div class="user-info">
        <span class="user-name"><?= htmlspecialchars($fullName) ?></span>
        <div class="avatar"><?= htmlspecialchars($initials) ?></div>
      </div>

    </header>

    <div class="projects-container">

      <div class="project-card">
        <div class="project-header">
          <span class="status status-active">Active – Revision Stage</span>
        </div>

        <div class="project-progress">
          <div class="progress-label">Overall Progress</div>
          <div class="progress-bar">
            <div class="progress-fill" style="width: 82%;"></div>
          </div>
          <div class="progress-percentage">82%</div>
        </div>

        <div class="project-meta">
          <div><strong>Adviser:</strong> Dr. Anna Reyes</div>
          <div><strong>Started:</strong> August 2025</div>
          <div><strong>Last update:</strong> February 07, 2026</div>
        </div>

      </div>

    </div>

  </main>

</div>

</body>
</html>