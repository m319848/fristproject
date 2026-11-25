<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');

$queryConfig = mysqli_query($con, "SELECT minWithdraw,coinrate FROM meddolic_config_misc_setting");
$valConfig = mysqli_fetch_assoc($queryConfig);
$minimumPayout = $valConfig['minWithdraw'];
$coinrate = $valConfig['coinrate'];

/* ───────── ROI WALLET BALANCE ─────────
   Agar $roiWallet pehle se loginCheck.php / Head.php me set hai to ye query skip ho jayegi.
   NOTE: table aur column ka naam apne database ke hisaab se badlein
   (jahan se $incomeWallet aa raha hai wahi table dekhein).
*/


unset($_SESSION['withdrawTokenSet']);
$randToken = rand(1111, 9999) . time() . date('s');
$newToken = md5($randToken);
$_SESSION['withdrawTokenSet'] = $newToken;

$qHist = mysqli_query($con, "SELECT * FROM meddolic_user_wallet_withdrawal WHERE member_id='$memberId' ORDER BY date_time DESC");
$rows = [];
while ($r = mysqli_fetch_assoc($qHist))
    $rows[] = $r;
$last = $rows[0] ?? null;

$qWallet = mysqli_query($con, "SELECT a.payment_id,a.walletAddress,b.currencyName
  FROM meddolic_user_wallet_address_details a,meddolic_config_currency_list b
  WHERE a.member_id='$memberId' AND a.currency_id=b.currency_id AND a.status=1
  ORDER BY a.addDate DESC");
$wallets = [];
while ($w = mysqli_fetch_assoc($qWallet))
    $wallets[] = $w;


if ($last) {

    if ($last['released'] == 2) {
        $statusText = "REJECT";
    } elseif ($last['status'] == "FINISHED") {
        $statusText = "RELEASED";
    } else {
        $statusText = 'PENDING';
    }
}

?>
<link
    href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap"
    rel="stylesheet">

<style>
    .row {
        display: flex;
        justify-content: space-between;
        width: 100%;
        gap: 10px;
    }

    .row .bal-card {
        flex: 1;
    }

    @media (max-width: 768px) {
        .row {
            flex-direction: column;
        }
    }
</style>

<!-- AURORA ORBS -->


<div class="dashboard">

    <div class="au-body">

        <!-- HERO -->
        <div class="au-hero">
            <div class="au-hero-eyebrow">Secure Transfer</div>
            <h1>Withdraw Funds</h1>
            <div class="au-hero-sub">Transfer your earnings directly to your crypto wallet.</div>
        </div>

        <div class="au-grid">

            <!-- ═══ LEFT ═══ -->
            <div>
                <div class="row">

                    <!-- INCOME WALLET CARD -->
                    <div class="bal-card">
                        <div class="bal-top">
                            <div>
                                <div class="bal-label">Income Wallet Balance</div>
                                <div class="bal-value">$ <?= number_format($incomeWallet, 2) ?></div>
                                <div class="bal-min">Min. withdrawal:
                                    <span>$<?= number_format($minimumPayout, 2) ?></span>
                                </div>
                                <div class="bal-min">1 USD:
                                    <span><?= $coinrate ?> Coins</span>
                                </div>
                            </div>
                            <div style="display:flex;flex-direction:column;align-items:flex-end;gap:10px;">
                                <div class="bal-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff"
                                        stroke-width="2">
                                        <rect x="2" y="5" width="20" height="14" rx="2" />
                                        <line x1="2" y1="10" x2="22" y2="10" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ROI WALLET CARD -->
                    <div class="bal-card">
                        <div class="bal-top">
                            <div>
                                <div class="bal-label">ROI Wallet Balance</div>
                                <div class="bal-value">$ <?= number_format($roiWallet, 2) ?></div>
                                <div class="bal-min">Min. withdrawal:
                                    <span>$<?= number_format($minimumPayout, 2) ?></span>
                                </div>
                                <div class="bal-min">1 USD:
                                    <span><?= $coinrate ?> Coins</span>
                                </div>
                            </div>
                            <div style="display:flex;flex-direction:column;align-items:flex-end;gap:10px;">
                                <div class="bal-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff"
                                        stroke-width="2">
                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                                        <polyline points="17 6 23 6 23 12" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- FORM CARD -->
                <div class="g-card">
                    <div class="g-card-label">
                        <div class="dot"></div> Payment Details
                    </div>

                    <form action="walletWithdrawProcess" method="POST">
                        <input type="hidden" name="memberId" value="<?= $memberId ?>">
                        <input type="hidden" name="user_id" id="sponser_id" value="<?= $userId ?>">
                        <input type="hidden" name="goodFile" value="<?= $newToken ?>">
                        <input type="hidden" name="minimumWithdraw" value="<?= $minimumPayout ?>">

                        <!-- Amount -->
                        <div class="amount-box">
                            <div class="amount-top">Enter Amount</div>
                            <div class="amount-row">
                                <span class="amount-cur">$</span>
                                <input class="amount-in" type="number" name="withdrawAmount" id="amtIn"
                                    placeholder="0.00" step="0.01" min="<?= $minimumPayout ?>" required>
                            </div>
                            <div class="chips">
                                <?php foreach ([100, 500, 1000, 5000, 10000] as $q): ?>
                                    <button type="button" class="chip"
                                        onclick="setAmt(<?= $q ?>,this)">$<?= number_format($q) ?></button>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Destination Wallet (crypto address) -->
                        <div class="fg" style="margin-bottom:14px;">
                            <label>Destination Wallet <em>*</em></label>
                            <select class="au-select" name="paymentId" id="paymentId" required>
                                <option value="">— Select your wallet —</option>
                                <?php foreach ($wallets as $w): ?>
                                    <option value="<?= htmlspecialchars($w['payment_id']) ?>">
                                        <?= htmlspecialchars($w['currencyName']) ?>
                                        [<?= htmlspecialchars($w['walletAddress']) ?>]
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Source Wallet (ROI / Income) -->
                        <div class="fg" style="margin-bottom:14px;">
                            <label>Withdraw From <em>*</em></label>
                            <select class="au-select" name="walletType" id="walletType" required onchange="updateMax()">
                                <option value="">— Select wallet —</option>
                                <option value="1" data-balance="<?= (float) $roiWallet ?>">
                                    ROI Wallet ($<?= number_format($roiWallet, 2) ?>)</option>
                                <option value="2" data-balance="<?= (float) $incomeWallet ?>">
                                    Income Wallet ($<?= number_format($incomeWallet, 2) ?>)</option>
                            </select>
                        </div>

                        <!-- Password -->
                        <div class="fg" style="margin-bottom:18px;">
                            <label>Transaction Password <em>*</em></label>
                            <div class="pw-wrap">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                                <input type="password" name="trnPassword" id="pwIn"
                                    placeholder="Enter your transaction password" required>
                                <span class="pw-toggle" onclick="togglePw()">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- <div class="fg" style="margin-bottom:18px;">
                            <label>Email Verification *</label>
                            <div class="pw-wrap">
                                <input placeholder="Verification Code" name="WidralOtp" required type="text"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="fg" style="margin-bottom:18px;">
                            <button style="margin-top:3px;padding:6px 20px 10px 20px; white-space: nowrap ;"
                                type="button" class="btn au-submit col-md-2 col-sm-3" id="emailBtn"
                                onclick="walletWidrallOTP('<?= $userId ?>')">
                                Send OTP
                                <span id="count" style="visibility:hidden;">00 S</span>

                            </button>
                        </div> -->
                        <button class="au-submit" type="submit" name="walletWithdraw">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <path d="M12 2v20M17 7l-5-5-5 5" />
                            </svg>
                            Withdraw Now
                        </button>

                        <div class="secure-row">
                            <span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                </svg>256-bit SSL</span>
                            <span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>Instant Processing</span>
                            <span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polyline points="9 11 12 14 22 4" />
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                                </svg>2FA Active</span>
                        </div>

                    </form>
                </div>
            </div>

            <!-- ═══ RIGHT ═══ -->
            <div class="right-col">

                <!-- Account snapshot -->
                <div class="pill-card">
                    <div class="pill-card-title">
                        Account Info
                        <div class="pct-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff"
                                stroke-width="2.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg></div>
                    </div>
                    <div class="mini-stats" style="margin-bottom:14px;">
                        <div class="mini-stat">
                            <div class="ms-label">User ID</div>
                            <div class="ms-value purple" style="font-size:14px;word-break:break-all;"><?= $userId ?>
                            </div>
                        </div>
                        <div class="mini-stat">
                            <div class="ms-label">Status</div>
                            <div class="ms-value" style="color:#34d399;font-size:14px;">
                                <?= ($topupFlag == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="summary-row"><span class="sr-key">Name</span><span
                            class="sr-val"><?= $userName ?></span></div>
                    <div class="summary-row"><span class="sr-key">Income Balance</span><span
                            class="sr-val green">$<?= number_format($incomeWallet, 2) ?></span></div>
                    <div class="summary-row"><span class="sr-key">ROI Balance</span><span
                            class="sr-val green">$<?= number_format($roiWallet, 2) ?></span></div>
                    <div class="summary-row"><span class="sr-key">Min. Withdraw</span><span
                            class="sr-val amber">$<?= number_format($minimumPayout, 2) ?></span></div>
                </div>

                <!-- Last TX Summary -->
                <div class="pill-card">
                    <div class="pill-card-title">
                        Last Transaction
                        <div class="pct-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff"
                                stroke-width="2.5">
                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                                <polyline points="17 6 23 6 23 12" />
                            </svg></div>
                    </div>
                    <?php if ($last): ?>
                        <div class="summary-row"><span class="sr-key">Amount</span><span
                                class="sr-val green">$<?= number_format($last['amount'], 2) ?></span></div>
                        <div class="summary-row"><span class="sr-key">Charge</span><span
                                class="sr-val pink">−$<?= number_format($last['withdrawCharge'], 2) ?></span></div>
                        <div class="summary-row">
                            <span class="sr-key">Status</span>
                            <span class="sr-val"><?= $statusText ?></span>
                        </div>
                        <div class="summary-row"><span class="sr-key">Date</span><span class="sr-val"
                                style="font-size:12px;color:#6b93ff;"><?= date("d M Y", strtotime($last['date_time'])) ?></span>
                        </div>
                        <div class="net-pill">
                            <span class="np-label">Net Received</span>
                            <span class="np-val">$<?= number_format($last['netAmount'], 2) ?></span>
                        </div>
                    <?php else: ?>
                        <div style="text-align:center;padding:20px;color:#fff;font-size:13px;">No transactions yet
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    function setAmt(v, el) {
        document.getElementById('amtIn').value = v;
        document.querySelectorAll('.chip').forEach(c => c.classList.remove('on'));
        el.classList.add('on');
    }

    function togglePw() {
        const i = document.getElementById('pwIn');
        i.type = i.type === 'password' ? 'text' : 'password';
    }

    // Selected wallet ke balance ke hisaab se amount ka max set karo (sirf UX ke liye,
    // asli check walletWithdrawProcess.php me server-side hona chahiye)
    function updateMax() {
        const sel = document.getElementById('walletType');
        const opt = sel.options[sel.selectedIndex];
        const bal = opt ? parseFloat(opt.getAttribute('data-balance')) : NaN;
        const amt = document.getElementById('amtIn');
        if (!isNaN(bal)) {
            amt.max = bal;
        } else {
            amt.removeAttribute('max');
        }
    }
</script>

<?php require_once("Include/Footer.php"); ?>