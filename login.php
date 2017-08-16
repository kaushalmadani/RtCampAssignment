<!DOCTYPE html>
<html lang="en">
<link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<title>Login</title>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php
session_start();
ini_set('max_execution_time', 600);
require_once 'lib/Facebook/autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;
$fb = new Facebook\Facebook([
  'app_id' => '152568361962769', // Replace {app-id} with your app id
  'app_secret' => '493f71315889f588a3325dbe6d974caa',
  'default_graph_version' => 'v2.2',
  'persistent_data_handler'=>'session',	
  ]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['user_photos'];
$loginUrl = $helper->getLoginUrl('http://spatel.club/assignment/fb-callback.php', $permissions);
echo '<h2 class="text-center">Click <u><a href="' . htmlspecialchars($loginUrl) . '">HERE</a></u> log in with Facebook!</h2>';
?>
</html>