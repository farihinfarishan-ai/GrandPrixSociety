<?php

session_start();
 
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /CartClub/share/login.php');
    exit;
}
 
include('../share/db.php');
 
$message = '';
$error   = '';
 
// ── DELETE ────────────────────────────────────────────────────────────────────
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
 
    // Prevent admin from deleting themselves
    if ($id === (int) $_SESSION['user_id']) {
        $error = 'You cannot delete your own account.';
    } else {
        mysqli_query($conn, "DELETE FROM users WHERE user_id = $id");
        $message = 'Member removed successfully.';
    }
}
 
// ── ADD NEW USER ──────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $email     = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password  = mysqli_real_escape_string($conn, trim($_POST['password']));
    $role      = $_POST['role'] === 'admin' ? 'admin' : 'user';
 
    // Check if email already exists
    $check = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT user_id FROM users WHERE email = '$email'"));
 
    if ($check) {
        $error = 'An account with that email already exists.';
    } elseif (empty($full_name) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
    } else {
        mysqli_query($conn,
            "INSERT INTO users (full_name, email, password, role)
             VALUES ('$full_name', '$email', '$password', '$role')"
        );
        $message = "Member \"$full_name\" added successfully.";
    }
}
 
// ── FETCH all users ───────────────────────────────────────────────────────────
$users_query = mysqli_query($conn, "SELECT * FROM users ORDER BY role ASC, created_at DESC");
 
// Count stats
$total_users  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM users WHERE role='user'"))['c'];
$total_admins = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM users WHERE role='admin'"))['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin – Members | Grand Prix Society</title>
    <link rel="stylesheet" href="/CartClub/GrandPrixSocietycss/style.css">
    <style>
        * {
             box-sizing: border-box;
         }
        body
         {
             font-family: Arial, sans-serif;
             background:#0a0a0a;
             color:#f0f0f0;
             margin:0;
         }
        .admin-wrapper
         {
             max-width:1000px;
             margin:40px auto;
             padding:0 24px;
         }
        h1 
         {
             color:#e10600;
             letter-spacing:2px;
             margin-bottom:8px;
         }
        h2 
         {
             color:#ccc;
             font-size:.85rem;
             text-transform:uppercase;
             letter-spacing:2px;
             margin-bottom:16px;
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
 
        /* ── messages ── */
        .msg-ok 
         {
             background:#1a3a1a;
             border:1px solid #2d6a2d;
             color:#8fff8f;
             padding:10px 16px;
             border-radius:4px;
             margin-bottom:20px;
         }
        .msg-err
         {
             background:#3a1a1a;
             border:1px solid #6a2d2d;
             color:#ff8f8f;
             padding:10px 16px;
             border-radius:4px;
             margin-bottom:20px;
         }
 
        /* ── stat row ── */
        .stat-row
         {
             display:grid;
             grid-template-columns:repeat(3,1fr);
             gap:16px;
             margin-bottom:36px;
         }
        .stat-card
         {
             background:#141414;
             border:1px solid #222;
             border-radius:8px;
             padding:20px;
             text-align:center;
         }
        .stat-card .num
         {
             font-size:2rem;
             font-weight:bold;
             color:#e10600;
         }
        .stat-card .lbl
         {
             font-size:.75rem;
             color:#777;
             text-transform:uppercase;
             letter-spacing:1px;
             margin-top:4px;
         }
 
        /* ── add form ── */
        .admin-form
         {
             background:#141414;
             border:1px solid #2a2a2a;
             padding:24px;
             border-radius:8px;
             margin-bottom:40px;
         }
        .form-row 
          {
             display:grid;
             grid-template-columns:1fr 1fr;
             gap:16px;
         }
        .admin-form label
         {
             display:block;
             margin-bottom:4px;
             color:#aaa;
             font-size:.82rem;
         }
        .admin-form input,
        .admin-form select
         {
            width:100%;
             padding:10px 12px;
              margin-bottom:16px;
            background:#111;
             border:1px solid #333;
              color:#f0f0f0;
            border-radius:4px;
             font-size:.95rem;
        }
        .admin-form select option
         {
             background:#111;
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
 
        /* ── table ── */
        .table-wrap
         {
             overflow-x:auto;
         }
        table
         {
             width:100%;
             border-collapse:collapse;
             min-width:600px;
         }
        th, td
         {
             padding:12px 14px;
             text-align:left;
             border-bottom:1px solid #1e1e1e;
             font-size:.88rem;
         }
        th
         {
             background:#181818;
             color:#e10600;
             text-transform:uppercase;
             font-size:.75rem;
             letter-spacing:1px;
         }
        tr:hover
         {
             background:#111;
         }
 
        /* role badge */
        .badge-admin
         {
             display:inline-block;
             background:rgba(225,6,0,0.15);
             border:1px solid #e10600;
             color:#e10600;
             padding:2px 10px;
             border-radius:12px;
             font-size:.75rem;
             font-weight:700;
             letter-spacing:1px;
         }
        .badge-user
          {
             display:inline-block;
             background:#1a1a1a;
             border:1px solid #333;
             color:#777;
             padding:2px 10px;
             border-radius:12px;
             font-size:.75rem;
             letter-spacing:1px;
         }
 
        /* action links */
        .action-del
         {
             color:#555;
             text-decoration:none;
             font-size:.82rem;
         }
        .action-del:hover
         {
             color:#e10600;
         }
        .self-tag
         {
             color:#555;
             font-size:.78rem;
             font-style:italic;
         }
 
        /* search */
        .search-bar
         {
             width:100%;
             padding:10px 14px;
             background:#111;
             border:1px solid #333;
             color:#f0f0f0;
             border-radius:4px;
             font-size:.95rem;
              margin-bottom:16px;
         }
        .search-bar:focus
         {
             outline:none;
             border-color:#e10600;
         }
    </style>
</head>
<body>
<div class="admin-wrapper">
 
    <a class="nav-back" href="admin_dashboard.php">← Back to Dashboard</a>
    <h1>👥 MANAGE MEMBERS</h1>
 
    <?php if ($message): ?>
        <div class="msg-ok"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="msg-err"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
 
    <!--STATS-->
    <div class="stat-row">
        <div class="stat-card">
            <div class="num"><?php echo $total_users + $total_admins; ?></div>
            <div class="lbl">Total Accounts</div>
        </div>
        <div class="stat-card">
            <div class="num"><?php echo $total_users; ?></div>
            <div class="lbl">Common Members</div>
        </div>
        <div class="stat-card">
            <div class="num"><?php echo $total_admins; ?></div>
            <div class="lbl">Admins</div>
        </div>
    </div>
 
    <!-- ADD NEW MEMBER FORM -->
    <div class="admin-form">
        <h2>➕ Add New Member</h2>
        <form method="POST">
            <div class="form-row">
                <div>
                    <label>Full Name *</label>
                    <input type="text" name="full_name" required placeholder="e.g. Ahmad Faiz">
                </div>
                <div>
                    <label>Email *</label>
                    <input type="email" name="email" required placeholder="e.g. ahmad@gmail.com">
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label>Password *</label>
                    <input type="text" name="password" required placeholder="Set a password">
                </div>
                <div>
                    <label>Role *</label>
                    <select name="role">
                        <option value="user">User<option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn-red">ADD MEMBER</button>
        </form>
    </div>
 
    <!-- ── MEMBERS TABLE ── -->
    <h2>All Members</h2>
    <input class="search-bar" type="text" id="searchInput"
           placeholder="Search by name or email..." onkeyup="filterTable()">
 
    <div class="table-wrap">
        <table id="membersTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($user = mysqli_fetch_assoc($users_query)): ?>
                <tr>
                    <td><?php echo $user['user_id']; ?></td>
                    <td>
                        <?php echo htmlspecialchars($user['full_name']); ?>
                        <?php if ($user['user_id'] == $_SESSION['user_id']): ?>
                            <span class="self-tag">(you)</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <?php if ($user['role'] === 'admin'): ?>
                            <span class="badge-admin">ADMIN</span>
                        <?php else: ?>
                            <span class="badge-user">MEMBER</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $user['created_at']
                            ? date('d M Y', strtotime($user['created_at']))
                            : '—'; ?>
                    </td>
                    <td>
                        <?php if ($user['user_id'] != $_SESSION['user_id']): ?>
                            <a class="action-del"
                               href="admin_users.php?delete=<?php echo $user['user_id']; ?>"
                               onclick="return confirm('Remove <?php echo htmlspecialchars($user['full_name']); ?> from the system?')">
                                Remove
                            </a>
                        <?php else: ?>
                            <span class="self-tag">Cannot delete </span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
 
</div>
 
<script>
function filterTable() {
    const input  = document.getElementById('searchInput').value.toLowerCase();
    const rows   = document.querySelectorAll('#membersTable tbody tr');
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
    });
}
</script>
 
</body>
</html>