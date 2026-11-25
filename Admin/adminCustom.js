function catchEnter(event){
  if(event.which == 13 || event.keyCode == 13){
    $("#loginSubmit").trigger('click');
    // alert('enter is pressed');
  }
}
// Show Password Login Page Code
function eyePass() {
    var x = document.getElementById("inputPassword");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
// Email Send Timer Code
function startTimer(){
    var counter = 101;
    setInterval(function() {
        counter--;
        if (counter >= 0) {
            span = document.getElementById("count");
            span.innerHTML = counter +' S' ;
        }
        if(counter === 0){
            //alert('sorry, out of time');
            document.getElementById("emailBtn").disabled = false;
            // document.getElementById("count").style.display = "none";
            document.getElementById("count").style.visibility = "hidden";
            clearInterval(counter);
        }
    }, 1000);
}
// Email Send Withdraw Verify OTP Code
function CryptoSendEmailOTP(currentTime){
    var username = document.getElementById("username").value;
    var pass = document.getElementById("pass").value;
    if(username!='' && pass!=''){
        document.getElementById("count").style.visibility = "visible";
        // document.getElementById("count").style.display = "block";
        document.getElementById("emailBtn").disabled = true;
        startTimer(); 
        jQuery.ajax({
            type: "POST",
            url: "loginSendEmailOTPAjax",
            data: {currentTime: currentTime },
            success: function(res) {
                //alert(res);
                alert('OTP send to your Email Id.');
            } });
    }else{
        alert('Please fill all fields');
    }
}
function removeModal(){
  // alert(window.location.href);
  // var currentUrl=window.location.href;
  setTimeout(function(){ location.reload(); }, 500);
  // location.reload();
}
$('#from_date').datepicker({
    format: 'dd-mm-yyyy'
})
$('#to_date').datepicker({
    format: 'dd-mm-yyyy'
})
function sponser_valid(sponser_id){
    document.getElementById("sponser_name").value="";
    if(!sponser_id==""){
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function(){
          if (xmlhttp.readyState==4 && xmlhttp.status==200){
                var v=xmlhttp.responseText;
                if(v.trim()!=""){
                    document.getElementById("sponser_name").value=v.trim();
                }
                else{
                    alert("Invalid Sponser ID");
                    document.getElementById("sponser_id").value="";
                }
               
            }
          }
        xmlhttp.open("GET","../get_sponser_name?sponser_id="+sponser_id,true);
        xmlhttp.send();
      }
    }