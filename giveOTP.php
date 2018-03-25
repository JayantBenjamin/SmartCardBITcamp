<?php
$html="";
include('connect.php');
if(!empty($_GET["UID"]))
{
    $uid=$_GET["UID"];
    echo $uid;
    $otp=rand(1111,9999);
echo "The OTP is ".$otp;
$sql = "UPDATE users SET OTP=".$otp." WHERE UId='".$uid."'";
echo"<br>";
echo $sql;
if ($conn->query($sql) === TRUE)
{
    echo "Record updated successfully";
} 
else 
{
    echo "Error updating record: " . $conn->error;
}
//////////////fetching phone number /////////////
$phone=0;
$sql2 = "SELECT * FROM users WHERE UId='".$uid."'";
$result = $conn->query($sql2);

if ($result->num_rows > 0) 
{
    // output data of each row
    while($row = $result->fetch_assoc()) 
    {
        echo "Phone is " . $row["Phone"]. "<br>";
       $phone= $row["Phone"]; 
    }
} 
else 
{
    echo "0 results";
}

$conn->close();
$url="http://jayantbenjamin.000webhostapp.com/RAIThack/sendmsg.php?ph=".$phone."&otp=".$otp;
$html = file_get_contents($url);
echo $html;
    
}


?>