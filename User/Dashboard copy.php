<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');

$todayDate = date('Y-m-d');
$queryGe = mysqli_query($con, "SELECT member_id,wallet,topupFlag,activationDate,fundWallet,date_time,rewardRank FROM meddolic_user_details WHERE user_id='$userId'");
$valGe = mysqli_fetch_assoc($queryGe);
$memberId = $valGe['member_id'];
$incomeWallet = $valGe['wallet'];
$topupFlag = $valGe['topupFlag'];
$fundWallet = $valGe['fundWallet'];
$rewardRank = $valGe['rewardRank'];
$activationDate = $valGe['activationDate'];

$queryTeam = mysqli_query($con, "SELECT
      (SELECT COUNT(1) FROM meddolic_user_details WHERE sponser_id='$memberId') AS totalSponser,
      (SELECT COUNT(1) FROM meddolic_user_details WHERE sponser_id='$memberId' AND topupFlag=1) AS activeSponser,
      (SELECT COUNT(1) FROM meddolic_user_details WHERE sponser_id='$memberId' AND topupFlag=0) AS inActiveSponser,
(SELECT COUNT(1) FROM meddolic_user_child_ids WHERE member_id='$memberId' AND level BETWEEN 1 AND 15) AS totalTeam,
    (SELECT COUNT(1) FROM meddolic_user_child_ids WHERE member_id='$memberId' AND topup_status=1 AND level BETWEEN 1 AND 15) AS activeTeam,
    (SELECT COUNT(1) FROM meddolic_user_child_ids WHERE member_id='$memberId' AND topup_status=0 AND level BETWEEN 1 AND 15) AS inActiveTeam");
$valTeam = mysqli_fetch_assoc($queryTeam);
$totalSponser = $valTeam['totalSponser'];
$activeSponser = $valTeam['activeSponser'];
$inActiveSponser = $valTeam['inActiveSponser'];
$totalTeam = $valTeam['totalTeam'];
$activeTeam = $valTeam['activeTeam'];
$inActiveTeam = $valTeam['inActiveTeam'];

$queryAll = mysqli_query($con, "SELECT
    (SELECT SUM(levelIncome) FROM meddolic_user_level_income WHERE memberId='$memberId' AND releaseStatus=1 ) AS levelIncome,
    (SELECT SUM(rewardIncome) FROM meddolic_user_reward_income WHERE memberId='$memberId' AND rewardStatus=1 ) AS rewardIncome,
    (SELECT SUM(tradeAmount) FROM meddolic_user_trade_income WHERE member_id='$memberId'AND status=1) AS tradeIncome,
    (SELECT SUM(levelIncome) FROM meddolic_user_trade_level_income WHERE memberId='$memberId'AND releaseStatus=1) AS tradeLevelIncome,
    (SELECT SUM(matchingIncome) FROM meddolic_user_matching_income WHERE memberId='$memberId') AS matchingIncome
           ");
$valAll = mysqli_fetch_assoc($queryAll);
$levelIncome = $valAll['levelIncome'];
$rewardIncome = $valAll['rewardIncome'];
$tradeIncome = $valAll['tradeIncome'];
$tradeLevelIncome = $valAll['tradeLevelIncome'];
$matchingIncome = $valAll['matchingIncome'];
$totalIncome = $tradeLevelIncome + $levelIncome + $rewardIncome + $tradeIncome + $matchingIncome;

$queryTeam = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE member_id IN ( SELECT child_id FROM meddolic_user_child_ids WHERE member_id='$memberId' AND topup_status=1)");
$valTeam = mysqli_fetch_array($queryTeam);
$teamBusiness = $valTeam[0];

$queryInvest = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE member_id='$memberId'");
$valInvest = mysqli_fetch_array($queryInvest);
$totalInvest = $valInvest[0];

$totalBusiness = $totalInvest;

$queryWithdraw = mysqli_query($con, "SELECT SUM(amount) FROM meddolic_user_wallet_withdrawal WHERE member_id='$memberId' AND released IN (0,1)");
$valWithdraw = mysqli_fetch_array($queryWithdraw);
$totalWithdraw = $valWithdraw[0];

$queryNews = mysqli_query($con, "SELECT news,newStatus FROM meddolic_config_news_list WHERE newStatus=1");
$valNews = mysqli_fetch_assoc($queryNews);

$queryLeftBusi = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE purchaseType=1 AND member_id IN (SELECT child_id FROM meddolic_user_child_ids WHERE member_id='$memberId'AND legPosition=2 AND topup_status=1)");
$valLeftBusi = mysqli_fetch_array($queryLeftBusi);
$leftBusi = $valLeftBusi[0];

$queryLeftbotBusi = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE  purchaseType=2 AND  member_id IN (SELECT child_id FROM meddolic_user_child_ids WHERE member_id='$memberId'AND legPosition=2 AND topup_status=1)");
$valLeftbotBusi = mysqli_fetch_array($queryLeftbotBusi);
$leftbotBusi = $valLeftbotBusi[0];

$queryRightBusi = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE purchaseType=1 AND  member_id IN (SELECT child_id FROM meddolic_user_child_ids WHERE member_id='$memberId'AND legPosition=3 AND topup_status=1)");
$valRightBusi = mysqli_fetch_array($queryRightBusi);
$rightBusi = $valRightBusi[0];

$queryRightbotBusi = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE purchaseType=2 AND  member_id IN (SELECT child_id FROM meddolic_user_child_ids WHERE member_id='$memberId'AND legPosition=3 AND topup_status=1)");
$valRightbotBusi = mysqli_fetch_array($queryRightbotBusi);
$rightbotBusi = $valRightbotBusi[0];

$queryPopup = mysqli_query($con, "SELECT dashboardImage, imageStatus FROM meddolic_config_misc_setting LIMIT 1");
$valPopup = mysqli_fetch_assoc($queryPopup);
$popupImage = $valPopup['dashboardImage'] ?? '';
$imageStatus = $valPopup['imageStatus'] ?? 0;

$queryAccount = mysqli_query($con, "SELECT accountNo FROM meddolic_user_trading_account_details WHERE member_id ='$memberId' AND status=1");
$valAccNo = mysqli_fetch_assoc($queryAccount);
$accountNo = $valAccNo['accountNo'] ?? '';

$queryNews = mysqli_query($con, "SELECT news FROM meddolic_config_news_list WHERE newStatus=1");
$newsList = [];
while ($row = mysqli_fetch_assoc($queryNews)) {
    $newsList[] = $row['news'];
}
?>

<!-- Premium Custom CSS Style Sheet for Global Presentation -->
<style>
    :root {
        --bg-dark: #0a0c10;
        --panel-bg: rgba(18, 22, 32, 0.65);
        --panel-border: rgba(255, 255, 255, 0.08);
        --neon-blue: #00e5ff;
        --neon-glow: rgba(0, 229, 255, 0.2);
        --gold-accent: #ffb703;
        --text-primary: #ffffff;
        --text-secondary: #94a3b8;
        --success-green: #00e676;
        --danger-red: #ff1744;
    }

    body {
        background-color: var(--bg-dark);
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
    }

    /* Core Layout Layout Container */
    .dashboard-container {
        padding: 24px;
        max-width: 1600px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Ticker System Customization */
    .news-ticker-premium {
        background: rgba(0, 229, 255, 0.03);
        border: 1px solid rgba(0, 229, 255, 0.15);
        border-radius: 12px;
        padding: 12px;
        overflow: hidden;
        white-space: nowrap;
        backdrop-filter: blur(10px);
    }

    .news-track-premium {
        display: inline-block;
        animation: marquee 25s linear infinite;
    }

    .news-track-premium span {
        margin-right: 50px;
        color: var(--neon-blue);
        font-weight: 500;
        font-size: 14px;
        letter-spacing: 0.5px;
    }

    @keyframes marquee {
        0% {
            transform: translate3d(100%, 0, 0);
        }

        100% {
            transform: translate3d(-100%, 0, 0);
        }
    }

    /* Glassmorphic Components Base */
    .glass-card {
        background: var(--panel-bg);
        border: 1px solid var(--panel-border);
        border-radius: 16px;
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .glass-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, var(--accent-blue), var(--primary-blue), #bf840000);
    }

    .glass-card:hover {
        border-color: rgba(0, 229, 255, 0.25);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
    }

    /* Top Grid Matrix Architecture */
    .header-grid-matrix {
        display: grid;
        grid-template-columns: 1.2fr 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 1024px) {
        .header-grid-matrix {
            grid-template-columns: 1fr;
        }
    }

    /* Welcome Identity Presentation Unit */
    .user-profile-unit {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 24px;
    }

    .user-profile-unit h1 {
        font-size: 22px;
        font-weight: 700;
        letter-spacing: -0.5px;
        margin: 0 0 8px 0;
        background: linear-gradient(135deg, #fff 0%, #cbd5e1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .meta-badge-box {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        color: var(--text-secondary);
    }

    .premium-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-active {
        background: rgba(0, 230, 118, 0.15);
        color: var(--success-green);
        border: 1px solid rgba(0, 230, 118, 0.2);
    }

    .badge-inactive {
        background: rgba(255, 23, 68, 0.15);
        color: var(--danger-red);
        border: 1px solid rgba(255, 23, 68, 0.2);
    }

    .avatar-wrapper {
        position: relative;
        width: 64px;
        height: 64px;
    }

    .avatar-wrapper img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.1);
    }

    .pulse-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        background: var(--success-green);
        border-radius: 50%;
        border: 2px solid #0e121a;
        box-shadow: 0 0 8px var(--success-green);
    }

    /* Action Interactive Blocks */
    .action-panel-box {
        display: flex;
        padding: 20px;
        gap: 16px;
        align-items: center;
        justify-content: space-between;
    }

    .action-info-side {
        max-width: 65%;
    }

    .action-info-side h3 {
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 6px 0;
        color: #fff;
    }

    .action-info-side p {
        font-size: 12px;
        color: var(--text-secondary);
        margin: 0;
        line-height: 1.4;
    }

    .action-vector-side img {
        width: 55px;
        height: 55px;
        object-fit: contain;
        opacity: 0.8;
    }

    /* Referral Group Management */
    .link-group-wrapper {
        display: flex;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--panel-border);
        border-radius: 8px;
        padding: 4px;
        margin-top: 10px;
        align-items: center;
    }

    .link-group-wrapper input {
        background: transparent;
        border: none;
        color: var(--text-primary);
        font-size: 12px;
        padding: 6px 10px;
        width: 100%;
        outline: none;
    }

    /* Premium Accent Action Control Elements */
    .action-trigger-btn {
        background: linear-gradient(135deg, #00e5ff 0%, #00b0ff 100%);
        color: #000;
        font-weight: 600;
        font-size: 13px;
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .action-trigger-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 0 15px var(--neon-glow);
        opacity: 0.95;
    }

    /* Bento Grid Matrix Infrastructure for Financial Statistics */
    .bento-financial-matrix {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .span-double-col {
        grid-column: span 2;
    }

    @media (max-width: 1024px) {
        .bento-financial-matrix {
            grid-template-columns: repeat(2, 1fr);
        }

        .span-double-col {
            grid-column: span 2;
        }
    }

    @media (max-width: 640px) {
        .bento-financial-matrix {
            grid-template-columns: 1fr;
        }

        .span-double-col {
            grid-column: span 1;
        }
    }

    /* Financial Segment Displays (Primary and Metrics Units) */
    .financial-primary-card {
        padding: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(145deg, rgba(18, 22, 32, 0.9) 0%, rgba(10, 12, 16, 0.7) 100%);
    }

    .metric-icon-box {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .bg-neon-opacity {
        background: rgba(0, 229, 255, 0.1);
        color: var(--neon-blue);
        border: 1px solid rgba(0, 229, 255, 0.15);
    }

    .bg-gold-opacity {
        background: rgba(255, 183, 3, 0.1);
        color: var(--gold-accent);
        border: 1px solid rgba(255, 183, 3, 0.15);
    }

    .currency-value-display {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .currency-value-display span {
        font-size: 11px;
        font-weight: 600;
        color: var(--text-secondary);
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }

    .currency-value-display b {
        font-size: 24px;
        font-weight: 700;
        color: #fff;
        letter-spacing: -0.5px;
    }

    /* Core Grid Matrix for Technical Analysis Module */
    .analytics-section-matrix {
        display: grid;
        grid-template-columns: 1.3fr 2.7fr;
        gap: 20px;
    }

    @media (max-width: 1024px) {
        .analytics-section-matrix {
            grid-template-columns: 1fr;
        }
    }

    .sub-metrics-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
        padding: 20px;
    }

    .sub-metrics-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.03);
    }

    .sub-metrics-item:hover {
        background: rgba(255, 255, 255, 0.04);
    }

    /* High Fidelity Chart Execution Panel */
    .tradingview-chart-container {
        padding: 16px;
        min-height: 420px;
        display: flex;
        flex-direction: column;
    }

    #chart_container {
        flex-grow: 1;
        width: 100%;
        min-height: 380px;
        border-radius: 12px;
        overflow: hidden;
    }

    /* Real-time Global Notifier Toast Component */
    #premium-toast-notifier {
        visibility: hidden;
        min-width: 280px;
        background: rgba(10, 12, 16, 0.9);
        color: var(--neon-blue);
        border: 1px solid var(--neon-blue);
        box-shadow: 0 0 20px rgba(0, 229, 255, 0.2);
        text-align: center;
        border-radius: 10px;
        padding: 14px;
        position: fixed;
        z-index: 9999;
        right: 30px;
        bottom: 30px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.5px;
        backdrop-filter: blur(8px);
        transform: translateY(20px);
        opacity: 0;
        transition: opacity 0.3s, transform 0.3s, visibility 0.3s;
    }

    #premium-toast-notifier.show-toast {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }

    /* System Interaction Modal Box Windows */
    #popupModal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(5, 7, 10, 0.85);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
    }

    .popup-content-premium {
        position: relative;
        background: #121620;
        padding: 6px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        max-width: 90%;
        max-height: 85%;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.8);
    }

    .popup-content-premium img {
        max-width: 100%;
        max-height: 75vh;
        border-radius: 12px;
        display: block;
    }

    .close-premium-btn {
        position: absolute;
        top: -16px;
        right: -16px;
        width: 34px;
        height: 34px;
        background: #fff;
        color: #000;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        transition: transform 0.2s;
    }

    .close-premium-btn:hover {
        transform: scale(1.05);
    }
</style>

<div class="dashboard-container">

    <!-- SYSTEM NEWS TICKER COMPONENT -->
    <?php if (!empty($newsList)): ?>
        <div class="news-ticker-premium">
            <div class="news-track-premium">
                <?php foreach ($newsList as $news): ?>
                    <span><i class="fa-solid fa-bullhorn"
                            style="margin-right: 8px;"></i><?= htmlspecialchars($news, ENT_QUOTES, 'UTF-8') ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- STEP 1: IDENTITY AND ACTION TRIAD HERO AREA -->
    <div class="header-grid-matrix">

        <!-- User Identity Block -->
        <div class="glass-card user-profile-unit">
            <div>
                <h1>WELCOME, <?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8'); ?></h1>
                <div class="meta-badge-box">
                    <?php if ($topupFlag == 1): ?>
                        <span class="premium-badge badge-active">Active</span>
                    <?php else: ?>
                        <span class="premium-badge badge-inactive">Inactive</span>
                    <?php endif; ?>
                    <span>ID: <?= htmlspecialchars($userId, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <div style="font-size: 11px; color: var(--text-secondary); margin-top: 10px;">
                    Activation Date: <?= htmlspecialchars($activationDate, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>
            <div class="avatar-wrapper">
                <img src="assets/img/user.png" alt="Profile UI Avatar">
                <div class="pulse-indicator"></div>
            </div>
        </div>

        <!-- Start Trading Execution Module -->
        <div class="glass-card action-panel-box">
            <div class="action-info-side">
                <h3>Start Trading</h3>
                <p>Begin your decentralized trading terminal solutions immediately.</p>
                <div style="margin-top: 12px;">
                    <a href="authActiveUser" class="action-trigger-btn">Invest Now</a>
                </div>
            </div>
            <div class="action-vector-side">
                <img src="assets/img/investment.png" alt="Investment Vector Graphics Asset">
            </div>
        </div>

        <!-- Referral Extraction Panel Module -->
        <div class="glass-card action-panel-box">
            <div class="action-info-side" style="max-width: 100%; flex-grow: 1;">
                <h3>Referral Links</h3>
                <p>Invite nodes and scale your ecosystem reward distribution channels instant 🚀</p>
                <div class="link-group-wrapper">
                    <input type="text" id="referralLinkPremium"
                        value="https://fundx.live/authUserRegister?affiliateCode=<?= $userId ?>" readonly>
                    <button class="action-trigger-btn" onclick="copyPremiumReferral()"
                        style="padding: 6px 12px; font-size: 11px; margin-right: 2px;">
                        <i class="fa-regular fa-copy"></i> Copy
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- STEP 2: PRIMARY FINANCIAL BALANCE MATRICES -->
    <div class="bento-financial-matrix">

        <!-- Fund Wallet Box Context -->
        <div class="glass-card financial-primary-card span-double-col">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="metric-icon-box bg-neon-opacity">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div class="currency-value-display">
                    <span>Fund Wallet Balance</span>
                    <b>$<?= htmlspecialchars(number_format((float) $fundWallet, 2), ENT_QUOTES, 'UTF-8') ?></b>
                </div>
            </div>
            <a href="fundRequest" class="action-trigger-btn"><i class="fa-solid fa-plus"></i> Deposit</a>
        </div>

        <!-- Income Wallet Box Context -->
        <div class="glass-card financial-primary-card span-double-col">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="metric-icon-box bg-gold-opacity">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div class="currency-value-display">
                    <span>Income Wallet Balance</span>
                    <b>$<?= htmlspecialchars(number_format((float) $incomeWallet, 2), ENT_QUOTES, 'UTF-8') ?></b>
                </div>
            </div>
            <a href="walletWithdraw" class="action-trigger-btn"
                style="background: linear-gradient(135deg, #ffb703 0%, #fb8500 100%);"><i
                    class="fa-solid fa-arrow-turn-up"></i> Withdraw</a>
        </div>

    </div>

    <!-- STEP 3: FINANCIAL BENTO SECTIONS & ANALYTICS INTERFACES -->
    <div class="analytics-section-matrix">

        <!-- Structured Secondary Metrics Stack List -->
        <div class="glass-card sub-metrics-list">

            <div class="sub-metrics-item">
                <div class="metric-icon-box bg-neon-opacity" style="width:36px; height:36px; font-size:14px;"><i
                        class="fa-solid fa-dollar-sign"></i></div>
                <div class="currency-value-display">
                    <span style="font-size:10px;">Total Earnings</span>
                    <b
                        style="font-size:16px;">$<?= htmlspecialchars(number_format((float) $totalIncome, 2), ENT_QUOTES, 'UTF-8') ?></b>
                </div>
            </div>

            <div class="sub-metrics-item">
                <div class="metric-icon-box bg-neon-opacity"
                    style="width:36px; height:36px; font-size:14px; color: var(--danger-red); border-color: rgba(255,23,68,0.1); background: rgba(255,23,68,0.05);">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i></div>
                <div class="currency-value-display">
                    <span style="font-size:10px;">Total Withdrawal</span>
                    <b
                        style="font-size:16px;">$<?= htmlspecialchars(number_format((float) $totalWithdraw, 2), ENT_QUOTES, 'UTF-8') ?></b>
                </div>
            </div>

            <div class="sub-metrics-item">
                <div class="metric-icon-box bg-gold-opacity" style="width:36px; height:36px; font-size:14px;"><i
                        class="fa-solid fa-briefcase"></i></div>
                <div class="currency-value-display">
                    <span style="font-size:10px;">Total Self Business</span>
                    <b
                        style="font-size:16px;">$<?= htmlspecialchars(number_format((float) $totalBusiness, 2), ENT_QUOTES, 'UTF-8') ?></b>
                </div>
            </div>

            <div class="sub-metrics-item">
                <div class="metric-icon-box bg-gold-opacity" style="width:36px; height:36px; font-size:14px;"><i
                        class="fa-solid fa-users"></i></div>
                <div class="currency-value-display">
                    <span style="font-size:10px;">Team Business Architecture</span>
                    <b
                        style="font-size:16px;">$<?= htmlspecialchars(number_format((float) $teamBusiness, 2), ENT_QUOTES, 'UTF-8') ?></b>
                </div>
            </div>

            <div class="sub-metrics-item">
                <div class="metric-icon-box bg-neon-opacity" style="width:36px; height:36px; font-size:14px;"><i
                        class="fa-solid fa-gift"></i></div>
                <div class="currency-value-display">
                    <span style="font-size:10px;">Level Income Breakdown</span>
                    <b
                        style="font-size:16px;">$<?= htmlspecialchars(number_format((float) $levelIncome, 2), ENT_QUOTES, 'UTF-8') ?></b>
                </div>
            </div>

            <div class="sub-metrics-item">
                <div class="metric-icon-box bg-neon-opacity" style="width:36px; height:36px; font-size:14px;"><i
                        class="fa-solid fa-coins"></i></div>
                <div class="currency-value-display">
                    <span style="font-size:10px;">Booster Package Incentives</span>
                    <b
                        style="font-size:16px;">$<?= htmlspecialchars(number_format((float) $rewardIncome, 2), ENT_QUOTES, 'UTF-8') ?></b>
                </div>
            </div>

            <div class="sub-metrics-item">
                <div class="metric-icon-box bg-gold-opacity" style="width:36px; height:36px; font-size:14px;"><i
                        class="fa-solid fa-crown"></i></div>
                <div class="currency-value-display">
                    <span style="font-size:10px;">Monthly Club Dividends</span>
                    <b
                        style="font-size:16px;">$<?= htmlspecialchars(number_format((float) $tradeIncome, 2), ENT_QUOTES, 'UTF-8') ?></b>
                </div>
            </div>

        </div>

        <!-- Premium Real-Time Analytics Component Interface Container -->
        <div class="glass-card tradingview-chart-container">
            <div
                style="font-size: 14px; font-weight: 600; margin-bottom: 12px; color: #fff; letter-spacing: 0.3px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-chart-line" style="color: var(--neon-blue);"></i> Live Technical Asset Stream
                Evaluation Metrics
            </div>
            <div id="chart_container"></div>
        </div>

    </div>

</div>

<!-- NOTIFICATION ENGINE SINK TOAST UI Component -->
<div id="premium-toast-notifier">Referral Network Path Link Copied Successfully ✔</div>

<!-- SYSTEM POPUP INJECTION POINT CONTAINER -->
<?php if ($imageStatus == 1 && !empty($popupImage)): ?>
    <div id="popupModal">
        <div class="popup-content-premium">
            <span class="close-premium-btn" onclick="closePremiumPopup()">&times;</span>
            <img src="../<?= htmlspecialchars($popupImage) ?>" alt="System Alert Dynamic Core Presentation Resource Banner">
        </div>
    </div>
<?php endif; ?>

<script>
    function closePremiumPopup() {
        document.getElementById("popupModal").style.display = "none";
    }

    function copyPremiumReferral() {
        var copyText = document.getElementById("referralLinkPremium");
        navigator.clipboard.writeText(copyText.value);

        var toast = document.getElementById("premium-toast-notifier");
        toast.classList.add("show-toast");

        setTimeout(function () {
            toast.classList.remove("show-toast");
        }, 2500);
    }
</script>

<script type="module" src="https://widgets.tradingview-widget.com/w/en/tv-ticker-tape.js"></script>
<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
<script>
    new TradingView.widget({
        "autosize": true,
        "symbol": "BINANCE:BTCUSDT",
        "interval": "H",
        "timezone": "Etc/UTC",
        "theme": "dark",
        "style": "1",
        "locale": "en",
        "container_id": "chart_container",
        "hide_top_toolbar": false,
        "hide_side_toolbar": true,
        "backgroundColor": "#121620",
        "gridColor": "rgba(255, 255, 255, 0.04)",
        "overrides": {
            "mainSeriesProperties.lineStyle.color": "#00e5ff",
            "mainSeriesProperties.lineStyle.linewidth": 2
        }
    });
</script>

<?php require_once("Include/Footer.php"); ?>