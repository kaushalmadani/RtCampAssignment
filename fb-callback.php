<html>	
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <link rel="stylesheet" href="lib/css/style.css">
  <link rel="stylesheet" href="lib/style.css">
</head>
<body>

<div id="loading" style="display:none;">
	<img id="loading-image" src="ajax-loader.gif" alt="Loading..." />
</div>
<div class="responsive">
<div class="header">
<?php
require "my_script.js";
include 'basic.php';
if(!isset($user_name)){
	header("location:fb-callback.php");
}else{
?>
<p class="msg" style="text-align:center;font-family:bold;"><?php echo "Welcome,".$user_name;?></p>
<?php
}
?>
<p id="display" class="msg" style="color:red;text-align:center;font-size:25px"></p>
<div style="width:100%;text-align:center;">
<button class="myButton1" onClick="dw_js()">Download all selected</button>
<button class="myButton1" onClick="upload()">Upload all selected</button>
<button class="myButton1"onClick="download_all()">Download all albums</button>
<button class="myButton1" onClick="upload_all()">Upload all albums</button>
</div>
</div>
</div>
<br>
<?php
try{
	if(isset($_GET['done'])){
		if($_GET['done']==1){
			echo "<script>alert('Album Uploaded!!');</script>";
		}elseif($_GET['done']==0){
			echo "<script>alert('Time out!!Please try again!!');</script>";
		}
	}
	ini_set('max_execution_time', 600);
	$response=$fb->get("/me?fields=albums{id,name,picture}",$accessToken);
	$obj = $response->getGraphObject();
	$album =  $obj->getProperty("albums");
?>
<div class="mar">
	<?php
		$i=0;
		foreach($album as $data){
		$full='image/'.$user_id.'/'.$data->getProperty('name');
	?>
	<div class="responsive">
		<div class="gallery">
			<a href="do_slide.php?album_id=<?php echo $data->getProperty('id');?>">
				<p class="msg"><?php echo "Click to start slide show of <br>".$data->getProperty('name');?></p>
				<img src="<?php echo $data->getProperty('picture')->getProperty('url');?>">
			</a>
			<div class="desc">
				<button type="submit" class="myButton" onClick="download_one('<?php echo $data->getProperty('id');?>','<?php echo $data->getProperty('name');?>')">Download</button>
				<button type="submit" class="myButton" onClick="upload_one('store.php?name=<?php echo 'image/'.$user_id.'/'.$data->getProperty('name')?>')">Upload</button>
				<div style="text-align:center">
				<input type="checkbox" style="margin:10px 32px 0 0;" class="msg" name="field1" value="<?php echo $data->getProperty('name');?>" id="<?php echo $data->getProperty('id');?>">Download</input><br>
				<input type="checkbox" style="margin:10px;" name="field2" value="<?php echo $full;?>" id="<?php echo $data->getProperty('id');?>">Upload to drive</input>
				</div>
			</div>
		</div>
	</div>
	<?php
	$i++;
	}
	}catch(Exception $e){
			header("location:fb-callback.php");
			exit();
	}
?>
</div>
</body>
</html>