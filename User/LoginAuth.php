<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Secure Access</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --gold-primary: #D4AF37;
            --gold-light: #F3E5AB;
            --gold-gradient: linear-gradient(135deg, #BF953F 0%, #FCF6BA 25%, #B38728 50%, #FBF5B7 70%, #AA771C 100%);
            --bg-dark-obsidian: #0A0A0C;
            --bg-dark-card: #121216;
            --bg-dark-input: #1A1A22;
            --border-gold-dim: rgba(212, 175, 55, 0.2);
            --text-light: #F5F5F7;
            --text-dim: #A0A0AA;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background-color: var(--bg-dark-obsidian);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        .login-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Left Side: Premium Architectural Backdrop */
        .login-visual {
            flex: 1.2;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: flex-end;
            padding: 80px;
        }

        .login-visual img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .login-visual::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, #0A0A0C 15%, rgba(18, 18, 22, 0.4) 100%);
            z-index: 1;
        }

        .visual-content {
            position: relative;
            z-index: 2;
            color: white;
            max-width: 520px;
        }

        .visual-content h1 {
            font-family: 'Cinzel', serif;
            font-size: clamp(2.2rem, 3.5vw, 3.4rem);
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
            letter-spacing: 1px;
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .visual-content p {
            color: var(--text-dim);
            font-size: 1.05rem;
            line-height: 1.6;
            font-weight: 300;
        }

        /* Right Side: Elite Form Authentication Hub */
        .login-form-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px clamp(30px, 8vw, 80px);
            background: var(--bg-dark-card);
            border-left: 1px solid var(--border-gold-dim);
            z-index: 2;
        }

        .form-header {
            margin-bottom: 40px;
        }

        .logo img {
            width: 80px;
            height: auto;
            filter: brightness(1.2);
        }

        .form-header h2 {
            font-family: 'Cinzel', serif;
            font-size: 2.2rem;
            font-weight: 500;
            color: var(--text-light);
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .form-header p {
            color: var(--text-dim);
            font-size: 0.95rem;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gold-light);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            display: block;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 18px;
            color: var(--text-dim);
            font-size: 0.95rem;
            transition: color 0.3s;
            pointer-events: none;
            z-index: 2;
        }

        .input-wrapper input {
            width: 100%;
            padding: 15px 18px 15px 52px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: var(--bg-dark-input);
            color: var(--text-light);
            border-radius: 8px;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.5px;
        }

        .input-wrapper input:focus {
            border-color: var(--gold-primary);
            background: var(--bg-dark-obsidian);
            box-shadow: 0 0 12px rgba(212, 175, 55, 0.15);
        }

        .input-wrapper input:focus+i {
            color: var(--gold-primary);
        }

        /* Password Visibility Trigger Styling */
        .password-toggle {
            position: absolute;
            right: 18px;
            left: auto !important;
            cursor: pointer;
            pointer-events: auto !important;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: var(--gold-primary);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            font-size: 0.85rem;
        }

        /* Custom Checkbox Design matching registry */
        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-dim);
            cursor: pointer;
            user-select: none;
        }

        .remember-me input[type="checkbox"] {
            appearance: none;
            width: 16px;
            height: 16px;
            border: 1px solid var(--border-gold-dim);
            border-radius: 3px;
            background: var(--bg-dark-input);
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
        }

        .remember-me input[type="checkbox"]:checked {
            background: var(--gold-primary);
            border-color: var(--gold-primary);
        }

        .remember-me input[type="checkbox"]:checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: var(--bg-dark-obsidian);
            font-size: 10px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .forgot-pass {
            color: var(--gold-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-pass:hover {
            color: var(--gold-light);
        }

        /* Elite Metallic Action Button */
        .btn-login {
            width: 100%;
            background: var(--gold-gradient);
            color: #000000;
            padding: 16px;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 20px rgba(170, 119, 28, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(252, 246, 186, 0.35);
            filter: brightness(1.05);
        }

        .footer-text {
            text-align: center;
            margin-top: 35px;
            color: var(--text-dim);
            font-size: 0.9rem;
        }

        .footer-text a {
            color: var(--gold-primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .footer-text a:hover {
            color: var(--gold-light);
        }

        /* Adaptive Mobile Breakdown */
        @media (max-width: 1024px) {
            body {
                background: url('assets/img/login.avif') center/cover no-repeat fixed;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 24px;
            }

            body::before {
                content: '';
                position: fixed;
                inset: 0;
                background: linear-gradient(135deg, rgba(10, 10, 12, 0.92), rgba(18, 18, 22, 0.98));
                z-index: 0;
            }

            .login-container {
                background: transparent;
                min-height: auto;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100%;
            }

            .login-visual {
                display: none;
            }

            .login-form-side {
                width: 100%;
                max-width: 480px;
                border-radius: 16px;
                padding: 50px 32px;
                background: var(--bg-dark-card);
                border: 1px solid var(--border-gold-dim);
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6);
                position: relative;
                z-index: 1;
            }

            .form-header {
                text-align: center;
            }

            .logo {
                margin-inline: auto;
            }
        }

        @media (max-width: 480px) {
            .login-form-side {
                padding: 40px 20px;
            }

            .form-header h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-visual">
            <img src="../admin-assets/images/login.png" alt="">
            <div class="visual-content">
                <h1>Build your future with us.</h1>
                <p>Access the most advanced dashboard for financial growth and ticket management. Secure, fast, and
                    reliable.</p>
            </div>
        </div>

        <div class="login-form-side">
            <div class="form-header">
                <div class="logo">
                    <img src="assets/img/favicon.png" alt="Favicon">
                </div>
                <h2>Sign In</h2>
                <p>Welcome back! Enter your details below.</p>
            </div>

            <form method="post" action="loginProcessAjax" id="loginForm">
                <div class="form-group">
                    <label>User ID</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" class="form-control" id="username" name="userid"
                            placeholder="Enter your User ID" value="<?php if (isset($_COOKIE["memberUserId"])) {
                                echo $_COOKIE["memberUserId"];
                            } ?>" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" class="form-control" id="pass" name="pass"
                            placeholder="Enter your password" required>
                        <i class="fa-solid fa-eye password-toggle" onclick="togglePass()"></i>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox"> Remember me
                    </label>
                    <a href="authPassRecovery" class="forgot-pass">Forgot Password?</a>
                </div>

                <button type="submit" id="loginBtn" class="btn-login">Login to Dashboard</button>
            </form>

            <p class="footer-text">
                Don't have an account? <a href="../authUserRegister">Register</a>
            </p>
        </div>
    </div>

    <script>
        function togglePass() {
            const passField = document.getElementById('pass');
            const toggleIcon = document.querySelector('.password-toggle');
            if (passField.type === 'password') {
                passField.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passField.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
    <script src="custom.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
</body>

</html>