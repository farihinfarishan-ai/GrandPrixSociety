<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // The simple query exactly as you learned it
    $sql = "SELECT username, password 
            FROM admin 
            WHERE username = '$username' 
            AND password = '$password'";

    $result = mysqli_query($conn, $sql);

    // If password is correct, redirect to the index page
    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['username'] = $username;
        header("Location: /CartClub/share/index.php");
        exit();
    } else {
        // If password is wrong, show alert and refresh login page
        echo "<script>
                alert('Invalid login');
                window.location='login.php';
              </script>";
        exit();
    }
}
?>
<?php include 'header.php'; ?>

<div class="auth-wrapper">
    <div class="auth-visual">
        <div class="auth-visual-content">
            <p class="auth-tag">

    <div class="auth-form-side">
        <div class="auth-form-box">
            <div class="auth-form-header">
                <h2 class="auth-form-heading">SIGN IN</h2>
                <p class="auth-form-sub">Enter your credentials to access the grid</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="auth-alert auth-alert-error">
                    <span class="alert-icon">⚠</span>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="auth-form" novalidate id="login-form">

                <div class="form-group">
                    <label class="form-label" for="email">EMAIL ADDRESS</label>
                    <input 
                        class="form-input" 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="you@university.ac.uk"
                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                        autocomplete="email"
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
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="toggle-pw" aria-label="Toggle password visibility" onclick="togglePassword('password', this)">
                        </button>
                        <p></p>
                    </div>
                </div>

 <button type="submit" class="btn-primary auth-submit-btn">SIGN IN</button>
            
                   
                <p class="auth-switch">
                    New member? 
                    <a href="/CartClub/share/signup.php" class="form-link-bold">CREATE ACCOUNT</a>
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
    background-image: linear-gradient(to right, rgba(0,0,0,0.85), rgba(0,0,0,0.2)), url('/CartClub/image/login_bg.png');
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

/* ── Alerts ────────────────────────────────── */
.auth-alert {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    font-size: 16px;
    margin-bottom: 24px;
    font-weight: 600;
    letter-spacing: 1px;
}

.auth-alert-error {
    background-color: rgba(204, 0, 0, 0.1);
    border: 1px solid #CC0000;
    color: #CC0000;
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

.input-wrap {
    position: relative;
}

.input-wrap .form-input {
    padding-right: 50px;
}

.toggle-pw {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #666;
    padding: 0;
    display: flex;
    align-items: center;
    transition: color 0.2s;
}

.toggle-pw:hover {
    color: #CC0000;
}

/* ── Submit button ─────────────────────────── */
.auth-submit-btn {
    width: 100%;
    text-align: center;
    margin-top: 10px;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s;
}

.auth-submit-btn:hover {
    background-color: #990000;
}

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
} */

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

<script>
function togglePassword(fieldId, btn) {
    const input = document.getElementById(fieldId);
    // const icon  = btn.querySelector('svg');
    if (input.type === 'password') {
        input.type = 'text';
    //     icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        input.type = 'password';
        // icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
}
</script>