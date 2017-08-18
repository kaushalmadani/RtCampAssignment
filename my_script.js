<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
	function upload_one(val){
		window.location.assign(val);
	}
	function download_one(id,id1){
			toggleLoading(true);
			jQuery.noConflict();
			jQuery.ajax({
				url: "download_all.php",
				method: 'POST',
				data: {album_id:id,album_name:id1},
				success: function(response){
					toggleLoading(false);
					console.log(response);
					document.getElementById('display').innerHTML=response;
				},
				error: function(error){
					toggleLoading(false);
					console.log("Something went wrong..."+error);
					window.location.assign('fb-callback.php?done=0');
				}
			});
	}
	function toggleLoading(loader){
		if(loader == true){
			jQuery('#loading').css('display','block');
		}else if(loader == false){
			jQuery('#loading').css('display','none');
		}
	}
	function dw_js(){
		var id=[];
		var name=[];
		var checkboxes = document.getElementsByName('field1');
		for (var i=0; i<checkboxes.length; i++) {
			if (checkboxes[i].checked==true) {
				id.push(checkboxes[i].id);
				name.push(checkboxes[i].value);
			}
		}
		if(id.length>0){
			toggleLoading(true);
			jQuery.noConflict();
			jQuery.ajax({
				url: "download_all.php",
				method: 'POST',
				data: {album_id:id.join(),album_name:name.join()},
				success: function(response){
					toggleLoading(false);
					console.log(response);
					document.getElementById('display').innerHTML=response;
				},
				error: function(error){
					toggleLoading(false);
					console.log("Something went wrong..."+error);
					window.location.assign('fb-callback.php?done=0');
				}
			});
		}else{
			alert("Please select atlease one album");
		}
	}
	function download_all(){
		toggleLoading(true);
		var id=[];
		var name=[];
		var checkboxes = document.getElementsByName('field1');
		for (var i=0; i<checkboxes.length; i++) {
			id.push(checkboxes[i].id);
			name.push(checkboxes[i].value);
		}
		if(id.length>0){
			toggleLoading(true);
			jQuery.ajax({
				url: "download_all.php",
				method: 'POST',
				data: {album_id:id.join(),album_name:name.join()},
				success: function(response){
					toggleLoading(false);
					console.log(response);
					document.getElementById('display').innerHTML=response;
				},
				error: function(error){
					toggleLoading(false);
					window.location.assign('fb-callback.php?done=0');
					console.log("Something went wrong..."+error);
				}
			});
		}else{
			alert("Please select atlease one album");
		}
		
	}
	function upload(){
		var id=[];
		var name=[];
		var checkboxes = document.getElementsByName('field2');
		for (var i=0; i<checkboxes.length; i++) {
			if (checkboxes[i].checked==true) {
				id.push(checkboxes[i].id);
				name.push(checkboxes[i].value);
			}
		}
		if(id.length>0){
			window.location.assign('store.php?album_id='+id+'&name='+name+'');
		}else{
			alert("Please select atlease one album");
		}
	}
	function upload_all(){
		var id=[];
		var name=[];
		var checkboxes = document.getElementsByName('field2');
		for (var i=0; i<checkboxes.length; i++) {
				id.push(checkboxes[i].id);
				name.push(checkboxes[i].value);
		}
		if(id.length>0){
			window.location.assign('store.php?album_id='+id+'&name='+name+'');
		}else{
			alert("Please select atlease one album");
		}
	}
</script>
