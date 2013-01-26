<?php
$host="127.0.0.1"; // Host name 
$username="root"; // Mysql username 
$password="teniscourts"; // Mysql password 
$db_name="test_comments"; // Database name 
$tbl_name="comments"; // Table name 

mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

$title = $_POST['title'];

$sql = "SELECT * FROM $tbl_name WHERE title='$title'";
$result = mysql_query($sql);

while($row=mysql_fetch_assoc($result)) {
       $username = $row['user'];
       $time = $row['time'];
       $comment = $row['comment'];
       echo "<strong><i>".$username."</i></strong>: ".$comment." $time</br>";
       echo "<hr style='border:none; border-top:1px #CCCCCC solid; height:1px' />";
   }
?>
