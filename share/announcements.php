<?php

include('../share/db.php'); // connect to MySQL database

/* Count total announcements for display purposes */
$ann_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM announcements");
$ann_row = mysqli_fetch_assoc($ann_query);
$total_ann = $ann_row['total'];

/* Get search keyword from URL */
$search = isset($_GET['search']) ? trim($_GET['search']) : '';


if (!empty($search)) {
     /* ── SEARCH MODE ── */ 
    $searchTerm = "%" . $search . "%";
    $stmt = mysqli_prepare($conn, 
        "SELECT * FROM announcements 
         WHERE title LIKE ? OR content LIKE ? 
         ORDER BY created_at DESC");
    mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmt);
    $announcements_query = mysqli_stmt_get_result($stmt);
} else {
    /* ── DEFAULT MODE ── */

    $announcements_query = mysqli_query($conn, 
        "SELECT * FROM announcements ORDER BY created_at DESC");
}

$index = 0;
$hasResults = mysqli_num_rows($announcements_query) > 0;
?>

<?php include('../share/header.php'); ?>
  <!-- hero section── --> 
<div class="top-section"> 
    <div class="top-section-content">
        <p class="top-tag">CURRENT NEWS</p>
        <h1 class="top-title">ANNOUNCEMENTS </h1>
        <p class="top-description">Stay informed with the latest updates, 
        upcoming events, registration opportunities, important notices, 
        and society news.</p>
    </div>
</div>
  <!-- qnnouncement  section── --> 
<div class="announcement-section">
    <h2 class="stats-heading"> ANNOUNCEMENT <br><span> AND NEWS </span></h2>
    
<div class="announcement-search">
    <form method="GET" action="" class="search-form">
        <input 
            type="text" 
            name="search" 
            placeholder="Search announcements..." 
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
            class="search-input"
        >
        <button type="submit" class="search-btn">Search</button>
        <?php if (!empty($_GET['search'])): ?>
            <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>" class="clear-search">Clear</a>
        <?php endif; ?>
    </form>
</div>

<div class="announcement-grid">
    <?php if (!$hasResults): ?>
        <p class="no-results">No announcements found matching "<?php echo htmlspecialchars($search); ?>".</p>
    <?php else: ?>
        <?php while($announcement = mysqli_fetch_assoc($announcements_query)): 
            $rowClass = ($index % 2 == 0) ? 'row-normal' : 'row-reversed';
        ?>
            <div class="announcement-card <?php echo $rowClass; ?>">
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
                    <a href="/CartClub/share/description.php?id=<?php echo $announcement['ann_id']; ?>" class="read-more">READ MORE →</a>

                    <div class="announcement-divider"></div>
                </div>
            </div>
        <?php 
            $index++;
        endwhile; ?>
    <?php endif; ?>
</div>

<style>
/* hero section and btop section */ 
    .top-section {
        padding: 110px 60px 40px 60px;
        overflow: hidden;
    }

    .announcement-grid {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }
/* announcement */ 
    .announcement-card {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .announcement-card.row-normal {
        flex-direction: row;
    }

    .announcement-card.row-reversed {
        flex-direction: row-reverse;
    }

    .announcement-image {
        flex: 1;
    }

    .announcement-card-body {
        flex: 1;
    }

    .announcement-search {
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
/* search button */ 
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