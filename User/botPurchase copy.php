<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --bg: #020617;
        --card: #081120;
        --border: rgba(59, 130, 246, .35);
        --text: #fff;
        --muted: #94a3b8;
        --blue: #1d9bf0;
        --cyan: #00d4ff;
        --purple: #7c3aed;
        --green: #10b981;
    }

    body {
        background: var(--bg);
        font-family: 'Inter', sans-serif;
        color: var(--text);
    }

    .bot-page {
        padding: 30px;
    }

    .bot-wrap {
        max-width: 1350px;
        margin: auto;
    }

    .plans-wrap {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 28px;
    }

    .plan-card {
        position: relative;
        overflow: hidden;
        border-radius: 30px;
        padding: 22px;
        background:
            linear-gradient(180deg, #071120 0%, #020817 100%);
        border: 2px solid rgba(255, 187, 0, .45);
        box-shadow:
            0 0 30px rgba(255, 187, 0, .12),
            inset 0 0 25px rgba(255, 255, 255, .02);
        transition: .35s;
    }

    .plan-card:hover {
        transform: translateY(-8px);
        box-shadow:
            0 0 45px rgba(255, 187, 0, .25),
            0 0 70px rgba(0, 183, 255, .12);
    }

    .plan-no {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        min-width: 70px;
        height: 42px;
        border-radius: 0 0 18px 18px;
        background: linear-gradient(180deg, #ffcc00, #d89a00);
        color: #111;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        font-weight: 900;
        box-shadow: 0 10px 20px rgba(255, 204, 0, .35);
    }

    .plan-title {
        margin-top: 45px;
        text-align: center;
        font-size: 34px;
        font-weight: 900;
        line-height: 1.1;
        color: #ffcc00;
        text-transform: uppercase;
    }

    .plan-title span {
        display: block;
        font-size: 46px;
        color: #fff;
        margin-top: 5px;
    }

    .plan-img {
        display: flex;
        justify-content: center;
        margin: 25px 0;
    }

    .plan-img img {
        width: 220px;
        object-fit: contain;
        filter: drop-shadow(0 15px 30px rgba(0, 0, 0, .45));
    }

    .plan-features {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-top: 10px;
    }

    .pf-item {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #dbeafe;
        font-size: 15px;
    }

    .pf-icon {
        min-width: 23px;
        height: 23px;
        border-radius: 50%;
        background: rgba(255, 187, 0, .12);
        border: 1px solid rgba(255, 187, 0, .45);
        color: #ffcc00;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 800;
    }

    .plan-price {
        margin-top: 28px;
        height: 78px;
        border-radius: 22px;
        background: linear-gradient(180deg, #ffcc00, #d89a00);
        color: #111827;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: 900;
        box-shadow:
            inset 0 2px 8px rgba(255, 255, 255, .35),
            0 12px 30px rgba(255, 187, 0, .35);
    }

    .buy-btn {
        width: 100%;
        height: 62px;
        border: none;
        border-radius: 18px;
        margin-top: 18px;
        font-size: 18px;
        font-weight: 800;
        cursor: pointer;
        color: #fff;
        background: linear-gradient(90deg, #00c6ff, #ffa831, #7c3aed);
        transition: .3s;
        box-shadow: 0 0 30px rgba(37, 99, 235, .35);
    }

    .buy-btn:hover {
        transform: translateY(-3px);
        box-shadow:
            0 0 45px rgba(37, 99, 235, .65),
            0 0 60px rgba(124, 58, 237, .35);
    }

    .alert-box {
        position: fixed;
        top: 30px;
        right: 30px;
        min-width: 340px;
        background: linear-gradient(135deg, #071b2f, #0f172a);
        border: 1px solid rgba(16, 185, 129, .4);
        color: #fff;
        border-radius: 20px;
        padding: 22px;
        box-shadow: 0 0 40px rgba(16, 185, 129, .35);
        transform: translateX(420px);
        opacity: 0;
        transition: .5s;
        z-index: 9999;
    }

    .alert-box.show {
        transform: translateX(0);
        opacity: 1;
    }

    .alert-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #10b981;
    }

    .alert-msg {
        color: #cbd5e1;
        line-height: 1.6;
        font-size: 15px;
    }

    @media(max-width:768px) {

        .bot-page {
            padding: 15px;
        }

        .plans-wrap {
            grid-template-columns: 1fr;
        }

        .plan-title {
            font-size: 28px;
        }

        .plan-title span {
            font-size: 38px;
        }

        .plan-price {
            font-size: 40px;
        }

        .alert-box {
            left: 15px;
            right: 15px;
            min-width: auto;
        }
    }
</style>

<div class="bot-page">

    <div class="bot-wrap">

        <div class="plans-wrap">

            <!-- CARD 1 -->
            <div class="plan-card">

                <div class="plan-no">01</div>

                <div class="plan-title">
                    25 PAIRS
                    <span>LAPTOP</span>
                </div>

                <div class="plan-img">
                    <img src="assets/img/laptop.png" alt="">
                </div>

                <div class="plan-features">

                    <div class="pf-item">
                        <div class="pf-icon">✓</div>
                        AI Powered Trading Bot
                    </div>

                    <div class="pf-item">
                        <div class="pf-icon">✓</div>
                        100% Automated Trading
                    </div>

                    <div class="pf-item">
                        <div class="pf-icon">✓</div>
                        Risk Management System
                    </div>

                    <div class="pf-item">
                        <div class="pf-icon">✓</div>
                        24/7 Trading Support
                    </div>

                    <div class="pf-item">
                        <div class="pf-icon">✓</div>
                        High Accuracy & Performance
                    </div>

                </div>

                <div class="plan-price">
                    $500
                </div>

                <form action="purchaseBotProcess.php" method="POST">

                    <input type="hidden" name="amount" value="500">

                    <button class="buy-btn purchase-btn" type="submit">
                        Purchase Now →
                    </button>

                </form>

            </div>

            <!-- CARD 2 -->
            <div class="plan-card">

                <div class="plan-no">02</div>

                <div class="plan-title">
                    50 PAIRS
                    <span>SERVER</span>
                </div>

                <div class="plan-img">
                    <img src="assets/img/server.png" alt="">
                </div>

                <div class="plan-features">

                    <div class="pf-item">
                        <div class="pf-icon">✓</div>
                        Advanced AI Signals
                    </div>

                    <div class="pf-item">
                        <div class="pf-icon">✓</div>
                        Fully Automated Trades
                    </div>

                    <div class="pf-item">
                        <div class="pf-icon">✓</div>
                        Smart Risk Protection
                    </div>

                    <div class="pf-item">
                        <div class="pf-icon">✓</div>
                        VIP Trading Support
                    </div>

                    <div class="pf-item">
                        <div class="pf-icon">✓</div>
                        Maximum Performance
                    </div>

                </div>

                <div class="plan-price">
                    $1000
                </div>

                <form action="purchaseBotProcess.php" method="POST">

                    <input type="hidden" name="amount" value="1000">

                    <button class="buy-btn purchase-btn" type="submit">
                        Purchase Now →
                    </button>

                </form>

            </div>

            <!-- CARD 3 -->
            <div class="plan-card">

                <div class="plan-no">03</div>

                <div class="plan-title">
                    100 PAIRS
                    <span>PREMIUM</span>
                </div>

                <div class="plan-img">
                    <img src="assets/img/premium.png" alt="">
                </div>

                <div class="plan-features">

                    <div class="pf-item">
                        <div class="pf-icon">✓</div>
                        Institutional AI Bot
                    </div>

                    <div class="pf-item">
                        <div class="pf-icon">✓</div>
                        Ultra Fast Execution
                    </div>

                    <div class="pf-item">
                        <div class="pf-icon">✓</div>
                        Advanced Protection
                    </div>

                    <div class="pf-item">
                        <div class="pf-icon">✓</div>
                        Lifetime Support
                    </div>

                    <div class="pf-item">
                        <div class="pf-icon">✓</div>
                        Highest Accuracy
                    </div>

                </div>

                <div class="plan-price">
                    $2500
                </div>

                <form action="purchaseBotProcess.php" method="POST">

                    <input type="hidden" name="amount" value="2500">

                    <button class="buy-btn purchase-btn" type="submit">
                        Purchase Now →
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<!-- ALERT -->
<div class="alert-box" id="purchaseAlert">

    <div class="alert-title">
        ✅ Purchase Successful
    </div>

    <div class="alert-msg">
        Your Trade Bot package has been activated successfully.
        Start your AI copy trading journey now.
    </div>

</div>

<script>

    document.querySelectorAll('.purchase-btn').forEach(btn => {

        btn.addEventListener('click', function (e) {

            e.preventDefault();

            const form = this.closest('form');

            const alertBox = document.getElementById('purchaseAlert');

            alertBox.classList.add('show');

            setTimeout(() => {

                form.submit();

            }, 2000);

        });

    });

</script>

<?php require_once("Include/Footer.php"); ?>