<?php
$host="127.0.0.1"; // Host name 
$username="root"; // Mysql username 
$password="teniscourts"; // Mysql password 
$db_name="test_comments"; // Database name 
$tbl_name="comments"; // Table name 

mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

$title=$_POST['title']; 
$user=$_POST['user']; 
$time=$_POST['time'];
$comment=$_POST['comment'];

$sql="INSERT into $tbl_name (title, user, time, comment) VALUES ('$title', '$user', '$time', '$comment')";
$result = mysql_query($sql);

echo "Comment logged successfully!"
?>