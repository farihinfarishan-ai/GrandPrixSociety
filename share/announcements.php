<?php

include('../share/db.php');

$ann_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM announcements");
$ann_row = mysqli_fetch_assoc($ann_query);
$total_ann = $ann_row['total'];
?>

<?php include('../share/header.php'); ?>

<div class="top-section"> 
    <div class="top-section-content">
        <p class="top-tag">-- 2026 UNIVERSITY GRAND PRIX --</p>
        <h1 class="top-title">ANNOUNCEMENTS </h1>
        <p class="top-description">Stay informed with the latest updates, 
        upcoming events, registration opportunities, important notices, 
        and society news. Check this section regularly to ensure you never 
        miss an important announcement.</p>
        <div class="top-buttons">

            <a href="/CartClub/share/signup.php" class="btn-primary">JOIN NOW</a>
            <a href="/CartClub/share/about.php" class="btn-secondary">EXPLORE</a>

        </div>
    </div>
</div>

