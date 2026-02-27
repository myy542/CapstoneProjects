<?php
$pageTitle = "Review Theses";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= htmlspecialchars($pageTitle) ?> - Theses Archiving System</title>
    <link rel="stylesheet" href="css/base.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/reviewThesis.css?v=<?= time() ?>">
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
            <a href="reviewThesis.php" class="nav-link active">
                <i class="fas fa-book-reader"></i> Review Theses
            </a>
            <a href="facultyFeedback.php" class="nav-link">
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

        <div class="search-filter-bar">
            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search by title, student, or ID...">
            </div>
            <select class="filter-select">
                <option>Filter by Status</option>
                <option>Pending</option>
                <option>In Progress</option>
                <option>Completed</option>
            </select>
        </div>

        <div class="thesis-list">
            <div class="thesis-card">
                <div class="thesis-header">
                    <h3 class="thesis-title">Smart Waste Bin Monitoring with IoT & Mobile App</h3>
                    <span class="status pending">Pending Review</span>
                </div>
                <div class="thesis-student">Mark Kiven Gie • 2021-001234</div>
                <div class="thesis-date">Submitted: Feb 5, 2026</div>
                <div class="thesis-actions">
                    <a href="#" class="btn btn-primary">View Manuscript</a>
                    <a href="#" class="btn btn-secondary">Add Feedback</a>
                </div>
            </div>

            <div class="thesis-card">
                <div class="thesis-header">
                    <h3 class="thesis-title">Blockchain-based Secure Grading System</h3>
                    <span class="status pending">Pending Review</span>
                </div>
                <div class="thesis-student">John Doe • 2021-005678</div>
                <div class="thesis-date">Submitted: Feb 3, 2026</div>
                <div class="thesis-actions">
                    <a href="#" class="btn btn-primary">View Manuscript</a>
                    <a href="#" class="btn btn-secondary">Add Feedback</a>
                </div>
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