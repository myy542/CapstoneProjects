<?php
$pageTitle = "Faculty Dashboard";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= htmlspecialchars($pageTitle) ?> - Theses Archiving System</title>
    <link rel="stylesheet" href="css/base.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/facultyDashboard.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="layout">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-wrapper">
                <div class="logo">TAP</div>
                <span>ARCHIVE</span>
            </div>
            <p>Faculty Portal</p>
        </div>

        <nav class="sidebar-nav">
            <a href="facultyDashboard.php" class="nav-link active">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="facultyProfile.php" class="nav-link">
                <i class="fas fa-user"></i> Profile
            </a>
            <a href="reviewThesis.php" class="nav-link">
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
            <h1>Faculty Dashboard</h1>
            <div class="student-id-container">
                <span class="notification-bell"><i class="fas fa-bell"></i><sup>2</sup></span>
                FACULTY ID <strong>FU</strong> #2024-001
            </div>
        </header>

        <!-- Welcome Card -->
        <div class="welcome-card">
            <h2>Welcome back, Dr. Reyes!</h2>
            <p>You have 8 theses pending review and 3 feedback requests.</p>
        </div>

        <!-- Stats Grid -->
        <div class="stats-overview">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-book"></i></div>
                <div class="stat-content">
                    <div class="stat-value">12</div>
                    <div class="stat-label">Theses Assigned</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-comment-dots"></i></div>
                <div class="stat-content">
                    <div class="stat-value">8</div>
                    <div class="stat-label">Pending Reviews</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-content">
                    <div class="stat-value">45</div>
                    <div class="stat-label">Completed Reviews</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-content">
                    <div class="stat-value">3</div>
                    <div class="stat-label">Pending Feedback</div>
                </div>
            </div>
        </div>

        <!-- Priority Action Items -->
        <h2 class="section-title"><i class="fas fa-exclamation-triangle" style="color: var(--red);"></i> Priority Reviews</h2>
        <div class="priority-grid">
            <div class="priority-card">
                <div class="priority-header">
                    <h3 class="priority-title">Smart Waste Bin Monitoring System</h3>
                    <span class="priority-badge">HIGH</span>
                </div>
                <div class="priority-details">
                    <p><strong>Student:</strong> Mark Kiven Gie</p>
                    <p><strong>Due:</strong> May 15, 2026</p>
                    <p><em>Chapter 4 submitted</em></p>
                </div>
                <a href="reviewThesis.php" class="btn btn-primary" style="margin-top:1rem;">Review Now</a>
            </div>
            <div class="priority-card">
                <div class="priority-header">
                    <h3 class="priority-title">Blockchain-based Grading System</h3>
                    <span class="priority-badge">MEDIUM</span>
                </div>
                <div class="priority-details">
                    <p><strong>Student:</strong> John Doe</p>
                    <p><strong>Due:</strong> May 20, 2026</p>
                    <p><em>Awaiting feedback</em></p>
                </div>
                <a href="reviewThesis.php" class="btn btn-primary" style="margin-top:1rem;">Review</a>
            </div>
        </div>

        <!-- Bottom two columns: Recent Theses & Deadlines -->
        <div class="dashboard-bottom">
            <!-- Recent Theses Table -->
            <div class="card">
                <h3 style="margin-bottom:1.2rem; display:flex; align-items:center; gap:0.5rem;">
                    <i class="fas fa-history" style="color: var(--sidebar);"></i> Recent Submissions
                </h3>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr><th>Thesis Title</th><th>Student</th><th>Status</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Cybersecurity Protocols</td>
                                <td>Jane Smith</td>
                                <td><span class="status-badge red">Pending</span></td>
                                <td><a href="#" class="btn btn-primary" style="padding:0.3rem 1rem;">Review</a></td>
                            </tr>
                            <tr>
                                <td>Ethical AI Frameworks</td>
                                <td>Mike Brown</td>
                                <td><span class="status-badge">In Progress</span></td>
                                <td><a href="#" class="btn btn-primary" style="padding:0.3rem 1rem;">Review</a></td>
                            </tr>
                            <tr>
                                <td>IoT in Agriculture</td>
                                <td>Lisa White</td>
                                <td><span class="status-badge red">Pending</span></td>
                                <td><a href="#" class="btn btn-primary" style="padding:0.3rem 1rem;">Review</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Upcoming Deadlines -->
            <div class="card">
                <h3 style="margin-bottom:1.2rem; display:flex; align-items:center; gap:0.5rem;">
                    <i class="fas fa-calendar-alt" style="color: var(--red);"></i> Upcoming Deadlines
                </h3>
                <ul class="deadline-list">
                    <li class="deadline-item">
                        <div class="deadline-date"><span class="day">18</span><span class="month">MAY</span></div>
                        <div class="deadline-info">
                            <div class="deadline-title">Thesis Proposal Defense</div>
                            <div class="deadline-meta">Room 302 • 10:00 AM</div>
                        </div>
                    </li>
                    <li class="deadline-item">
                        <div class="deadline-date"><span class="day">25</span><span class="month">MAY</span></div>
                        <div class="deadline-info">
                            <div class="deadline-title">Final Manuscript Submission</div>
                            <div class="deadline-meta">Registrar's Office</div>
                        </div>
                    </li>
                    <li class="deadline-item">
                        <div class="deadline-date"><span class="day">02</span><span class="month">JUN</span></div>
                        <div class="deadline-info">
                            <div class="deadline-title">Faculty Meeting</div>
                            <div class="deadline-meta">Conference Room</div>
                        </div>
                    </li>
                </ul>
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