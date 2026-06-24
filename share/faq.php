<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php include('../share/header.php'); ?>

<style>
    .faq-section {
        padding: 60px 60px 70px 60px;
        background-color: #0a0a0a;
        border-top: 1px solid #222;
        border-bottom: 1px solid #222;
    }

    .faq-list{
        display: flex;
        flex-direction:column;
        gap:16px;
        margin-top: 50px;
        max-width: 900px;
    }

    .faq-item {
        background-color: #111;
        border: 1px solid #222;
        padding: 0 24px;
        transition: border-color 0.2s;
    }
    .faq-item:hover {
        border-color: #CC0000;
    }
 
    .faq-question {
        font-size: 24px;
        font-weight: 700;
        color: white;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 20px 0;
        cursor: pointer;
        list-style: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: 'Barlow Condensed', sans-serif;
    }
 
    .faq-question::-webkit-details-marker {
        display: none;
    }
 
    .faq-question::after {
        content: '+';
        color: #CC0000;
        font-size: 24px;
        font-weight: 700;
        margin-left: 20px;
    }
 
    .faq-item[open] .faq-question::after {
        content: '–';
    }
 
    .faq-answer {
        font-size: 18px;
        color: #aaaaaa;
        line-height: 1.6;
        padding-bottom: 20px;
        font-family: 'Barlow Condensed', sans-serif;
    }
</style>

<div class="top-section">
    <div class="top-section-content">
        <p class="top-tag">   GOT QUESTIONS?   </p>
        <h1 class="top-title">FREQUENTLY <span>ASKED</span> <span>QUESTIONS</span></h1>
        <p class="top-description">Everything you need to know before joining the grid.</p>
    </div>
</div>
<!-- this section mainly for the head of the page, start of faq -->
 
<div class="faq-section">
    <h2 class="stats-heading">FAQ <br><span>FOR MEMBERS</span></h2>
 
    <div class="faq-list">
        <details class="faq-item">
            <summary class="faq-question">Who can join Grand Prix Society?</summary>
            <p class="faq-answer">Any currently enrolled student can join, regardless of
            your course or year of study. You don't need an engineering background —
            we have roles in design, marketing, sponsorship, and event management too.</p>
        </details> 
        <!-- each question in different class for more visibility -->
 
        <details class="faq-item">
            <summary class="faq-question">Do I need prior motorsport or engineering experience?</summary>
            <p class="faq-answer">No prior experience is required. Most members start with zero background and learn through hands-on workshops run by senior members each season.</p>
        </details>
 
        <details class="faq-item">
            <summary class="faq-question">How much does membership cost?</summary>
            <p class="faq-answer">Membership fees and what they cover are announced at the start of each season on the Announcements page. Sign up to receive the latest details for Season 2026.</p>
        </details>
 
        <details class="faq-item">
            <summary class="faq-question">What events does the club take part in?</summary>
            <p class="faq-answer">Our main event is the annual summer engineering
            competition at the Silverstone circuit in the UK, where members design, build,
            and race a single-seat open-wheel car. Check the Events page for the full
            schedule.</p>
        </details>
 
        <details class="faq-item">
            <summary class="faq-question">How do I sign up?</summary>
            <p class="faq-answer">Click "Join Now" or "Sign Up" anywhere on the site to create your member account. Once registered, you'll get access to event updates and committee announcements.</p>
        </details>
 
        <details class="faq-item">
            <summary class="faq-question">Can I be part of the committee?</summary>
            <p class="faq-answer">Committee positions open up each season and are voted on by active members. Keep an eye on the Announcements page for nomination periods.</p>
        </details>
    </div>
</div>
<!-- information can be variable, not fixed -->

<div class="cta-section">
    <div class="cta-content">
        <h2 class="cta-heading">STILL HAVE <br>QUESTIONS?</h2>
        <p class="cta-desc">Reach out to the committee directly and we'll get back to you.</p>
        <div class="cta-buttons">
            <a href="signup.php" class="btn-primary-dark">SIGN UP →</a>
            <a href="contact.php" class="btn-outline-white">GET IN TOUCH</a>
        </div>//basically button which directly brings to contact page or registration page as user
    </div>
    <img src="/CartClub/image/cta-car.png" class="cta-image">
    <!-- for decorative purposes-image -->
</div>
 
<?php include('../share/footer.php'); ?>
 