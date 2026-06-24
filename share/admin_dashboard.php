<?php

session_start();
 
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /login.php');
    exit;
}
 
include('../share/db.php');
 
// Quick stats
$stats = [];
foreach ([
    'announcements' => 'ann_id',
    'events'        => 'event_id',
    'committee'     => 'committee_id',
    'users'         => 'user_id',
] as $table => $pk) {
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM $table"));
    $stats[$table] = $r['c'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Grand Prix Society</title>
    <link rel="stylesheet" href="/CartClub/GrandPrixSocietycss/style.css">
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background:#0a0a0a; color:#f0f0f0; margin:0; }
        .dash-wrapper { max-width:900px; margin:50px auto; padding:0 24px; }
        .dash-header { display:flex; align-items:center; justify-content:space-between;
                       margin-bottom:40px; }
        .dash-header h1 { color:#e10600; letter-spacing:2px; margin:0; }
        .dash-header a  { color:#777; font-size:.85rem; text-decoration:none; }
        .dash-header a:hover { color:#fff; }
 
        /* stat cards row */
        .stat-row { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:48px; }
        .stat-card { background:#141414; border:1px solid #222; border-radius:8px;
                     padding:20px 16px; text-align:center; }
        .stat-card .num { font-size:2rem; font-weight:bold; color:#e10600; }
        .stat-card .lbl { font-size:.78rem; color:#777; text-transform:uppercase;
                          letter-spacing:1px; margin-top:4px; }
 
        /* section cards */
        .section-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
        .section-card { background:#141414; border:1px solid #222; border-radius:8px;
                        padding:28px 22px; text-decoration:none; color:#f0f0f0;
                        transition: border-color .2s, transform .15s; display:block; }
        .section-card:hover { border-color:#e10600; transform:translateY(-3px); }
        .section-card .icon { font-size:2rem; margin-bottom:12px; }
        .section-card h3 { margin:0 0 6px; font-size:1.05rem; color:#fff; letter-spacing:1px; }
        .section-card p  { margin:0; font-size:.82rem; color:#666; line-height:1.5; }
        .section-card .arrow { color:#e10600; font-size:1.1rem; margin-top:16px;
                               display:block; font-weight:bold; }
        h2 { color:#ccc; font-size:.85rem; text-transform:uppercase;
             letter-spacing:2px; margin-bottom:16px; }
    </style>
</head>
<body>
<div class="dash-wrapper">
 
    <div class="dash-header">
        <h1>ADMIN DASHBOARD</h1>
        <div>
            <span style="color:#555; margin-right:16px;">
                Logged in as <strong style="color:#ccc"><?php echo htmlspecialchars($_SESSION['full_name'] ?? 'Admin'); ?></strong>
            </span>
            <a href="/CartClub/share/logout.php">Logout →</a>
            
        </div>
    </div>
 
    <!-- stat row -->
    <h2>Overview</h2>
    <div class="stat-row">
        <div class="stat-card">
            <div class="num"><?php echo $stats['announcements']; ?></div>
            <div class="lbl">Announcements</div>
        </div>
        <div class="stat-card">
            <div class="num"><?php echo $stats['events']; ?></div>
            <div class="lbl">Events</div>
        </div>
        <div class="stat-card">
            <div class="num"><?php echo $stats['committee']; ?></div>
            <div class="lbl">Committee</div>
        </div>
        <div class="stat-card">
            <div class="num"><?php echo $stats['users']; ?></div>
            <div class="lbl">Members</div>
        </div>
    </div>
 
    <!-- section cards -->
    <h2>Manage Sections</h2>
    <div class="section-grid">
        <a class="section-card" href="admin_announcements.php">
            <div class="icon">📢</div>
            <h3>ANNOUNCEMENTS</h3>
            <p>Add, edit, or delete announcements shown on the homepage and news feed.</p>
            <span class="arrow">MANAGE →</span>
        </a>
        <a class="section-card" href="admin_events.php">
            <div class="icon">🏁</div>
            <h3>EVENTS</h3>
            <p>Add upcoming events with date, time, and location. They appear live on the homepage.</p>
            <span class="arrow">MANAGE →</span>
        </a>
        <a class="section-card" href="admin_committee.php">
            <div class="icon">👤</div>
            <h3>COMMITTEE</h3>
            <p>Add or update committee members with their role, bio, photo, and display order.</p>
            <span class="arrow">MANAGE →</span>
        </a>
          <a class="section-card" href="admin_members.php">
            <div class="icon">👥</div>
            <h3>MEMBERS</h3>
            <p>View all registered members, add new accounts, or remove existing users.</p>
            <span class="arrow">MANAGE →</span>
        </a>
    </div>
 
    <p style="margin-top:40px; text-align:center;">
        <a href="/CartClub/share/index.php" style="color:#555; font-size:.85rem;">
            ← View public homepage
        </a>
    </p>
</div>
</body>
</html>