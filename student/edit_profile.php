<?php
session_start();
require_once __DIR__ . "/../admin/config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../authentication/login.php");
    exit;
}

$user_id = (int)$_SESSION["user_id"];
$error = "";

$stmt = $conn->prepare("SELECT first_name, last_name, email, contact_number, address, birth_date, profile_picture FROM user_table WHERE user_id=?");
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

$profilePicUrl = $user["profile_picture"] 
    ? "../uploads/profile_pictures/" . $user["profile_picture"] 
    : "";

/* ====================== POST HANDLING ====================== */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name  = trim($_POST["first_name"] ?? "");
    $last_name   = trim($_POST["last_name"] ?? "");
    $email       = trim($_POST["email"] ?? "");
    $contact_num = trim($_POST["contact_number"] ?? "");
    $birth_date  = trim($_POST["birth_date"] ?? "");
    $address     = trim($_POST["address"] ?? "");

    if ($first_name === "" || $last_name === "" || $email === "") {
        $error = "First name, last name, and email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $newFileName = null;

        if (!empty($_FILES["profile_picture"]["name"])) {
            $file = $_FILES["profile_picture"];
            $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

            if (!in_array($ext, ["jpg", "jpeg", "png"])) {
                $error = "Only JPG, JPEG or PNG files allowed.";
            } else {
                $uploadDir = __DIR__ . "/../uploads/profile_pictures/";
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $newFileName = "user_" . $user_id . "_" . time() . "." . $ext;
                $dest = $uploadDir . $newFileName;

                if (!move_uploaded_file($file["tmp_name"], $dest)) {
                    $error = "Failed to upload picture.";
                    $newFileName = null;
                }
            }
        }

        if (!$error) {
            if ($newFileName) {
                $sql = "UPDATE user_table SET first_name=?, last_name=?, email=?, contact_number=?, address=?, birth_date=?, profile_picture=?, updated_at=NOW() WHERE user_id=?";
                $upd = $conn->prepare($sql);
                $upd->bind_param("sssssssi", $first_name, $last_name, $email, $contact_num, $address, $birth_date, $newFileName, $user_id);
            } else {
                $sql = "UPDATE user_table SET first_name=?, last_name=?, email=?, contact_number=?, address=?, birth_date=?, updated_at=NOW() WHERE user_id=?";
                $upd = $conn->prepare($sql);
                $upd->bind_param("ssssssi", $first_name, $last_name, $email, $contact_num, $address, $birth_date, $user_id);
            }

            if ($upd->execute()) {
                $upd->close();
                header("Location: profile.php");
                exit;
            } else {
                $error = "Update failed: " . $upd->error;
                $upd->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - TAP Archive</title>
    <link rel="stylesheet" href="css/base.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/edit_profile.css?v=<?= time() ?>">
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
            <a href="profile.php" class="nav-link">
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
            <h1>Edit Profile</h1>
            <div class="student-id-container">
                <span class="notification-bell"><i class="fas fa-bell"></i><sup>2</sup></span>
                STUDENT ID <strong>DU</strong> #<?= str_pad($user_id, 6, "0", STR_PAD_LEFT) ?>
            </div>
        </header>

        <section class="edit-section">
            <div class="edit-main-card">
                <?php if ($error): ?>
                    <div class="alert error">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" class="edit-form">
                    <div class="picture-section">
                        <label>Profile Picture</label>

                        <?php if ($profilePicUrl && file_exists(__DIR__ . "/../uploads/profile_pictures/" . $user["profile_picture"])): ?>
                            <img src="<?= htmlspecialchars($profilePicUrl) ?>?v=<?= time() ?>" class="current-photo" alt="Current">
                        <?php else: ?>
                            <div class="current-photo placeholder">No photo</div>
                        <?php endif; ?>

                        <div class="upload-area">
                            <label for="profile_picture" class="upload-btn">
                                <i class="fas fa-upload"></i> Choose New Photo
                            </label>
                            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" hidden>
                            <span class="file-name">No file selected</span>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($first) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($last) ?>" required>
                        </div>

                        <div class="form-group full-width">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user["email"]) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="contact_number">Contact Number</label>
                            <input type="tel" id="contact_number" name="contact_number" value="<?= htmlspecialchars($user["contact_number"] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label for="birth_date">Birth Date</label>
                            <input type="date" id="birth_date" name="birth_date" value="<?= htmlspecialchars($user["birth_date"] ?? '') ?>">
                        </div>

                        <div class="form-group full-width">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" rows="3"><?= htmlspecialchars($user["address"] ?? '') ?></textarea>
                        </div>

                        <div class="form-actions full-width">
                            <a href="profile.php" class="btn secondary">Cancel</a>
                            <button type="submit" class="btn primary">Save Changes</button>
                        </div>
                    </div>
                </form>
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

document.getElementById('profile_picture')?.addEventListener('change', function(e) {
    const fileName = e.target.files.length > 0 ? e.target.files[0].name : 'No file selected';
    document.querySelector('.file-name').textContent = fileName;
});
</script>

</body>
</html>