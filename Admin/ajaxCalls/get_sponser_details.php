<?php 
include("../../conection.php"); 

$sponser_id = isset($_GET['sponser_id']) 
    ? mysqli_real_escape_string($con, $_GET['sponser_id']) 
    : '';

if(empty($sponser_id)){
    echo json_encode([]);
    exit;
}

$query = mysqli_query($con, "
    SELECT 
        name,
        fundWallet,
        wallet
    FROM meddolic_user_details 
    WHERE user_id = '$sponser_id' 
      AND acctStatus = 1
");

$response = [];

if ($row = mysqli_fetch_assoc($query)) {
    $response = [
        "name" => $row["name"],
        "fund_wallet" => $row["fundWallet"],
        "income_wallet" => $row["wallet"],
    ];
}

header('Content-Type: application/json');
echo json_encode($response);

include("../../close-connection.php"); 
?>
