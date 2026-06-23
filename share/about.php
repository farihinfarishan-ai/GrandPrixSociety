<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include ('../share/db.php');

// $member_query = mysqli_query ($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'user'");
// $member_row = mysqli_fetch_assoc($member_query);
// $total_members = $member_row['total'];

// $event_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM events");
// $event_row = mysqli_fetch_assoc($event_query);
// $total_members = $member_row['total'];

// $award_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM awards");
// $award_row = mysqli_query($award_query);
// $total_awards = $award_row['total'];

// $committee_query = mysqli_query($conn, "SELECT * FROM committee ORDER BY display_order ASC");
// ?>

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
</style>
 
    

<div class="top-section">
    <div class="top-section-content">
        <p class="top-tag">  WHO WE ARE  </p>
        <h1 class="top-title"> ABOUT <span>US</span></h1>
        <p class="top-description">Grand Prix Society is more than a club, it's a team of 
            students who design, build and race single-seat cars on an international stage.</
            p>
</div>
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

<div class="stats-section">
    <div class="stats-left">
        <h2 class ="stats-heading">THE SOCIETY <br><span>IN FIGURES</span></h2>

        <div class = "stats-list">
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
                <div class="stat-number"><?php echo $total_awards; ?></div>
                <div class="stat-label">National Awards</div>
            </div>
        </div>
    </div>
    <div class="stats-right" style="
        background-image: linear-gradient (to right, rgba(10,10,10,0.8), rgba(0,0,0,0)),
        url('/CartClub/image/lewis2.png');
        background-size: cover;
        background-position: center;">
    </div>
</div>

<div class="mission-section">
    <h2 class="stats-heading">OUR <span>MISSION</span></h2>
    <div class="mission-grid">
        <div class="mission-card">
            <h3>Design</h3>
            <p>Engineer a competitive open-wheel race car from the ground up, applying real classroom theory to a real machine.</p>
        </div>
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
</div>

<div class="cta-section">
    <div class="cta-content">
        <h2 class="cta-heading">WANT TO BE <br>PART OF THE TEAM?</h2>
        <p class="cta-desc">Membership is open for Season 2026. Lock in your spot before lights out.</p>
        <div class="cta-buttons">
            <a href="signup.php" class="btn-primary-dark">SIGN UP →</a>
            <a href="contact.php" class="btn-outline-white">GET IN TOUCH</a>
        </div>
    </div>
    <img src="/CartClub/image/cta-car.png" class="cta-image">
</div>
 
<?php include('../share/footer.php'); ?>

