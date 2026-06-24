<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../share/db.php');

$committee_query = mysqli_query($conn, "SELECT * FROM committee ORDER BY display_order ASC");

// pull everything into array so can use same data for achievement
$committee_members = [];
while ($row = mysqli_fetch_assoc($committee_query)) {
    $committee_members[]=$row;
}
?>

<?php include('../share/header.php'); ?>

<style>
    .committee-section {
        padding: 60px 60px;
        background-color: #0a0a0a;
        border-top: 1px solid #222;
    }

    .committee-heading {
        font-size: 56px;
        font-weight: 700;
        text-transform: uppercase;
        color: white;
        line-height: 1;
        margin-bottom: 10px;
        text-align: left;
        position: sticky;
    }

    .committee-heading span {
        color: #CC0000;
    }

    .committee-sub {
        font-size: 16px;
        color: #888;
        max-width: 600px;
        margin-bottom: 50px;
    }

    .committee-row {
        display: flex;
        height: 480px;
        overflow: hidden;
    }

    .committee-card {
        position: relative;
        flex: 1;
        display: flex;
        flex-direction: column;
        padding: 30px 20px 30px 60px;
        color: white;
        transition: flex 0.4s ease;
        overflow: hidden;
        background-color: #111;
    }

    .committee-card:hover {
        flex: 1.1;
    }

    .committee-photo {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
        opacity: 0.85;
    }

    .committee-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0) 30%, rgba(0,0,0,0.8) 100%);
        z-index: 1;
        pointer-events: none;
    }

    .committee-overlay {
        position: relative;
        z-index: 2;
    }

    .committee-name {
        font-size: 18px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 4px;
        margin-top: 200%;
    }

    .committee-position {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 2px;
        opacity: 1;
        margin-bottom: 12px;
    }

    .committee-know-more {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        color: white;
        text-decoration: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        padding-bottom: 2px;
    }

    .member-detail-section {
        padding: 60px 60px;
        background-color: #0a0a0a;
        border-top: 1px solid #222;
    }

    .member-detail {
        display: flex;
        gap: 50px;
        padding: 50px 0;
        border-bottom: 1px solid #222;
        scroll-margin-top: 90px; 
        /* keep content clear from the fixed position when jumped to */
    }

    .member-detail:last-child {
        border-bottom: none;
    }

    .member-detail-photo {
        width: 280px;
        height: 340px;
        flex-shrink: 0;
        background-color: #111;
        overflow: hidden;
    }

     .member-detail-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
    }
 
    .member-detail-info {
        flex: 1;
    }
 
    .member-detail-tag {
        color: #CC0000;
        font-size: 13px;
        letter-spacing: 3px;
        font-weight: 600;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
 
    .member-detail-name {
        font-size: 36px;
        font-weight: 900;
        text-transform: uppercase;
        color: white;
        margin: 0 0 4px 0;
        letter-spacing: 1px;
    }
 
    .member-detail-position {
        font-size: 14px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #888;
        margin: 0 0 20px 0;
    }
 
    .member-detail-bio {
        font-size: 16px;
        color: #aaaaaa;
        line-height: 1.8;
        max-width: 650px;
        margin-bottom: 24px;
    }
 
    .member-detail-subheading {
        font-size: 16px;
        font-weight: 700;
        letter-spacing: 2px;
        color: white;
        text-transform: uppercase;
        margin-bottom: 14px;
    }
 
    .achievement-list {
        list-style: none;
        margin: 0 0 20px 0;
        padding: 0;
        max-width: 650px;
    }
 
    .achievement-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #1a1a1a;
        color: white;
        font-size: 15px;
    }
 
    .achievement-item:last-child {
        border-bottom: none;
    }
 
    .achievement-icon {
        color: #CC0000;
        font-size: 13px;
        line-height: 1.6;
    }
 
    .member-back-link {
        display: inline-block;
        color: #aaaaaa;
        font-size: 12px;
        letter-spacing: 2px;
        text-decoration: none;
        text-transform: uppercase;
        margin-top: 10px;
        transition: color 0.2s;
    }
 
    .member-back-link:hover {
        color: white;
    }
 
    @media (max-width: 800px) {
        .member-detail {
            flex-direction: column;
        }
        .member-detail-photo {
            width: 100%;
            height: 320px;
        }
    }
</style>

<div class="top-section">
    <div class="top-section-content">
        <p class="top-tag">  WHO WE ARE  </p>
        <h1 class="top-title">THE <span>COMMITTEE</span></h1>
        <p class="top-description">Meet the students steering Grand Prix Society this season — from chassis design to event logistics, here's who's behind the wheel.</p>
    </div>
</div>

<div class="committee-section">
    <div class="committee-header">
        <h2 class="committee-heading">MEET THE <span>COMMITTEE</span></h2>
        <p class="committee-sub">The dedicated team driving Grand Prix Society forward this season.</p>
    </div>

    <div class="committee-row">
        <?php foreach ($committee_members as $member): ?>
            <div class="committee-card">
                 <?php if (!empty($member['photo_url'])): ?>
                    <img src="<?php echo htmlspecialchars($member['photo_url']); ?>"
                         class="committee-photo"
                         alt="<?php echo htmlspecialchars($member['name']); ?>">
                <?php endif; ?>
                <!-- prints img tag if member has photo_url in database -->
                <div class="committee-overlay">
                    <h3 class="committee-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                    <p class="committee-position"><?php echo htmlspecialchars($member['position']); ?></p>
                    <a href="#member-<?php echo $member['committee_id']; ?>" class="committee-know-more">KNOW MORE →</a>
                </div>
                <!-- so if committee_id is 3, the link will jump to respective member which has id(unique) -->
            </div>
        <?php endforeach; ?>
    </div>
    <!-- closes the loop so it doesnt check each member, so closes the committee-row and section -->
</div>
 
<div class="member-detail-section">
    <div class="committee-header">
        <h2 class="committee-heading">BIOS & <span>ACHIEVEMENTS</span></h2>
        <p class="committee-sub">A closer look at the people behind the team — their story so far, and what they've achieved with Grand Prix Society.</p>
    </div>
 
    <?php foreach ($committee_members as $member): ?>
        <!-- loop through same member instead of running whole query again -->
        <?php
            $achievements = [];
            if (!empty($member['achievements'])) {
                $achievements = array_filter(array_map('trim', explode("\n", $member['achievements'])));
            }
            //  explode, split achievement text on every break, trim removes unecessary space, filter removes empty entries
        ?>
        <div class="member-detail" id="member-<?php echo $member['committee_id']; ?>">
            <div class="member-detail-photo">
                <?php if (!empty($member['photo_url'])): ?>
                    <img src="<?php echo htmlspecialchars($member['photo_url']); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>">
                <?php endif; ?>
            </div>
            <div class="member-detail-info">
                <p class="member-detail-tag">SEASON 2026 COMMITTEE</p>
                <h3 class="member-detail-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                <p class="member-detail-position"><?php echo htmlspecialchars($member['position']); ?></p>
                <p class="member-detail-bio">
                    <?php echo !empty($member['bio']) ? nl2br(htmlspecialchars($member['bio'])) : 'Bio coming soon.'; ?>
                </p>
 
                <?php if (!empty($achievements)): ?>
                    <h4 class="member-detail-subheading">KEY ACHIEVEMENTS</h4>
                    <ul class="achievement-list">
                        <?php foreach ($achievements as $achievement): ?>
                            <li class="achievement-item">
                                <span class="achievement-icon">🏁</span>
                                <span><?php echo htmlspecialchars($achievement); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
 
                <a href="#top" class="member-back-link">↑ BACK TO TOP</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>



    <!-- <div class="committee-row">
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

<?php include('../share/footer.php'); ?>