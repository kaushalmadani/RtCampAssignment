<?php
	//This is file is used to clear all sessions.
	session_start();
	$_SESSION['GoogleaccessToken']="";
	$_SESSION['fb_access_token1']="";
	// remove all session variables
	session_unset(); 	

	// destroy the session 
	session_destroy(); 
?>