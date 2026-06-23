<?php

include('../share/db.php');

$event_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM events");
$event_row = mysqli_fetch_assoc($event_query);
$total_events = $event_row['total'];
?>

<?php include('../share/header.php'); ?>

<div class="top-section"> 
    <div class="top-section-content">
        <p class="top-tag">-- 2026 UNIVERSITY GRAND PRIX --</p>
        <h1 class="top-title">EVENTS </h1>
        <p class="top-description">Discover the exciting events and programmes 
        organized by our society throughout the year.</p>
        <div class="top-buttons">

            <a href="/CartClub/share/signup.php" class="btn-primary">JOIN NOW</a>
            <a href="/CartClub/share/about.php" class="btn-secondary">EXPLORE</a>

        </div>
    </div>
</div>

