<?php
if(!empty($_GET["ph"]))
{
    $ph=$_GET["ph"];
     $otp=$_GET["otp"];
}

//Your authentication key
$authKey = "205669Aj9QHmWM5ab62df6";

//Multiple mobiles numbers separated by comma
$mobileNumber = $ph;

//Sender ID,While using route4 sender id should be 6 characters long.
$senderId = "IoTmum";

//Your message to send, Add URL encoding here.

$message = "Your OTP is ".$otp;

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

echo $output;
?>
