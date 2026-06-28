
<!DOCTYPE html>
<html>
<head>
    <title>Grand Prix Society</title>
    <link rel="stylesheet" href="/CartClub/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body id="top">

<header>
<nav>
    <!-- LOGO -->
    <div class="nav-logo">
        Grand Prix<span>Society</span>
    </div>

    <!-- MIDDLE LINKS -->
    <div class="nav-links">
        <a href="/CartClub/share/index.php">Home</a>
        <a href="/CartClub/share/about.php">About</a>
        <a href="/CartClub/share/events.php">Activities</a>
        <a href="/CartClub/share/committee.php">Committee</a>
        <a href="/CartClub/share/announcements.php">Announcements</a>
        <a href="/CartClub/share/faq.php">FAQ</a>
    </div>

    <!-- RIGHT SIDE — LOGIN + SIGNUP -->
    <div class="nav-right">
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="/CartClub/share/logout.php" class="nav-login">Logout</a>
        <?php else: ?>
            <a href="/CartClub/share/login.php" class="nav-login">Login</a>
            <a href="/CartClub/share/signup.php" class="nav-btn">Sign Up</a>
        <?php endif; ?>
    </div>
</nav>
</header>