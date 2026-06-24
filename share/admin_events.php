<?php
session_start();
 
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /login.php');
    exit;
}
 
include('../share/db.php');
 
$message = '';
 
// ── DELETE ────────────────────────────────────────────────────────────────────
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM events WHERE event_id = $id");
    $message = 'Event deleted.';
}
 
// ── INSERT or UPDATE ──────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = mysqli_real_escape_string($conn, trim($_POST['title']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
$event_date = !empty($_POST['event_date']) ? "'" . mysqli_real_escape_string($conn, $_POST['event_date']) . "'" : 'NULL';
    $event_time  = !empty($_POST['event_time']) ? "'" . mysqli_real_escape_string($conn, $_POST['event_time']) . "'" : 'NULL';
    $location    = mysqli_real_escape_string($conn, trim($_POST['location']));
    $created_by  = $_SESSION['user_id'];
 
    if (!empty($_POST['event_id'])) {
        $id = (int) $_POST['event_id'];
        mysqli_query($conn,
            "UPDATE events
             SET title='$title', description='$description',
                 event_date='$event_date', event_time=$event_time, location='$location'
             WHERE event_id=$id"
        );
        $message = 'Event updated successfully.';
    } else {
        mysqli_query($conn,
            "INSERT INTO events (title, description, event_date, event_time, location, created_by)
             VALUES ('$title', '$description', '$event_date', $event_time, '$location', $created_by)"
        );
        $message = 'Event added successfully.';
    }
}
 
// ── FETCH for edit form ───────────────────────────────────────────────────────
$edit_data = null;
if (isset($_GET['edit'])) {
    $id        = (int) $_GET['edit'];
    $result    = mysqli_query($conn, "SELECT * FROM events WHERE event_id=$id");
    $edit_data = mysqli_fetch_assoc($result);
}
 
// ── FETCH all events ──────────────────────────────────────────────────────────
$all = mysqli_query($conn, "SELECT * FROM events ORDER BY event_date ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin – Events | Grand Prix Society</title>
    <link rel="stylesheet" href="/CartClub/GrandPrixSocietycss/style.css">
    <style>
        body { font-family: Arial, sans-serif; background:#0a0a0a; color:#f0f0f0; margin:0; padding:0; }
        .admin-wrapper { max-width:960px; margin:40px auto; padding:0 20px; }
        h1 { color:#e10600; letter-spacing:2px; }
        h2 { color:#ccc; font-size:1rem; text-transform:uppercase; letter-spacing:1px; }
        .msg { background:#1a3a1a; border:1px solid #2d6a2d; color:#8fff8f;
               padding:10px 16px; border-radius:4px; margin-bottom:20px; }
        .admin-form { background:#1a1a1a; border:1px solid #2a2a2a;
                      padding:24px; border-radius:8px; margin-bottom:40px; }
        .admin-form label { display:block; margin-bottom:4px; color:#aaa; font-size:.85rem; }
        .admin-form input[type=text],
        .admin-form input[type=date],
        .admin-form input[type=time],
        .admin-form textarea {
            width:100%; padding:10px 12px; margin-bottom:16px;
            background:#111; border:1px solid #333; color:#f0f0f0;
            border-radius:4px; box-sizing:border-box; font-size:.95rem;
        }
        .admin-form textarea { height:90px; resize:vertical; }
        .form-row { display:flex; gap:16px; }
        .form-row > div { flex:1; }
        .btn-red  { background:#e10600; color:#fff; border:none; padding:10px 22px;
                    border-radius:4px; cursor:pointer; font-weight:bold; letter-spacing:1px; }
        .btn-red:hover { background:#b00500; }
        .btn-gray { background:#333; color:#fff; border:none; padding:10px 22px;
                    border-radius:4px; cursor:pointer; margin-left:10px; }
        .btn-gray:hover { background:#444; }
        table { width:100%; border-collapse:collapse; }
        th, td { padding:12px 14px; text-align:left; border-bottom:1px solid #222; font-size:.9rem; }
        th { background:#181818; color:#e10600; text-transform:uppercase; font-size:.78rem; letter-spacing:1px; }
        tr:hover { background:#111; }
        .action-link { color:#e10600; text-decoration:none; margin-right:12px; font-size:.85rem; }
        .action-link:hover { text-decoration:underline; }
        .action-del { color:#888; }
        .action-del:hover { color:#e10600; }
        .badge { display:inline-block; background:#1a1a1a; border:1px solid #333;
                 padding:2px 8px; border-radius:12px; font-size:.78rem; color:#aaa; }
        .nav-back { display:inline-block; margin-bottom:24px; color:#888;
                    text-decoration:none; font-size:.85rem; }
        .nav-back:hover { color:#fff; }
    </style>
</head>
<body>
<div class="admin-wrapper">
 
    <a class="nav-back" href="admin_dashboard.php">← Back to Dashboard</a>
    <h1>🏁 MANAGE EVENTS</h1>
 
    <?php if ($message): ?>
        <div class="msg"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
 
    <!-- ADD / EDIT FORM -->
    <div class="admin-form">
        <h2><?php echo $edit_data ? '✏️ Edit Event' : '➕ Add New Event'; ?></h2>
        <form method="POST">
            <?php if ($edit_data): ?>
                <input type="hidden" name="event_id" value="<?php echo $edit_data['event_id']; ?>">
            <?php endif; ?>
 
            <label>Event Title *</label>
            <input type="text" name="title" required
                   value="<?php echo $edit_data ? htmlspecialchars($edit_data['title']) : ''; ?>">
 
            <label>Description</label>
            <textarea name="description"><?php echo $edit_data ? htmlspecialchars($edit_data['description']) : ''; ?></textarea>
 
            <div class="form-row">
                <div>
                    <label>Event Date (optional)</label>
                    <input type="date" name="event_date"
                           value="<?php echo $edit_data ? $edit_data['event_date'] : ''; ?>">
                </div>
                <div>
                    <label>Event Time (optional)</label>
                    <input type="time" name="event_time"
                           value="<?php echo $edit_data ? $edit_data['event_time'] : ''; ?>">
                </div>
            </div>
 
            <label>Location</label>
            <input type="text" name="location"
                   value="<?php echo $edit_data ? htmlspecialchars($edit_data['location']) : ''; ?>">
 
            <button type="submit" class="btn-red">
                <?php echo $edit_data ? 'UPDATE EVENT' : 'ADD EVENT'; ?>
            </button>
            <?php if ($edit_data): ?>
                <a href="admin_events.php" class="btn-gray">CANCEL</a>
            <?php endif; ?>
        </form>
    </div>
 
    <!-- ── TABLE ────────────────────────────────────────────────────── -->
    <h2>All Events</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($all)): ?>
            <tr>
                <td><?php echo $row['event_id']; ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td>
                    <?php
                    // Handle invalid dates like 0000-00-00
                    echo ($row['event_date'] && $row['event_date'] !== '0000-00-00')
                        ? date('d M Y', strtotime($row['event_date']))
                        : '<span style="color:#555">TBC</span>';
                    ?>
                </td>
                <td>
                    <?php echo $row['event_time']
                        ? date('h:i A', strtotime($row['event_time']))
                        : '<span style="color:#555">TBC</span>'; ?>
                </td>
                <td><?php echo $row['location'] ? htmlspecialchars($row['location']) : '<span style="color:#555">—</span>'; ?></td>
                <td>
                    <a class="action-link"
                       href="admin_events.php?edit=<?php echo $row['event_id']; ?>">Edit</a>
                    <a class="action-link action-del"
                       href="admin_events.php?delete=<?php echo $row['event_id']; ?>"
                       onclick="return confirm('Delete this event?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
 
</div>
</body>
</html>