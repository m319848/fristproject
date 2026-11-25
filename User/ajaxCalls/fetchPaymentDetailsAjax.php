<?php include('../../conection.php');

$payment_id = $_POST['paymentId'];

$queryDetails = mysqli_query($con, "SELECT * FROM meddolic_config_payment_details WHERE payment_id='$payment_id'");
$valDetails = mysqli_fetch_assoc($queryDetails); ?>
<div id="payment-info-box" class="payment-details-card">
  <div class="method-header"> <?= $valDetails['paymentName'] ?> </div>
  <div class="method-body">
    <div class="row">

      <div id="method-display">
        <?php if ($valDetails['paymentImage'] != "") { ?><img src="../<?= $valDetails['paymentImage'] ?>"
            class="img-responsive" width="100%" height="50%"><?php } ?>
      </div>
    </div>
  </div>
  <div class="method-address" id="payment-address">
    <?= $valDetails['paymentAddress'] ?>
  </div>
</div>