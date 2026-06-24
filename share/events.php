<?php

include('../share/db.php');

$event_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM events");
$event_row = mysqli_fetch_assoc($event_query);
$total_events = $event_row['total'];
?>

<?php include('../share/header.php'); ?>

<div class="top-section"> 
    <div class="top-section-content">
        <p class="top-tag">EXPLORE WITH US!</p>
        <h1 class="top-title">EVENTS </h1>
        <p class="top-description">Discover the exciting events and programmes 
        organized by our society throughout the year.</p>
    </div>
</div>

<div class="events-back">
    <div class="events-header">
        <h2 class="events-heading">UPCOMING <span>EVENTS</span></h2>
    </div>

    <div class="events-list">
        <?php
        $events_query = mysqli_query($conn, 
            "SELECT * FROM events ORDER BY event_date ASC ");
        
        $i = 0;
        while($event = mysqli_fetch_assoc($events_query)): 
            $month = strtoupper(date('M', strtotime($event['event_date'])));
            $day = date('d', strtotime($event['event_date']));
            $i++;
        ?>
            <a href="event-single.php?id=<?php echo $event['event_id']; ?>" 
               class="event-row <?php echo $i === 1 ? 'event-row-highlight' : ''; ?>">
                <div class="event-date">
                    <span class="event-month"><?php echo $month; ?></span>
                    <span class="event-day"><?php echo $day; ?></span>
                </div>
                <div class="event-divider"></div>
                <div class="event-info">
                    <h3 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h3>
                    <div class="event-meta">
                        <span class="event-location">📍 <?php echo htmlspecialchars($event['location']); ?></span>
                        <span class="event-time">🕒 <?php // CORRECT — check before formatting
echo $event['event_time']       
    ? date('h:i A', strtotime($event['event_time'])) 
    : 'TBC'; ?></span>
                    </div>
                </div>
                <span class="event-arrow">→</span>
            </a>
        <?php endwhile; ?>
    </div>
</div>

<?php include('../share/footer.php'); ?>

<style>
    .events-back {
        padding: 50px 60px;
        background-color: #0a0a0a;
        border-top: 1px solid #222;
        margin-top: 40px;
        background-image:
            linear-gradient(to bottom, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
            url('/CartClub/images/actv.avif');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
</style>