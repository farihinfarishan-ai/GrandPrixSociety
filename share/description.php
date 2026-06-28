<?php
include('db.php');
// this one to connect with sql base 

/* Get the announcement ID from the URL */ 
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

/* If no valid ID provided redirect back to homepage
   This prevents someone visiting the page with no ?id= */
if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM announcements WHERE ann_id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$announcement = mysqli_fetch_assoc($result);

if (!$announcement) {
    header("Location: index.php");
    exit;
}
?>

<?php include('../share/header.php'); // load header ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($announcement['title']); ?></title>
    <link rel="stylesheet" href="/CartClub/share/style.css">
</head>
<body>
<div class="opacity">
    <!-- Main announcement card -->
    <div class="announcement-detail-page">
        <a href="javascript:history.back()" class="back-link">← Back</a>
        <div class="announcement-detail-card">
<!-- Banner image at top of card --> 
            <?php if (!empty($announcement['image_url'])): ?>
                <div class="announcement-detail-image" 
                    style="background-image: url('<?php echo htmlspecialchars($announcement['image_url']); ?>');">
                </div>
            <?php endif; ?>

            <div class="announcement-detail-body">
                <p class="announcement-date">
                    <?php echo date('d M Y', strtotime($announcement['created_at'])); ?>
                </p>

                <h1 class="announcement-detail-title">
                    <?php echo htmlspecialchars($announcement['title']); ?>
                </h1>

                <div class="announcement-detail-content">
                    <?php echo nl2br(htmlspecialchars($announcement['content'])); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<style>

    /* Extra top padding so content clears the fixed navbar */
    
    body {
        position: relative;
        padding-top: 90px;
        min-height: 100vh;
    }
 /* Blurred background image behind the whole page */ 
    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('/CartClub/image/lewistop.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        filter: blur(8px) brightness(0.4);
        transform: scale(1.1);
        z-index: -2;
    }

    .opacity {
        position: relative;
        min-height: 100vh;
        z-index: 1;
    }

    .announcement-detail-page {
        max-width: 800px;
        margin: 0 auto 40px;
        padding: 0 20px;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 20px;
        margin-top: 20px;
        text-decoration: none;
        color: #fff;
        font-weight: bold;
    }

    .back-link:hover {
        text-decoration: underline;
    }
/* announcement writting  */ 
    .announcement-detail-card {
        border-radius: 1px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        background: #101010fa;
    }

    .announcement-detail-image {
        width: 100%;
        height: 350px;
        background-size: cover;
        background-position: center;
    }

    .announcement-detail-body {
        padding: 30px;
    }

    .announcement-detail-title {
        margin: 10px 0 20px;
        font-size: 28px;
        color: #b80000;
    }
/* content */ 
    .announcement-detail-content {
        font-size: 16px;
        line-height: 1.6;
        color: #fff;
    }
</style>

<?php include('../share/footer.php'); ?>