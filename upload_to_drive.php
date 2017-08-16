<?php
ini_set('max_execution_time', 600);
include "basic.php";
$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];
require_once 'lib/source/Google_Client.php';
require_once 'lib/source/contrib/Google_DriveService.php';
$names = $_SESSION['aname'];
$fname = explode(',',$names);
if(isset($_SESSION['aid'])){
	$ids=$_SESSION['aid'];
	$ids = explode(',',$ids);
}
$client = new Google_Client();
$client->setClientId('502979999013-03cv4qh9etufsdh616suk2mqqjh3jmpl.apps.googleusercontent.com');
$client->setClientSecret('SdLrJczvXRmZ_tNzPb8Xo6hI');
$client->setRedirectUri($url);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));
$service = new Google_DriveService($client);
function download($nm,$id){
include 'basic.php';
	$photos=$fb->get("/{$id}/photos",$accessToken);
	$json=$photos->getGraphEdge();
	$name=array();
	$image=array();
	foreach ($json as $graphNode) {
			$fid=$graphNode->getProperty('id');
			array_push($name,$graphNode->getProperty('name'));
			$link=$fb->get("/{$fid}/picture",$accessToken);
			array_push($image,$link->getHeaders()['Location']);
	}
	$dir=$nm;
	if(!file_exists($dir)){
		mkdir($dir, 0777, true);
	}
	for($i=0;$i<count($name);$i++) {
		$content = file_get_contents($image[$i]);
		$fp = fopen($dir."/".$i.".jpeg", "w");
		fwrite($fp, $content);
		fclose($fp);
	}
}
function upload($nm){
		global $file,$service;
		$subDirectoryFiles = scandir($nm);
			foreach($subDirectoryFiles as $subFile){
				if($subFile!='.' && $subFile!=".."){
					if(strlen($subFile) > 2){
						$file_path = $nm.'/'.$subFile;
						$mime_type = 'image/jpeg';
						$file->setTitle(basename($subFile));
						$file->setDescription('This is a '.$mime_type.' document');
						$file->setMimeType($mime_type);
						$service->files->insert(
							$file,
							array(
								'data' => file_get_contents($file_path),
								'mimeType' => $mime_type
							)
						);
					}
				}
			}
}
if (isset($_GET['code'])) {
	$client->authenticate($_GET['code']);
    $access_token = $client->getAccessToken();
	$_SESSION['GoogleaccessToken'] = $access_token;
} elseif (!isset($_SESSION['GoogleaccessToken'])) {
    $client->authenticate();
}else{
   $access_token=$_SESSION['GoogleaccessToken'] ;
}
try{
	$client->setAccessToken($_SESSION['GoogleaccessToken']);
	$file = new Google_DriveFile();
	$flag_option = false;
	$files = $service->files->listFiles();
	$folderId = '';
	foreach ($files['items'] as $item) {
		if ($item['title'] == "facebook_".$user_name."_albums"){
			$flag_option = true;
			$folderId = $item['id'];
			break;
		}
	}
	if($flag_option == false){
		$folder = new Google_DriveFile();
		$folder_mime = "application/vnd.google-apps.folder";
		$folder_name = "facebook_".$user_name."_albums";
		$folder->setTitle($folder_name);
		$folder->setMimeType($folder_mime);
		$masterDirectory = $service->files->insert($folder);
		$folderId  = $masterDirectory['id'];
	}
	$i=0;
	foreach($fname as $nm){
        $dir='facebook_'.$user_name.'_'. basename($nm);
		$folder = new Google_DriveFile();
		$folder_mime = "application/vnd.google-apps.folder";
		$folder->setTitle($dir);
		$folder->setMimeType($folder_mime);
		if($folderId != null){
			$parent = new Google_ParentReference();
			$parent->setId($folderId);
			$folder->setParents(array($parent));
		}
		$directory = $service->files->insert($folder);
		$parentId  = $directory['id'];
		if($parentId != null){
			$parent = new Google_ParentReference();
			$parent->setId($parentId);
			$file->setParents(array($parent));
		}
		if(file_exists($nm)){
				upload($nm,$file);
		}else{
			download($nm,$ids[$i]);
			upload($nm,$file);
		}
		$i++;		
    }
	header("location:http://spatel.club/assignment/fb-callback.php?done=1");
}catch(Exception $e){
	echo "Error";
}
exit;
?>