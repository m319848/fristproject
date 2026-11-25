<?php require('conection.php');
error_reporting(1);
unset($_SESSION['tokenSet']);
$randToken = rand(1111, 9999) . time() . date('s');
$newToken = md5($randToken);
$_SESSION['tokenSet'] = $newToken; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fund X | Sign Up | Premium Access</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="shortcut icon" href="User/assets/img/favicon.png" type="image/x-icon">
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

    /* Left Side: Editorial Visual */
    .login-visual {
      flex: 1.1;
      position: relative;
      background: url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=2015&auto=format&fit=crop') center/cover no-repeat;
      display: flex;
      align-items: flex-end;
      padding: 80px;
    }

    .login-visual::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, #0A0A0C 15%, rgba(18, 18, 22, 0.4) 100%);
    }

    .visual-content {
      position: relative;
      z-index: 1;
      max-width: 500px;
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

    /* Right Side: Luxury Form Panel */
    .login-form-side {
      flex: 1.3;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 40px clamp(30px, 6vw, 80px);
      background: var(--bg-dark-card);
      border-left: 1px solid var(--border-gold-dim);
      overflow-y: auto;
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

    /* Input Fields Grid Architecture */
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 22px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
    }

    .form-group.full-width {
      grid-column: span 2;
    }

    .form-group label {
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--gold-light);
      margin-bottom: 8px;
      text-transform: uppercase;
      letter-spacing: 1.5px;
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
    }

    .input-wrapper input,
    .input-wrapper select {
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

    .input-wrapper select {
      appearance: none;
      cursor: pointer;
    }

    .input-wrapper input:focus,
    .input-wrapper select:focus {
      border-color: var(--gold-primary);
      background: var(--bg-dark-obsidian);
      box-shadow: 0 0 12px rgba(212, 175, 55, 0.15);
    }

    .input-wrapper input:focus+i,
    .input-wrapper select:focus+i {
      color: var(--gold-primary);
    }

    .input-wrapper input:disabled {
      background: rgba(10, 10, 12, 0.6);
      color: #52525B;
      border-color: rgba(255, 255, 255, 0.03);
      cursor: not-allowed;
    }

    /* Custom Checkbox Design */
    .terms-check {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      margin-top: 8px;
      grid-column: span 2;
      font-size: 0.85rem;
      color: var(--text-dim);
      cursor: pointer;
      line-height: 1.4;
    }

    .terms-check input[type="checkbox"] {
      appearance: none;
      width: 16px;
      height: 16px;
      border: 1px solid var(--border-gold-dim);
      border-radius: 3px;
      background: var(--bg-dark-input);
      cursor: pointer;
      position: relative;
      margin-top: 2px;
      flex-shrink: 0;
    }

    .terms-check input[type="checkbox"]:checked {
      background: var(--gold-primary);
      border-color: var(--gold-primary);
    }

    .terms-check input[type="checkbox"]:checked::after {
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

    .terms-check a {
      color: var(--gold-primary);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s;
    }

    .terms-check a:hover {
      color: var(--gold-light);
    }

    /* Elite Metallic Registration Action Button */
    .btn-register {
      grid-column: span 2;
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
      margin-top: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      box-shadow: 0 4px 20px rgba(170, 119, 28, 0.2);
    }

    .btn-register:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 25px rgba(252, 246, 186, 0.35);
      filter: brightness(1.05);
    }

    .btn-register:disabled {
      background: #27272A;
      color: #71717A;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
      filter: none;
    }

    /* Inline Action CSS Spinner */
    .btn-loading::after {
      content: "";
      width: 16px;
      height: 16px;
      border: 2px solid transparent;
      border-top-color: currentColor;
      border-radius: 50%;
      animation: goldSpin 0.75s linear infinite;
    }

    @keyframes goldSpin {
      to {
        transform: rotate(360deg);
      }
    }

    .footer-text {
      margin-top: 35px;
      text-align: center;
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

    /* Adaptability Layout Viewports */
    @media (max-width: 1100px) {
      .login-visual {
        display: none;
      }

      .login-form-side {
        flex: 1;
        background: var(--bg-dark-obsidian);
        padding: 50px 24px;
        align-items: center;
        justify-content: flex-start;
      }

      .form-header,
      #signupForm,
      .footer-text {
        width: 100%;
        max-width: 580px;
      }
    }

    @media (max-width: 640px) {
      .form-grid {
        grid-template-columns: 1fr;
        gap: 18px;
      }

      .form-group {
        grid-column: span 1 !important;
      }

      .terms-check,
      .btn-register {
        grid-column: span 1;
      }

      .form-header h2 {
        font-size: 1.9rem;
      }
    }
  </style>
</head>

<body>

  <div class="login-container">
    <div class="login-visual">
      <div class="visual-content">
        <h1>Start your journey today.</h1>
        <p>Join thousands of users managing their assets with our highly secure and optimized platform.</p>
      </div>
    </div>

    <div class="login-form-side">
      <div class="form-header">
        <div class="logo">
          <img src="User/assets/img/favicon.png" alt="Logo">
        </div>
        <h2>Create Account</h2>
        <p>Fill in the details below to get started.</p>
      </div>

      <form class="form-grid" id="signupForm" action="authRegisterProcess" enctype="multipart/form-data" method="POST">
        <?php
        if (!empty($_GET['affiliateCode'])) {
          $query1 = "SELECT name,topupFlag FROM meddolic_user_details WHERE user_id='$_GET[affiliateCode]'";
          $result1 = mysqli_query($con, $query1);
          $val1 = mysqli_fetch_assoc($result1);
          $sponser_name = $val1['name']; ?>
          <div class="form-group">
            <label>Sponsor ID *</label>
            <div class="input-wrapper">
              <i class="fa-solid fa-people-group"></i>
              <input class="form-control" name="sponser_id1" disabled value="<?= $_GET['affiliateCode'] ?>">
              <input type="hidden" name="sponser_id" value="<?= $_GET['affiliateCode'] ?>">
            </div>
          </div>
          <div class="form-group">
            <label>Sponsor Name *</label>
            <div class="input-wrapper">
              <i class="fa-solid fa-signature"></i>
              <input class="form-control" disabled value="<?= $sponser_name ?>" placeholder="Sponsor Name">
            </div>
          </div>
        <?php } else { ?>
          <div class="form-group">
            <label>Sponsor ID *</label>
            <div class="input-wrapper">
              <i class="fa-solid fa-people-group"></i>
              <input class="form-control" name="sponser_id" required id="sponser_id" onblur="sponserNewValid(this.value)"
                placeholder="Sponsor ID">
            </div>
          </div>
          <div class="form-group">
            <label>Sponsor Name *</label>
            <div class="input-wrapper">
              <i class="fa-solid fa-signature"></i>
              <input class="form-control" readonly disabled id="sponsorName" placeholder="Sponsor Name">
            </div>
          </div>
        <?php } ?>

        <div class="form-group">
          <label>Full Name *</label>
          <div class="input-wrapper">
            <i class="fa-solid fa-user"></i>
            <input type="text" class="form-control" id="userName" name="name" placeholder="Enter your full name"
              required />
            <input type="hidden" name="goodFile" value="<?= $newToken ?>">
          </div>
        </div>

        <div class="form-group">
          <label>Email Address *</label>
          <div class="input-wrapper">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" class="form-control" id="emailId" name="emailId" placeholder="Enter your email"
              required />
          </div>
        </div>

        <div class="form-group">
          <label>Phone Number *</label>
          <div class="input-wrapper">
            <i class="fa-solid fa-phone"></i>
            <input type="number" class="form-control" id="MobPhone" name="phone" placeholder="Enter your mobile number"
              onkeypress="return onlynum(event)" required />
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Country *</label>
          <div class="input-wrapper">
            <i class="fa-solid fa-globe"></i>
            <select class="form-control" required id="M_COUNTRY" name="countryId">
              <option value="">Select Country</option>
              <?php $queryCountry = "SELECT * FROM meddolic_config_country_list WHERE status=1 ORDER BY countryName ASC";
              $resultCountry = mysqli_query($con, $queryCountry);
              while ($valCountry = mysqli_fetch_assoc($resultCountry)) { ?>
                <option value="<?= $valCountry['country_id'] ?>">
                  <?= $valCountry['countryName'] ?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Password *</label>
          <div class="input-wrapper">
            <i class="fa-solid fa-lock"></i>
            <input type="password" placeholder="••••••••" name="password" required>
          </div>
        </div>

        <div class="form-group">
          <label>Transaction Password *</label>
          <div class="input-wrapper">
            <i class="fa-solid fa-shield-halved"></i>
            <input type="password" placeholder="••••••••" name="trnPassword" required>
          </div>
        </div>

        <label class="terms-check">
          <input type="checkbox" required>
          <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</span>
        </label>

        <button type="submit" class="btn-register" name="submitRegister" id="submitBtn">Register Now</button>
      </form>

      <p class="footer-text">
        Already have an account? <a href="User/LoginAuth">Sign In</a>
      </p>
    </div>
  </div>

  <script>
    function onlynum(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
      }
      return true;
    }

    function sponserNewValid(sponser_id) {
      document.getElementById("sponsorName").value = "";
      if (sponser_id.trim() !== "") {
        if (window.XMLHttpRequest) {
          xmlhttp = new XMLHttpRequest();
        } else {
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var v = xmlhttp.responseText;
            if (v.trim() != "") {
              document.getElementById("sponsorName").value = v.trim();
            } else {
              alert("Invalid Sponsor ID");
              document.getElementById("sponser_id").value = "";
            }
          }
        }
        xmlhttp.open("GET", "getSponserNameAjax?sponserId=" + sponser_id, true);
        xmlhttp.send();
      }
    }

    // document.getElementById('signupForm').addEventListener('submit', function (e) {
    //   const submitBtn = document.getElementById('submitBtn');
    //   submitBtn.classList.add('btn-loading');
    //   submitBtn.disabled = true;
    // });
    document.getElementById('signupForm').addEventListener('submit', function (e) {
  const submitBtn = document.getElementById('submitBtn');
  if (submitBtn.disabled) {
    e.preventDefault();
    return false;
  }

  // Button disable hone se pehle uski value ko hidden input me copy kar do
  const hiddenSubmit = document.createElement('input');
  hiddenSubmit.type = 'hidden';
  hiddenSubmit.name = submitBtn.name;
  hiddenSubmit.value = submitBtn.value || '1';
  this.appendChild(hiddenSubmit);

  submitBtn.disabled = true;
  submitBtn.classList.add('btn-loading');
  submitBtn.textContent = 'Please wait...';
});
  </script>
</body>

</html>