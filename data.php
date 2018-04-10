<?php
if(isset($_POST[0]['host'])){
$server="localhost";
$username="bikem";
$password="bikeMetrics";
$databaseName="bike_metrics";
$db=new mysqli($server,$username,$password,$databaseName);
if ($db->connect_error) {
    //die("Connection failed: " . $conn->connect_error);
    echo -1;
    die();
}
$user=$_POST[0]['host'];
//$name=$db->real_escape_string($_POST['name']);
for($x=1;$x<=(int)$_POST[0]['newitems'];$x++){
$id=$_POST[$x]['id'];
$EPC=$_POST[$x]['EPC'];
$time=$_POST[$x]['time'];
$query= "INSERT INTO access (id_local, EPC, access_time, parking_id) VALUES ('$id', '$EPC', '$time', '$user');";
//$query= "INSERT INTO access (id_local, EPC, access_time, parking_id) VALUES ('2', 'ASDKLASNLSNFLLWLNEF', '2018-04-04 18:00', '9');";
//echo $query;
$result=$db->query($query);
if(!$result){
	echo -$x;
	die();
}
}
echo 1;
}