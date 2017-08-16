<!DOCTYPE html>
<html>
<title>Slide Show</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="lib/style.css">
<body>
<h2 class="w3-center">
<?php 
try{
ini_set('max_execution_time', 600);
include 'basic.php';
?>
<p class="text-info"><?php echo "Welcome,".$user_name;?></p>
<div class="w3-content w3-display-container">
<?php
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
	<img class="mySlides" src=<?php echo $image[$i]?> style="width:100%" class="img-responsive">
<?php
	}
}else{
	echo "no";
}
}catch(Exception $e){
	header("location:fb-callback.php");
}
?>
<button class="prev" onclick="plusDivs(-1)">&#10094;</button>
<button class="next" onclick="plusDivs(1)">&#10095;</button>
</div>
<script>
//This script is used to display slideshow.
var myIndex = 0;
carousel();
function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 4000); // Change image every 2 seconds
}
var slideIndex = 1;
function plusDivs(n) {
    showDivs(slideIndex += n);
}

function showDivs(n) {
    var i;
    var x = document.getElementsByClassName("mySlides");
    if (n > x.length) {slideIndex = 1} 
    if (n < 1) {slideIndex = x.length} ;
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none"; 
    }
    x[slideIndex-1].style.display = "block"; 
}
</script>
</body>
</html>