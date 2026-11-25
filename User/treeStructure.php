<?php
require_once("loginCheck.php");
require_once('Include/Head.php');
require_once('Include/Sidebar.php');
?>

<?php
if ($_GET) {
  $userId1 = $_GET['userId'];
} else {
  $userId1 = $userId;
} ?>
<div class="dashboard">
  <div class="page-header-flex">
    <div>
      <h2>Tree View</h2>
      <p style="color: var(--text-muted); margin: 0;">Manage and move your capital instantly</p>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="row" style="display:unset">
      <div class="col-lg-12">
        <?php
        $queryNew = mysqli_query($con, "SELECT member_id FROM meddolic_user_details WHERE user_id='$userId1'");
        $valNew = mysqli_fetch_assoc($queryNew);
        $memberId1 = $valNew['member_id'] ?>
        <iframe src="binaryTree/binaryTree?member_id=<?= $memberId1 ?>"
          style="width: 100%; height: 800px; background: white; border: none;"></iframe>
      </div>
    </div>
</div>
<!-- /.row -->
</section>
<!-- /.content -->
<?php
require_once 'include/footer.php'; ?>

</script>
</body>

</html>