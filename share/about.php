<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include ('../share/db.php');

$member_query = mysqli_query ($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'user'");
$member_row = mysqli_fetch_assoc($member_query);
$total_members = $member_row['total'];

$event_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM events");
$event_row = mysqli_fetch_assoc($event_query);

$total_events = $event_row['total'];
$total_members = $member_row['total'];

$award_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM awards");
$award_row = mysqli_fetch_assoc($award_query);
$total_awards = $award_row['total'];

$committee_query = mysqli_query($conn, "SELECT * FROM committee ORDER BY display_order ASC");//all this to collect the number of events and connect back to the page, so its dynamic
// this to collect number of events and connect it back to front page, so itll be dynamic not static
?>

<?php include('../share/header.php'); ?>

<style>
    .mission-section {
        padding: 60px 60px 70px 60px;
        background-color: #0a0a0a;
        border-top: 1px solid #222;
        border-bottom: 1px solid #222;
    }
 
    .mission-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        margin-top: 50px;
    }
 
    .mission-card {
        background-color: #111;
        border: 1px solid #222;
        padding: 30px 24px;
        transition: border-color 0.2s;
    }
 
    .mission-card:hover {
        border-color: #CC0000;
    }
 
    .mission-card h3 {
        font-size: 22px;
        font-weight: 700;
        color: white;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 12px;
        font-family: 'Barlow Condensed', sans-serif;
    }
 
    .mission-card p {
        font-size: 15px;
        color: #aaaaaa;
        line-height: 1.6;
        font-family: 'Barlow Condensed', sans-serif;
    }

    .history-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 520px;
        background-color: #0a0a0a;
    }
 
    .history-left {
        padding: 60px;
    }
 
    .history-right {
        background-size: cover;
        background-position: center;
    }
 
    .history-intro {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 16px;
        color: #aaaaaa;
        line-height: 1.6;
        margin: 20px 0 40px;
        max-width: 480px;
    }
 
    .history-timeline {
        display: flex;
        flex-direction: column;
        gap: 28px;
    }
 
    .history-item {
        display: flex;
        gap: 20px;
        align-items: flex-start;
        border-left: 2px solid #CC0000;
        padding-left: 20px;
    }
 
    .history-year {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 700;
        font-size: 22px;
        color: #CC0000;
        min-width: 64px;
        flex-shrink: 0;
    }
 
    .history-text {
        font-family: 'Barlow Condensed', sans-serif;
        color: #cccccc;
        font-size: 15px;
        line-height: 1.6;
    }

     .cta-section {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #1a0000 0%, #0a0a0a 60%);
        border-top: 1px solid #222;
        padding: 80px 60px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
    }
 
    .cta-content {
        position: relative;
        z-index: 2;
        max-width: 560px;
    }
 
    .cta-heading {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 800;
        font-size: 48px;
        line-height: 1.1;
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 20px;
    }
 
    .cta-desc {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 17px;
        color: #bbbbbb;
        line-height: 1.6;
        margin-bottom: 36px;
        max-width: 420px;
    }
 
    .cta-buttons {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
    }
 
    .btn-primary-dark,
    .btn-outline-white {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        text-decoration: none;
        padding: 16px 32px;
        border-radius: 2px;
        transition: all 0.2s ease;
        display: inline-block;
    }
 
    .btn-primary-dark {
        background-color: #CC0000;
        color: #ffffff;
        border: 1px solid #CC0000;
    }
 
    .btn-primary-dark:hover {
        background-color: #a30000;
        border-color: #a30000;
    }
 
    .btn-outline-white {
        background-color: transparent;
        color: #ffffff;
        border: 1px solid #555555;
    }
 
    .btn-outline-white:hover {
        border-color: #ffffff;
        background-color: rgba(183, 16, 16, 0.05);
    }
 
    .cta-image {
        position: relative;
        z-index: 1;
        width: 45%;
        max-width: 480px;
        height: auto;
        object-fit: contain;
        filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.6));
    }
 
    @media (max-width: 900px) {
        .cta-section {
            flex-direction: column;
            text-align: center;
            padding: 60px 30px;
        }
        .cta-content {
            max-width: 100%;
        }
        .cta-buttons {
            justify-content: center;
        }
        .cta-image {
            width: 70%;
            margin-top: 40px;
        }
    }
</style>
 
    

<div class="top-section">
    <div class="top-section-content">
        <p class="top-tag">  WHO WE ARE  </p>
        <h1 class="top-title"> ABOUT <span>US</span></h1>
        <p class="top-description">Grand Prix Society is more than a club, it's a team of 
            students who design, build and race single-seat cars on an international stage.</
            p>
</div>
 <!-- for the introduction part, head of page -->
</div>


<div class="about-section">
    <div class="about-left">
        <img src="/CartClub/image/about.png" alt="Team Photo" class="about-image">
    </div>
    <div class="about-right">
        <h2 class="stats-heading">OUR <br><span>STORY</span></h2>
        <p class="about-desc">
            We are the Grand Prix Society. The club challenges students to design, build,
            and market single-seat, open-wheel race cars to compete in the annual summer
            engineering competitions hosted at the iconic Silverstone circuit in the UK.
            What started as a small group of motorsport enthusiasts has grown into a full
            engineering team covering chassis design, aerodynamics, electronics, and team
            management.
        </p>
    </div>
</div>
<!-- mainly body -->

<div class="history-section">
    <div class="history-left">
        <h2 class="stats-heading"> OUR <br><span>HISTORY</span></h2>
        <p class="history-intro">
            From a handful of motorsport enthusiasts to a full-scale student engineering body, here's how Grand Prix Society got up to speed. 
</p>
<div class="history-timeline">
    <div class="history-item">
        <div class="history-year">2018 </div>
        <div class="history-text">Founded by a small group of students with a shared love a motorsport and a garage full of spare parts. </div>
</div>

<div class="history-item">
    <div class="history-year">2020</div>
    <div class="history-text">Built and tested the society's first complete single-seat chassis. </div>
</div>

 <div class="history-item">
                <div class="history-year">2022</div>
                <div class="history-text">Made the team's first appearance at the Silverstone summer engineering competition.</div>
            </div>
            <div class="history-item">
                <div class="history-year">2025</div>
                <div class="history-text">Grew into a full multi-discipline team and brought home the society's first national award.</div>
            </div>
        </div>
    </div>
    <!-- each class will be different timeline so will appear much more easy to view -->

     <div class="history-right" style="background-image: linear-gradient(to right, rgba(10,10,10,0.8), rgba(0,0,0,0)), url('/CartClub/image/lewis2.png');">
    </div>
    <!-- background photo fill one half of history section -->
</div>


<div class="stats-section">
    
    <div class="stats-right" style="
        background-image: linear-gradient(to left, rgba(10,10,10,0.8), rgba(0,0,0,0)),
        url('/CartClub/image/lewis2.png');
        background-size: cover;
        background-position: center;">
    </div>
    <div class="stats-left">
        <h2 class ="stats-heading">THE SOCIETY <br><span>IN FIGURES</span></h2>

        <div class = "stats-list">
            <div class="stat-item">
                <div class="stat-number"><?php echo $total_members; ?>+</div>
                <div class="stat-label">Active Members</div>
                <!-- collects from query member, sql database -->
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $total_events; ?></div>
                <div class="stat-label">Events This Year</div>
            </div>
            <!-- collects from query event, sql database -->

            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $total_awards; ?></div>
                <div class="stat-label">National Awards</div>
                <!-- collects from query award, sql database, so will display number or amount already added or follow update from database -->
            </div>
        </div>
    </div>
</div>

<div class="mission-section">
    <h2 class="stats-heading">OUR <span>MISSION</span></h2>
    <div class="mission-grid">
        <div class="mission-card">
            <h3>Design</h3>
            <p>Engineer a competitive open-wheel race car from the ground up, applying real classroom theory to a real machine.</p>
        </div>
        <!-- also designed to have each mission in one space, too make less compact -->
        <div class="mission-card">
            <h3>Build</h3>
            <p>Turn drawings into hardware — chassis fabrication, electronics wiring, and final assembly, all done by students.</p>
        </div>
        <div class="mission-card">
            <h3>Compete</h3>
            <p>Represent the university at the Silverstone summer engineering competitionagainst teams from across the world.</p>
        </div>
        <div class="mission-card">
            <h3>Mentor</h3>
            <p>Pass down knowledge every season so new members can join with no prior experience and leave as confident engineers.</p>
        </div>
    </div>
</div>
<!-- each box is a different goal to be envisioned by the club -->
<!-- 
<div class="committee-section">
    <div class="committee-header">
        <h2 class="committee-heading">MEET THE <span>COMMITTEE</span></h2>
        <p class="committee-sub">The dedicated team driving Grand Prix Society forward this season.</p>
    </div>
    <div class="committee-row">
        <?php while($member = mysqli_fetch_assoc($committee_query)): ?>
            <div class="committee-card">
                <?php if (!empty($member['photo_url'])): ?>
                    <img src="<?php echo htmlspecialchars($member['photo_url']); ?>"
                         class="committee-photo"
                         alt="<?php echo htmlspecialchars($member['name']); ?>">
                <?php endif; ?>
                <div class="committee-overlay">
                    <h3 class="committee-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                    <p class="committee-position"><?php echo htmlspecialchars($member['position']); ?></p>
                    <a href="committee-profile.php?id=<?php echo $member['committee_id']; ?>" class="committee-know-more">KNOW MORE →</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div> -->


<div class="cta-section">
    <div class="cta-content">
        <h2 class="cta-heading">WANT TO BE <br>PART OF THE TEAM?</h2>
        <p class="cta-desc">Membership is open for Season 2026. Lock in your spot before lights out.</p>
        <div class="cta-buttons">
            <a href="signup.php" class="btn-primary-dark">SIGN UP →</a>
            
        </div>
    </div>
    <img src="/CartClub/image/cta-car.png" class="cta-image">
</div>
<!-- a button to connect directly to the sign up page and contact page -->
 
<?php include('../share/footer.php'); ?>

