<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
    <div class="activation-container">
        <div class="page-breadcrumb">
            <p>Dashboard / <span>Support</span></p>
        </div>

        <button class="btn-full-width" onclick="toggleModal(true)">
            + Create New Ticket
        </button>

        <div class="report-card mt-30">
            <div class="card-header">
                <h3>All Outbox Tickets</h3>
            </div>
            <div class="table-responsive">
                <table id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ticket No</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Priority</th>
                            <th>Raise Date</th>
                            <th>Last Update</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;

                        $queryRequest = mysqli_query($con, "
SELECT 
a.ticketCode,
a.ticketMessage,
a.raiseDate,
a.actionDate,
a.ticketStatus,
b.user_id,
b.name,
c.subjectName,
d.priorityName 
FROM meddolic_user_support_ticket a
JOIN meddolic_user_details b ON a.memberId = b.member_id
JOIN meddolic_config_support_subject c ON a.subjectId = c.subjectId
JOIN meddolic_config_support_priority d ON a.priorityId = d.priorityId
WHERE a.memberId = '$memberId'
ORDER BY a.raiseDate DESC
");

                        while ($valRequest = mysqli_fetch_assoc($queryRequest)) {
                            $count++;

                            $statusBadge = match ($valRequest['ticketStatus']) {
                                '1' => "<span class='badge badge-primary'>OPEN</span>",
                                '2' => "<span class='badge badge-warning'>PROCESSING</span>",
                                '3' => "<span class='badge badge-success'>RESOLVED</span>",
                                default => "<span class='badge badge-secondary'>UNKNOWN</span>",
                            };
                            ?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><?= $valRequest['ticketCode'] ?></td>
                                <td><?= $valRequest['subjectName'] ?></td>
                                <td><?= $valRequest['ticketMessage'] ?></td>
                                <td><?= $valRequest['priorityName'] ?></td>

                                <td>
                                    <i class="fa fa-clock-o"></i>
                                    <?= date("d-m-Y H:i:s", strtotime($valRequest['raiseDate'])) ?>
                                </td>

                                <td>
                                    <?php if (!empty($valRequest['actionDate'])) { ?>
                                        <i class="fa fa-clock-o"></i>
                                        <?= date("d-m-Y H:i:s", strtotime($valRequest['actionDate'])) ?>
                                    <?php } ?>
                                </td>

                                <td><?= $statusBadge ?></td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="report-card mt-30">
            <div class="card-header">
                <h3>All Inbox Tickets</h3>
            </div>
            <div class="table-responsive">
                <table id="">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $queryResponse = mysqli_query($con, "SELECT a.adminMessage,a.actionDate,a.ticketStatus,b.user_id,b.name,c.subjectName FROM meddolic_user_support_ticket a, meddolic_user_details b, meddolic_config_support_subject c WHERE a.memberId='$memberId' AND a.memberId=b.member_id AND a.subjectId=c.subjectId AND a.adminMessage<>'' ORDER BY a.actionDate DESC");
                        while ($valResponse = mysqli_fetch_assoc($queryResponse)) {
                            $count++; ?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><?= $valResponse['subjectName'] ?></td>
                                <td><?= $valResponse['adminMessage'] ?></td>
                                <td><i class="fa fa-clock-o"></i>
                                    <?= date("d-m-Y H:i:s", strtotime($valResponse['actionDate'])) ?></td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="ticketModal">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Create a new ticket</h4>
                <span class="close-btn" onclick="toggleModal(false)">&times;</span>
            </div>
            <form class="purchase-form" action="SupportProcess" enctype="multipart/form-data" method="POST">
                <div class="form-group">
                    <label>Subject</label>
                    <select class="form-control" required id="subjectId" name="subjectId">
                        <option value=""> Select One </option>
                        <?php $querySubject = mysqli_query($con, "SELECT subjectId,subjectName FROM meddolic_config_support_subject WHERE subjectStatus=1");
                        while ($valSubject = mysqli_fetch_assoc($querySubject)) { ?>
                            <option value="<?= $valSubject['subjectId'] ?>">
                                <?= $valSubject['subjectName'] ?>
                            </option>
                        <?php } ?>
                    </select>
                    <input type="hidden" name="memberId" value="<?= $memberId ?>">
                </div>
                <div class="form-group">
                    <label>Priority</label>
                    <div class="col-md-12">
                        <select class="form-control" required id="priorityId" name="priorityId">
                            <option value=""> Select One </option>
                            <?php $queryPriority = mysqli_query($con, "SELECT priorityId,priorityName FROM meddolic_config_support_priority WHERE priorityStatus=1");
                            while ($valPriority = mysqli_fetch_assoc($queryPriority)) { ?>
                                <option value="<?= $valPriority['priorityId'] ?>">
                                    <?= $valPriority['priorityName'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea rows="4" placeholder="Enter Message" id="ticketMessage" name="ticketMessage"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-submit" name="supportTicket"><i
                            class="fa-solid fa-info-circle"></i> Submit</button>
                    <button type="button" class="btn-cancel" onclick="toggleModal(false)">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal(show) {
        const modal = document.getElementById('ticketModal');
        modal.style.display = show ? 'flex' : 'none';
    }

    // Close modal if user clicks outside of the box
    window.onclick = function (event) {
        const modal = document.getElementById('ticketModal');
        if (event.target == modal) {
            toggleModal(false);
        }
    }
</script>


<?php require_once("Include/Footer.php"); ?>