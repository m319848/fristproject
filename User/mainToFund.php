<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');



$limit = 10;

// current page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1)
    $page = 1;

$offset = ($page - 1) * $limit;

// total records
$totalQuery = mysqli_query($con, "SELECT COUNT(*) as total 
    FROM meddolic_user_income_wallet_transfer 
    WHERE memberId='$memberId'");

$totalData = mysqli_fetch_assoc($totalQuery);
$totalRecords = $totalData['total'];

$totalPages = ceil($totalRecords / $limit);
?>
<style>
    select.fi {
        height: 40px;
        border-radius: 12px;
        width: 100%;
    }

    option {
        color: #1a01ac !important;
    }

    .badge {
        padding: 7px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-primary {
        background: #dbeafe;
        color: #1d4ed8;
    }
</style>
<div class="dashboard">

    <div class="itf-head">
        <div class="itf-head-left">
            <h1 class="itf-h1">Wallet <em>Transfer</em></h1>
            <div class="itf-crumb">Fund Manager <span>/</span>Wallet Transfer</div>
        </div>
        <div class="live-chip"><span class="live-dot"></span> Live Transfer</div>
    </div>

    <div class="itf-grid">

        <div>

            <div class="f-card">
                <div class="f-head">
                    <div class="f-head-icon"><i class="fa fa-exchange"></i></div>
                    <div class="f-head-text">
                        <h3>Transfer Funds</h3>
                        <p>Income wallet → Fund wallet</p>
                    </div>
                </div>
                <div class="f-body">
                    <form action="mainToFundProcess" method="POST">
                        <div class="f-row">
                            <div class="fg">
                                <label>User ID</label>
                                <input type="text" name="sponser_id"
                                    value="<?= htmlspecialchars($userId, ENT_QUOTES, 'UTF-8') ?>" readonly
                                    class="fi ro">
                                <input type="hidden" name="loginMemberId" value="<?= $memberId ?>">
                            </div>
                            <div class="fg">
                                <label>Full Name</label>
                                <input type="text" value="<?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?>"
                                    readonly class="fi ro">
                            </div>
                        </div>

                        <div class="f-divider">
                            <span class="f-divider-icon"><i class="fa fa-arrow-down"></i></span>
                            Transfer
                        </div>

                        <div class="fg">
                            <label>Select Transfer Wallet <span class="req">*</span></label>

                            <select name="transferType" required class="fi">
                                <option value="">Choose Wallet</option>

                                <option value="income_to_fund">
                                    Income Wallet → Fund Wallet
                                </option>

                                <!-- <option value="trade_to_income">
                                    Trade Wallet → Fund Wallet
                                </option> -->
                            </select>
                        </div>

                        <div class="fg">
                            <label>Amount <span class="req">*</span></label>
                            <div class="fi-wrap">
                                <span class="fi-prefix">$</span>
                                <input type="number" name="amount" placeholder="0.00" required class="fi">
                            </div>
                        </div>

                        <div class="fg">
                            <label>Transaction Password <span class="req">*</span></label>
                            <div class="fi-wrap">
                                <input type="password" name="trnPassword" placeholder="Enter transaction password"
                                    required class="fi">
                                <i class="fa fa-lock fi-suffix"></i>
                            </div>
                        </div>

                        <button type="submit" name="fundTransfer" class="f-btn">Confirm Transfer &nbsp;→</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="right-panel">
            <div class="u-card">
                <div class="u-avatar"><?= strtoupper(substr($userName, 0, 2)) ?></div>
                <div class="u-name"><?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?></div>
                <div class="u-uid">#<?= htmlspecialchars($userId, ENT_QUOTES, 'UTF-8') ?></div>
                <div class="u-stats">
                    <div class="u-stat">
                        <div class="u-stat-label">Income</div>
                        <div class="u-stat-val">$<?= number_format($incomeWallet, 2) ?></div>
                    </div>
                    <div class="u-stat">
                        <div class="u-stat-label">Fund</div>
                        <div class="u-stat-val">$<?= number_format($fundWallet, 2) ?></div>
                    </div>
                    <div class="u-stat">
                        <div class="u-stat-label">Trade</div>
                        <div class="u-stat-val">$
                            <?= number_format($tradeWallet, 2) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div class="info-card-head">Transfer Notes</div>
                <div class="info-item">Transfers are instant and irreversible once confirmed.</div>
                <div class="info-item">Ensure your transaction password is correct before submitting.</div>
                <div class="info-item">You cannot transfer more than your income wallet balance.</div>
                <div class="info-item">Contact support if transfer doesn't reflect within 5 minutes.</div>
            </div>
        </div>

        <div class="itf-history">
            <div class="h-card">
                <div class="h-head">
                    <div class="h-head-left">
                        <h3>Transfer History</h3>
                        <?php
                        $ct = mysqli_num_rows(mysqli_query($con, "SELECT 1 FROM meddolic_user_income_wallet_transfer WHERE memberId='$memberId'"));
                        ?>
                        <span class="h-badge"><?= $ct ?> records</span>
                    </div>
                    <div class="h-search-wrap">
                        <i class="fa fa-search"></i>
                        <input type="text" class="h-search" placeholder="Search…" id="hSearch">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="itf-tbl" id="hTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Transfer Type</th>
                                <th>Amount</th>
                                <th>Date &amp; Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cnt = 0;
                            $q = mysqli_query($con, " SELECT a.transferAmount,a.transferDate,a.remark,b.user_id,b.name
                FROM meddolic_user_income_wallet_transfer a,
                     meddolic_user_details b
                WHERE a.memberId='$memberId' AND a.memberId=b.member_id
                ORDER BY a.transferDate DESC LIMIT $limit OFFSET $offset
              ");
                            if (mysqli_num_rows($q) === 0):
                                ?>
                                <tr>
                                    <td colspan="4">
                                        <div class="empty"><i class="fa fa-history"></i>No transfer history yet</div>
                                    </td>
                                </tr>
                            <?php else:
                                while ($v = mysqli_fetch_assoc($q)):
                                    $cnt++;
                                    $ini = strtoupper(substr($v['name'], 0, 2)); ?>
                                    <tr>
                                        <td><span class="td-n"><?= $cnt ?></span></td>
                                        <td>

                                            <div class="td-user">
                                                <div class="td-av"><?= $ini ?></div>
                                                <div>
                                                    <div class="td-uname">
                                                        <?= htmlspecialchars($v['name'], ENT_QUOTES, 'UTF-8') ?>
                                                    </div>
                                                    <div class="td-uid">
                                                        <?= htmlspecialchars($v['user_id'], ENT_QUOTES, 'UTF-8') ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($v['remark'] == 'Income To Fund') { ?>
                                                <span class="badge badge-success">
                                                    Income → Fund
                                                </span>
                                            <?php } else { ?>
                                                <span class="badge badge-primary">
                                                    Trade → Fund
                                                </span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <span class="amt-pill"><i
                                                    class="fa fa-minus"></i>$<?= number_format($v['transferAmount'], 2) ?></span>
                                        </td>
                                        <td>
                                            <div class="td-date">
                                                <i class="fa fa-clock-o"></i>
                                                <?= htmlspecialchars(date("d M Y, H:i", strtotime($v['transferDate'])), ENT_QUOTES, 'UTF-8') ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; endif; ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?= $page - 1 ?>">« Prev</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>">Next »</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.getElementById('hSearch').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#hTable tbody tr').forEach(r => {
            r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>

<?php require_once("Include/Footer.php"); ?>