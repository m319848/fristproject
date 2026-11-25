<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');

session_start();

$todayDate = date('Y-m-d');
$queryGe = mysqli_query($con, "SELECT member_id,wallet,topupFlag,activationDate,fundWallet,date_time FROM meddolic_user_details WHERE user_id='$userId'");
$valGe = mysqli_fetch_assoc($queryGe);
$memberId = $valGe['member_id'];
$incomeWallet = $valGe['wallet'];
$topupFlag = $valGe['topupFlag'];
$fundWallet = $valGe['fundWallet'];
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
    (SELECT SUM(incomeAmount) FROM meddolic_user_cashback_income_details WHERE member_id='$memberId' AND status=1 AND packageStatus=2 ) AS packageroiIncome,
    (SELECT SUM(incomeAmount) FROM meddolic_user_cashback_income_details WHERE member_id='$memberId' AND status=1 AND packageStatus=1 ) AS roiIncome,
    (SELECT SUM(rewardIncome) FROM meddolic_user_reward_details WHERE memberId='$memberId') AS rewardIncome,
    (SELECT SUM(directIncome) FROM meddolic_user_sponsor_income WHERE memberId='$memberId' AND releaseStatus=1) AS directIncome
       
           ");
$valAll = mysqli_fetch_assoc($queryAll);
$levelIncome = $valAll['levelIncome'];
$boostroiIncome = $valAll['packageroiIncome'];
$roiIncome = $valAll['roiIncome'];
$directIncome = $valAll['directIncome'];
$rewardIncome = $valAll['rewardIncome'];
$totalIncome = $roiIncome + $levelIncome + $rewardIncome + $directIncome;

$queryTeam = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE member_id IN ( SELECT child_id FROM meddolic_user_child_ids WHERE member_id='$memberId' AND topup_status=1)");
$valTeam = mysqli_fetch_array($queryTeam);
$teamBusiness = $valTeam[0];


$queryInvest = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE member_id='$memberId'");
$valInvest = mysqli_fetch_array($queryInvest);
$totalInvest = $valInvest[0];

if ($activeSponser <= 0) {
    $cappingLimit = $totalInvest * 2;
} else {
    $cappingLimit = $totalInvest * 3;
}

$remainingLimit = $cappingLimit - $totalIncome;
// $remainingLimit = 0;

$showPopupOnce = false;

// capping over condition
if ($remainingLimit <= 0) {

    // check cookie
    if (!isset($_COOKIE['capping_popup_shown'])) {
        $showPopupOnce = true;

        // set cookie for 1 day (you can change time)
        setcookie("capping_popup_shown", "1", time() + 86400, "/");
    }
}
$queryWithdraw = mysqli_query($con, "SELECT SUM(amount) FROM meddolic_user_wallet_withdrawal WHERE member_id='$memberId' AND (released IN (0,1) OR status='FINISHED')");
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

$queryNews = mysqli_query($con, "SELECT news FROM meddolic_config_news_list WHERE newStatus=1");
$newsList = [];

while ($row = mysqli_fetch_assoc($queryNews)) {
    $newsList[] = $row['news'];
}
$queryWithdraw = mysqli_query($con, "SELECT coinrate FROM meddolic_config_misc_setting");
$valWithdraw = mysqli_fetch_assoc($queryWithdraw);
$coinrate = $valWithdraw['coinrate'];
?>
<style>
    /* ── Pagination ─────────────────────────────────────────── */
    .pagination .page-link {
        background-color: #0f1535;
        border-color: #2a2f6e;
        color: #a0aec0;
        font-size: 0.8rem;
        padding: 0.35rem 0.65rem;
        transition: all 0.2s ease;
    }

    .pagination .page-link:hover {
        background-color: #1a237e;
        border-color: #3949ab;
        color: #ffffff;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #e5b046, #d4b806);
        border-color: transparent;
        color: #ffffff;
        font-weight: 600;
        box-shadow: 0 0 10px rgba(79, 70, 229, 0.5);
    }

    .pagination .page-item.disabled .page-link {
        background-color: #0a0e27;
        border-color: #1a1f4e;
        color: #3a4060;
        cursor: not-allowed;
    }

    .pagination .page-item:first-child .page-link {
        border-radius: 8px 0 0 8px;
    }

    .pagination .page-item:last-child .page-link {
        border-radius: 0 8px 8px 0;
    }

    /* Showing X-Y of Z text */
    .pagination-info {
        color: #a0aec0;
        font-size: 0.8rem;
    }

    .pagination-info strong {
        color: #06b6d4;
    }
</style>
<div class="dashboard">
    <?php if (!empty($newsList)): ?>
        <div class="news-ticker">
            <div class="news-track">
                <?php
                foreach ($newsList as $news) {
                    echo "<span>" . htmlspecialchars($news) . "</span>";
                }
                ?>
            </div>
        </div>
    <?php endif; ?>
    <div id="toast">Referral Link Copied!</div>
    <div class="gradient-border header-card">
        <div class="inner-content">
            <div class="user-title">
                <h1>
                    WELCOME ,
                    <?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8'); ?>
                    (<?= htmlspecialchars($userId, ENT_QUOTES, 'UTF-8'); ?>)
                </h1>

                <div class="user-meta">

                    <?php if ($topupFlag == 1): ?>
                        <span class="badge badge-success">Active</span>
                    <?php else: ?>
                        <span class="badge badge-danger">Inactive</span>
                    <?php endif; ?>

                    Activated: <?= htmlspecialchars($activationDate, ENT_QUOTES, 'UTF-8'); ?>

                </div>
            </div>


            <div class="avatar-box">
                <img src="assets/img/user.png" alt="Profile">
                <div class="status-dot"></div>
            </div>
        </div>
    </div>

    <div class="top-row">
        <div class="gradient-border trade-box">
            <div class="inner-content split-box">

                <!-- LEFT CONTENT -->
                <div class="content-side">
                    <h3>Start Trading</h3>
                    <p>Begin your crypto trading journey with our trusted partner exchange.</p>
                    <a target="" href="authActiveUser" class="btn-blue">Invest Now</a>
                </div>
                <!-- RIGHT IMAGE -->
                <div class="image-side">
                    <img src="assets/img/investment.png" alt="Investment">
                </div>
            </div>
        </div>
        <div class="gradient-border referral-box">
            <div class="inner-content referral-split">

                <!-- LEFT CONTENT -->
                <div class="ref-content">
                    <h3>Referral Links</h3>
                    <p>Invite friends and earn rewards instantly 🚀</p>

                    <p>Left Referral</p>
                    <div class="copy-group">
                        <input type="text" id="referralLink"
                            value="https://fundx.live/authUserRegister?affiliateCode=<?= $userId ?>" readonly>

                        <button class="btn-blue" onclick="copyReferral()">
                            <i class="fa-regular fa-copy"></i> Copy
                        </button>
                    </div>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="ref-image">
                    <img src="assets/img/refer.png" alt="Referral">
                </div>

            </div>
        </div>

        <!-- Toast -->
        <div id="toast">Referral Link Copied ✔</div>

    </div>

    <div class="main-grid">
        <div class="gradient-border stat-card">
            <div class="inner-content" style="justify-content:space-between">
                <div style="display: flex; gap:15px;">
                    <div class="ph-icon"><i class="fa-solid fa-wallet"></i></div>
                    <div class="stat-info">
                        <span>FUND WALLET</span>
                        <b>$
                            <?= htmlspecialchars(number_format((float) $fundWallet, 2), ENT_QUOTES, 'UTF-8') ?>
                        </b>
                    </div>
                </div>
                <a href="fundRequestonline" class="btn-blue">Deposite</a>
            </div>
        </div>

        <div class="gradient-border stat-card">
            <div class="inner-content" style="justify-content:space-between">
                <div style="display: flex; gap:15px;">
                    <div class="ph-icon"><i class="fa-solid fa-chart-line"></i></div>
                    <div class="stat-info">
                        <span>INCOME WALLET</span>
                        <b>$
                            <?= htmlspecialchars(number_format((float) $incomeWallet, 2), ENT_QUOTES, 'UTF-8') ?>
                        </b>
                    </div>
                </div>
                <a href="walletWithdraw" class="btn-blue">Withdrawal</a>
            </div>
        </div>
    </div>
    <div class="main-grid">
        <div class="stats-side">
            <div class="gradient-border stat-card">
                <div class="inner-content">
                    <div class="ph-icon"><i class="fa-solid fa-dollar-sign"></i></div>
                    <div class="stat-info">
                        <span>TOTAL EARNING</span>
                        <b>$
                            <?= htmlspecialchars(number_format((float) $totalIncome, 2), ENT_QUOTES, 'UTF-8') ?>
                        </b>
                    </div>
                </div>
            </div>

            <div class="gradient-border stat-card">
                <div class="inner-content">
                    <div class="ph-icon"><i class="fa-solid fa-arrow-up-right-from-square"></i></div>
                    <div class="stat-info">
                        <span>TOTAL WITHDRAWAL</span>
                        <b>$
                            <?= htmlspecialchars(number_format((float) $totalWithdraw, 2), ENT_QUOTES, 'UTF-8') ?>
                        </b>
                    </div>
                </div>
            </div>

            <div class="gradient-border stat-card">
                <div class="inner-content">
                    <div class="ph-icon"><i class="fa-solid fa-briefcase"></i></div>
                    <div class="stat-info">
                        <span>TOTAL SELF BUSINESS</span>
                        <b>$
                            <?= htmlspecialchars(number_format((float) $totalInvest, 2), ENT_QUOTES, 'UTF-8') ?>
                        </b>
                    </div>
                </div>
            </div>
             <div class="gradient-border stat-card">
                <div class="inner-content">
                    <div class="ph-icon"><i class="fa-solid fa-briefcase"></i></div>
                    <div class="stat-info">
                        <span>TOTAL FDX Token</span>
                        <b>
                            <?= htmlspecialchars(number_format((float) $totalInvest * $coinrate , 2), ENT_QUOTES, 'UTF-8') ?> FDX
                        </b>
                    </div>
                </div>
            </div>

            <div class="gradient-border stat-card">
                <div class="inner-content">
                    <div class="ph-icon"><i class="fa-solid fa-briefcase"></i></div>
                    <div class="stat-info">
                        <span>TEAM BUSINESS</span>
                        <b>$
                            <?= htmlspecialchars(number_format((float) $teamBusiness, 2), ENT_QUOTES, 'UTF-8') ?>
                        </b>
                    </div>
                </div>
            </div>
            
            <div class="gradient-border stat-card">
                <div class="inner-content">
                    <div class="ph-icon"><i class="fa-solid fa-briefcase"></i></div>
                    <div class="stat-info">
                        <span>TEAM BUSINESS (FDX Token)</span>
                        <b>
                            <?= htmlspecialchars(number_format((float) $teamBusiness *$coinrate, 2), ENT_QUOTES, 'UTF-8') ?> FDX
                        </b>
                    </div>
                </div>
            </div>

            <div class="gradient-border stat-card">
                <div class="inner-content">
                    <div class="ph-icon"><i class="fa-solid fa-briefcase"></i></div>
                    <div class="stat-info">
                        <span>TOTAL CAPPING</span>
                        <b>$<?= htmlspecialchars(number_format((float) $cappingLimit, 2), ENT_QUOTES, 'UTF-8') ?></b>
                    </div>
                </div>
            </div>

            <!--<div class="gradient-border stat-card">-->
            <!--    <div class="inner-content">-->
            <!--        <div class="ph-icon"><i class="fa-solid fa-gift"></i></div>-->
            <!--        <div class="stat-info">-->
            <!--            <span>REMAINING CAPPING</span>-->
            <!--            <b>$<?= htmlspecialchars(number_format((float) $remainingLimit, 2), ENT_QUOTES, 'UTF-8') ?></b>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="gradient-border stat-card">
                <div class="inner-content">
                    <div class="ph-icon"><i class="fa-solid fa-gift"></i></div>
                    <div class="stat-info">
                        <span>LEVEL INCOME</span>
                        <b>$
                            <?= htmlspecialchars(number_format((float) $levelIncome, 2), ENT_QUOTES, 'UTF-8') ?>
                        </b>
                    </div>
                </div>
            </div>

            <div class="gradient-border stat-card">
                <div class="inner-content">
                    <div class="ph-icon"><i class="fa-solid fa-coins"></i></div>
                    <div class="stat-info">
                        <span>BOOSTER PACKAGE INCOME</span>
                        <b>$
                            <?= htmlspecialchars(number_format((float) $boostroiIncome, 2), ENT_QUOTES, 'UTF-8') ?>
                        </b>
                    </div>
                </div>
            </div>
            <div class="gradient-border stat-card">
                <div class="inner-content">
                    <div class="ph-icon"><i class="fa-solid fa-coins"></i></div>
                    <div class="stat-info">
                        <span>DAILY STAKING BONUS</span>
                        <b>$
                            <?= htmlspecialchars(number_format((float) $roiIncome, 2), ENT_QUOTES, 'UTF-8') ?>
                        </b>
                    </div>
                </div>
            </div>

            <div class="gradient-border stat-card">
                <div class="inner-content">
                    <div class="ph-icon"><i class="fa-solid fa-crown"></i></div>
                    <div class="stat-info">
                        <span>Direct Income</span>
                        <b>$
                            <?= htmlspecialchars(number_format((float) $directIncome, 2), ENT_QUOTES, 'UTF-8') ?>
                        </b>
                    </div>
                </div>
            </div>
            <div class="gradient-border stat-card">
                <div class="inner-content">
                    <div class="ph-icon"><i class="fa-solid fa-crown"></i></div>
                    <div class="stat-info">
                        <span>Reward Income</span>
                        <b>$
                            <?= htmlspecialchars(number_format((float) $rewardIncome, 2), ENT_QUOTES, 'UTF-8') ?>
                        </b>
                    </div>
                </div>
            </div>

        </div>
        <div class="gradient-border chart-area">
            <div class="inner-content">
                <div id="chart_container">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container" style="height:100%;width:100%">
                        <div class="tradingview-widget-container__widget" style="height:calc(100% - 32px);width:100%">
                        </div>
                        <script type="text/javascript"
                            src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                                {
                                    "allow_symbol_change": true,
                                        "calendar": false,
                                            "details": false,
                                                "hide_side_toolbar": true,
                                                    "hide_top_toolbar": false,
                                                        "hide_legend": false,
                                                            "hide_volume": false,
                                                                "hotlist": false,
                                                                    "interval": "D",
                                                                        "locale": "en",
                                                                            "save_image": true,
                                                                                "style": "2",
                                                                                    "symbol": "BITSTAMP:BTCUSD",
                                                                                        "theme": "dark",
                                                                                            "timezone": "Etc/UTC",
                                                                                                "backgroundColor": "#0F0F0F",
                                                                                                    "gridColor": "rgba(242, 242, 242, 0.06)",
                                                                                                        "watchlist": [],
                                                                                                            "withdateranges": false,
                                                                                                                "compareSymbols": [],
                                                                                                                    "studies": [],
                                                                                                                        "autosize": true
                                }
                            </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
            </div>
        </div>
    </div>
    <?php if ($showPopupOnce): ?>
        <div id="cappingPopup" class="popup-modal">
            <div class="popup-box">

                <span class="close-btn" onclick="closeCappingPopup()">&times;</span>

                <h2>⚠️ Capping Limit Reached</h2>

                <p>
                    Your earning capping limit has been completed.
                    Please re-topup to continue earning.
                </p>

                <a href="fundRequestonline" class="retopup-btn">
                    Re-Topup Now
                </a>

            </div>
        </div>
    <?php endif; ?>

    <?php if ($imageStatus == 1 && !empty($popupImage)): ?>
        <div id="popupModal">
            <div class="popup-content">
                <span class="close-btn" onclick="closePopup()">&times;</span>
                <img src="../<?= htmlspecialchars($popupImage) ?>" alt="Popup Image">
            </div>
        </div>
    <?php endif; ?>
    <script>
        function closePopup() {
            document.getElementById("popupModal").style.display = "none";
        }
        function closeCappingPopup() {
            document.getElementById("cappingPopup").style.display = "none";
        }
    </script>

    <script>
        function copyReferral() {

            var copyText = document.getElementById("referralLink");

            navigator.clipboard.writeText(copyText.value);

            var toast = document.getElementById("toast");

            toast.classList.add("show");

            setTimeout(function () {
                toast.classList.remove("show");
            }, 2000);
        }
    </script>
    <script type="module" src="https://widgets.tradingview-widget.com/w/en/tv-ticker-tape.js"></script>

    <?php require_once("Include/Footer.php"); ?>