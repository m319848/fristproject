<?php
include("loginCheck.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (isset($_POST['addFundNow'])) {
    $queryAccess = mysqli_query($con, "SELECT member_id FROM meddolic_user_details 
    WHERE user_id='{$_SESSION['member_user_id']}'");
    $valAccess = mysqli_fetch_array($queryAccess);
    if (!$valAccess) {
        echo "<script>alert('Invalid session. Please log in again.'); window.top.location.href='LoginAuth';</script>";
        exit;
    }
  echo  $loginMemberId = $valAccess['member_id'];
    $user_id1 = $_POST['user_id'];
    $investmentAmount = $_POST['invetsAmount'];
    $d = date("Y-m-d H:i:s");
    $todayDate = date("Y-m-d");

    if ($investmentAmount < 5) { ?>
        <script>
            alert("Invailid Amount!!!");
            window.top.location.href = "fundRequestonline";
        </script>
        <?php
        exit;
    }

    $resultUser = mysqli_query($con, "SELECT * FROM meddolic_user_details WHERE user_id='$user_id1' AND userType=2");
    if (!mysqli_num_rows($resultUser)) { ?>
        <script>
            alert("Invalid User Id!!!");
            window.top.location.href = "fundRequestonline";
        </script>
        <?php
        exit;
    }

    $queryOld = mysqli_query($con, "SELECT COUNT(1) FROM meddolic_user_invest_purchase_details WHERE memberId='$loginMemberId' AND actionType=2 AND nextPayOpen=0");
    $valOld = mysqli_fetch_array($queryOld);
    if ($valOld[0] > 0) { ?>
        <script>
            alert("Your Previous Request is on Pending!!!");
            window.top.location.href = "fundRequestonline";
        </script>
        <?php
        exit;
    }

    $queryDetails = mysqli_query($con, "SELECT member_id,name,phone,email_id,user_id,sponser_id FROM meddolic_user_details WHERE member_id='$loginMemberId'");
    $valDetails = mysqli_fetch_assoc($queryDetails);
    $memberId = $valDetails['member_id'];
    $name = $valDetails['name'];
    $phone = $valDetails['phone'];
    $emailId = $valDetails['email_id'];
    $userId = $valDetails['user_id'];
    $sponserId = $valDetails['sponser_id'];

   

    $orderId = "FX" . time() . $memberId . "AF" . rand(1000, 9999);
    $queryTemp = mysqli_query($con, "INSERT INTO meddolic_user_invest_purchase_details (`memberId`,`loginMemberId`,`name`,`phone`,`emailId`,`addDate`,`orderId`,`packagePrice`,`actionType`) VALUES ('$memberId','$loginMemberId','$name','$phone','$emailId','$d','$orderId','$investmentAmount',2)");
    $tempId = $con->insert_id;

    $apiUrl = "https://gateway.faradpay.com/api/payment";
    $apiKey = '37C5328B-4FFF-42AC-B85E-3E5A55139FA0';
    $postData = [
        "priceAmount" => (float) $investmentAmount,
        "priceCurrency" => "USDTBSC",
        "payCurrency" => "USDTBSC",
        "network" => "bsc",
        "orderId" => $orderId,
        "orderDescription" => "Deposit (Online)"
    ];

    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'x-api-key: ' . $apiKey,
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if (curl_errno($curl)) {
        echo 'faradpay Error: ' . curl_error($curl);
        exit;
    }

    curl_close($curl);

    $data = json_decode($response, true);

    // Check if 'data' key exists
    if (!isset($data['data'])) {
        echo "<script>alert('Invalid response from faradpay'); window.top.location.href='fundRequestonline';</script>";
        exit;
    }

    // Extract from nested 'data' array
    $paymentData = $data['data'];

    $paymentId = $paymentData['paymentId'] ?? '';
    $paymentStatus = $paymentData['paymentStatus'] ?? '';
    $payAddress = $paymentData['payAddress'] ?? '';
    $priceAmount = $paymentData['priceAmount'] ?? '';
    $priceCurrency = $paymentData['priceCurrency'] ?? '';
    $payAmount = $paymentData['payAmount'] ?? ''; // May be missing in faradpay, use fallback if needed
    $payCurrency = $paymentData['payCurrency'] ?? '';
    $amountReceived = $paymentData['amountReceived'] ?? ''; // May not be available yet (waiting)
    $createdAt = $paymentData['createdAt'] ?? '';
    $updatedAt = $paymentData['updatedAt'] ?? '';
    $purchaseId = $paymentData['purchaseId'] ?? '';
    $returnOrderId = $paymentData['orderId'] ?? $orderId;


    mysqli_query($con, "UPDATE meddolic_user_invest_purchase_details   SET   paymentId='$paymentId',  paymentStatus='$paymentStatus',    payAddress='$payAddress',    priceAmount='$priceAmount',    priceCurrency='$priceCurrency',    payAmount='$payAmount',    payCurrency='$payCurrency',    amountReceived='$amountReceived',   createdTime='$d',   updateTime='$d', purchaseId='$purchaseId' WHERE orderId='$returnOrderId'");

    // Payment Gateway Code Ends (faradpay)
    ?>
    <script>
        // window.top.location.href = "fundRequestSuccessNew.php?orderId=<?= $returnOrderId ?>";
         window.top.location.href =
            "https://gateway.faradpay.com/payment?paymentId=<?= $paymentId ?>&redirect_url=https://fundx.live/User/fundRequestonline.php%3Fstatus%3Dsuccess%26order%3DORD-1786012528-9798";
    </script>

    <?php
}
?>

<?php include("../close-connection.php"); ?>