<?php include "slide_js.js";?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="lib/slide.css">
<body onload="myFunction()">
<h2 style="text-align:center">SLIDESHOW</h2>
</div>
  <div id="myModal" class="modal">
  <span class="close cursor" onclick="closeModal()">&times;</span>
  <div class="modal-content">
<?php
try{
	ini_set('max_execution_time', 600);
	include 'basic.php';
	if(isset($_GET["album_id"])){

	$id=$_GET["album_id"];
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

	for($i=0;$i<count($name);$i++) {
?>
		 <div class="mySlides">
				<div class="numbertext"><?php echo $i+1;?> / <?php echo count($name);?></div>
				<img src="<?php echo $image[$i]?>" style="width:410px;height:410px;">
		</div>
		
<?php
	}
?>	
  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
	<div class="caption-container">
      <p id="caption"></p>
</div>
 </div>
<?php

	for($i=0;$i<count($name);$i++) {
	
?><img class="demo cursor" src="<?php echo $image[$i]?>" style="width:50px;height:50px" onclick="currentSlide(<?php echo $i+1;?>)" alt="<?php echo $name[$i]==""?"Photo":$name[$i];?>">	 
<?php
	}
}else{
	echo "no";
}
}catch(Exception $e){
	header("location:fb-callback.php");
}
?>
 </div>
</div>
</div>
</body>
</html>