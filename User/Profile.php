<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>
<?php
$queryProfile = mysqli_query($con, "SELECT date_time,sponser_id,countryId,name,user_id,email_id,phone FROM meddolic_user_details WHERE user_id='$userId'");
$valProfile = mysqli_fetch_assoc($queryProfile);
$dateTime = $valProfile['date_time'];
$sponserId = $valProfile['sponser_id'];
$countryId = $valProfile['countryId'];
$name = $valProfile['name'];
$email_id = $valProfile['email_id'];
$phone = $valProfile['phone'];

if ($countryId != '') {
    $queryCountry = mysqli_query($con, "SELECT countryName FROM meddolic_config_country_list WHERE country_id='$countryId'");
    $valCountry = mysqli_fetch_assoc($queryCountry);
    $countryName = $valCountry['countryName'];
} ?>


<div class="dashboard">
    <div class="profile-container">

        <div class="page-header">
            <h2>User Profile</h2>
        </div>

        <!-- IDENTITY WRAPPER -->
        <div class="identity-card">
            <div class="banner-bg"></div>
            <div class="user-info-row">
                <div class="avatar-wrapper">
                    <img src="https://cdn.vectorstock.com/i/1000v/51/87/student-avatar-user-profile-icon-vector-47025187.jpg"
                        alt="User Avatar">
                </div>
                <div class="user-details">
                    <div class="name-id-row">
                        <h3><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></h3>
                        <span class="user-id"><?= htmlspecialchars($userId, ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <div class="status-indicator">
                        <?= ($topupFlag == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?>
                    </div>
                </div>
            </div>

            <!-- TAB MENU PANEL CONTAINER -->
            <div class="tab-navigation">
                <button class="tab-btn active" onclick="switchTab(event, 'profile')">
                    <i class="fa-regular fa-user"></i> <span>My Profile</span>
                </button>
                <button class="tab-btn" onclick="switchTab(event, 'login-pass')">
                    <i class="fa-solid fa-users-gear"></i> <span>Change Login Password</span>
                </button>
                <button class="tab-btn" onclick="switchTab(event, 'trn-pass')">
                    <i class="fa-solid fa-table-cells-large"></i> <span>Change Transaction Password</span>
                </button>
            </div>
        </div>

        <!-- DISPLAY BLOCK CONTENT PANELS -->
        <div class="content-card">

            <!-- TAB ROW: PROFILE DATA -->
            <div id="profile" class="tab-content active">
                <h3 class="section-title">My Profile</h3>
                <form action="#" method="POST" class="profile-form">
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" id="userName" name="name" placeholder="Name" readonly=""
                            value="<?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="memberId"
                            value="<?= htmlspecialchars($memberId, ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="form-group">
                        <label>Mobile *</label>
                        <input type="text" id="phoneNo" name="phone" placeholder="Mobile Number"
                            value="<?= htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') ?>"
                            onkeypress="return onlynum(event)" readonly="">
                    </div>
                    <div class="form-group">
                        <label>Email ID *</label>
                        <input type="email" name="emailId" placeholder="Email ID"
                            value="<?= htmlspecialchars($email_id, ENT_QUOTES, 'UTF-8') ?>" readonly="">
                    </div>
                    <div class="form-group">
                        <label>Country *</label>
                        <select class="form-control" readonly="" id="M_COUNTRY" name="countryId">
                            <option value="">Select Country</option>
                            <?php
                            $queryCountry = "SELECT * FROM meddolic_config_country_list WHERE status=1 ORDER BY countryName ASC";
                            $resultCountry = mysqli_query($con, $queryCountry);
                            while ($valCountry = mysqli_fetch_assoc($resultCountry)) { ?>
                                <option value="<?= htmlspecialchars($valCountry['country_id'], ENT_QUOTES, 'UTF-8') ?>"
                                    <?php if ($valCountry['country_id'] == $countryId)
                                        echo "selected"; ?>>
                                    <?= htmlspecialchars($valCountry['countryName'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <!--<button type="submit" class="update-btn" name="profileUpdate" id="submit">Update Profile</button>-->
                </form>
            </div>

            <!-- TAB ROW: LOGIN PASSWORD -->
            <div id="login-pass" class="tab-content">
                <h3 class="section-title">Change Login Password</h3>
                <form class="profile-form" action="userProfileAuthProcess" method="POST">
                    <div class="form-group">
                        <label>Current Login Password *</label>
                        <input type="password" name="password" id="currentPass" placeholder="Enter current password"
                            required>
                        <input type="hidden" name="memberId"
                            value="<?= htmlspecialchars($memberId, ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="form-group" style="display:none; d-none:true; height:0px; width:0px; overflow:hidden;">
                        <!-- Clear Layout Spacing Grid Align Break for elements -->
                    </div>
                    <div class="form-group">
                        <label>New Login Password *</label>
                        <input type="password" name="password1" id="loginPassword" placeholder="Enter new password"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password *</label>
                        <input type="password" id="confirmLoginPassword" name="password2"
                            placeholder="Re-enter new password" required>
                    </div>
                    <button type="submit" name="changeLogin" id="loginJoin" class="update-btn">Update Password</button>
                </form>
            </div>

            <!-- TAB ROW: TRANSACTION COMPONENT PIN -->
            <div id="trn-pass" class="tab-content">
                <h3 class="section-title">Change Transaction Password</h3>
                <p style="color: #8a99ad; font-size: 0.85rem; margin-top:-10px; margin-bottom: 20px;">
                    This password is required for withdrawals and fund transfers.
                </p>
                <form class="profile-form" action="userProfileAuthProcess" method="POST">
                    <div class="form-group">
                        <label>Current Transaction Password *</label>
                        <input type="password" name="trnPassword" id="trnPassword" placeholder="Enter current PIN/Pass"
                            required>
                        <input type="hidden" name="memberId"
                            value="<?= htmlspecialchars($memberId, ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="form-group" style="display:none; d-none:true; height:0px; width:0px; overflow:hidden;">
                        <!-- Clear Layout Spacing Grid Align Break for elements -->
                    </div>
                    <div class="form-group">
                        <label>New Transaction Password *</label>
                        <input type="password" id="trnPassword1" name="trnPassword1"
                            placeholder="Set new transaction pass" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Transaction Password *</label>
                        <input type="password" name="trnPassword2" id="trnPassword2"
                            placeholder="Confirm new transaction pass" required>
                    </div>
                    <button type="submit" name="changeTrn" id="TrnJoin" class="update-btn">Update TRN Password</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    function switchTab(event, tabId) {
        // Discard all active layout states
        const contentTabs = document.querySelectorAll('.tab-content');
        const navigationButtons = document.querySelectorAll('.tab-btn');

        contentTabs.forEach(tab => tab.classList.remove('active'));
        navigationButtons.forEach(btn => btn.classList.remove('active'));

        // Assert new interactive state layout
        document.getElementById(tabId).classList.add('active');
        event.currentTarget.classList.add('active');
    }
</script>

<?php require_once("Include/Footer.php"); ?>