<?php
ini_set('max_execution_time', 600);
session_start();
$_SESSION['aname']='';
$_SESSION['aid']='';
if(isset($_GET['album_id'])){
	$id = $_GET['album_id'];
	$_SESSION['aid']=$id;
}
$names = $_GET['name'];
$_SESSION['aname']=$names;
header("location:upload_to_drive.php");
?>