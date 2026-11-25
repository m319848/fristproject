<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>
<style>
.pkg-select {
    width: 100%;
    height: 55px;
    border-radius: 14px;
    border: 1px solid #2a2a2a;
    background: #111827;
    color: #fff;
    padding: 0 16px;
    font-size: 15px;
    outline: none;
}

.pkg-select option {
    background: #111827;
    color: #fff;
}

.form-row {
    margin-bottom: 20px;
}

.pay-grid {
    margin-bottom: 20px;
}
</style>

<div class="dashboard">
    <!-- PAGE HEADER -->
    <div class="ph">
        <div class="ph-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="1.8" stroke-linecap="round"
                stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="3" />
                <path d="M1 10h22" />
                <path d="M6 15h4" />
            </svg>
        </div>
        <div>
            <div class="ph-title">Trade Purchase</div>
            <div class="ph-sub">Select &amp; Your Trade Package Securely</div>
        </div>
    </div>

    <div class="layout">
        <form action="authActiveUserProcess" method="POST" onsubmit="return validateForm()">
            <!-- ══════ LEFT PANEL ══════ -->
            <div class="card">

                <!-- USER INFORMATION -->
                <div class="sh">User Information</div>
                <div class="u-grid">
                    <div class="u-box">
                        <div>
                            <div class="u-lbl">User ID</div>
                            <div class="u-val" id="userIdText">
                                <input type="text" id="sponser_id" name="sponser_id" value="<?= $userId ?>" readonly
                                    class="u-val" style="border:none; background:transparent;">
                            </div>
                        </div>
                        <button class="copy-btn" title="Copy" onclick="copyId(this)">
                            <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="9" y="9" width="13" height="13" rx="2" />
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                            </svg>
                        </button>
                    </div>
                    <div class="u-box">
                        <div>
                            <div class="u-lbl">Name</div>
                            <div class="u-val">
                                <input type="text" id="sponser_name" value="<?= $userName ?>" class="u-val" readonly
                                    style="border:none; background:transparent;">
                            </div>
                        </div>
                        <div class="avatar">
                            <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- PAYMENT DETAILS -->
                <div class="sh"> Details</div>
                <div class="pay-grid">
                    <!-- FUND WALLET -->
                    <div class="fw">
                        <div class="awx">
                            <div class="fw-hd">
                                <div class="fw-ic">
                                    <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="1" y="4" width="22" height="16" rx="2" />
                                        <path d="M1 10h22" />
                                    </svg>
                                </div>
                                <span class="fw-title">Fund Wallet</span>
                            </div>
                            <div class="fw-lbl">Available Balance</div>
                            <div class="fw-bal">$ <?= $fundWallet ?></div>
                        </div>

                        <a href="fundRequestonline" class="dep-btn">Deposit</a>
                    </div>

                    <!-- AMOUNT -->
                    <div class="amt-box-wrap">
                        <div class="amt-hd">
                            <div class="rupee-ic">$</div>
                            Amount
                        </div>
                        <div class="amt-input-row">
                            <span class="rupee-sym">$</span>
                            <input class="amt-inp" type="number" id="amtInp" name="investAmount"
                                placeholder="Enter Amount" required>
                        </div>
                    </div>
                </div>


                <!-- PURCHASE BUTTON -->
                <button type="submit" name="upgradeNow" class="purchase-btn">
                    Purchase Now <span class="arrow-ic">→</span>
                </button>

                <!-- FOOTER TAGS -->
                <div class="ft-row">
                    <div class="ft-tag">
                        <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        Secure &amp; Encrypted
                    </div>
                    <div class="ft-sep"></div>
                    <div class="ft-tag">
                        <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        Instant Processing
                    </div>
                </div>
            </div>
        </form>

        <!-- ══════ RIGHT: ORDER SUMMARY ══════ -->
        <div class="card">
            <div class="os-hd">
                <h3>Recent History</h3>
                <button class="dots-btn">&#8943;</button>
            </div>

            <?php
            $history = mysqli_query($con, "SELECT * FROM meddolic_user_activation_details WHERE member_id='$memberId' ORDER BY id DESC LIMIT 1");
            $data = mysqli_fetch_assoc($history);
            ?>

            <div class="os-row">
                <div class="os-key">
                    <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="4" width="20" height="16" rx="2" />
                        <path d="M8 4v16" />
                    </svg>
                    <?= $userId ?>
                </div>
                <div class="os-val">
                    <?= $userId ?? 'N/A' ?>
                </div>
            </div>

            <!-- <div class="os-row">
                <div class="os-key">
                    <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="18" rx="2" />
                        <path d="M2 9h20M8 3v6" />
                    </svg>
                    Trade Type
                </div>
                <div class="os-val">
                    <?= ($data['purchaseType'] == 1) ? 'Copy Trade' : (($data['purchaseType'] == 2) ? 'Self Trade' : 'N/A'); ?>
                </div>
            </div> -->

            <div class="os-row">
                <div class="os-key">
                    <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 8v4l3 3" />
                    </svg>
                    Amount
                </div>
                <div class="os-val" id="sumAmt">
                    $<?= isset($data['investPrice']) ? number_format($data['investPrice'], 2) : '0.00' ?>
                </div>
            </div>
            <div class="os-row">
                <div class="os-key">
                    <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 8v4l3 3" />
                    </svg>
                    Date
                </div>
                <div class="os-val" id="sumAmt">
                    $
                    <?= isset($data['date_time']) ? date($data['date_time'], 2) : 'N/A' ?>
                </div>
            </div>

            <div class="total-block">
                <span class="total-lbl">Total Payable</span>
                <span class="total-amt" id="totalAmt">
                    $<?= isset($data['investPrice']) ? number_format($data['investPrice'], 2) : '0.00' ?>
                </span>
            </div>

            <!-- BENEFITS (unchanged) -->
            <div class="ben-wrap">
                <div class="ben-hd">
                    <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="18" rx="2" />
                        <path d="M8 3v4M16 3v4M2 11h20" />
                    </svg>
                    Benefits
                </div>

                <div class="ben-item">
                    <span class="check-ic"><svg viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12" />
                        </svg></span>
                    Instant Trade
                </div>

                <div class="ben-item">
                    <span class="check-ic"><svg viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12" />
                        </svg></span>
                    24/7 Support
                </div>

                <div class="ben-item">
                    <span class="check-ic"><svg viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12" />
                        </svg></span>
                    Secure Transaction
                </div>

                <div class="ben-item">
                    <span class="check-ic"><svg viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12" />
                        </svg></span>
                    High Returns
                </div>
            </div>
        </div>

    </div>
</div>
<script>
document.getElementById('sponser_id').addEventListener('input', function() {
    let userId = this.value.trim();

    if (userId !== '') {
        fetch('getUserName.php?userId=' + encodeURIComponent(userId))
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('sponser_name').value = data.name;
                } else {
                    document.getElementById('sponser_name').value = 'User not found';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        document.getElementById('sponser_name').value = '';
    }
});
</script>

<script>
let selectedMin = 0;
let selectedMax = 0;

function setPackageRange() {

    let select = document.getElementById('packageSelect');
    let option = select.options[select.selectedIndex];

    selectedMin = parseFloat(option.getAttribute('data-min')) || 0;
    selectedMax = parseFloat(option.getAttribute('data-max')) || 0;

    let amtInp = document.getElementById('amtInp');

    amtInp.min = selectedMin;

    if (selectedMax > 0) {
        amtInp.max = selectedMax;
        amtInp.placeholder = `Enter Amount Between $${selectedMin} - $${selectedMax}`;
    } else {
        amtInp.removeAttribute('max');
        amtInp.placeholder = `Enter Amount Above $${selectedMin}`;
    }

    amtInp.value = selectedMin;
}

function validateForm() {

    let amt = parseFloat(document.getElementById('amtInp').value);

    if (!amt || amt <= 0) {
        alert("Please Enter Amount");
        return false;
    }

    if (amt < selectedMin) {
        alert("Minimum amount should be $" + selectedMin);
        return false;
    }

    if (selectedMax > 0 && amt > selectedMax) {
        alert("Maximum amount should be $" + selectedMax);
        return false;
    }

    return confirm("Confirm Purchase?");
}
</script>



<script>
function fmt(v) {
    const n = parseFloat(v) || 0;
    return '$' + n.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

var pwVisible = false;

function togglePw() {
    pwVisible = !pwVisible;
    document.getElementById('pwInp').type = pwVisible ? 'text' : 'password';
    var ic = document.getElementById('eyeIc');
    ic.innerHTML = pwVisible ?
        '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>' :
        '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
}

function copyId(btn) {
    var userId = document.getElementById('userIdText').innerText.trim();

    navigator.clipboard.writeText(userId).then(function() {

        // success icon
        btn.querySelector('svg').innerHTML =
            '<polyline points="20 6 9 17 4 12" stroke="#10b981" stroke-width="2.5"/>';

        setTimeout(function() {
            btn.querySelector('svg').innerHTML =
                '<rect x="9" y="9" width="13" height="13" rx="2"/>' +
                '<path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>';
        }, 1500);

    }).catch(function() {
        alert("Copy failed!");
    });
}

function validateForm() {

    var amt = document.getElementById('amtInp').value;
    var pw = document.getElementById('pwInp').value;

    if (!amt || amt <= 0) {
        alert("Please Select Package");
        return false;
    }

    if (!pw) {
        alert("Enter transaction password");
        return false;
    }

    return confirm("Confirm Purchase?");
}

function selectTrade(val, el) {
    // set value in hidden input
    document.getElementById('tradeInVal').value = val;

    // remove active class from all
    document.querySelectorAll('.drop-hd').forEach(e => e.classList.remove('active'));

    // highlight selected
    el.classList.add('active');
}

function doConfirm() {
    var a = document.getElementById('amtInp').value;
    if (!a || parseFloat(a) <= 0) {
        alert('Please enter an amount first.');
        return
    }
    if (confirm('Confirm payment of ' + fmt(a) + '?')) alert('✅ Payment Confirmed!');
}

window.onload = function() {
    var defaultAmt = document.getElementById('amtInp').value;
    syncAmt(defaultAmt);
}
</script>

<?php require_once("Include/Footer.php"); ?>