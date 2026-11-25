<?php require('conection.php');
$newMember = $_GET['glowCoco'];
$glowCoco = base64_decode($newMember);
$queryNew = mysqli_query($con, "SELECT name,user_id,sponser_id,password,trnPassword FROM meddolic_user_details WHERE member_id='$_SESSION[newDevineToken]' AND userType=2");
$valNew = mysqli_fetch_assoc($queryNew);
$newName = $valNew['name'];
$newUserId = $valNew['user_id'];
$password = $valNew['password'];
$trnPassword = $valNew['trnPassword'];
$sponser_id = $valNew['sponser_id']; ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fund X | Registration Successful</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="User/assets/img/favicon.png" />
    <link rel="stylesheet" href="User/assets/css/libs.min.css">
    <link rel="stylesheet" href="User/assets/css/coinexe209.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary: #7c3aed;
            --primary-dark: #4f46e5;
            --dark: #0a0f25;
            --light: #ffffff;
            --accent: #4a6cf7;
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

        /* Success Container */
        .success-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 100%;
            max-width: 500px;
            padding: 40px 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .success-card:hover {
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

        .brand-logo p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .success-icon {
            text-align: center;
            margin-bottom: 20px;
        }

        .success-icon i {
            font-size: 4rem;
            color: #10b981;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 50%;
            padding: 20px;
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

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: var(--light);
            padding: 12px 45px 12px 15px;
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

        /* Corrected Password Toggle Position */
        .password-toggle-container {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
            background: transparent;
            border: none;
            padding: 0;
            margin: 0;
        }

        .password-toggle {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            padding: 5px 8px;
            border-radius: 4px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
        }

        .password-toggle:hover {
            color: var(--light);
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-login {
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            padding: 12px 20px;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
            letter-spacing: 0.5px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(79, 70, 229, 0.6);
            color: white;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .success-message {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 8px;
            border-left: 4px solid #10b981;
        }

        .credentials-box {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .credentials-box h4 {
            margin-bottom: 15px;
            color: var(--primary);
            font-size: 1.2rem;
        }

        .note-box {
            background: rgba(255, 193, 7, 0.1);
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
        }

        .note-box h5 {
            color: #ffc107;
            margin-bottom: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 575.98px) {
            .success-card {
                padding: 30px 20px;
            }

            .brand-logo h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Background Animation -->
    <div class="bg-animation">
        <!-- Liquid Gradient Layer -->
        <div class="liquid-gradient"></div>

        <!-- Floating Nodes/Network -->
        <canvas id="networkCanvas"></canvas>

        <!-- Floating Particles -->
        <div id="particles-container"></div>
    </div>

    <!-- Success Container -->
    <div class="success-container">
        <div class="success-card">
            <div class="brand-logo">
                <h1>Fund X </h1>
                <p>Trading Platform</p>
            </div>

            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>

            <div class="form-title">
                <h2>Registration Successful</h2>
                <p>Welcome to Fund X </p>
            </div>

            <div class="success-message">
                <p>Your account has been created successfully. Please save your credentials securely.</p>
            </div>

            <div class="credentials-box">
                <h4>Your Account Details</h4>
                <div class="form-group">
                    <label class="form-label" for="userId">User ID</label>
                    <input type="text" class="form-control" id="userId" value="<?= $newUserId ?>" disabled>
                </div>

                <div class="form-group">
                    <label class="form-label" for="name">Full Name</label>
                    <input type="text" class="form-control" id="name" value="<?= $newName ?>" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" value="<?= $password ?>" readonly>
                        <div class="password-toggle-container">
                            <button type="button" class="password-toggle" id="togglePassword">
                                <span id="eyeIcon" class="fa fa-eye"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="trnPassword">Transaction Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="trnPassword" value="<?= $trnPassword ?>"
                            readonly>
                        <div class="password-toggle-container">
                            <button type="button" class="password-toggle" id="toggleTrnPassword">
                                <span id="eyeIconTrn" class="fa fa-eye"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="note-box">
                <h5><i class="fas fa-exclamation-triangle"></i> Important Note</h5>
                <p>Please save your credentials in a secure location. For security reasons, we recommend changing your
                    password after your first login.</p>
            </div>

            <a href="User" class="btn-login">Sign In to Your Account</a>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="User/assets/js/libs.min.js"></script>
    <script src="User/assets/js/charts/widgetcharts.js"></script>
    <script src="User/assets/js/fslightbox.js"></script>
    <script src="User/assets/js/app.js"></script>
    <script src="User/assets/js/charts/apexcharts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Password visibility toggle
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });

        // Transaction Password visibility toggle
        document.getElementById('toggleTrnPassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('trnPassword');
            const eyeIcon = document.getElementById('eyeIconTrn');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });

        // Create floating particles
        function createParticles() {
            const container = document.getElementById('particles-container');
            const particleCount = 50;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                // Random position
                particle.style.left = Math.random() * 100 + 'vw';
                particle.style.top = Math.random() * 100 + 'vh';

                // Random size
                const size = Math.random() * 3 + 1;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';

                // Random animation delay
                particle.style.animationDelay = Math.random() * 15 + 's';

                container.appendChild(particle);
            }
        }

        // Initialize particles when page loads
        window.addEventListener('load', createParticles);
    </script>

    <script>
        // Network Nodes Animation
        const canvas = document.getElementById('networkCanvas');
        const ctx = canvas.getContext('2d');
        let width = canvas.width = window.innerWidth;
        let height = canvas.height = window.innerHeight;

        const nodes = [];
        const N = 60;

        for (let i = 0; i < N; i++) {
            nodes.push({
                x: Math.random() * width,
                y: Math.random() * height,
                vx: (Math.random() - 0.5) * 0.4,
                vy: (Math.random() - 0.5) * 0.4,
                radius: 2 + Math.random() * 3
            });
        }

        function drawNodes() {
            ctx.clearRect(0, 0, width, height);

            for (let i = 0; i < N; i++) {
                const n = nodes[i];
                n.x += n.vx;
                n.y += n.vy;

                if (n.x < 0 || n.x > width) n.vx *= -1;
                if (n.y < 0 || n.y > height) n.vy *= -1;

                // Draw node
                ctx.fillStyle = '#4a6cf7';
                ctx.beginPath();
                ctx.arc(n.x, n.y, n.radius, 0, Math.PI * 2);
                ctx.fill();

                // Connect nodes
                for (let j = i + 1; j < N; j++) {
                    const m = nodes[j];
                    const dx = n.x - m.x;
                    const dy = n.y - m.y;
                    const dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < 150) {
                        ctx.strokeStyle = `rgba(74,108,247,${1 - dist / 150})`;
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(n.x, n.y);
                        ctx.lineTo(m.x, m.y);
                        ctx.stroke();
                    }
                }
            }
            requestAnimationFrame(drawNodes);
        }

        drawNodes();

        window.addEventListener('resize', () => {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        });
    </script>
</body>

</html>