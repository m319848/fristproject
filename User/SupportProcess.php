<?php
include("loginCheck.php");

if (!$con->set_charset('utf8mb4')) {
  error_log("Failed to set charset: " . $con->error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supportTicket'])) {

  $memberId = isset($_SESSION['user_member_id']) ? (int) $_SESSION['user_member_id'] : 0;
  if ($memberId <= 0) {
    echo '<script>alert("Please login and try again."); window.top.location.href="LoginAuth";</script>';
    exit;
  }

  $subjectId = isset($_POST['subjectId']) ? (int) $_POST['subjectId'] : 0;
  $priorityId = isset($_POST['priorityId']) ? (int) $_POST['priorityId'] : 0;
  $rawMessage = isset($_POST['ticketMessage']) ? (string) $_POST['ticketMessage'] : '';

  $noScript = preg_replace('/<\s*script\b[^>]*>(.*?)<\s*\/\s*script\s*>/is', '', $rawMessage);

  $cleanMessage = strip_tags($noScript);

  $cleanMessage = trim($cleanMessage);
  $maxLen = 4000;
  if (mb_strlen($cleanMessage, 'UTF-8') > $maxLen) {
    $cleanMessage = mb_substr($cleanMessage, 0, $maxLen, 'UTF-8');
  }

  if ($cleanMessage === '') {
    echo '<script>alert("Ticket message cannot be empty."); window.top.location.href="Support";</script>';
    exit;
  }

  $checkSql = "SELECT COUNT(1) FROM meddolic_user_support_ticket WHERE memberId = ? AND (ticketStatus = 1 OR ticketStatus = 2)";
  if ($stmt = $con->prepare($checkSql)) {
    $stmt->bind_param("i", $memberId);
    $stmt->execute();
    $stmt->bind_result($openCount);
    $stmt->fetch();
    $stmt->close();

    if (!empty($openCount) && $openCount > 0) {
      echo '<script>alert("Your previous request is still processing. Please wait."); window.top.location.href="Support";</script>';
      exit;
    }
  } else {
    error_log("DB prepare failed (check open tickets): " . $con->error);
    echo '<script>alert("Server error. Try later."); window.top.location.href="Support";</script>';
    exit;
  }

  $ticketCode = 'AT' . random_int(11111, 99999) . $memberId . date('s') . date('h');

  $insertSql = "INSERT INTO meddolic_user_support_ticket (memberId, ticketCode, subjectId, priorityId, ticketMessage, raiseDate)
                  VALUES (?, ?, ?, ?, ?, ?)";
  $now = date("Y-m-d H:i:s");

  if ($stmt = $con->prepare($insertSql)) {
    $stmt->bind_param("isiiss", $memberId, $ticketCode, $subjectId, $priorityId, $cleanMessage, $now);
    $execOk = $stmt->execute();

    if ($execOk) {
      $stmt->close();
      $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
      echo '<script>alert("Support Ticket Raised Successfully"); window.top.location.href="Support";</script>';
      exit;
    } else {
      error_log("DB insert failed: " . $stmt->error);
      $stmt->close();
      echo '<script>alert("Could not create ticket right now. Try again later."); window.top.location.href="Support";</script>';
      exit;
    }
  } else {
    error_log("DB prepare failed (insert): " . $con->error);
    echo '<script>alert("Server error. Try later."); window.top.location.href="Support";</script>';
    exit;
  }
}

include("../close-connection.php");