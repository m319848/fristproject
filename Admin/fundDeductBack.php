<?php

date_default_timezone_set("Asia/Kolkata");
include("loginCheck.php");

if (isset($_POST['fundDeduct'])) {
    $user_id1 = mysqli_real_escape_string($con, $_POST['sponser_id']);
    $sender_member_id = intval($_POST['login_member_id']);
    $amount = floatval($_POST['amount']);
    $wallet_type = $_POST['wallet_type'] ?? '';
    $action_type = $_POST['action_type'] ?? '';
    $d = date("Y-m-d H:i:s");

    // Validate wallet type
    $allowed_wallets = ['fundWallet', 'wallet'];

    if (!in_array($wallet_type, $allowed_wallets)) {
        echo "<script>
                alert('Invalid Wallet Type');
                window.location.href='fundDeduct';
              </script>";
        exit;
    }

    // Validate action type
    $allowed_actions = ['add', 'subtract'];

    if (!in_array($action_type, $allowed_actions)) {
        echo "<script>
                alert('Invalid Action');
                window.location.href='fundDeduct';
              </script>";
        exit;
    }

    // Validate amount
    if ($amount <= 0) {
        echo "<script>
                alert('Invalid Amount');
                window.location.href='fundDeduct';
              </script>";
        exit;
    }

    // Check user exists
    $query = mysqli_query(
        $con,
        "SELECT * FROM meddolic_user_details 
         WHERE user_id='$user_id1' 
         AND acctStatus=1"
    );

    if (!$query || !mysqli_num_rows($query)) {
        echo "<script>
                alert('Invalid Member ID');
                window.location.href='fundDeduct';
              </script>";
        exit;
    }

    $user = mysqli_fetch_assoc($query);
    $receiver_member_id = intval($user['member_id']);

    // Get selected wallet balance
    $current_wallet = floatval($user[$wallet_type]);

    // Calculate new balance
    if ($action_type == "subtract") {

        // Check sufficient balance
        if ($current_wallet < $amount) {
            echo "<script>
                    alert('Insufficient Balance');
                    window.location.href='fundDeduct';
                  </script>";
            exit;
        }

        $new_balance = $current_wallet - $amount;

    } elseif ($action_type == "add") {

        $new_balance = $current_wallet + $amount;
    }

    // Update selected wallet
    $update = mysqli_query(
        $con,
        "UPDATE meddolic_user_details 
         SET $wallet_type = '$new_balance' 
         WHERE member_id = '$receiver_member_id'"
    );

    if (!$update) {
        echo "<script>
                alert('Wallet Update Failed');
                window.location.href='fundDeduct';
              </script>";
        exit;
    }

    // Insert history
    $history = mysqli_query(
        $con,
        "INSERT INTO meddolic_user_fund_deduct_history
        (
            sender_member_id,
            receiver_member_id,
            wallet_type,
            action_type,
            amount,
            date_time
        )
        VALUES
        (
            '$sender_member_id',
            '$receiver_member_id',
            '$wallet_type',
            '$action_type',
            '$amount',
            '$d'
        )"
    );

    if (!$history) {
        echo "<script>
                alert('Wallet updated, but history could not be saved');
                window.location.href='fundDeduct';
              </script>";
        exit;
    }

    echo "<script>
            alert('Wallet Updated Successfully!');
            window.location.href='fundDeduct';
          </script>";
    exit;
}
?>
