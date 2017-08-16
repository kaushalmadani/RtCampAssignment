<!DOCTYPE html>
<html lang="en">
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="lib/style.css">
<head><meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"></head>
<title>Home</title>
<body>
<?php require "my_script.js";
include 'basic.php';
?>
<div id="loading" style="display:none;">
			<img id="loading-image" src="ajax-loader.gif" alt="Loading..." />
</div>
<div class="text-center">
  <h3 class="text-info"><?php 
  if(!isset($user_name)){
	header("location:fb-callback.php");
  }else{
	echo "Welcome,".$user_name;
  }
  ?></h3> 
  <div class="text-right">
  <h6 class="text-info">
  <?php
	$url = 'http://spatel.club/assignment/login.php';
	echo "<a href='$url'>Logout</a>";
	?>
  </h6>
  </div>
  <h5 class="text-info"><span id='display'></span></h3>
</div>
<form id="form" action="#" method="post">
<div class="table-responsive"> 
<table border="2" class="table table-striped">
<th class="text-info">SLIDE SHOW</th>
<th class="text-info">DOWNLOAD</th>
<th class="text-info">UPLOAD</th>	
<th class="text-info">DOWNLOAD SELECTED ALBUMS</th>
<th class="text-info">UPLOAD SELECTED ALBUMS TO DRIVE</th>
<?php
try{
	if(isset($_GET['done'])){
		if($_GET['done']==1){
			echo "<script>alert('Album Uploaded!!');</script>";
		}elseif($_GET['done']==0){
			echo "<script>alert('Error Occurred!!Please Try after logging out of your account!!');</script>";
		}
	}
	ini_set('max_execution_time', 600);
	$response=$fb->get("/me?fields=albums",$accessToken);
	$obj = $response->getGraphObject();
	$album =  $obj->getProperty("albums");
	$i=0;
	foreach($album as $data){
	$full='image/'.$user_id.'/'.$data->getProperty('name');
?>
<tr>
<td class="text-center">Click <a href="do_slide.php?album_id=<?php echo $data->getProperty('id');?>"><?php echo $data->getProperty('name');?></a> to start slide  show</td>
<td class="text-center">Download <a href="#" onClick="download_one('<?php echo $data->getProperty('id');?>','<?php echo $data->getProperty('name');?>')"><?php echo $data->getProperty('name');?></a> Album</td>
<td class="text-center">Upload<a href="store.php?name=<?php echo 'image/'.$user_id.'/'.$data->getProperty('name')?>"> <?php echo $data->getProperty('name');?></a> Album</td>
<td class="text-center"><input type="checkbox" name="field1" value="<?php echo $data->getProperty('name');?>" id="<?php echo $data->getProperty('id');?>"/></td>
<td class="text-center"><input type="checkbox" name="field2" value="<?php echo $full;?>" id="<?php echo $data->getProperty('id');?>"/></td>
</tr>
<?php
	$i++;
	}
	}catch(Exception $e){
			header("location:fb-callback.php");
			exit();
	}
?>
<tr>
<td></td>
<td></td>
<td></td>
<td><input type="button" onClick="dw_js()" value="Download all selected albums" class="btn btn-info"/></td>
<td><input type="button" onClick="upload()" value="Upload all selected albums" class="btn btn-info"/></td>
</tr>
</table>
</div>
<div class="text-center"><input type="button" onClick="download_all()" value="Download all albums" class="btn btn-info"/>
<input type="button" onClick="upload_all()" value="Upload all albums" class="btn btn-info"/></div>
</form>
</body>
</html>