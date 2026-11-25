<?php
   include("../../conection.php");
    $id = $_POST['id'];
    $userId = $_POST['userId'];
    $fromDate = $_POST['fromDate'];
    $toDate = $_POST['toDate'];
    $queryDetails=mysqli_query($con,"SELECT orderId,memberId FROM meddolic_user_principal_invest_withdraw WHERE id='$id'");
    $valDetails=mysqli_fetch_assoc($queryDetails); ?>
<div class="modal-content">
    <div class="modal-header" style="background-color: #5d9cec; color: #ffffff;">
        <h4 class="modal-title" id="myModalLabel">Withdraw Remark : <?=$valDetails['orderId']?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    </div>                          
    <form method="POST" action="principalWithdrawProcess" >
        <div class="modal-body">
            <div class="form-group">
                <label class="control-label" for="inputSuccess">Select One :</label>
                <select name="withdrawStatus" class="form-control" required="">
                        <option value=""> -Select Status- </option>
                        <option value="2"> Released </option>
                        <!-- <option value="4"> Processing </option> -->
                </select>
                <input type="hidden" id="id" name="id" value="<?= $id?>" >
                <input type="hidden" id="userId" name="userId" value="<?= $userId?>" >
                <input type="hidden" id="fromDate" name="fromDate" value="<?= $fromDate?>" >
                <input type="hidden" id="toDate" name="toDate" value="<?= $toDate?>" >
                <input type="hidden" name="memberId" value="<?= $valDetails['memberId']?>" >
            </div>
            <div class="form-group">
                <label class="control-label" for="inputSuccess"> Remark :</label>
                <input type="text" class="form-control" id="remarks" name="remarks" required >
            </div>
        </div>
        <div class="modal-footer" style="background-color: #ff902bb5;">
            <input type="submit" name="addRemark" class="btn btn-success" value="Submit Now">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </form>
</div>