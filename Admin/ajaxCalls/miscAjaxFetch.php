<?php
   include("../../conection.php");
    $miscId = $_POST['miscId'];
    $queryDetails=mysqli_query($con,"SELECT tokenId,tokenName,tokenRate FROM meddolic_config_token_rate WHERE tokenId='$miscId'");
    $valDetails=mysqli_fetch_array($queryDetails); ?>
<div class="modal-content">
    <div class="modal-header" style="background-color: #5d9cec; color: #ffffff;">
        <h4 class="modal-title" id="myModalLabel">MISC Edit</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="removeModal()">x</button>
    </div>                            
    <form method="POST" action="miscSettingProcess">
        <div class="modal-body" style="color: #000000;">
            <div class="form-group">
                <label class="control-label" for="inputSuccess">Token Name</label>
                <input type="text" class="form-control" name="tokenName" value="<?= $valDetails['tokenName'] ?>" required >
                <input type="hidden" name="miscId" value="<?= $miscId?>" readonly >
            </div>
            <div class="form-group">
                <label class="control-label" for="inputSuccess">Token Rate</label>
                <input type="text" class="form-control" name="tokenRate" value="<?= $valDetails['tokenRate'] ?>" required >
            </div>
       </div>
        <div class="modal-footer" style="background-color: #ff902bb5;">
            <input type="submit" name="miscUpdate" class="btn btn-success" value="Save Change">
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="removeModal()">Close</button>
        </div>
    </form>
</div>
