<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Fund X | Forgot Password</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="assets/img/favicon.png" />
  <link rel="stylesheet" href="assets/css/libs.min.css">
  <link rel="stylesheet" href="assets/css/coinexe209.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    :root {
      --primary: #7c3aed;
      --primary-dark: #4f46e5;
      --dark: #0a0f25;
      --light: #ffffff;
      --accent: #4a6cf7;
      --gray: rgba(255, 255, 255, 0.7);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: var(--dark);
      color: var(--light);
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* Background Animation */
    .bg-animation {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: -1;
      background: var(--dark);
    }

    .liquid-gradient {
      position: absolute;
      width: 200%;
      height: 200%;
      background: linear-gradient(270deg, #182350, #161935, #262746, #02012e, #02062e, #060124);
      background-size: 1200% 1200%;
      animation: liquidMove 30s ease infinite;
      filter: blur(120px);
      transform: translate(-50%, -50%);
      z-index: 1;
    }

    @keyframes liquidMove {
      0% {
        background-position: 0% 50%;
      }

      50% {
        background-position: 100% 50%;
      }

      100% {
        background-position: 0% 50%;
      }
    }

    /* Particles */
    #particles-container {
      position: absolute;
      width: 100%;
      height: 100%;
      z-index: 2;
      pointer-events: none;
    }

    .particle {
      position: absolute;
      background-color: rgba(74, 108, 247, 0.5);
      border-radius: 50%;
      animation: float 15s infinite ease-in-out;
    }

    @keyframes float {
      0% {
        transform: translateY(0) translateX(0);
      }

      50% {
        transform: translateY(-20px) translateX(10px);
      }

      100% {
        transform: translateY(0) translateX(0);
      }
    }

    /* Network Canvas */
    #networkCanvas {
      position: absolute;
      width: 100%;
      height: 100%;
      z-index: 3;
    }

    /* Forgot Password Container */
    .forgot-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .forgot-card {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.1);
      width: 100%;
      max-width: 450px;
      padding: 40px 30px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .forgot-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
    }

    .brand-logo {
      text-align: center;
      margin-bottom: 30px;
    }

    .brand-logo h1 {
      font-size: 2.5rem;
      font-weight: 700;
      background: linear-gradient(90deg, var(--primary), var(--primary-dark));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 5px;
    }

    .brand-logo img {
      width: 100%;
    }

    .brand-logo p {
      color: var(--gray);
      font-size: 0.9rem;
    }

    .form-title {
      text-align: center;
      margin-bottom: 30px;
      position: relative;
    }

    .form-title h2 {
      font-weight: 600;
      margin-bottom: 10px;
    }

    .form-title p {
      color: var(--gray);
    }

    .form-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 3px;
      background: linear-gradient(90deg, var(--primary), var(--primary-dark));
      border-radius: 3px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-label {
      font-weight: 600;
      margin-bottom: 8px;
      display: block;
      color: rgba(255, 255, 255, 0.9);
    }

    .form-control {
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      color: var(--light);
      padding: 12px 15px;
      transition: all 0.3s ease;
      width: 100%;
    }

    .form-control:focus {
      background: rgba(255, 255, 255, 0.12);
      border-color: var(--primary);
      box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.25);
      color: var(--light);
      outline: none;
    }

    .form-control::placeholder {
      color: rgba(255, 255, 255, 0.6);
    }

    .btn-primary {
      background: linear-gradient(90deg, var(--primary), var(--primary-dark));
      border: none;
      border-radius: 8px;
      color: white;
      font-weight: 600;
      padding: 12px 20px;
      width: 100%;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
      letter-spacing: 0.5px;
      margin-top: 10px;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 7px 20px rgba(79, 70, 229, 0.6);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    .btn-secondary {
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 8px;
      color: white;
      font-weight: 600;
      padding: 12px 20px;
      width: 100%;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.15);
    }

    .signin-section {
      text-align: center;
      margin-top: 25px;
      padding-top: 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .signin-section p {
      color: var(--gray);
      margin-bottom: 0;
    }

    .signin-link {
      color: var(--primary) !important;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .signin-link:hover {
      color: #a78bfa !important;
      text-decoration: underline;
    }

    .status-message {
      text-align: center;
      margin-top: 15px;
      padding: 10px;
      border-radius: 8px;
      font-weight: 500;
    }

    .status-success {
      background: rgba(34, 197, 94, 0.1);
      color: #22c55e;
      border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .status-error {
      background: rgba(239, 68, 68, 0.1);
      color: #ef4444;
      border: 1px solid rgba(239, 68, 68, 0.2);
    }

    /* Loading animation for button */
    .btn-loading {
      position: relative;
      color: transparent !important;
    }

    .btn-loading::after {
      content: '';
      position: absolute;
      width: 20px;
      height: 20px;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      margin: auto;
      border: 2px solid transparent;
      border-top-color: #ffffff;
      border-radius: 50%;
      animation: button-loading-spinner 1s ease infinite;
    }

    @keyframes button-loading-spinner {
      from {
        transform: rotate(0turn);
      }

      to {
        transform: rotate(1turn);
      }
    }

    .hidden {
      display: none !important;
    }

    /* Responsive adjustments */
    @media (max-width: 575.98px) {
      .forgot-card {
        padding: 30px 20px;
      }

      .brand-logo h1 {
        font-size: 2rem;
      }
    }
  </style>
</head>
<?php require('../conection.php');
error_reporting(1);
unset($_SESSION['passTokenSet']);
$randToken = rand(1111, 9999) . time() . date('s');
$_SESSION['passTokenSet'] = md5($randToken); ?>

<body class="" data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
  <!-- Background Animation -->
  <div class="bg-animation">
    <!-- Liquid Gradient Layer -->
    <div class="liquid-gradient"></div>

    <!-- Floating Nodes/Network -->
    <canvas id="networkCanvas"></canvas>

    <!-- Floating Particles -->
    <div id="particles-container"></div>
  </div>

  <!-- Forgot Password Container -->
  <div class="forgot-container">
    <div class="forgot-card">
      <div class="brand-logo">
        <img src="assets/img/logo.png" alt="logo">
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

        <!-- <div class="status-message hidden" id="statusMessage"></div> -->

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
  <!-- Backend Bundle JavaScript -->
  <script src="assets/js/libs.min.js"></script>

</body>

</html>