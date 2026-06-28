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
    mysqli_query($conn, "DELETE FROM committee WHERE committee_id = $id");
    $message = 'Committee member removed.';
}
 
// ── INSERT or UPDATE ──────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name          = mysqli_real_escape_string($conn, trim($_POST['name']));
    $position      = mysqli_real_escape_string($conn, trim($_POST['position']));
    $bio           = mysqli_real_escape_string($conn, trim($_POST['bio']));
    $photo_url     = mysqli_real_escape_string($conn, trim($_POST['photo_url']));
    $display_order = (int) $_POST['display_order'];
 
    if (!empty($_POST['committee_id'])) {
        $id = (int) $_POST['committee_id'];
        mysqli_query($conn,
            "UPDATE committee
             SET name='$name', position='$position', bio='$bio',
                 photo_url='$photo_url', display_order=$display_order
             WHERE committee_id=$id"
        );
        $message = 'Committee member updated successfully.';
    } else {
        mysqli_query($conn,
            "INSERT INTO committee (name, position, bio, photo_url, display_order)
             VALUES ('$name', '$position', '$bio', '$photo_url', $display_order)"
        );
        $message = 'Committee member added successfully.';
    }
}
 
// ── FETCH for edit form ───────────────────────────────────────────────────────
$edit_data = null;
if (isset($_GET['edit'])) {
    $id        = (int) $_GET['edit'];
    $result    = mysqli_query($conn, "SELECT * FROM committee WHERE committee_id=$id");
    $edit_data = mysqli_fetch_assoc($result);
}
 
// ── FETCH all committee members ───────────────────────────────────────────────
$all = mysqli_query($conn, "SELECT * FROM committee ORDER BY display_order ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin – Committee | Grand Prix Society</title>
    <link rel="stylesheet" href="/CartClub/GrandPrixSocietycss/style.css">
    <style>
        body
         {
             font-family: Arial, sans-serif;
             background:#0a0a0a;
             color:#f0f0f0;
             margin:0;
             padding:0;
         }
        .admin-wrapper
         {
             max-width:960px;
             margin:40px auto;
             padding:0 20px;
         }
        h1
         {
             color:#e10600;
              letter-spacing:2px;
         }
        h2
         {
             color:#ccc;
             font-size:1rem;
             text-transform:uppercase;
             letter-spacing:1px;
        }
        .msg
         {
             background:#1a3a1a;
             border:1px solid #2d6a2d;
             color:#8fff8f;
             padding:10px 16px;
             border-radius:4px;
             margin-bottom:20px;
         }
        .admin-form
         {
             background:#1a1a1a;
             border:1px solid #2a2a2a;
             padding:24px;
             border-radius:8px;
             margin-bottom:40px;
         }
        .admin-form label
         {
             display:block;
             margin-bottom:4px;
             color:#aaa;
             font-size:.85rem;
         }
        .admin-form input[type=text],
        .admin-form input[type=number],
        .admin-form textarea
         {
            width:100%; padding:10px 12px; margin-bottom:16px;
            background:#111; border:1px solid #333; color:#f0f0f0;
            border-radius:4px; box-sizing:border-box; font-size:.95rem;
        }
        .admin-form textarea
         {
             height:90px;
             resize:vertical;
         }
        .form-row
         {
             display:flex;
             gap:16px;
         }
        .form-row > div
         {
             flex:1;
         }
        .btn-red 
         {
             background:#e10600;
             color:#fff;
             border:none;
             padding:10px 22px;
             border-radius:4px;
             cursor:pointer;
             font-weight:bold;
             letter-spacing:1px;
         }
        .btn-red:hover
         {
             background:#b00500;
         }
        .btn-gray
         {
             background:#333;
             color:#fff;
             border:none;
             padding:10px 22px;
             border-radius:4px;
             cursor:pointer;
             margin-left:10px;
        }
        .btn-gray:hover
         {
             background:#444;
         }
        table
         {
             width:100%;
             border-collapse:collapse;
         }
        th, td
         {
             padding:12px 14px;
             text-align:left;
             border-bottom:1px solid #222;
             font-size:.9rem;
             vertical-align:middle;
         }
        th
         {
             background:#181818;
             color:#e10600;
             text-transform:uppercase;
             font-size:.78rem;
             letter-spacing:1px;
         }
        tr:hover
         {
             background:#111;
         }
        .action-link
         {
             color:#e10600;
             text-decoration:none;
             margin-right:12px;
             font-size:.85rem;
         }
        .action-link:hover
         {
             text-decoration:underline;
         }
        .action-del
         {
             color:#888;
         }
        .action-del:hover
         {
             color:#e10600;
         }
        .avatar
         {
             width:48px;
             height:48px;
             object-fit:cover;
             border-radius:50%;
             border:2px solid #333;
             background:#222;
         }
        .order-badge
         {
             display:inline-block;
             background:#1a1a1a;
             border:1px solid #e10600;
             color:#e10600;
             width:24px;
             height:24px;
             border-radius:50%;
             text-align:center;
             line-height:24px;
             font-size:.78rem;
             font-weight:bold;
         }
        .nav-back
         {
             display:inline-block;
             margin-bottom:24px;
             color:#888;
             text-decoration:none;
             font-size:.85rem;
        }
        .nav-back:hover
         {
             color:#fff;
         }
        .hint
         {
             font-size:.78rem;
             color:#555;
             margin-top:-12px;
             margin-bottom:14px;
         }
    </style>
</head>
<body>
<div class="admin-wrapper">
 
    <a class="nav-back" href="admin_dashboard.php">← Back to Dashboard</a>
    <h1>👤 MANAGE COMMITTEE</h1>
 
    <?php if ($message): ?>
        <div class="msg"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
 
    <!-- ── ADD / EDIT FORM ──────────────────────────────────────────── -->
    <div class="admin-form">
        <h2><?php echo $edit_data ? '✏️ Edit Member' : '➕ Add Committee Member'; ?></h2>
        <form method="POST">
            <?php if ($edit_data): ?>
                <input type="hidden" name="committee_id" value="<?php echo $edit_data['committee_id']; ?>">
            <?php endif; ?>
 
            <div class="form-row">
                <div>
                    <label>Full Name *</label>
                    <input type="text" name="name" required
                           value="<?php echo $edit_data ? htmlspecialchars($edit_data['name']) : ''; ?>">
                </div>
                <div>
                    <label>Position *</label>
                    <input type="text" name="position" required placeholder="e.g. President"
                           value="<?php echo $edit_data ? htmlspecialchars($edit_data['position']) : ''; ?>">
                </div>
            </div>
 
            <label>Bio</label>
            <textarea name="bio"><?php echo $edit_data ? htmlspecialchars($edit_data['bio']) : ''; ?></textarea>
 
            <label>Photo URL</label>
            <input type="text" name="photo_url" placeholder="e.g. /CartClub/image/pres.png"
                   value="<?php echo $edit_data ? htmlspecialchars($edit_data['photo_url']) : ''; ?>">
 
            <label>Display Order</label>
            <input type="number" name="display_order" min="1" max="99"
                   value="<?php echo $edit_data ? $edit_data['display_order'] : ''; ?>"
                   placeholder="1 = shown first">
            <p class="hint">Lower number = shown first on the homepage. E.g. President = 1, Vice President = 2.</p>
 
            <button type="submit" class="btn-red">
                <?php echo $edit_data ? 'UPDATE MEMBER' : 'ADD MEMBER'; ?>
            </button>
            <?php if ($edit_data): ?>
                <a href="admin_committee.php" class="btn-gray">CANCEL</a>
            <?php endif; ?>
        </form>
    </div>
 
    <!-- ── TABLE ────────────────────────────────────────────────────── -->
    <h2>Current Committee (<?php
        $count_result = mysqli_query($conn, "SELECT COUNT(*) as c FROM committee");
        $count_row    = mysqli_fetch_assoc($count_result);
        echo $count_row['c'];
    ?> members)</h2>
    <table>
        <thead>
            <tr>
                <th>Order</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Position</th>
                <th>Bio Preview</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($all)): ?>
            <tr>
                <td><span class="order-badge"><?php echo $row['display_order']; ?></span></td>
                <td>
                    <?php if (!empty($row['photo_url'])): ?>
                        <img class="avatar"
                             src="<?php echo htmlspecialchars($row['photo_url']); ?>"
                             alt="<?php echo htmlspecialchars($row['name']); ?>">
                    <?php else: ?>
                        <span style="color:#555">—</span>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['position']); ?></td>
                <td style="color:#777; font-size:.82rem;">
                    <?php echo $row['bio'] ? htmlspecialchars(substr($row['bio'], 0, 60)) . '…' : '—'; ?>
                </td>
                <td>
                    <a class="action-link"
                       href="admin_committee.php?edit=<?php echo $row['committee_id']; ?>">Edit</a>
                    <a class="action-link action-del"
                       href="admin_committee.php?delete=<?php echo $row['committee_id']; ?>"
                       onclick="return confirm('Remove <?php echo htmlspecialchars($row['name']); ?> from committee?')">Remove</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
 
</div>
</body>
</html>