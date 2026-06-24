<?php

include('../share/db.php');

$event_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM events");
$event_row = mysqli_fetch_assoc($event_query);
$total_events = $event_row['total'];

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($search)) {
    $searchTerm = "%" . $search . "%";
    $stmt = mysqli_prepare($conn, 
        "SELECT * FROM events 
         WHERE title LIKE ? OR location LIKE ? 
         ORDER BY event_date ASC");
    mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmt);
    $events_query = mysqli_stmt_get_result($stmt);
} else {
    $events_query = mysqli_query($conn, 
        "SELECT * FROM events ORDER BY event_date ASC");
}

$hasResults = mysqli_num_rows($events_query) > 0;
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

<div class="events-section">
    <div class="events-header">
        <h2 class="events-heading">UPCOMING <span>EVENTS</span></h2>
    </div>

    <div class="events-search">
        <form method="GET" action="" class="search-form">
            <input 
                type="text" 
                name="search" 
                placeholder="Search events..." 
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                class="search-input"
            >
            <button type="submit" class="search-btn">Search</button>
            <?php if (!empty($_GET['search'])): ?>
                <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>" class="clear-search">Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="events-list">
        <?php if (!$hasResults): ?>
            <p class="no-results">No events found matching "<?php echo htmlspecialchars($search); ?>".</p>
        <?php else: ?>
            <?php
            $i = 0;
            while($event = mysqli_fetch_assoc($events_query)): 
                $month = strtoupper(date('M', strtotime($event['event_date'])));
                $day = date('d', strtotime($event['event_date']));
                $i++;
            ?>
                <div class="event-row <?php echo $i === 1 ? 'event-row-highlight' : ''; ?>">
                    <div class="event-date">
                        <span class="event-month"><?php echo $month; ?></span>
                        <span class="event-day"><?php echo $day; ?></span>
                    </div>
                    <div class="event-divider"></div>
                    <div class="event-info">
                        <h3 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h3>
                        <div class="event-meta">
                            <span class="event-location">📍 <?php echo htmlspecialchars($event['location']); ?></span>
                            <span class="event-time">🕒 <?php 
                                echo $event['event_time']       
                                    ? date('h:i A', strtotime($event['event_time'])) 
                                    : 'TBC'; ?></span>
                        </div>
                    </div>
                    <span class="event-arrow">→</span>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<style>
    .top-section {
        padding: 110px 60px 40px 60px;
        overflow: hidden;
    }

    .events-section {
        padding: 20px 60px;
        background-color: #b80000;
        border-top: 1px solid #222;
        margin-top: 5px;
        background-image:
            linear-gradient(to bottom, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
            url('/CartClub/image/actv.avif');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    .events-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .events-search {
        margin-bottom: 30px;
    }

    .search-form {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-input {
        flex: 1;
        max-width: 400px;
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    }

    .search-btn {
        padding: 10px 20px;
        border: none;
        background: #333;
        color: white;
        border-radius: 6px;
        cursor: pointer;
    }

    .search-btn:hover {
        background: #555;
    }

    .clear-search {
        font-size: 13px;
        color: #888;
        text-decoration: underline;
    }

    .no-results {
        padding: 40px;
        text-align: center;
        color: #888;
    }
</style>

<?php include('../share/footer.php'); ?>