<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Fund X | Forgot Password</title>
  <link rel="shortcut icon" href="assets/img/favicon.png" />
  <link rel="stylesheet" href="assets/css/libs.min.css">
  <link rel="stylesheet" href="assets/css/coinexe209.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
      overflow-x: hidden;
    }

    /* Luxury Ambient Background System */
    .bg-animation {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: -1;
      background: var(--bg-dark-obsidian);
    }

    .liquid-gradient {
      position: absolute;
      width: 200%;
      height: 200%;
      background: linear-gradient(270deg, #0f0f14, #121218, #18140f, #070709);
      background-size: 1200% 1200%;
      animation: liquidMove 30s ease infinite;
      filter: blur(120px);
      transform: translate(-50%, -50%);
      z-index: 1;
    }

    @keyframes liquidMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Gold Dust Particles */
    #particles-container {
      position: absolute;
      width: 100%;
      height: 100%;
      z-index: 2;
      pointer-events: none;
    }

    .particle {
      position: absolute;
      background-color: rgba(212, 175, 55, 0.25);
      border-radius: 50%;
      animation: float 15s infinite ease-in-out;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0) translateX(0); }
      50% { transform: translateY(-25px) translateX(15px); }
    }

    #networkCanvas {
      position: absolute;
      width: 100%;
      height: 100%;
      z-index: 3;
      opacity: 0.15;
    }

    /* Centralized Interface Architecture */
    .forgot-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
      position: relative;
      z-index: 4;
    }

    .forgot-card {
      background: var(--bg-dark-card);
      border-radius: 16px;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6);
      border: 1px solid var(--border-gold-dim);
      width: 100%;
      max-width: 480px;
      padding: 50px 40px;
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
    }

    .forgot-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 30px 60px rgba(212, 175, 55, 0.08);
    }

    .brand-logo {
      display: flex;
      justify-content: center;
      margin-bottom: 30px;
    }

    .brand-logo img {
      height: 52px;
      width: auto;
      filter: brightness(1.1);
    }

    .form-title {
      text-align: center;
      margin-bottom: 35px;
      position: relative;
    }

    .form-title h2 {
      font-family: 'Cinzel', serif;
      font-size: 2rem;
      font-weight: 500;
      color: var(--text-light);
      margin-bottom: 12px;
      letter-spacing: 1px;
    }

    .form-title p {
      color: var(--text-dim);
      font-size: 0.95rem;
    }

    .form-title::after {
      content: '';
      position: absolute;
      bottom: -12px;
      left: 50%;
      transform: translateX(-50%);
      width: 50px;
      height: 2px;
      background: var(--gold-gradient);
      border-radius: 2px;
    }

    .form-group {
      margin-bottom: 24px;
    }

    .form-label {
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--gold-light);
      margin-bottom: 8px;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      display: block;
    }

    .form-control {
      background: var(--bg-dark-input);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 8px;
      color: var(--text-light);
      padding: 15px 18px;
      font-size: 0.95rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      width: 100%;
      outline: none;
      letter-spacing: 0.5px;
    }

    .form-control:focus {
      background: var(--bg-dark-obsidian);
      border-color: var(--gold-primary);
      box-shadow: 0 0 12px rgba(212, 175, 55, 0.15);
      color: var(--text-light);
    }

    .form-control::placeholder {
      color: rgba(255, 255, 255, 0.3);
    }

    /* Metallic Luxury Action Buttons */
    .btn-primary {
      background: var(--gold-gradient);
      border: none;
      border-radius: 8px;
      color: #000000;
      font-weight: 700;
      padding: 16px 20px;
      width: 100%;
      text-transform: uppercase;
      letter-spacing: 2px;
      font-size: 0.95rem;
      cursor: pointer;
      transition: all 0.3s;
      box-shadow: 0 4px 20px rgba(170, 119, 28, 0.2);
      margin-top: 10px;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 25px rgba(252, 246, 186, 0.35);
      filter: brightness(1.05);
    }

    .btn-secondary {
      background: #27272A;
      border: 1px solid rgba(255, 255, 255, 0.05);
      border-radius: 8px;
      color: #A1A1AA;
      font-weight: 600;
      padding: 16px 20px;
      width: 100%;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .signin-section {
      text-align: center;
      margin-top: 35px;
      padding-top: 24px;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .signin-section p {
      color: var(--text-dim);
      font-size: 0.9rem;
    }

    .signin-link {
      color: var(--gold-primary) !important;
      font-weight: 600;
      text-decoration: none;
      transition: color 0.2s;
    }

    .signin-link:hover {
      color: var(--gold-light) !important;
    }

    /* Functional Alert Status Overrides */
    .status-message {
      text-align: center;
      margin-top: 15px;
      padding: 12px;
      border-radius: 8px;
      font-size: 0.9rem;
      font-weight: 500;
    }

    .status-success {
      background: rgba(34, 197, 94, 0.1);
      color: #4ade80;
      border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .status-error {
      background: rgba(239, 68, 68, 0.1);
      color: #f87171;
      border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .hidden {
      display: none !important;
    }

    @media (max-width: 575.98px) {
      .forgot-card {
        padding: 40px 24px;
      }

      .form-title h2 {
        font-size: 1.7rem;
      }
    }
  </style>
</head>

<?php require('../conection.php');
error_reporting(1);
unset($_SESSION['passTokenSet']);
$randToken = rand(1111, 9999) . time() . date('s');
$_SESSION['passTokenSet'] = md5($randToken); ?>

<body data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">

  <div class="bg-animation">
    <div class="liquid-gradient"></div>
    <canvas id="networkCanvas"></canvas>
    <div id="particles-container"></div>
  </div>

  <div class="forgot-container">
    <div class="forgot-card">
      <div class="brand-logo">
        <img src="assets/img/logo.png" alt="Logo">
      </div>

      <div class="form-title">
        <h2>Reset Password</h2>
        <p>Enter your details to reset your password</p>
      </div>

      <form class="form-signin" id="forgotPassForm">
        <div class="form-group">
          <label class="form-label" for="inputUserId">User ID</label>
          <input type="text" class="form-control" data-val="true" data-val-required="User ID is Required"
            id="inputUserId" name="inputUserId" placeholder="Enter your User ID" required value="<?php if (isset($_COOKIE["memberUserId"])) {
              echo $_COOKIE["memberUserId"];
            } ?>" />
          <span class="field-validation-valid" data-valmsg-for="username" data-valmsg-replace="true"></span>
        </div>

        <div class="form-group">
          <label class="form-label" for="inputEmailId">Email Address</label>
          <input id="inputEmailId" name="inputEmailId" class="form-control" type="email"
            placeholder="Enter your registered email" required>
          <span class="field-validation-valid" data-valmsg-for="mpwd" data-valmsg-replace="true"></span>
        </div>

        <div class="form-group">
          <button type="button" class="btn-primary" id="passSubmit"
            onclick="forgotPassValidate('<?= $_SESSION['passTokenSet'] ?>')">
            Reset Password
          </button>
          <button type="button" disabled class="btn-secondary loadingMore hidden" id="loadingButton">
            <i class="fas fa-spinner fa-spin me-2"></i>Validating Data...
          </button>
        </div>
      </form>

      <div class="signin-section">
        <p>Remember your password? <a class="signin-link" href="../User/">Sign In</a></p>
      </div>
    </div>
  </div>

  <script src="custom.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <script src="assets/js/libs.min.js"></script>

</body>

</html>