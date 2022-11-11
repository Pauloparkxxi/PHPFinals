<?php
$conndb = mysqli_connect("localhost", "root", "", "dbsource");

if($conndb)
{
	echo '';
}
else
{
	die("<b>Unable to connect</b>");
	exit();
}
?>