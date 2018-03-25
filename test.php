//RAIThack/giveOTP.php?UID=834B25D9
<?php 
$html="";
$url="http://jayantbenjamin.000webhostapp.com/RAIThack/giveOTP.php?UID=";
$uid="834B25D9";
$url=$url.$uid;
$html = file_get_contents($url);
echo $html;
 ?>
 