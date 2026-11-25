<?php
$queryAccess = mysqli_query($con, "SELECT name,user_id,member_id,roiWallet,topupFlag,wallet,fundWallet,email_id FROM meddolic_user_details WHERE user_id='$_SESSION[member_user_id]'");
if ($valAccess = mysqli_fetch_array($queryAccess)) {
    $userName = $valAccess['name'];
    $userId = $valAccess['user_id'];
    $memberId = $valAccess['member_id'];
    $topupFlag = $valAccess['topupFlag'];
    $incomeWallet = $valAccess['wallet'];
    $fundWallet = $valAccess['fundWallet'];
    $roiWallet = $valAccess['roiWallet'];
    $emailId = $valAccess['email_id'];

} ?>
<div class="mobile-header">
    <div class="logo-area" style="margin:0; padding:0; border:0; width:30%;">
        <div class="logo-icon"><img src="assets/img/favicon.png" alt="" style="width:60%"></div>
    </div>
    <button class="menu-toggle" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars" id="menuIcon"></i>
    </button>
</div>
<aside class="sidebar" id="sidebar">
    <div class="logo-area">
        <div class="logo-icon"><img src="assets/img/logo.png" alt="" style="width:90%"></div>
        <h2 style="font-size: 1.2rem;"></h2>
    </div>

    <nav class="nav-links">
        <a href="Dashboard" class="nav-item active"><i class="fa-solid fa-gauge-high"></i> Overview</a>
        <a href="Profile" class="nav-item"><i class="fa-solid fa-circle-user"></i> Profile</a>

        <!--<div>-->
        <!--    <button class="nav-item dropdown-btn" onclick="toggleDrop(this)">-->
        <!--        <span><i class="fa-solid fa-circle-user"></i> Profile</span>-->
        <!--        <i class="fa-solid fa-circle-chevron-down chevron"></i>-->
        <!--    </button>-->
        <!--    <div class="dropdown-container">-->
        <!--        <a href="Profile">My Profile</a>-->

        <!--    </div>-->
        <!--</div>-->

        <div>
            <button class="nav-item dropdown-btn" onclick="toggleDrop(this)">
                <span> <i class="fi fi-rr-file-invoice-dollar"></i> Fund Manager</span>
                <i class="fa-solid fa-circle-chevron-down chevron"></i>
            </button>
            <div class="dropdown-container">
                <a href="fundRequestonline">Add Fund</a>
                <a href="fundTransfer">P2P Transfer</a>
                <a href="mainToFund">Fund Transfer</a>
            </div>
        </div>
        <div>
            <button class="nav-item dropdown-btn" onclick="toggleDrop(this)">
                <span><i class="fi fi-rs-employees"></i> Team Network</span>
                <i class="fa-solid fa-circle-chevron-down chevron"></i>
            </button>
            <div class="dropdown-container">
                <a href="myReferral">Referral Team</a>
                <a href="myLevelTeam">Level Team</a>
            </div>
        </div>
        <div>
            <button class="nav-item dropdown-btn" onclick="toggleDrop(this)">
                <span><i class="fi fi-rr-power"></i> Trade Purchase</span>
                <i class="fa-solid fa-circle-chevron-down chevron"></i>
            </button>
            <div class="dropdown-container">
                <a href="authActiveUser">Trade Purchase</a>
                <a href="activationHistory">Trade Purchase History</a>
            </div>
        </div>


        <!-- <a href="authActiveUser" class="nav-item"> <i class="fi fi-rr-power"></i> Activation</a> -->
        <div>
            <button class="nav-item dropdown-btn" onclick="toggleDrop(this)">
                <span><i class="fa-solid fa-wallet"></i>Financial Report</span>
                <i class="fa-solid fa-circle-chevron-down chevron"></i>
            </button>
            <div class="dropdown-container">
                <a href="directIncome">Direct Income</a>
                <a href="levelIncome">Level Income</a>
                <a href="roiIncome">Booster Package Income</a>
                <a href="stakingroiIncome">Daily Staking Bonus</a>
                <a href="rewardIncome">Reward Income</a>
            </div>
            <div>
                <button class="nav-item dropdown-btn" onclick="toggleDrop(this)">
                    <span><i class="fa-solid fa-repeat"></i> Wallet Withdraw</span>
                    <i class="fa-solid fa-circle-chevron-down chevron"></i>
                </button>
                <div class="dropdown-container">
                    <a href="addWalletAddress">Add Wallet Address</a>
                    <a href="walletWithdraw">Withdraw</a>
                    <!-- <a href="principalWithdrawal">Principal Withdraw</a> -->
                    <a href="withdrawalHistory">Withdrawal History</a>
                    <!-- <a href="principalWithdrawalHistory">Principal Withdrawal History</a> -->
                </div>
            </div>
            <!-- <a href="walletWithdraw" class="nav-item"><i class="fa-solid fa-repeat"></i>Wallet Withdraw</a> -->
            <a href="Support" class="nav-item"><i class="fa-solid fa-headset"></i> Support</a>
    </nav>
    <div class="payment-card">
        <h3>Secure Payment</h3>

        <div class="icon-boxnav">
            <img src="assets/img/nav.png" alt="" style="width: 80%; margin-top: 10px;">
        </div>

        <!-- <p>100% Safe & Fast</p> -->

    </div>
    <div class="sidebar-footer" style="margin-top: 10px;border-top: 1px solid rgba(255,255,255,0.05);">
        <a href="authSignDash" class="nav-item"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</aside>