<?php
//This file is used to download albums.
try{

ini_set('max_execution_time', 600);

include 'basic.php';
include 'create_zip.php';

$album_ids = $_REQUEST['album_id'];
$album_names = $_REQUEST['album_name'];
$albumIds = explode(',',$album_ids);
$albumName = explode(',',$album_names);
$k=0;

foreach($albumIds as $album_id){
	$dir="image/".$user_id."/".$albumName[$k];
	if(!file_exists($dir)){
		mkdir($dir, 0777, true);
	}
		$photos=$fb->get("/{$album_id}/photos",$accessToken);
		$json=$photos->getGraphEdge();
		$name=array();
		$image=array();
		foreach ($json as $graphNode) {
				$fid=$graphNode->getProperty('id');
				array_push($name,$graphNode->getProperty('name'));
				$link=$fb->get("/{$fid}/picture",$accessToken);
				array_push($image,$link->getHeaders()['Location']);
		}
		for($i=0;$i<count($name);$i++) {
			$content = file_get_contents($image[$i]);
			$fp = fopen($dir."/".$i.".jpeg", "w");
			fwrite($fp, $content);
			fclose($fp);
		}	
	//}
	$k++;
}
if(count($albumName)==1){
		Zip("image/".$user_id."/".$albumName[0],"image/".$user_id."/".$albumName[0].".zip");
		$full="image/".$user_id."/".$albumName[0].".zip";
		echo "<br><a href='$full' class='msg' style='color:red;text-align:center'>Download your album:".$albumName[0]."</a>";
}else{
	foreach($albumName as $nm){
		Zip("image/".$user_id."/".$nm,"image/".$user_id."/selected.zip");
	}
	$full="image/".$user_id."/"."selected.zip";
	echo "<br><a href='$full' class='msg' style='color:red;text-align:center'>Download all your albums</a>";
}
}catch(Exception $e){
echo "<br>Please try again!!";
}
?>