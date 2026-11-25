<?php
$queryAccess = mysqli_query($con, "SELECT member_id,name,user_id from meddolic_user_details WHERE user_id='$_SESSION[admin_user_id]'");
if ($valAccess = mysqli_fetch_array($queryAccess)) {
    $name = $valAccess['name'];
    $user_id = $valAccess['user_id'];
    $member_id = $valAccess['member_id'];
    $mainId = $valAccess['user_id'];
} 
$openSupportQuery = mysqli_query($con, "SELECT COUNT(*) as totalOpen  FROM meddolic_user_support_ticket  WHERE ticketStatus='1'");
$openSupportData = mysqli_fetch_assoc($openSupportQuery);
$openSupportCount = $openSupportData['totalOpen'];

?>
<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">
        <div class="user-account">
            <img src="../admin-assets/images/logo.png" class="rounded-circle user-photo" alt="Fund X ">
            <div class="dropdown">
                <span>Hi, <?= $user_id ?></span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name"
                    data-toggle="dropdown"><strong><?= $name ?></strong></a>
                <ul class="dropdown-menu dropdown-menu-right account">
                    <li><a href="changePassword"><i class="icon-envelope-open"></i>Change Password</a></li>
                    <li class="divider"></li>
                    <li><a href="logoutCode"><i class="icon-power"></i>Logout</a></li>
                </ul>
            </div>
            <hr>
        </div>
        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane active" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">
                        <li id="dashboard">
                            <a href="dashboard"><i class="icon-home"></i> <span>Dashboard</span></a>
                        </li>
                        <li id="Members">
                            <a href="#Members" class="has-arrow"><i class="icon-user-follow"></i> <span>User
                                    Management</span></a>
                            <ul>
                                <li id="viewMember"><a href="viewMember">View Member</a></li>
                                <li id="searchMember"><a href="searchMember">Search Member</a></li>

                                <li id="activationHistory"><a href="activationHistory">User Invest History</a></li>
                            </ul>
                        </li>

                        <li id="fund">
                            <a href="#fund" class="has-arrow"><i class="icon-user-follow"></i> <span>Fund
                                    Management</span></a>
                            <ul>
                                <li id="paymentDetailsUpdate"><a href="paymentDetailsUpdate">Payment Details Update</a>
                                </li>
                                <li id="fundRequest"><a href="fundRequest">Fund Request</a></li>
                                <li id="fundTransfer"><a href="fundTransfer"><span>Fund Transfer</span></a></li>
                                <li id="fundDeduct"><a href="fundDeduct"><span>Fund Deduct</span></a></li>
                                <li id="fundDeductHistory"><a href="fundDeductHistory"><span>Fund Deduct History</span></a></li>
                                <!-- <li id="activationHistory"><a href="activationHistory">User Invest History</a></li>
                                <li id="fundTransfer"><a href="fundTransfer"><span>Fund Transfer</span></a></li> -->
                            </ul>
                        </li>
                        
                        <li id="income">
                            <a href="#income" class="has-arrow"><i class="icon-folder"></i> <span>Income Report</span></a>
                            <ul>
                                <li id="incomeReport"><a href="incomeReport">Income Report</a></li>
                                <!-- <li id="principalWithdrawRequest"><a href="principalWithdrawRequest">Principal
                                        Withdraw</a></li> -->

                            </ul>
                        </li>
                        

                        <li id="Withdraw">
                            <a href="#Withdraw" class="has-arrow"><i class="icon-folder"></i> <span>Withdraw</span></a>
                            <ul>
                                <li id="walletWithdrawStatus"><a href="walletWithdrawStatus">Approve Withdraw</a></li>
                                <!-- <li id="principalWithdrawRequest"><a href="principalWithdrawRequest">Principal
                                        Withdraw</a></li> -->

                            </ul>
                        </li>
                        <!--<li id="Support">-->
                        <!--    <a href="#Support" class="has-arrow"><i class="icon-bubbles"></i> <span>Support</span></a>-->
                        <!--    <ul>-->
                        <!--        <li id="newSupportTicket"><a href="newSupportTicket"> New Tickets</a></li>-->
                        <!--        <li id="supportTicket"><a href="supportTicket"> Support Tickets</a></li>-->
                        <!--    </ul>-->
                        <!--</li>-->
                        
                        <li id="Support">
                     <a href="#supportArea" class="has-arrow" data-toggle="collapse"
                        aria-expanded="false">

                        <i class="fa fa-envelope"></i>

                        <span>
                           Support

                           <?php if ($openSupportCount > 0) { ?>
                              <span class="badge badge-danger" style="
                  margin-right:90px;
                  font-size:10px;
                  padding:3px 6px;
                  border-radius:10px;
               ">
                                 <?= $openSupportCount ?>
                              </span>
                           <?php } ?>

                        </span>

                        <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                     </a>

                     <ul id="supportArea" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">

                        <li id="newSupportTicket">
                           <a href="newSupportTicket">

                              New Tickets

                              <?php if ($openSupportCount > 0) { ?>
                                 <span class="badge badge-danger ml-2" style="
                  font-size:10px;
                  padding:3px 6px;
                  border-radius:10px;
               ">
                                    <?= $openSupportCount ?>
                                 </span>
                              <?php } ?>

                           </a>
                        </li>

                        <li id="supportTicket">
                           <a href="supportTicket">
                              Support Tickets
                           </a>
                        </li>

                     </ul>
                  </li>
                        <li id="Team">
                            <a href="#Team" class="has-arrow"><i class="icon-users"></i> <span>Team & Report</span></a>
                            <ul>
                                <li id="myDirect"><a href="myDirect">My Direct</a></li>
                                <!--<li id="myDownline"><a href="myDownline">My Downline</a></li>-->
                            </ul>
                        </li>
                        <li id="Wallet">
                            <a href="#Wallet" class="has-arrow"><i class="icon-puzzle"></i> <span>Wallet</span></a>
                            <ul>
                                <!-- <li id="walletStatement"><a href="walletStatement">Wallet Statement</a></li> -->
                                <li id="walletOutstanding"><a href="walletOutstanding">Wallet Outstanding</a></li>
                            </ul>
                        </li>
                        <li id="Setting">
                            <a href="#Setting" class="has-arrow"><i class="icon-diamond"></i> <span>Setting</span></a>
                            <ul>
                                <li id="noticeSetting"><a href="noticeSetting">Notice Setting</a></li>
                                <li id="popUpSetting"><a href="popUpSetting">Pop-Up Setting</a></li>
                                <!--<li id="roiSetting"><a href="roiSetting">Coin Rate</a></li>-->
                            </ul>
                        </li>
                        <li>
                            <a href="logoutCode"><i class="icon-power"></i> <span>Sign Out</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>