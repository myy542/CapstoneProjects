<?php
$pageTitle = "My Feedback";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= htmlspecialchars($pageTitle) ?> - Theses Archiving System</title>
    <link rel="stylesheet" href="css/base.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/facultyFeedback.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="layout">

    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-wrapper">
                <div class="logo">TAP</div>
                <span>ARCHIVE</span>
            </div>
            <p>Faculty Portal</p>
        </div>

        <nav class="sidebar-nav">
            <a href="facultyDashboard.php" class="nav-link">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="facultyProfile.php" class="nav-link">
                <i class="fas fa-user"></i> Profile
            </a>
            <a href="reviewThesis.php" class="nav-link">
                <i class="fas fa-book-reader"></i> Review Theses
            </a>
            <a href="facultyFeedback.php" class="nav-link active">
                <i class="fas fa-comment-dots"></i> My Feedback
            </a>
            <a href="logout.php" class="nav-link logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="theme-toggle">
                <input type="checkbox" id="darkmode" />
                <label for="darkmode" class="toggle-label">
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </aside>

    <main class="main-content">

        <header class="welcome-header">
            <h1><?= htmlspecialchars($pageTitle) ?></h1>
            <div class="student-id-container">
                <span class="notification-bell"><i class="fas fa-bell"></i><sup>2</sup></span>
                FACULTY ID <strong>FU</strong> #2024-001
            </div>
        </header>

        <div class="feedback-stats">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-comment-dots"></i></div>
                <div class="stat-value">28</div>
                <div class="stat-label">Feedback Given</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-thumbs-up"></i></div>
                <div class="stat-value">91%</div>
                <div class="stat-label">Positive Rating</div>
            </div>
        </div>

        <div class="feedback-list">
            <div class="feedback-card">
                <div class="feedback-header">
                    <h3>Chapter 4 – Smart Waste Bin Project</h3>
                    <span class="feedback-date">Feb 8, 2026</span>
                </div>
                <p class="feedback-text">
                    The methodology section is well-structured, but consider adding more details about data preprocessing steps...
                </p>
                <div class="feedback-student">Student: Mark Kiven Gie</div>
            </div>

            <div class="feedback-card">
                <div class="feedback-header">
                    <h3>Introduction – Blockchain Grading System</h3>
                    <span class="feedback-date">Feb 5, 2026</span>
                </div>
                <p class="feedback-text">
                    Good literature review. Please clarify the research gap in the last paragraph.
                </p>
                <div class="feedback-student">Student: John Doe</div>
            </div>
        </div>

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