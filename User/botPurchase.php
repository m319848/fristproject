<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');

$queryGet = mysqli_query($con, "SELECT packageId,packagePrice FROM `meddolic_config_bot_package_type` WHERE packageStatus=1");
$valGet = mysqli_fetch_assoc($queryGet);
$packageId = $valGet['packageId'];
$investAmount = $valGet['packagePrice'];

?>
<style>
    .bot-page {
        padding: 25px 12px;
    }

    .premium-wrap {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        gap: 25px;
    }

    /* LEFT BOT CARD */

    .premium-card {
        position: relative;
        width: 100%;
        max-width: 100%;
        /* decreased size */
        border-radius: 32px;
        overflow: hidden;
        background:
            linear-gradient(160deg, #050b16 0%, #0b1730 45%, #07111f 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow:
            0 0 25px rgba(0, 198, 255, .18),
            0 0 70px rgba(124, 58, 237, .10),
            inset 0 0 30px rgba(255, 255, 255, .03);
        backdrop-filter: blur(14px);
    }

    .premium-card::before {
        content: '';
        position: absolute;
        width: 240px;
        height: 240px;
        background: rgba(0, 198, 255, .15);
        border-radius: 50%;
        top: -120px;
        right: -100px;
        filter: blur(55px);
    }

    .premium-card::after {
        content: '';
        position: absolute;
        width: 220px;
        height: 220px;
        background: rgba(124, 58, 237, .12);
        border-radius: 50%;
        bottom: -120px;
        left: -80px;
        filter: blur(55px);
    }

    .card-top {
        position: relative;
        z-index: 2;
        padding: 28px 22px 15px;
        text-align: center;
    }

    .bot-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        border-radius: 50px;
        background: rgba(255, 204, 0, .10);
        border: 1px solid rgba(255, 204, 0, .30);
        color: #ffcc00;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 1px;
        box-shadow: 0 0 20px rgba(255, 204, 0, .15);
    }

    .bot-title {
        margin-top: 18px;
        font-size: 34px;
        font-weight: 900;
        color: #fff;
        line-height: 1.1;
        letter-spacing: 1px;
    }

    .bot-title span {
        background: linear-gradient(90deg, #00c6ff, #f6dd3b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .user-box {
        margin-top: 18px;
        padding: 14px;
        border-radius: 22px;
        background: rgba(255, 255, 255, .04);
        border: 1px solid rgba(255, 255, 255, .07);
        backdrop-filter: blur(10px);
    }

    .user-label {
        font-size: 11px;
        color: #94a3b8;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .user-name {
        margin-top: 6px;
        color: #fff;
        font-size: 19px;
        font-weight: 800;
    }

    .user-id {
        margin-top: 4px;
        color: #00c6ff;
        font-size: 13px;
        font-weight: 600;
        border: none;
    }

    .bot-image {
        position: relative;
        z-index: 2;
        text-align: center;
        margin-top: 5px;
    }

    .bot-image img {
        width: 180px;
        transition: .4s ease;
        filter: drop-shadow(0 20px 35px rgba(0, 0, 0, .45));
    }

    .premium-card:hover .bot-image img {
        transform: translateY(-8px) scale(1.05);
    }

    .feature-area {
        position: relative;
        z-index: 2;
        padding: 10px 20px 18px;
    }

    .feature-box {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
        padding: 14px;
        border-radius: 18px;
        background: rgba(255, 255, 255, .03);
        border: 1px solid rgba(255, 255, 255, .05);
        transition: .3s;
    }

    .feature-box:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, .05);
    }

    .feature-icon {
        min-width: 40px;
        height: 40px;
        border-radius: 14px;
        background: linear-gradient(135deg, #00c6ff, #ffa831);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        box-shadow: 0 0 20px rgba(37, 99, 235, .35);
    }

    .feature-text {
        color: #e2e8f0;
        font-size: 13px;
        line-height: 1.5;
    }

    .price-section {
        position: relative;
        z-index: 2;
        margin: 10px 20px;
        padding: 18px;
        border-radius: 24px;
        background: linear-gradient(135deg, #ffcc00, #f59e0b);
        text-align: center;
        box-shadow: 0 15px 30px rgba(255, 204, 0, .25);
    }

    .price-label {
        font-size: 13px;
        font-weight: 800;
        color: #111827;
        letter-spacing: 1px;
    }

    .price-value {
        margin-top: 6px;
        font-size: 46px;
        font-weight: 900;
        color: #111827;
        line-height: 1;
    }

    .buy-area {
        padding: 15px 20px 25px;
        position: relative;
        z-index: 2;
    }

    .buy-btn {
        width: 100%;
        height: 60px;
        border: none;
        border-radius: 18px;
        background: linear-gradient(90deg, #00c6ff, #ffa831, #7c3aed);
        color: #fff;
        font-size: 17px;
        font-weight: 800;
        letter-spacing: .5px;
        cursor: pointer;
        transition: .35s;
        box-shadow:
            0 0 25px rgba(37, 99, 235, .35),
            inset 0 0 12px rgba(255, 255, 255, .15);
    }

    .buy-btn:hover {
        transform: translateY(-3px);
        box-shadow:
            0 0 50px rgba(37, 99, 235, .55),
            0 0 70px rgba(124, 58, 237, .30);
    }

    /* WALLET CARD */

    .wallet-card {
        width: 420px;
        min-height: 240px;
        border-radius: 32px;
        padding: 28px 22px;
        background: linear-gradient(160deg, #08111f 0%, #101827 55%, #050816 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow:
            0 0 30px rgba(0, 198, 255, .12),
            0 0 70px rgba(124, 58, 237, .10);
        position: relative;
        overflow: hidden;
    }

    .wallet-card::before {
        content: '';
        position: absolute;
        width: 220px;
        height: 220px;
        background: rgba(0, 198, 255, .10);
        border-radius: 50%;
        top: -90px;
        right: -80px;
        filter: blur(50px);
    }

    .wallet-logo {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .wallet-logo img {
        width: 100%;
        filter: drop-shadow(0 0 20px rgba(0, 198, 255, .25));
    }

    .wallet-title {
        position: relative;
        z-index: 2;
        margin-top: 18px;
        text-align: center;
        color: #94a3b8;
        font-size: 13px;
        letter-spacing: 2px;
        font-weight: 700;
    }

    .wallet-balance {
        position: relative;
        z-index: 2;
        text-align: center;
        margin-top: 12px;
        font-size: 42px;
        font-weight: 900;
        color: #00c6ff;
        text-shadow: 0 0 20px rgba(0, 198, 255, .35);
    }

    .wallet-text {
        position: relative;
        z-index: 2;
        margin-top: 10px;
        text-align: center;
        color: #e2e8f0;
        font-size: 15px;
    }

    @media(max-width:768px) {

        .premium-card,
        .wallet-card {
            width: 100%;
            max-width: 100%;
        }

        .bot-title {
            font-size: 28px;
        }

        .price-value {
            font-size: 40px;
        }

        .wallet-balance {
            font-size: 36px;
        }

        .bot-image img {
            width: 160px;
        }

        .premium-wrap {
            display: grid !important;
        }
    }
</style>

<div class="bot-page">

    <div class="premium-wrap">

        <div class="premium-card">

            <div class="card-top">

                <div class="bot-badge">
                    AI TRADING BOT
                </div>

                <div class="bot-title">
                    TURBO <span>EX BOT</span>
                </div>

                <div class="user-box">

                    <div class="user-label">
                        Activated For
                    </div>

                    <div class="user-name">
                        <?php echo $userName; ?>
                    </div>

                    <div class="user-id">
                        USER ID : <?php echo $userId; ?>
                    </div>

                </div>

            </div>

            <div class="feature-area">

                <div class="feature-box">
                    <div class="feature-icon">✓</div>
                    <div class="feature-text">
                        24/7 Live Market Monitoring & Bot Support
                    </div>
                </div>

                <div class="feature-box">
                    <div class="feature-icon">✓</div>
                    <div class="feature-text">
                        Bot subscription validity is 365 days from the date of joining.
                    </div>
                </div>

            </div>

            <div class="price-section">

                <div class="price-label">
                    ONE TIME ACTIVATION
                </div>

                <div class="price-value">
                    $<?php echo $investAmount; ?>
                </div>

            </div>

            <div class="buy-area">

                <form action="botPurchaseProcess.php" method="POST" role="FORM"
                    onsubmit="return confirm('Are you sure?')">

                    <input type="hidden" name="amount" value="<?php echo $investAmount; ?>">

                    <button class="buy-btn purchase-btn" type="submit" name="purchaseNow" value="Purchase Now">
                        PURCHASE NOW →
                    </button>

                </form>

            </div>

        </div>

        <!-- RIGHT SIDE WALLET CARD -->

        <div class="wallet-card">

            <div class="wallet-logo">
                <img src="assets/img/logo.png" alt="logo">
            </div>

            <div class="wallet-title">
                MAIN WALLET
            </div>

            <div class="wallet-balance">
                $<?php echo number_format($mainWallet, 2); ?>
            </div>

            <div class="wallet-text">
                Available Balance
            </div>

        </div>

    </div>

</div>

<script>

    document.querySelector('.purchase-btn').addEventListener('click', function () {

        const btn = this;

        btn.innerHTML = 'PROCESSING...';
        btn.style.opacity = '0.8';

    });

</script>

<?php require_once("Include/Footer.php"); ?>