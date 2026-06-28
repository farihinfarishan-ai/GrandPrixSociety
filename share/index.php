<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "PHP is working!";

// this is for to test the errror and display error

include('../share/db.php');

$member_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'user'");
$member_row = mysqli_fetch_assoc($member_query);
$total_members = $member_row['total'];

$ann_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM announcements");
$ann_row = mysqli_fetch_assoc($ann_query);
$total_ann = $ann_row['total'];
// $conn is the connection to db.php yang connect with database 
// count is the total rows for announcement table 
// from announcement table 
// $ann quesry is tempat dia nak ambik results and convert to php so boleh baca
$event_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM events");
$event_row = mysqli_fetch_assoc($event_query);
$total_events = $event_row['total'];

$award_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM awards");
$award_row = mysqli_fetch_assoc($award_query);
$total_awards = $award_row['total'];
?>

<?php include('../share/header.php'); ?>
<!-- include footer and header using include --> 
 <!-- Top section / Hero Section --> 
<div class="top-section"> 
    <div class="top-section-content">
        <p class="top-tag">-- 2026 UNIVERSITY GRAND PRIX --</p>
        <h1 class="top-title">GRAND PRIX <span>SOCIETY</span></h1>
        <p class="top-description">The Grand Prix Society is a student-led organization 
        dedicated to promoting the excitement and culture of motorsports on campus.</p>
        <div class="top-buttons">
 <!-- Connect to other files when Click the Button --> 
            <a href="/CartClub/share/signup.php" class="btn-primary">JOIN NOW</a>
            <a href="/CartClub/share/about.php" class="btn-secondary">EXPLORE</a>

        </div>
    </div>
</div>

 <!-- Club in Numbers Section --> 

<div class="stats-section">
    <div class="stats-left">
    
        <h2 class="stats-heading">THE SOCIETY <br><span>IN FIGURES</span></h2>

        <div class="stats-list">
            <div class="stat-item">
                <div class="stat-number"><?php echo $total_members; ?>+</div>
                <div class="stat-label">Active Members</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $total_events; ?></div>
                <div class="stat-label">Events This Year</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $total_ann; ?></div>
                <div class="stat-label">Announcements</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $total_awards; ?></div>
                <div class="stat-label">National Awards</div>
            </div>
        </div>
    </div>

     <!-- Background image with gradient --> 
   <div class="stats-right" style="
    background-image: linear-gradient(to right, rgba(10,10,10,0.8), rgba(0,0,0,0)),

    /* url('/GrandPrixSociety-main/image/lewis2.png'); */

    url('/CartClub/image/lewis2.png');

    background-size: cover;
    background-position: center;">
</div>
</div>
 <!-- Announcement Section --> 
 <div class="announcement-section">

        <h2 class="stats-heading"> ANNOUNCEMENT <br><span> AND NEWS </span></h2>

<div class="announcement-grid">
    <?php
    $announcements_query = mysqli_query($conn, 
        "SELECT * FROM announcements ORDER BY created_at DESC LIMIT 3");
    // this one code to show that on page will list down only 3 
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
   <!-- Announcement Card Body and Section --> 
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
                <a href="/CartClub/share/description.php?id=<?php echo $announcement['ann_id']; ?>" class="read-more">READ MORE →</a>
                <div class="announcement-divider"></div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
<!-- event section -->
<div class="events-section">
    <div class="events-header">
        <h2 class="events-heading">UPCOMING <span>EVENTS</span></h2>
        <a href="events.php" class="see-more">SEE MORE →</a>
        <!-- connect with events.php file when click see more  -->
    </div>

    <div class="events-list">
        <?php
        $events_query = mysqli_query($conn, 
            "SELECT * FROM events ORDER BY event_date ASC LIMIT 3");
        
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
                        <!-- htmlspechialchars for php function that convert char to HTML entities-->
                        <span class="event-location">📍 <?php echo htmlspecialchars($event['location'] ?? 'TBC'); ?></span>
                        <span class="event-time">🕒 <?php 
                            echo $event['event_time']       
                                ? date('h:i A', strtotime($event['event_time'])) 
                                : 'TBC'; ?></span>
                    </div>
                </div>
                <span class="event-arrow">→</span>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- untuk profile  -->
 <div class="committee-section">
    <div class="committee-header">
        <h2 class="committee-heading">MEET THE <span>COMMITTEE</span></h2>
        <p class="committee-sub">The dedicated team driving Grand Prix Society forward this season.</p>
    </div>

    <div class="committee-row">
        <?php
        $committee_query = mysqli_query($conn, 
            "SELECT * FROM committee ORDER BY display_order ASC");
        
        while($member = mysqli_fetch_assoc($committee_query)): ?>
            <div class="committee-card">
                <?php if (!empty($member['photo_url'])): ?>
                    <img src="<?php echo htmlspecialchars($member['photo_url']); ?>" 
                         class="committee-photo" 
                         alt="<?php echo htmlspecialchars($member['name']); ?>">
                <?php endif; ?>
                <div class="committee-overlay">
                    <h3 class="committee-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                    <p class="committee-position"><?php echo htmlspecialchars($member['position']); ?></p>
                    <a href="/CartClub/share/committee.php?id=<?php echo $member['committee_id']; ?>" class="committee-know-more">KNOW MORE →</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<!--  this is for the about us  -->
<div class="about-section">
    <div class="about-left">

        <img src="/CartClub/image/about.png" alt="Team Photo" class="about-image">

    </div>
    <div class="about-right">
        <h2 class="stats-heading">BACK TO <br><span>HISTORY</span></h2>
        <p class = "about-desc"> We are the Grand Prix Society. 
        The club challenges students to design, build, and market single-seat, 
        open-wheel race cars to compete in the annual summer engineering competitions 
        hosted at the iconic Silverstone circuit in the UK. </p> 
</div>
<a href="about.php" class="see-more">SEE MORE →</a>
<!--  connect to about.php or about section  -->
    </div>
                </div>
<div class="cta-section">
    <div class="cta-content">
        <h2 class="cta-heading">READY TO TAKE <br>YOUR SEAT?</h2>
        <p class="cta-desc">Membership is open for Season 2026. Lock in your spot before lights out.</p>
        <div class="cta-buttons">
            <a href="signup.php" class="btn-primary-dark">SIGN UP →</a>
            <a href="events.php" class="btn-outline-white">DISCOVER</a>
            <!--  connect to signup.php and events.php so open the file code  -->
        </div>
    </div>

<img src="/GrandPrixSociety-main/image/cta-car.png" class="cta-image">

<img src="/CartClub/image/cta-car.png" class="cta-image">
<!-- link with the car image -->
</div>

<?php include('../share/footer.php'); ?>