<?php
error_reporting(0);
$html="";
include('connect.php');
if(!empty($_GET["UID"]))
{
    $uid=$_GET["UID"];
    $id=0;
    $th=0;
    //echo $uid;
    //$otp=rand(1111,9999);
//echo "The OTP is ".$otp;
//$sql = "UPDATE users SET OTP=".$otp." WHERE UId='".$uid."'";
//echo"<br>";
//echo $sql;
//if ($conn->query($sql) === TRUE)
//{
//    echo "Record updated successfully";
//} 
//else 
//{
  //  echo "Error updating record: " . $conn->error;
//}
//////////////fetching phone number /////////////
$name="";
$phone=0;
$hr=0;
$sql = "SELECT * FROM users WHERE UId='".$uid."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
    // output data of each row
    while($row = $result->fetch_assoc()) 
    {
        $id=$row['Id'];
       $phone= $row["Phone"]; 
    }
} 

$sql1 = "SELECT * FROM skills2 WHERE Id='".$id."'";
$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) 
{
    // output data of each row
    while($row1 = $result1->fetch_assoc()) 
    {
        $hr=$row1['Hours'];
    }
} 
$hr++;

$sql2= "Update Skills_lvl SET Hours=".$hr." Where Id=".$id;
if ($conn->query($sql2) === TRUE) {
    echo "OK";
} else {
    echo "Error updating record: " . $conn->error;
}

$sql3 = "SELECT * FROM skills WHERE S_Id=1";
$result3 = $conn->query($sql3);

if ($result3->num_rows > 0) 
{
    // output data of each row
    while($row3 = $result3->fetch_assoc()) 
    {
        $th=$row3['Threshold'];
        $name=$row3['S_name'];
    }
} 
echo "<br> UID ".$uid;
if($hr>=$th)
{
   //Your authentication key
$authKey = "205669Aj9QHmWM5ab62df6";

//Multiple mobiles numbers separated by comma
$mobileNumber = $phone;

//Sender ID,While using route4 sender id should be 6 characters long.
$senderId = "IoTmum";

//Your message to send, Add URL encoding here.

$message = "You have completed the skill of ".$name;

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
}



$conn->close();
//$url="http://jayantbenjamin.000webhostapp.com/RAIThack/sendmsg.php?ph=".$phone."&otp=".$otp;
//$html = file_get_contents($url);
//echo $html;
    
}


?>