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
            <p>Home <span>•</span> User Profile</p>
        </div>

        <div class="identity-card">
            <div class="banner-bg"></div>
            <div class="user-info-row">
                <div class="avatar-wrapper">
                    <img src="https://cdn.vectorstock.com/i/1000v/51/87/student-avatar-user-profile-icon-vector-47025187.jpg"
                        alt="User">
                    <!--<div class="add-btn"><i class="fa-solid fa-plus"></i></div>-->
                </div>
                <div class="user-details">
                    <div class="name-id-row">
                        <h3><?= $name ?></h3>
                        <span class="user-id">
                            <?= $userId ?>
                        </span>
                    </div>
                    <div class="status-indicator <?= ($topupFlag == 1) ? 'active' : 'inactive'; ?>">
                        <!-- <span class="dot"></span> -->
                        <?= ($topupFlag == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?>
                    </div>
                </div>
            </div>

            <div class="tab-navigation">
                <button class="tab-btn active" onclick="switchTab(event, 'profile')">
                    <i class="fa-regular fa-user"></i> <span> My Profile</span>
                </button>
                <button class="tab-btn" onclick="switchTab(event, 'login-pass')">
                    <i class="fa-solid fa-users-gear"></i><span>Change Login Password</span>
                </button>
                <button class="tab-btn" onclick="switchTab(event, 'trn-pass')">
                    <i class="fa-solid fa-table-cells-large"></i> Change Transaction Password
                </button>
            </div>
        </div>


        <div class="content-card">

            <div id="profile" class="tab-content active">
                <h3 class="section-title">My Profile</h3>
                <?php $profileEditable = ($topupFlag == 0); ?>
                <?php if (!$profileEditable) { ?>
                    <div style="color:red; margin-bottom:15px; font-weight:600;">
                        Profile editing is disabled after account activation.
                    </div>
                <?php } ?>

                <form action="userProfileAuthProcess" method="POST" class="profile-form">
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" id="userName" name="name" placeholder="Name" required
                            value="<?= $userName ?>" <?= (!$profileEditable) ? 'readonly' : '' ?>>
                        <input type="hidden" name="memberId" value="<?= $memberId ?>">
                    </div>
                    <div class="form-group">
                        <label>Mobile *</label>
                        <input type="text" id="phoneNo" name="phone" placeholder="Mobile Number" value="<?= $phone ?>"
                            onkeypress="return onlynum(event)" <?= (!$profileEditable) ? 'readonly' : '' ?>>
                    </div>
                    <div class="form-group">
                        <label>Email ID *</label>
                        <input type="email" name="emailId" placeholder="Email ID" value="<?= $email_id ?>"
                            <?= (!$profileEditable) ? 'readonly' : '' ?>>
                    </div>
                    <div class="form-group">
                        <label>Country*</label>
                        <select class="form-control" required id="M_COUNTRY" name="countryId" <?= (!$profileEditable) ? 'disabled' : '' ?>>
                            <option value="">Select Country</option>
                            <?php $queryCountry = "SELECT * FROM meddolic_config_country_list WHERE status=1 ORDER BY countryName ASC";
                            $resultCountry = mysqli_query($con, $queryCountry);
                            while ($valCountry = mysqli_fetch_assoc($resultCountry)) { ?>
                                <option value="<?= $valCountry['country_id'] ?>" <?php if ($valCountry['country_id'] == $countryId)
                                      echo "selected"; ?>>
                                    <?= $valCountry['countryName'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="update-btn" name="profileUpdate" id="submit" <?= (!$profileEditable) ? 'disabled' : '' ?>>
                        Update Profile
                    </button>
                </form>

            </div>

            <div id="login-pass" class="tab-content">
                <h3 class="section-title">Change Login Password</h3>
                <form class="profile-form" action="userProfileAuthProcess" method="POST">
                    <div class="form-group">
                        <label>Current Login Password *</label>
                        <input type="password" name="password" id="currentPass" placeholder="Enter current password">
                        <input type="hidden" name="memberId" value="<?= $memberId ?>">
                    </div>
                    <div class="form-group">
                        <label>New Login Password *</label>
                        <input type="password" name="password1" id="loginPassword" placeholder="Enter new password">
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password *</label>
                        <input type="password" id="confirmLoginPassword" name="password2"
                            placeholder="Re-enter new password">
                    </div>
                    <button type="submit" name="changeLogin" id="loginJoin" class="update-btn">Update Password</button>
                </form>
            </div>

            <div id="trn-pass" class="tab-content">
                <h3 class="section-title">Change Transaction Password</h3>
                <p style="color: var(--text-light); font-size: 0.85rem; margin-bottom: 20px;">
                    This password is required for withdrawals and fund transfers.
                </p>
                <form class="profile-form" action="userProfileAuthProcess" method="POST">
                    <div class="form-group">
                        <label>Current Transaction Password *</label>
                        <input type="password" name="trnPassword" id="trnPassword" placeholder="Enter current PIN/Pass">
                        <input type="hidden" name="memberId" value="<?= $memberId ?>">
                    </div>
                    <div class="form-group">
                        <label>New Transaction Password *</label>
                        <input type="password" id="trnPassword1" name="trnPassword1"
                            placeholder="Set new transaction pass">
                    </div>
                    <div class="form-group">
                        <label>Confirm Transaction Password *</label>
                        <input type="password" name="trnPassword2" id="trnPassword2"
                            placeholder="Confirm new transaction pass">
                    </div>
                    <button type="submit" name="changeTrn" id="TrnJoin" class="update-btn">Update TRN Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once("Include/Footer.php"); ?>