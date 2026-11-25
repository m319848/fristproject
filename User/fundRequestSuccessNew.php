<!DOCTYPE html>
<html lang="en">
<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
?>
<link href="assets\css\customAcctRecord.css" rel="stylesheet">

<?php
$queryAccess = mysqli_query($con, "SELECT member_id FROM meddolic_user_details WHERE user_id='$_SESSION[member_user_id]'");
if ($valAccess = mysqli_fetch_array($queryAccess)) {
    $memberId = $valAccess['member_id'];
}
$orderId = $_GET['orderId'];
$queryTrn = mysqli_query($con, "SELECT priceAmount,addDate,priceCurrency,payAmount,payCurrency,amountReceived,paymentId,paymentStatus,payAddress,createdTime,updateTime,purchaseId FROM meddolic_user_invest_purchase_details WHERE memberId='$memberId' AND orderId='$orderId'");
$valTrn = mysqli_fetch_assoc($queryTrn);
$priceAmount = $valTrn['priceAmount'];
$priceCurrency = $valTrn['priceCurrency'];
$payAmount = $valTrn['payAmount'];
$payCurrency = $valTrn['payCurrency'];
$amountReceived = $valTrn['amountReceived'];
$paymentId = $valTrn['paymentId'];
$paymentStatus = $valTrn['paymentStatus'];
$payAddress = $valTrn['payAddress'];
$createdTime = $valTrn['createdTime'];
$updateTime = $valTrn['updateTime'];
$purchaseId = $valTrn['purchaseId'];
$addDate = $valTrn['addDate'];
?>
<style>
body {
    background: #0b1120;
    font-family: 'Poppins', sans-serif;
}

.dashboard-body-part {
    min-height: 100vh;
    padding: 40px 15px;
}

.content-wrapper {
    max-width: 850px;
    margin: auto;
}

.content-header h5 {
    text-align: center;
    color: #fff;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 30px;
}

.box {
    background: #111827;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid #1f2937;
    box-shadow: 0 20px 50px rgba(0, 0, 0, .4);
}

.box-header {
    background: linear-gradient(90deg, #f59e0b, #f97316);
    padding: 20px;
    text-align: center;
}

.badge-success {
    background: none !important;
    color: #fff !important;
    font-size: 18px;
    font-weight: 700;
}

.box-body {
    padding: 35px;
}

.payment-card {
    background: #1e293b;
    border-radius: 16px;
    padding: 25px;
    text-align: center;
    margin-bottom: 25px;
}

.control-label {
    color: #cbd5e1;
    font-size: 15px;
}

.amount-box {
    margin-top: 15px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    font-size: 30px;
    font-weight: 700;
    padding: 18px;
    border-radius: 15px;
}

#payAddress {
    background: #0f172a;
    border: 2px solid #334155;
    color: #fff;
    height: 55px;
    border-radius: 12px;
    font-weight: 600;
}

#payAddress:focus {
    border-color: #f59e0b;
    box-shadow: none;
}

.btn-success {
    height: 55px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #f59e0b, #ea580c) !important;
    font-weight: 600;
}

.btn-success:hover {
    transform: scale(1.03);
}

#qrImage {
    width: 280px;
    height: 280px;
    background: #fff;
    padding: 15px;
    border-radius: 20px;
}

.qr-wrapper {
    text-align: center;
    background: #1e293b;
    border-radius: 20px;
    padding: 25px;
    margin-top: 20px;
}

#countdown {
    display: inline-block;
    margin-top: 15px;
    background: #dc2626;
    color: #fff !important;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
}

.instruction-box {
    margin-top: 30px;
    background: #1e293b;
    border-radius: 15px;
    padding: 20px;
}

.instruction-box p {
    color: #e2e8f0;
    margin-bottom: 12px;
}

.instruction-box a {
    color: #f59e0b;
    font-weight: 600;
}

.status-card {
    background: #0f172a;
    border: 1px solid #334155;
    border-radius: 12px;
    padding: 12px;
    text-align: center;
    margin-bottom: 20px;
}

.badge-primary {
    background: #2563eb;
    color: #fff;
    padding: 8px 15px;
    border-radius: 30px;
}

@media(max-width:768px) {

    .box-body {
        padding: 20px;
    }

    #qrImage {
        width: 220px;
        height: 220px;
    }

    .amount-box {
        font-size: 24px;
    }

}

.popup-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .65);
    backdrop-filter: blur(5px);
    z-index: 99999;
    animation: fadeIn .3s ease;
}

.popup-card {
    width: 420px;
    max-width: 90%;
    background: #fff;
    border-radius: 20px;
    padding: 35px 25px;
    text-align: center;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    box-shadow: 0 20px 60px rgba(0, 0, 0, .25);
    animation: popupScale .4s ease;
}

.success-icon {
    width: 90px;
    height: 90px;
    margin: 0 auto 20px;
    border-radius: 50%;
    background: linear-gradient(135deg, #00c853, #00e676);
    color: #fff;
    font-size: 50px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 25px rgba(0, 200, 83, .35);
}

.popup-card h1 {
    margin: 0 0 12px;
    color: #00a651;
    font-size: 30px;
    font-weight: 700;
}

.popup-card h2 {
    margin: 0 0 20px;
    color: #444;
    font-size: 20px;
    font-weight: 600;
}

.popup-card h2 span {
    color: #0066ff;
}

.message {
    color: #666;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 20px;
}

.redirect {
    color: #888;
    font-size: 14px;
    margin-top: 15px;
}

.loader {
    width: 40px;
    height: 40px;
    margin: 0 auto;
    border: 4px solid #e5e5e5;
    border-top: 4px solid #00c853;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes popupScale {
    from {
        opacity: 0;
        transform: translate(-50%, -50%) scale(.8);
    }

    to {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes spin {
    100% {
        transform: rotate(360deg);
    }
}
</style>

<body>
    <div class="dashboard-body-part">
        <div class="content-wrapper">
            <section class="content-header">
                <h5 style="color: white">Deposit Request</h5>
                <!-- <ol class="breadcrumb">
        <li class="breadcrumb-item" style="color: black"><a href="Dashboard.php"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="breadcrumb-item active" style="color: black">Fund</li>
      </ol> -->
            </section>
            <section class="content" style="padding: unset;">
                <div class="row" style=" justify-content: center;">
                    <div class="col-xl-6 col-lg-12">
                        <div class="box">
                            <div class="box-header"><span class="badge badge-success" style=" color: black">Request Id
                                    -:
                                    <?= $orderId ?></span></div>
                            <div class="box-body">
                                <div class="col-xl-12 col-lglg-4 col-md-12 col-sm-4 col-12">
                                    <div class="payment-card">

                                        <label class="control-label">
                                            Send the exact amount of <b><?= $payCurrency ?></b> to the address below
                                        </label>

                                        <div class="amount-box">
                                            <?= $priceAmount ?> <?= $payCurrency ?>
                                        </div>

                                    </div>
                                    <?php if ($paymentStatus != 'canceled' && $paymentStatus != 'expired' && $paymentStatus != 'refunded' && $paymentStatus != 'finished') { ?>
                                    <p><label style="font-size:16px;" style="font-size:14px; color: white">Payment
                                            Address -: <span class='badge badge-primary' style="font-weight: 600;"
                                                id="qrstatus" style="font-size:14px;">
                                                <?= strtoupper($paymentStatus) ?>
                                            </span></label></p>
                                    <div class="row" id="payAddressBox"
                                        style=" display: flex; justify-content: center;">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input type="text" class="form-control pull-right" id="payAddress"
                                                    value="<?= $payAddress ?>" readonly style="display: inline-block;">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <a onclick="copyPayAddress()" style="display: inline-block;"
                                                    href="javascript:;" class="btn btn-success btn-sm"><i
                                                        class="zoom fa fa-copy " style="color:white;"></i> Copy</a>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <label class="control-label">QR Code</label>

                                    <!--<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?= $payAddress ?>&choe=UTF-8" /><br/>-->
                                    <div class="qr-wrapper">

                                        <div class="status-card">
                                            Payment Status :
                                            <span class="badge badge-primary"
                                                id="qrstatus"><?= strtoupper($paymentStatus) ?></span>
                                        </div>

                                        <img id="qrImage"
                                            src="https://quickchart.io/qr?text=<?= $payAddress ?>&choe=UTF-8">

                                        <br><br>

                                        <span id="countdown"></span>

                                    </div>
                                    <?php } else if ($paymentStatus == 'finished') { ?>
                                    <center id="qrBox">
                                        <span style="font-size:16px;font-weight:bold;color:#28a745;">
                                            Payment Successful
                                        </span>
                                    </center>
                                    <br>
                                    <?php } else if ($paymentStatus == 'canceled') { ?>
                                    <center id="qrBox">
                                        <span style="font-size:16px;font-weight:bold;color:#ff3333;">
                                            Payment Canceled
                                        </span>
                                    </center>

                                    <?php } else { ?>
                                    <span style="font-size:16px;font-weight:bold;color:#ff3333;"> Expired</span>
                                    <?php } ?>
                                    </center><br />
                                </div>
                                <div class="instruction-box">
                                    <p>✅ Fund will be credited after required blockchain confirmations.</p>

                                    <p>✅ Please send the exact amount shown above.</p>

                                    <p>✅ Keep this page open until payment confirmation.</p>

                                    <p>
                                        📧 Support:
                                        support@fundX.com

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- success popup -->
    <!-- Payment Success Popup -->
    <div id="paymentSuccessPopup" class="popup-overlay">

        <div class="popup-card">

            <div class="success-icon">
                ✓
            </div>

            <h1>Payment Successful</h1>

            <h2>
                Amount Received:
                <span id="receivedAmount">0 <?= $payCurrency ?></span>
            </h2>

            <p class="message">
                Your Fund Request has been completed successfully.
            </p>

            <div class="loader"></div>

            <p class="redirect">
                Redirecting...
            </p>

        </div>

    </div>



    <!-- success popup -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    jQuery(document).ready(function() {

        let paymentCompleted = false;

        let paymentChecker = setInterval(function() {

            const orderId = "<?= $orderId; ?>";
            const paymentStatus = "<?= $paymentStatus; ?>";

            $.ajax({
                type: "POST",
                url: "fundRequestPaymentAjaxProcess.php",
                data: {
                    orderId: orderId
                },
                cache: false,

                success: function(data) {

                    const resData = jQuery.parseJSON(data);

                    // SUCCESS POPUP + REDIRECT
                    if (resData.status == "finished") {
                        $("#receivedAmount").text(resData.payAmount +
                            " <?= $payCurrency ?>");
                        let popupKey = "payment_popup_" + orderId;


                        if (paymentStatus != "finished") {

                            sessionStorage.setItem(popupKey, "shown");

                            clearInterval(paymentChecker);

                            $("#paymentSuccessPopup").fadeIn();

                            setTimeout(function() {
                                window.location.href = "fundRequestonline.php";
                            }, 3000);
                        }
                        return;
                    }

                    if (resData.status == "confirming")
                        jQuery('#qrstatus').text("(Payment Partially Confirmed)");

                    if (resData.status == "canceled")
                        jQuery('#qrstatus').text("(Payment Expired)");

                    if (resData.status == "refunded")
                        jQuery('#qrstatus').text("(Payment Refunded)");

                    if (resData.status == "failed")
                        jQuery('#qrstatus').text("(Payment Failed)");

                    if (resData.status == "partially_paid")
                        jQuery('#qrstatus').text("(Payment Partially Paid)");

                    if (resData.status == "sending")
                        jQuery('#qrstatus').text("(Payment Sending)");

                    if (resData.status == "confirmed")
                        jQuery('#qrstatus').text("(Payment Confirmed)");

                    if (resData.status == "waiting")
                        jQuery('#qrstatus').text("(Payment Waiting)");

                    var current_addr = "<?= $payAddress ?>";

                    if (current_addr != resData.address) {
                        location.reload();
                    }
                }
            });

        }, 10000);

    });

    function copyPayAddress() {
        var copyText = document.getElementById("payAddress");
        copyText.select();
        document.execCommand("Copy");
        alert("Pay Address Copied Successfully!!!");
    }
    var d = document.getElementById("Fund");
    d.className += " active";
    var d = document.getElementById("fundRequest.php");
    d.className += " active";
    </script>
    <script>
    // Timer Setup
    var createdTime = "<?= $addDate ?>"; // e.g. "2025-10-03 10:05:00"
    var createdDate = new Date(createdTime.replace(/-/g, "/"));
    var expireTime = createdDate.getTime() + (60 * 60 * 1000); // +60 min

    var countdownEl = document.getElementById("countdown");
    var qrBox = document.getElementById("qrBox");

    function updateTimer() {

        var now = new Date().getTime();
        var distance = expireTime - now;

        if (distance <= 0) {

            clearInterval(timerInterval);

            // Hide QR Code
            var qrImg = document.getElementById("qrImage");
            if (qrImg) {
                qrImg.style.display = "none";
            }

            // Hide Address Box
            var payBox = document.getElementById("payAddressBox");
            if (payBox) {
                payBox.style.display = "none";
            }

            // Hide Copy Button
            var copyBtn = document.querySelector(".btn-success");
            if (copyBtn) {
                copyBtn.style.display = "none";
            }

            // Expired Message
            document.getElementById("countdown").innerHTML =
                "<span style='color:#fff;font-weight:bold'>Payment Expired</span>";

            return;
        }

        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("countdown").innerHTML =
            "Expires in: " + minutes + "m " + seconds + "s";
    }

    var timerInterval = setInterval(updateTimer, 1000);
    updateTimer();
    </script>
</body>

</html>