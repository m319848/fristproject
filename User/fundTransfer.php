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
    FROM meddolic_user_fund_transfer_history 
    WHERE sender_member_id='$memberId'");

$totalData = mysqli_fetch_assoc($totalQuery);
$totalRecords = $totalData['total'];

$totalPages = ceil($totalRecords / $limit);
?>


<div class="dashboard">

    <div class="page-header-flex">
        <div>
            <h2>Fund Transfer</h2>
            <p style="color: var(--text-muted); margin: 0;">Manage and move your capital instantly</p>
        </div>
    </div>

    <div class="transfer-grid">

        <div class="modern-card">
            <div class="card-padding">
                <div class="card-title">
                    <i class="fa fa-paper-plane" style="color: var(--primary)"></i> Send Funds
                </div>

                <form action="fundTransferProcess" method="POST" id="transferForm">
                    <div class="wallet-stat">
                        <span>Current Balance</span>
                        <h3>$<?= number_format($fundWallet, 2) ?></h3>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label class="form-label">Your ID</label>
                            <input type="text" name="userid" value="<?= $userId ?>" readonly
                                class="input-style readonly-field">
                        </div>
                        <div>
                            <label class="form-label">Your Name</label>
                            <input type="text" value="<?= $userName ?>" readonly class="input-style readonly-field">
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label class="form-label">Amount to Transfer ($)</label>
                        <input type="number" step="0.01" name="amount" id="transferAmount" class="input-style"
                            placeholder="0.00" required>
                        <input type="hidden" name="loginMemberId" value="<?= $memberId ?>">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label class="form-label">Receiver UserID *</label>
                        <input type="text" name="sponser_id" id="sponser_id" class="input-style"
                            placeholder="Enter Receiver ID" onblur="sponser_valid(this.value)" required>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label class="form-label">Receiver Name</label>
                        <input type="text" id="sponser_name" class="input-style readonly-field" readonly>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label class="form-label">Transaction Password</label>
                        <input type="password" name="trnPassword" class="input-style" placeholder="••••••••" required>
                    </div>

                    <button type="submit" name="fundTransfer" class="submit-btn">
                        Execute Transfer
                    </button>
                </form>
            </div>
        </div>

        <div class="modern-card">
            <div class="card-padding">
                <div class="card-title">Recent Transactions</div>

                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Receiver</th>
                                <th>Amount</th>
                                <th>Charge</th>
                                <th>Net Amount</th>
                                <th>Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $queryTransfer = mysqli_query($con, "SELECT a.amount,a.charge,a.netAmount, a.date_time, 
    c.user_id AS receiverId, c.name AS receiverName 
    FROM meddolic_user_fund_transfer_history a 
    INNER JOIN meddolic_user_details c 
        ON a.receiver_member_id = c.member_id 
    WHERE a.sender_member_id='$memberId' 
    ORDER BY a.date_time DESC 
    LIMIT $limit OFFSET $offset");

                            while ($valTransfer = mysqli_fetch_assoc($queryTransfer)) { ?>
                                <tr>
                                    <td>
                                        <div class="user-pill">
                                            <span class="name"><?= htmlspecialchars($valTransfer['receiverName']) ?></span>
                                            <span class="uid">ID: <?= htmlspecialchars($valTransfer['receiverId']) ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-success">$<?= number_format($valTransfer['amount'], 2) ?></span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-danger">$<?= number_format($valTransfer['charge'], 2) ?></span>
                                    </td>
                                    <td>
                                        <span class="badge badge-danger">$
                                            <?= number_format($valTransfer['netAmount'], 2) ?>
                                        </span>
                                    </td>
                                    <td style="color: var(--text-muted); font-size: 0.8rem;">
                                        <i class="fa fa-clock-o"></i>
                                        <?= date("d M, Y H:i", strtotime($valTransfer['date_time'])) ?>
                                    </td>
                                </tr>
                            <?php } ?>
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

<?php require_once("Include/Footer.php"); ?>