<?php
include('db.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

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

<?php include('../share/header.php'); ?>

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
    <div class="announcement-detail-page">
        <a href="javascript:history.back()" class="back-link">← Back</a>
        <div class="announcement-detail-card">

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
    body {
        padding-top: 90px;
        background-image: url('/CartClub/image/lewistop.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        min-height: 100vh;
    }
    
    .opacity {
        background: #0b0b0bf1;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        min-height: 100vh;
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
        color: #b80000;
        font-weight: bold;
    }

    .back-link:hover {
        text-decoration: underline;
    }

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

    .announcement-detail-content {
        font-size: 16px;
        line-height: 1.6;
        color: #fff;
    }
</style>

<?php include('../share/footer.php'); ?>