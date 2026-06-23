<?php
session_start();
 
// ── GUARD: only admin can access ──────────────────────────────────────────────
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /login.php');
    exit;
}
 
include('../share/db.php');
 
$message = '';
 
// ── DELETE ────────────────────────────────────────────────────────────────────
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM announcements WHERE ann_id = $id");
    $message = 'Announcement deleted.';
}
 
// ── INSERT or UPDATE ──────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title     = mysqli_real_escape_string($conn, trim($_POST['title']));
    $content   = mysqli_real_escape_string($conn, trim($_POST['content']));
    $image_url = mysqli_real_escape_string($conn, trim($_POST['image_url']));
    $posted_by = $_SESSION['user_id'];
 
    if (!empty($_POST['ann_id'])) {
        // EDIT
        $id = (int) $_POST['ann_id'];
        mysqli_query($conn,
            "UPDATE announcements
             SET title='$title', content='$content', image_url='$image_url'
             WHERE ann_id=$id"
        );
        $message = 'Announcement updated successfully.';
    } else {
        // ADD NEW
        mysqli_query($conn,
            "INSERT INTO announcements (title, content, image_url, posted_by)
             VALUES ('$title', '$content', '$image_url', $posted_by)"
        );
        $message = 'Announcement added successfully.';
    }
}
 
// ── FETCH for edit form ───────────────────────────────────────────────────────
$edit_data = null;
if (isset($_GET['edit'])) {
    $id        = (int) $_GET['edit'];
    $result    = mysqli_query($conn, "SELECT * FROM announcements WHERE ann_id=$id");
    $edit_data = mysqli_fetch_assoc($result);
}
 
// ── FETCH all announcements ───────────────────────────────────────────────────
$all = mysqli_query($conn, "SELECT * FROM announcements ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin – Announcements | Grand Prix Society</title>
    <link rel="stylesheet" href="/CartClub/GrandPrixSocietycss/style.css">
    <style>
        body { font-family: Arial, sans-serif; background:#0a0a0a; color:#f0f0f0; margin:0; padding:0; }
        .admin-wrapper { max-width:960px; margin:40px auto; padding:0 20px; }
        h1 { color:#e10600; letter-spacing:2px; }
        h2 { color:#ccc; font-size:1rem; text-transform:uppercase; letter-spacing:1px; }
        .msg { background:#1a3a1a; border:1px solid #2d6a2d; color:#8fff8f;
               padding:10px 16px; border-radius:4px; margin-bottom:20px; }
 
        /* ── form ── */
        .admin-form { background:#1a1a1a; border:1px solid #2a2a2a;
                      padding:24px; border-radius:8px; margin-bottom:40px; }
        .admin-form label { display:block; margin-bottom:4px; color:#aaa; font-size:.85rem; }
        .admin-form input[type=text],
        .admin-form textarea {
            width:100%; padding:10px 12px; margin-bottom:16px;
            background:#111; border:1px solid #333; color:#f0f0f0;
            border-radius:4px; box-sizing:border-box; font-size:.95rem;
        }
        .admin-form textarea { height:120px; resize:vertical; }
        .btn-red   { background:#e10600; color:#fff; border:none; padding:10px 22px;
                     border-radius:4px; cursor:pointer; font-weight:bold; letter-spacing:1px; }
        .btn-red:hover { background:#b00500; }
        .btn-gray  { background:#333; color:#fff; border:none; padding:10px 22px;
                     border-radius:4px; cursor:pointer; margin-left:10px; }
        .btn-gray:hover { background:#444; }
 
        /* ── table ── */
        table { width:100%; border-collapse:collapse; }
        th, td { padding:12px 14px; text-align:left; border-bottom:1px solid #222; font-size:.9rem; }
        th { background:#181818; color:#e10600; text-transform:uppercase; font-size:.78rem; letter-spacing:1px; }
        tr:hover { background:#111; }
        .action-link { color:#e10600; text-decoration:none; margin-right:12px; font-size:.85rem; }
        .action-link:hover { text-decoration:underline; }
        .action-del { color:#888; }
        .action-del:hover { color:#e10600; }
        .thumb { width:60px; height:40px; object-fit:cover; border-radius:3px; background:#222; }
        .nav-back { display:inline-block; margin-bottom:24px; color:#888;
                    text-decoration:none; font-size:.85rem; }
        .nav-back:hover { color:#fff; }
    </style>
</head>
<body>
<div class="admin-wrapper">
 
    <a class="nav-back" href="admin_dashboard.php">← Back to Dashboard</a>
    <h1>📢 MANAGE ANNOUNCEMENTS</h1>
 
    <?php if ($message): ?>
        <div class="msg"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
 
    <!-- ── ADD / EDIT FORM ──────────────────────────────────────────── -->
    <div class="admin-form">
        <h2><?php echo $edit_data ? '✏️ Edit Announcement' : '➕ Add New Announcement'; ?></h2>
        <form method="POST">
            <?php if ($edit_data): ?>
                <input type="hidden" name="ann_id" value="<?php echo $edit_data['ann_id']; ?>">
            <?php endif; ?>
 
            <label>Title *</label>
            <input type="text" name="title" required
                   value="<?php echo $edit_data ? htmlspecialchars($edit_data['title']) : ''; ?>">
 
            <label>Content *</label>
            <textarea name="content" required><?php echo $edit_data ? htmlspecialchars($edit_data['content']) : ''; ?></textarea>
 
            <label>Image URL (e.g. /CartClub/image/welcome.jpg)</label>
            <input type="text" name="image_url"
                   value="<?php echo $edit_data ? htmlspecialchars($edit_data['image_url']) : ''; ?>">
 
            <button type="submit" class="btn-red">
                <?php echo $edit_data ? 'UPDATE' : 'ADD ANNOUNCEMENT'; ?>
            </button>
            <?php if ($edit_data): ?>
                <a href="admin_announcements.php" class="btn-gray">CANCEL</a>
            <?php endif; ?>
        </form>
    </div>
 
    <!-- ── TABLE ────────────────────────────────────────────────────── -->
    <h2>All Announcements</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Date Posted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($all)): ?>
            <tr>
                <td><?php echo $row['ann_id']; ?></td>
                <td>
                    <?php if (!empty($row['image_url'])): ?>
                        <img class="thumb" src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="">
                    <?php else: ?>
                        <span style="color:#555">—</span>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                <td>
                    <a class="action-link"
                       href="admin_announcements.php?edit=<?php echo $row['ann_id']; ?>">Edit</a>
                    <a class="action-link action-del"
                       href="admin_announcements.php?delete=<?php echo $row['ann_id']; ?>"
                       onclick="return confirm('Delete this announcement?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
 
</div>
</body>
</html>