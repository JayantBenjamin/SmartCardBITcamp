<?php
include('connect.php');
$id=$_GET['id'];
$bal=0;
$comp= [];
$from= [];
$to= [];
$skill= [];
$hr= [];
$th=[];
$name=[];

 $sql1 = "SELECT * From users where Id = '$id'";
       $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
    while($row1 = $result1->fetch_assoc()) {
    	$username=$row1['Name'];
    	//echo  $row1['Email']."<br>";
    }
}
$sql2 = "SELECT * From trans where Id = '$id'";
       $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
    while($row2 = $result2->fetch_assoc()) {
    	$bal=$row2['Bal'];
  
    }
}
//echo "Current balance is ".$bal." <br>";

$i=1;
$sql3 = "SELECT * From work where Id = '$id'";
       $result3 = $conn->query($sql3);
        if ($result3->num_rows > 0) {
    while($row3 = $result3->fetch_assoc()) {
    	$comp[$i]=$row3['Company'];
    	$from[$i]=$row3['From_date'];
    	$to[$i]=$row3['To_date'];
    	$i++;
  
    }
}
$k=1;
while($k<$i)
{
	//echo "Worked in company ".$comp[$k]." from ".$from[$k]." to ".$to[$k]."<br>";
	$k++;
}

$i=1;
$sql4 = "SELECT * From Skills_lvl where Id=".$id;
       $result4 = $conn->query($sql4);
        if ($result4->num_rows > 0) {
    while($row4 = $result4->fetch_assoc()) {
    	$skill[$i]=$row4['S_Id'];
    	$hr[$i]=$row4['Hours'];
    
$i++;
  
    }
}
$k=1;
while($k<$i)
{
    $sql5="Select * from skills where S_Id=".$skill[$k];
    $result5= $conn->query($sql5);
        if ($result5-> num_rows > 0) {
    while($row5= $result5->fetch_assoc()) {
     $th[$k]=$row5['Threshold'];
     $name[$k]=$row5['S_name'];
     //echo "Skill ".$name[$k]." with threshold of ".$th[$k]." hours has comleted ".$hr[$k]." hours <br>";
     $k++;
    }
        }
    
}

?>
<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Learned',  <?php echo $hr[1];?>],
          ['Remaining',<?php echo $th[1]-$hr[1];?>],
          
        ]);

        var options = {
          title: 'आपके कौशल (<?php echo$name[1];?>)',
          pieHole: 0.9,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
     <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Learned',  <?php echo $hr[2];?>],
          ['Remaining',<?php echo $th[2]-$hr[2];?>],
          
        ]);

        var options = {
          title: 'आपके कौशल (<?php echo$name[2];?>)',
          pieHole: 0.9,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart2'));
        chart.draw(data, options);
      }
    </script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 900px;
  margin: auto;
  text-align: center;
  font-family: arial;
}

dialog::backdrop {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color:red;
}
dialog {
  width: 500px;
  backdrop: 
	}


.title {
  color: grey;
  font-size: 18px;
}

button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}
.button2 {
    background-color: #DC2C06;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

a {
  text-decoration: none;
  font-size: 22px;
  color: black;
}

button:hover, a:hover {
  opacity: 0.7;
}
</style>
</head>
<body>

<h2 style="text-align:center">User Profile Card</h2>

<div class="card">
  <img src="http://jayantbenjamin.000webhostapp.com/RAIThack/photos/<?php echo$id;?>.png" alt="John" style="width:100%">
  <h1><?php echo $username;?></h1>
  <p class="title">Skills</p>
  <div id="donutchart" style="width: 900px; height: 500px;"></div>
  <div id="donutchart2" style="width: 900px; height: 500px;"></div>
  <p class="title">Amount</p>
<button class="button2"><?php echo $bal;?></button>
<p class="title">Work Experience</p>
<?php $k=1;
while($k<$i)
{
	echo "Worked in company ".$comp[$k]." from ".$from[$k]." to ".$to[$k]."<br>";
	$k++;
}
?>
<dialog id="window">
  
  <a href="http://www.skilldevelopment.gov.in/pmkvy.html">Try a Skill Out </a>
<br>

<a href="http://jayantbenjamin.000webhostapp.com/RAIThack">
    Visit Home
</a>

<button id="exit">Exit</button>
</dialog>
<button id="show">Government Schemes</button>
<script>
(function() {
    var dialog = document.getElementById('window');
  document.getElementById('show').onclick = function() {
    dialog.show();
      };
  document.getElementById('exit').onclick = function() {
    dialog.close();
  };
})();
</script>
</body>
</html>


