<?php
session_start();
require "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email   = $_POST['email'];
    $full_name = $_POST['full_name'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // 1. Check if passwords match
    if ($password !== $confirm) {
        echo "<script>
                alert('Passwords do not match!');
                window.location='signup.php';
              </script>";
        exit();
    }

    // 2. Check if the email already exists
    $check_sql = "SELECT * FROM users WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>
                alert('An account with that email already exists!');
                window.location='signup.php';
              </script>";
        exit();
    }

    // 3. Insert the new user into the database
    $insert_sql = "INSERT INTO users (email, full_name, password) VALUES ('$email', '$full_name', '$password')";
    
    if (mysqli_query($conn, $insert_sql)) {
        echo "<script>
                alert('Account created successfully! You can now sign in.');
                window.location='login.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Database error. Could not create account.');
                window.location='signup.php';
              </script>";
        exit();
    }
}
?>
<?php include 'header.php'; ?>

<div class="auth-wrapper">
    <div class="auth-visual auth-visual-signup">
        <div class="auth-visual-content">
            <p class="auth-tag">NEW MEMBER ENROLLMENT</p>
            <h1 class="auth-title">JOIN THE<span>SOCIETY.</span></h1>
            <p class="auth-description">Become part of a community built on speed, engineering, and a shared passion for motorsport.</p>
        </div>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-box">
            <div class="auth-form-header">
                <h2 class="auth-form-heading">CREATE ACCOUNT</h2>
                <p class="auth-form-sub">Register your account credentials</p>
            </div>

            <form method="POST" action="" class="auth-form" novalidate>

                <div class="form-group">
                    <label class="form-label" for="email">EMAIL ADDRESS</label>
                    <input 
                        class="form-input" 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="you@gmail.com"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="full_name">FULL NAME</label>
                    <input 
                        class="form-input" 
                        type="text" 
                        id="full_name" 
                        name="full_name" 
                        placeholder="Your full name"
                        autocomplete="name"
                        required
                    >
                </div>

                <div class="form-group">    
                    <label class="form-label" for="password">PASSWORD</label>
                    <div class="input-wrap">
                        <input 
                            class="form-input" 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Create a password"
                            autocomplete="new-password"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="confirm_password">CONFIRM PASSWORD</label>
                    <div class="input-wrap">
                        <input 
                            class="form-input" 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            placeholder="Repeat your password"
                            autocomplete="new-password"
                            required
                        >
                    </div>
                </div>

                <button type="submit" class="btn-primary auth-submit-btn">CREATE ACCOUNT</button>

                <p class="auth-switch">
                    Already a member? 
                    <a href="login.php" class="form-link-bold">SIGN IN</a>
                </p>
            </form>
        </div>
    </div>
</div>

<style>
/* ── Layout ────────────────────────────────── */
.auth-wrapper {
    font-family: 'Barlow Condensed', sans-serif;
    display: flex;
    min-height: 100vh;
    background-color: #0a0a0a;
    color: white;
}

/* ── Visual / Left panel ───────────────────── */
.auth-visual {
    flex: 1;
    /* We use a slightly different gradient/image for the signup page */
    background-image: linear-gradient(to bottom, rgba(10,10,10,0.5) 0%, #0a0a0a 100%), url('/CartClub/image/lewistop.png');
    background-position: center; 
    background-size: cover; 
    display: flex;
    align-items: center;
    padding: 0 60px;
    position: relative;
    overflow: hidden;
    border-right: 2px solid #CC0000;
}

.auth-visual-content {
    max-width: 700px;
    text-align: left;
}

.auth-tag {
    color: #CC0000;
    font-size: 20px;
    letter-spacing: 5px;
    font-weight: 600;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.auth-title {
    font-size: 130px !important;
    font-weight: 700;
    line-height: 0.95;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: white;
    margin-bottom: 24px;
    margin-top: 0;
}

.auth-title span {
    color: #CC0000;
    display: block;
}

.auth-description {
    font-size: 20px;
    color: #aaa;
    max-width: 500px;
    line-height: 1.6;
    font-weight: 400;
}

/* ── Form / Right panel ────────────────────── */
.auth-form-side {
    width: 500px;
    flex-shrink: 0;
    background-color: #050505;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px;
}

.auth-form-box {
    width: 100%;
}

.auth-form-header {
    margin-bottom: 40px;
}

.auth-form-heading {
    font-size: 42px;
    font-weight: 700;
    text-transform: uppercase;
    color: white;
    line-height: 1;
    margin-bottom: 8px;
    letter-spacing: 2px;
}

.auth-form-sub {
    font-size: 15px;
    color: #aaaaaa;
    letter-spacing: 2px;
    text-transform: uppercase;
}

/* ── Form elements ─────────────────────────── */
.auth-form {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-label {
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #aaaaaa;
}

.form-input {
    background-color: #111;
    border: 1px solid #333;
    color: white;
    padding: 16px 20px;
    font-size: 16px;
    font-family: 'Barlow Condensed', sans-serif;
    outline: none;
    transition: border-color 0.2s;
    width: 100%;
    box-sizing: border-box;
}

.form-input:focus {
    border-color: #CC0000;
}

.form-input::placeholder {
    color: #444;
}

/* ── Submit button ─────────────────────────── */
.auth-submit-btn {
    width: 100%;
    text-align: center;
    margin-top: 10px;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s;
    background-color: #CC0000;
    color: white;
    padding: 14px 32px;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 2px;
    text-decoration: none;
    text-transform: uppercase;
}

.auth-submit-btn:hover {
    background-color: #990000;
}

/* ── Footer link ───────────────────────────── */
.auth-switch {
    text-align: center;
    font-size: 16px;
    color: #aaaaaa;
    margin-top: 10px;
    letter-spacing: 1px;
}

.form-link-bold {
    color: #CC0000;
    font-weight: 700;
    text-decoration: none;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-left: 8px;
    transition: color 0.2s;
}

.form-link-bold:hover {
    color: white;
}

/* ── Responsive ────────────────────────────── */
@media (max-width: 960px) {
    .auth-wrapper {
        flex-direction: column;
    }
    .auth-visual {
        padding: 60px 30px;
        min-height: 400px;
        border-right: none;
        border-bottom: 2px solid #CC0000;
    }
    .auth-title {
        font-size: 80px !important;
    }
    .auth-form-side {
        width: 100%;
        padding: 60px 30px;
    }
}
</style>

<?php include 'footer.php'; ?>