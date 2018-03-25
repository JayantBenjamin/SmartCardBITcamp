<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
include('../connect.php');
$phone=0;
$uid=0;
$id=0;
$otp=$_POST['otp'];
$pass=$_POST['pass'];
$with=$_POST['amt'];
$prod=$_POST['prod'];
$sql="SELECT * from users where OTP=".$otp." AND Password='".$pass."'";
echo $sql;
$result = $conn->query($sql);
       if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) {
    	$uid = $row['UId'];
    	$id= $row['Id'];
    	$phone= $row['Phone'];
    }
}
  date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d H:i:s'); // use actual date() format displayed in your table.

$dateElements = explode('-', $date);
$year = $dateElements[0]-'0';
$month = $dateElements[1]-'0';
$day = $dateElements[2]-'0';
$dateElements2 = explode(' ', $date);
$dateElements3 = explode(':', $dateElements2[1]);
$hr=$dateElements3[0]-'0';
$min= $dateElements3[1]-'0';
$sec= $dateElements3[2]-'0';
$date2=$day*100+$month;
$time2=$hr*100+$min;
$depo = 0;

$new_bal = 0;
$bal=0;



    $sql2 = "SELECT * From trans where Id = '$id'";
       $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
    while($row2 = $result2->fetch_assoc()) {
    	//$tid = $row2['T_Id'];
    	$bal = $row2['Bal'];
    	//echo $bal;
    
    }
}
echo "Available balance is '$bal'";
if($bal<$with)
{
	echo "Insufficient balance";
}
else
{
     if($depo == 0)
     {
     	$new_bal = $bal - $with; 
     }
     else
     {
     	$new_bal - $bal + $depo;
     }
}
echo "New Balance is '$new_bal'";
$sql3 = "INSERT INTO trans (Id, Bal , Deposit , Withdraw, time1 , date1) VALUES ('".$id."', '".$new_bal."', '".$depo."' , '".$with."' ,'".$time2."' , '".$date2."')";
$conn->query($sql3); 

//Your authentication key
$authKey = "205669Aj9QHmWM5ab62df6";

//Multiple mobiles numbers separated by comma
$mobileNumber = $phone;

//Sender ID,While using route4 sender id should be 6 characters long.
$senderId = "IoTmum";

//Your message to send, Add URL encoding here.

$message = "The amount deducted from your account is Rs.".$with.". The new balance is Rs.".$new_bal;

//Define route 
$route = 4;
//Prepare you post parameters
$postData = array(
    'authkey' => $authKey,
    'mobiles' => $mobileNumber,
    'message' => $message,
    'sender' => $senderId,
    'route' => $route
);

//API URL
$url="http://api.msg91.com/api/sendhttp.php";

// init the resource
$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData
    //,CURLOPT_FOLLOWLOCATION => true
));


//Ignore SSL certificate verification
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


//get response
$output = curl_exec($ch);

//Print error if any
if(curl_errno($ch))
{
    echo 'error:' . curl_error($ch);
}

curl_close($ch);

//echo $output;
    
}
?>
<body>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
  <form class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"> 
    <fieldset>
      <legend>

भुगतान(Payment)</legend>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="One time Password"> गुप्त संख्या     (OTP)</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="otp" id="otp" placeholder="One time password">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="card-number">पासवर्ड (Password)</label>
        <div class="col-sm-9">
          <input type="password" class="form-control" name="pass" id="pass" placeholder="पासवर्ड">
        </div>
      </div>
      <div class="form-group">
        
        <div class="col-sm-9">
          <div class="row">
            <div class="col-xs-3"> 
            </div>
            <div class="col-xs-3">  
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="Amount"> रकम (Amount)</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="amt" id="amt" placeholder="Amount">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="cvv">
सामग्री (Products)</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" name="prod" id="prod" placeholder="Enter products">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
          <button type="button" class="btn btn-success">
भुगतान (Pay Now)</button>
        </div>
      </div>
    </fieldset>
  </form>
</div>
</body>