<!DOCTYPE html>
<html lang="en">
<?php include('include/head.php');
      include("loginCheck.php");
      include('include/header.php');
      include('include/menu.php'); ?>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Fund Deduct</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"> Fund Manager </a></li>
                        <li class="breadcrumb-item active"> Fund Deduct</li>
                    </ul>
                </div>            
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <h2>Fund Deduct</h2>
                    </div>
                    <div class="body">
                       <form class="text-center" method="POST" action="fundDeductBack"
                  onsubmit="return confirm('Are you sure?')">
                  <fieldset>
                     <div class="form-card text-left">
                        <div class="row">
                           <div class="col-12">
                              <h3 class="mb-4">Fund Deduct</h3>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>User ID -:</label>
                                 <input type="text" name="sponser_id" id="sponser_id" class="form-control"
                                    placeholder="e.g. xxxxxxxxxx" onblur="sponser_valid(this.value)" required>
                                 <input type="hidden" name="login_member_id" value="<?= $member_id ?>">
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Name -: </label>
                                 <input type="text" id="sponser_name" class="form-control" placeholder="e.g. xxxxxxxxx"
                                    disabled="">
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>fund Wallet -: </label>
                                 <input type="text" id="fund_wallet" class="form-control" placeholder="e.g. 123"
                                    disabled="">
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Income Wallet -: </label>
                                 <input type="text" id="income_wallet" class="form-control" placeholder="e.g. 123"
                                    disabled="">
                              </div>
                           </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                 <label>Select Wallet:</label>
                                 <select name="wallet_type" id="wallet_type" class="form-control" required>
                                    <option value="">-- Select Wallet --</option>
                                    <option value="fundWallet">Fund Wallet</option>
                                    <option value="wallet">Income Wallet</option>
                                 </select>
                              </div>
                           </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                 <label>Action:</label>
                                 <select name="action_type" id="action_type" class="form-control" required>
                                    <option value="">-- Select Action --</option>
                                    <option value="add">Add Amount</option>
                                    <option value="subtract">Subtract Amount</option>
                                 </select>
                              </div>
                           </div> 
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Amount To Deduct -:</label>
                                 <input type="text" id="amount" name="amount" class="form-control"
                                    placeholder="e.g. Transfer Amount" onkeypress="return onlynum(event)" required>
                              </div>
                           </div>
                        </div>
                     </div>
                     <button type="submit" name="fundDeduct" class="btn btn-primary action-button float-left"
                        value="Submit">Submit Now</button>
                     <button type="button" name="previous" class="btn btn-danger action-button-previous float-left ml-3"
                        value="Reset" onclick="location.reload()">Reset</button>
                  </fieldset>
               </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('include/footer.php'); ?>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>-->
<script>
   function sponser_valid(sponser_id) {
      document.getElementById("sponser_name").value = "";
      document.getElementById("fund_wallet").value = "";
      document.getElementById("income_wallet").value = "";

      if (sponser_id !== "") {
         fetch("ajaxCalls/get_sponser_details?sponser_id=" + sponser_id)
            .then(res => res.json())
            .then(data => {
               if (data.name) {
                  document.getElementById("sponser_name").value = data.name;
                  document.getElementById("fund_wallet").value = data.fund_wallet;
                  document.getElementById("income_wallet").value = data.income_wallet;
               } else {
                  alert("Invalid User ID");
                  document.getElementById("sponser_id").value = "";
               }
            })
            .catch(() => {
               alert("Server Error");
            });
      }
   }

   var d = document.getElementById("fund");
   d.className += " active";
   var d = document.getElementById("fundDeduct");
   d.className += " active";
</script>
</body>
</html> 