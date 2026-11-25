<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<div class="dashboard">
    <div class="income-report-container">
        <div class="page-breadcrumb">
            <p>Team Network / <span>Level Team Details</span></p>
        </div>

        <div class="report-card">
            <div class="table-responsive">
                <table class="income-table" id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User Id</th>
                            <th>Name</th>
                            <th>Date of Joining</th>
                            <th>Account Status</th>
                            <th>Date of Activation </th>
                            <th>Total Trade Investment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        function totaltradeInvest($con, $memberId)
                        {
                            $queryInvest = mysqli_query($con, "SELECT SUM(investPrice) FROM meddolic_user_activation_details WHERE member_id='$memberId' AND purchaseType=1");

                            $valInvest = mysqli_fetch_array($queryInvest);
                            if ($valInvest[0] != "") {
                                return $valInvest[0];
                            } else {
                                echo "0.00";
                            }
                        }
                        $count = 0;
                        $queryTeam = mysqli_query($con, "SELECT a.member_id,a.user_id,a.name,a.date_time,a.activationDate,a.topupFlag FROM meddolic_user_details a, meddolic_user_child_ids b WHERE a.member_id=b.child_id AND b.member_id='$memberId' AND b.level='$_GET[LevelId]'  ORDER BY b.date_time DESC");
                        while ($valTeam = mysqli_fetch_assoc($queryTeam)) {
                            $count++; ?>
                            <tr>
                                <td><?= $count ?></td>

                                <td><?= htmlspecialchars($valTeam['user_id'], ENT_QUOTES, 'UTF-8'); ?></td>

                                <td><?= htmlspecialchars($valTeam['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <i class="fa fa-clock-o"></i>
                                    <?= htmlspecialchars(date("d-m-Y", strtotime($valTeam['date_time'])), ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td>
                                    <?php
                                    if ($valTeam['topupFlag'] == 1)
                                        echo "<span class='badge badge-success'>Active</span>";
                                    else
                                        echo "<span class='badge badge-danger'>In-Active</span>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($valTeam['activationDate'] !== null) {
                                        echo htmlspecialchars(date('Y-m-d', strtotime($valTeam['activationDate'])), ENT_QUOTES, 'UTF-8');
                                    } else {
                                        echo '';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        $
                                        <?= htmlspecialchars(totaltradeInvest($con, $valTeam['member_id']), ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
              
            </div>
        </div>
    </div>
    </div>



    <?php require_once("Include/Footer.php"); ?>