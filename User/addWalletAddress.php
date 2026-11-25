<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2" />
                <path d="M16 3H8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z" />
                <circle cx="16" cy="14" r="1.5" />
            </svg>
        </div>
        <div class="page-header-text">
            <h1>Wallet Addresses</h1>
            <p>Manage your cryptocurrency withdrawal addresses</p>
        </div>
    </div>

    <!-- Add Wallet Card -->
    <div class="wallet-card">
        <div class="card-head">
            <div class="card-head-dot"></div>
            <h3>Add New Address</h3>
            <span class="badge">Secured</span>
        </div>

        <form class="wallet-form" action="userProfileAuthProcess" method="POST">
            <div class="form-grid">

                <!-- Currency -->
                <div class="field-group">
                    <label>Select Currency <span>*</span></label>
                    <div class="field-wrap select-wrap">
                        <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                        <select name="currencyId" id="currencyId" required>
                            <option value="">Select currency…</option>
                            <?php
                            $queryCoin = mysqli_query($con, "SELECT * FROM meddolic_config_currency_list WHERE status=1 ORDER BY currencyName ASC");
                            while ($valCoin = mysqli_fetch_assoc($queryCoin)) { ?>
                                <option value="<?= $valCoin['currency_id'] ?>">
                                    <?= htmlspecialchars($valCoin['currencyName'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Wallet Address -->
                <div class="field-group">
                    <label>Wallet Address <span>*</span></label>
                    <div class="field-wrap">
                        <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        <input type="text" name="walletAddress" id="walletAddress" placeholder="0x… or bc1q…">
                        <input type="hidden" name="memberId" value="<?= $memberId ?>">
                    </div>
                </div>

                <div class="field-group">
                    <label>Transaction Password <span>*</span></label>
                    <div class="field-wrap">
                        <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                        <input type="password" name="trnPassword" id="trnPassword"
                            placeholder="Enter transaction password">
                        <button type="button" class="eye-btn" onclick="togglePwd()">
                            <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- <div class="field-group">
                    <label>Email OTP</label>
                    <div class="field-wrap">
                        <div class="input-group">
                            <input type="text" name="emailOtp" class="form-control" id="emailOtp"
                                placeholder="Enter Email OTP" required />
                        </div>
                    </div>
                </div>
                <div class="field-group">
                    <label></label>
                    <div class="field-wrap">
                        <button type="button" class="btn btn-save col-md-2 col-sm-3" id="emailBtn"
                            onclick="addressVerifyOTP('<?= $userId ?>','<?= $emailId ?>')">Send OTP
                            <span id="count" style="visibility:hidden;">00 S</span>
                        </button>
                    </div>
                </div> -->




            </div>

            <div class="form-actions">
                <button type="submit" name="addWalletAddress" class="btn-save">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                        <polyline points="17 21 17 13 7 13 7 21" />
                        <polyline points="7 3 7 8 15 8" />
                    </svg>
                    Save Address
                </button>
            </div>
        </form>
    </div>

    <!-- Saved Addresses Card -->
    <div class="wallet-card">
        <div class="card-head">
            <div class="card-head-dot" style="background:var(--accent-2);box-shadow:0 0 8px var(--accent-2)"></div>
            <h3>Saved Addresses</h3>
        </div>

        <div class="table-scroll">
            <table class="wallet-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Currency</th>
                        <th>Wallet Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    $queryWallet = mysqli_query(
                        $con,
                        "SELECT a.payment_id, a.walletAddress, a.addDate, b.currencyName
             FROM meddolic_user_wallet_address_details a, meddolic_config_currency_list b
             WHERE a.member_id='$memberId'
               AND a.currency_id = b.currency_id
               AND a.status = 1
             ORDER BY a.addDate DESC"
                    );

                    if (mysqli_num_rows($queryWallet) === 0): ?>
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <rect x="2" y="7" width="20" height="14" rx="2" />
                                        <path d="M16 3H8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z" />
                                    </svg>
                                    <p>No wallet addresses added yet</p>
                                </div>
                            </td>
                        </tr>
                    <?php else:
                        while ($valWallet = mysqli_fetch_assoc($queryWallet)):
                            $count++;
                            $addr = htmlspecialchars($valWallet['walletAddress'], ENT_QUOTES, 'UTF-8');
                            $currency = htmlspecialchars($valWallet['currencyName'], ENT_QUOTES, 'UTF-8');
                            ?>
                            <tr>
                                <td><span class="sr-badge"><?= $count ?></span></td>
                                <td><span class="currency-pill"><?= $currency ?></span></td>
                                <td style="display: flex;
        justify-content: flex-start;
        align-items: center;">
                                    <span class="addr-mono" title="<?= $addr ?>"><?= $addr ?></span>
                                    <button class="copy-btn" onclick="copyAddr(this, '<?= $addr ?>')">Copy</button>
                                </td>
                            </tr>
                        <?php endwhile; endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    function togglePwd() {
        const inp = document.getElementById('trnPassword');
        const icon = document.getElementById('eyeIcon');
        if (inp.type === 'password') {
            inp.type = 'text';
            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
        } else {
            inp.type = 'password';
            icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        }
    }

    function copyAddr(btn, addr) {
        navigator.clipboard.writeText(addr).then(() => {
            btn.textContent = 'Copied!';
            btn.style.borderColor = 'var(--accent-2)';
            btn.style.color = 'var(--accent-2)';
            setTimeout(() => {
                btn.textContent = 'Copy';
                btn.style.borderColor = '';
                btn.style.color = '';
            }, 1800);
        });
    }
</script>

<?php require_once("Include/Footer.php"); ?>