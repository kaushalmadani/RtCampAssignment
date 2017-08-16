<?php
	//This is basic file which includes facebook related stuff like token,userid,username 
	
	ini_set('max_execution_time', 600);
	session_start();
	require_once 'lib/Facebook/autoload.php';
	use Facebook\FacebookSession;
	use Facebook\FacebookRequest;
	use Facebook\GraphUser;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookRedirectLoginHelper;
	
	$fb = new Facebook\Facebook([
		'app_id' => '152568361962769',
		'app_secret' => '493f71315889f588a3325dbe6d974caa',
		'default_graph_version' => 'v2.2',
	]);
	$accessToken=isset($_SESSION['fb_access_token1'])?$_SESSION['fb_access_token1']:"";
	if($accessToken==''){
		$helper=$fb->getRedirectLoginHelper();
		$accessToken=$helper->getAccessToken();
		$_SESSION['fb_access_token1'] = (string) $accessToken;
		$response=$fb->get("/me?fields=id,name",$accessToken);
		$user=$response->getGraphUser();
		$_SESSION['id']=$user["id"];
		$_SESSION['name']=$user["name"];
	}else{
		$user_id=$_SESSION['id'];
		$user_name=$_SESSION['name'];
	}
?>