<?php
session_start();
require_once __DIR__ . "/../admin/config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../authentication/login.php");
    exit;
}

$user_id = (int)$_SESSION["user_id"];

$stmt = $conn->prepare("
    SELECT first_name, last_name, email, contact_number, address, birth_date, profile_picture
    FROM user_table
    WHERE user_id = ?
");
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
$full  = trim($first . " " . $last);

$initials = "";
if ($first && $last) $initials = strtoupper(substr($first,0,1) . substr($last,0,1));
elseif ($first) $initials = strtoupper(substr($first,0,1));
else $initials = "U";

$profilePicUrl = $user["profile_picture"]
    ? "../uploads/profile_pictures/" . $user["profile_picture"]
    : "";

$email   = trim($user["email"] ?? "");
$contact = trim($user["contact_number"] ?? "");
$address = trim($user["address"] ?? "");
$birth   = trim($user["birth_date"] ?? "");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - TAP Archive</title>
    <link rel="stylesheet" href="css/base.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/profile.css?v=<?= time() ?>">
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
            <a href="student_dashboard.php" class="nav-link">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="profile.php" class="nav-link active">
                <i class="fas fa-user"></i> Profile
            </a>
            <a href="projects.php" class="nav-link">
                <i class="fas fa-folder"></i> My Projects
            </a>
            <a href="submission.php" class="nav-link">
                <i class="fas fa-upload"></i> Submit Thesis
            </a>
            <a href="archived.php" class="nav-link">
                <i class="fas fa-archive"></i> Archived Theses
            </a>
            <a href="notification.php" class="nav-link">
                <i class="fas fa-bell"></i> Notifications
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
            <h1>My Profile</h1>
            <div class="student-id-container">
                <span class="notification-bell"><i class="fas fa-bell"></i><sup>2</sup></span>
                STUDENT ID <strong>DU</strong> #<?= str_pad($user_id, 6, "0", STR_PAD_LEFT) ?>
            </div>
        </header>

        <section class="profile-hub">
            <div class="hub-grid">
                <!-- Center - Profile Main Card (big centered feel) -->
                <div class="profile-main-card">
                    <div class="profile-header">
                        <?php if ($profilePicUrl && file_exists(__DIR__ . "/../uploads/profile_pictures/" . $user["profile_picture"])): ?>
                            <img src="<?= htmlspecialchars($profilePicUrl) ?>?v=<?= time() ?>" class="profile-avatar large" alt="Profile">
                        <?php else: ?>
                            <div class="profile-avatar large initials"><?= htmlspecialchars($initials) ?></div>
                        <?php endif; ?>

                        <div class="profile-info">
                            <h2><?= htmlspecialchars($full ?: "Student") ?></h2>
                            <p class="subtitle">Student Account</p>
                        </div>
                    </div>

                    <div class="profile-details">
                        <div class="detail-item">
                            <strong>Email</strong>
                            <span><?= htmlspecialchars($email ?: "—") ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Contact Number</strong>
                            <span><?= htmlspecialchars($contact ?: "—") ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Address</strong>
                            <span><?= htmlspecialchars($address ?: "—") ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Birth Date</strong>
                            <span><?= $birth ? date("F d, Y", strtotime($birth)) : "—" ?></span>
                        </div>
                    </div>

                    <a href="edit_profile.php" class="btn primary edit-btn">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                </div>

                <!-- Right - Progress Card -->
                <div class="progress-card">
                    <h3>Thesis Progress</h3>
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
                    <p class="progress-subtitle">70% — Final Review Stage</p>
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