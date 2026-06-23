<?php

include('../share/db.php');

$ann_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM announcements");
$ann_row = mysqli_fetch_assoc($ann_query);
$total_ann = $ann_row['total'];
?>

<?php include('../share/header.php'); ?>

<div class="top-section"> 
    <div class="top-section-content">
        <p class="top-tag">CURRENT NEWS</p>
        <h1 class="top-title">ANNOUNCEMENTS </h1>
        <p class="top-description">Stay informed with the latest updates, 
        upcoming events, registration opportunities, important notices, 
        and society news.</p>
    </div>
</div>

<div class="announcement-section">
    <h2 class="stats-heading"> ANNOUNCEMENT <br><span> AND NEWS </span></h2>
    
<div class="announcement-grid">
    <?php
    $announcements_query = mysqli_query($conn, 
        "SELECT * FROM announcements ORDER BY created_at DESC");
    
    while($announcement = mysqli_fetch_assoc($announcements_query)): ?>
        <div class="announcement-card">
            <div class="announcement-image" 
                 style="<?php echo !empty($announcement['image_url']) 
                    ? "background-image: url('".htmlspecialchars($announcement['image_url'])."');" 
                    : ''; ?>">
                <?php if (empty($announcement['image_url'])): ?>
                    <span class="announcement-placeholder">GPS</span>
                <?php endif; ?>
            </div>

            <div class="announcement-card-body">
                <p class="announcement-date">
                    <?php echo date('d M Y', strtotime($announcement['created_at'])); ?>
                </p>
                <h3 class="announcement-title">
                    <?php echo htmlspecialchars($announcement['title']); ?>
                </h3>
                <p class="announcement-desc">
                    <?php echo htmlspecialchars(substr($announcement['content'], 0, 100)); ?>...
                </p>
                <a href="/CartClub/share/announcements.php?id=<?php echo $announcement['ann_id']; ?>" class="read-more">READ MORE →</a>

                <a href="/CartClub/share/announcements.php?id=<?php echo $announcement['ann_id']; ?>" class="read-more">READ MORE →</a>


                <div class="announcement-divider"></div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<div class="anouncement-detail">
    <div class="announcement-left">

        <img src="/CartClub/image/about.png" alt="Team Photo" class="about-image">

    </div>
    <div class="announcement-right">
        <h2 class="stats-heading">BACK TO <br><span>HISTORY</span></h2>
        <p class = "about-desc"> We are the Grand Prix Society. 
        The club challenges students to design, build, and market single-seat, 
        open-wheel race cars to compete in the annual summer engineering competitions 
        hosted at the iconic Silverstone circuit in the UK. </p> 
</div>



<?php include('../share/footer.php'); ?>