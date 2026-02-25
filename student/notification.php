<?php
session_start();
require_once __DIR__ . "/../admin/config.php";

if (!isset($_SESSION["user_id"])) {
  header("Location: ../authentication/login.php");
  exit;
}

$user_id = (int)$_SESSION["user_id"];

// ===== USER INFO (latest from DB) =====
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

// ===== VALIDATION: MARK AS READ (same file) =====
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["mark_read"])) {
  $notification_id = (int)$_POST["mark_read"];

  if ($notification_id > 0) {
    $stmt = $conn->prepare("
      UPDATE notification_table
      SET status='read'
      WHERE notification_id=? AND user_id=?
    ");
    $stmt->bind_param("ii", $notification_id, $user_id);
    $stmt->execute();
    $stmt->close();
  }

  header("Location: notifications.php");
  exit;
}

$notification = [];
$stmt = $conn->prepare("
  SELECT notification_id, message, status, created_at
  FROM notification_table
  WHERE user_id=?
  ORDER BY created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
  $notification[] = $row;
}
$stmt->close();

$unreadCount = 0;
$stmt = $conn->prepare("SELECT COUNT(*) AS c FROM notification_table WHERE user_id=? AND status='unread'");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$unreadCount = (int)($stmt->get_result()->fetch_assoc()["c"] ?? 0);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notifications - Theses Archiving System</title>
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/notifications.css">
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

        <a href="archived.php" class="nav-link">
          <i class="fas fa-archive"></i> Archived Theses
        </a>

        <a href="notification.php" class="nav-link active">
          <i class="fas fa-bell"></i> Notifications
          <?php if ($unreadCount > 0): ?>
            <span class="badge"><?= (int)$unreadCount ?></span>
          <?php endif; ?>
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

        <a href="../authentication/logout.php" class="logout-btn">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </aside>

    <main class="main-content">
      <header class="topbar">
        <h1>Notifications</h1>

        <div class="user-info">
          <span class="user-name"><?= htmlspecialchars($fullName) ?></span>
          <div class="avatar"><?= htmlspecialchars($initials) ?></div>
        </div>
      </header>

      <div class="notifications-container">

        <?php if (count($notification) === 0): ?>
          <div class="notification-empty" style="padding:24px;border:1px dashed rgba(148,163,184,.6);border-radius:14px;">
            <strong>No notifications available.</strong>
            <div style="margin-top:6px;color:#64748b;">
            </div>
          </div>
        <?php else: ?>

          <?php foreach ($notification as $n): ?>
            <?php $isUnread = (strtolower(trim($n["status"])) === "unread"); ?>

            <form method="POST" style="margin:0;">
              <input type="hidden" name="mark_read" value="<?= (int)$n["notification_id"] ?>">

              <button type="submit"
                      class="notification-item <?= $isUnread ? 'unread' : '' ?>"
                      style="width:100%;text-align:left;border:0;background:transparent;padding:0;cursor:pointer;">
                <div class="notif-icon"><i class="fas fa-bell"></i></div>
                <div class="notif-content">
                  <p><?= htmlspecialchars($n["message"]) ?></p>
                  <span class="notif-time"><?= htmlspecialchars($n["created_at"]) ?></span>
                </div>
              </button>
            </form>

          <?php endforeach; ?>

        <?php endif; ?>

      </div>
    </main>
  </div>

  <script>
    // dark mode toggle
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