<?php
session_start();
require_once __DIR__ . "/../admin/config.php";

if (!isset($_SESSION["user_id"])) {
  header("Location: ../authentication/login.php");
  exit;
}

$user_id = (int)$_SESSION["user_id"]; // this is the logged-in user_id

// ===== USER TOPBAR (latest) =====
$stmt = $conn->prepare("SELECT first_name, last_name, username FROM user_table WHERE user_id=? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$u = $stmt->get_result()->fetch_assoc();
$stmt->close();

$fullName = trim(($u["first_name"] ?? "") . " " . ($u["last_name"] ?? ""));
if ($fullName === "") $fullName = $u["username"] ?? "User";

$fi = strtoupper(substr(($u["first_name"] ?? $fullName), 0, 1));
$li = strtoupper(substr(($u["last_name"] ?? $fullName), 0, 1));
$initials = trim($fi . $li);

// ===== UNREAD NOTIF COUNT =====
$unreadCount = 0;
$stmt = $conn->prepare("SELECT COUNT(*) AS c FROM notification_table WHERE user_id=? AND status='unread'");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$unreadCount = (int)($stmt->get_result()->fetch_assoc()["c"] ?? 0);
$stmt->close();

// ===== FETCH ARCHIVED THESES from thesis_table =====
// IMPORTANT: archived is based on status column
$archived = [];
$stmt = $conn->prepare("
  SELECT thesis_id, title, abstract, adviser, file_path, date_submitted, status
  FROM thesis_table
  WHERE student_id = ?
    AND LOWER(status) = 'archived'
  ORDER BY date_submitted DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
  $archived[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Archived Theses - Theses Archiving System</title>
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/archived.css">
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
        <a href="projects.php" class="nav-link">
          <i class="fas fa-folder-open"></i> My Projects
        </a>
        <a href="submission.php" class="nav-link">
                <i class="fas fa-upload"></i> Submit Thesis
            </a>
        <a href="archived.php" class="nav-link active">
          <i class="fas fa-archive"></i> Archived Theses
        </a>
        <a href="notifications.php" class="nav-link">
          <i class="fas fa-bell"></i> Notifications
          <?php if ($unreadCount > 0): ?>
            <span class="badge"><?= (int)$unreadCount ?></span>
          <?php endif; ?>
        </a>
      </nav>

      <div class="sidebar-footer">
        <a href="../authentication/logout.php" class="logout-btn">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </aside>

    <main class="main-content">
      <header class="topbar">
        <h1>Archived Theses</h1>

        <div class="user-info">
          <span class="user-name"><?= htmlspecialchars($fullName) ?></span>
          <div class="avatar"><?= htmlspecialchars($initials) ?></div>
        </div>
      </header>

      <div class="archived-container">

        <?php if (count($archived) === 0): ?>
          <!-- ✅ EMPTY STATE -->
          <div class="archive-empty" style="padding:24px;border:1px dashed rgba(148,163,184,.6);border-radius:14px;">
            <strong></strong>
            <div style="margin-top:6px;color:#64748b;">
              <b></b>.
            </div>
          </div>

        <?php else: ?>
          <!-- ✅ SHOW ARCHIVED LIST -->
          <?php foreach ($archived as $a): ?>
            <div class="archive-card">

              <h2><?= htmlspecialchars($a["title"] ?? "Untitled") ?></h2>

              <div class="archive-meta">
                <?php if (!empty($a["adviser"])): ?>
                  <span class="adviser"><b>Adviser:</b> <?= htmlspecialchars($a["adviser"]) ?></span>
                <?php endif; ?>

                <?php if (!empty($a["date_submitted"])): ?>
                  <span class="date">
                    <b>Date:</b> <?= htmlspecialchars(date("F d, Y", strtotime($a["date_submitted"]))) ?>
                  </span>
                <?php endif; ?>
              </div>

              <div class="archive-actions">
                <?php if (!empty($a["file_path"])): ?>
                  <a href="<?= htmlspecialchars($a["file_path"]) ?>" class="btn primary" target="_blank">View PDF</a>
                <?php endif; ?>

                <?php if (!empty($a["abstract"])): ?>
                  <button class="btn secondary" type="button"
                          onclick="alert(<?= json_encode($a['abstract']) ?>)">
                    View Abstract
                  </button>
                <?php endif; ?>
              </div>

            </div>
          <?php endforeach; ?>

        <?php endif; ?>

      </div>
    </main>
  </div>

</body>
</html>