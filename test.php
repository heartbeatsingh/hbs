<?php
   if(isset($_FILES['file'])){
      $errors= array();
      $file_name = $_FILES['file']['name'];
      $file_size =$_FILES['file']['size'];
      $file_tmp =$_FILES['file']['tmp_name'];
      $file_type=$_FILES['file']['type'];
	  
      $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
      
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"images/".$file_name);
         echo "Success";
      }else{
         print_r($errors);
      }
   }
   
   if(isset($_POST['heart']) AND $_POST['heart'] === 'beat'){
	   
	   echo 'hi m here';
   }
?><!DOCTYPE html>
<html>
<head>
	<title>
		Exemple de HTML
	</title>
</head>
<link rel="stylesheet" type="text/css" href="vendor/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/annotate.css">
<body >
<div id="successMsg" style='display:none'><div class="alert alert-success">
  <strong>Success!</strong> Picture has been uploaded successfully.
</div></div>
 <form id="cropimage" action="" method="POST" enctype="multipart/form-data">
	<div class="my-image-selector">
		<input id="file" name="file" type="file" />
	
			
		<input type="submit"  value="upload Image"/>
		
	</div>
	<div style="margin-top:50px">
		<div  id="myCanvas" style="position:relative"></div>
	</div>
	</form>
	<script type="text/javascript" src="vendor/js/jquery.min.js"></script>
	<script type="text/javascript" src="vendor/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="djaodjin-annotate.js"></script>
	<script type="text/javascript" src="scripts/jquery.imgareaselect.pack.js"></script>
	
	<script>
		$(document).ready(function(){
			var counter = 0;
			$('#myCanvas').on("annotate-image-added", function(event, id, path){
				$(".my-image-selector").append("<label><input type=\"radio\" name=\"image-selector\" class=\"annotate-image-select\" value=\"" + path + "\" checked id=\"" + id + "\"><img src=\"" + path + "\" width=\"35\" height=\"35\"></label>");
			});
			$('#myCanvas').annotate({
				color: 'blue',
				bootstrap: true,
				images: ['images/test.jpg']});

			/* $(".push-new-image").click(function(event) {
				if (counter === 0){
					$('#myCanvas').annotate("push", "images/test_2.jpg");
					counter += 1;
				}else{
					$('#myCanvas').annotate("push", {id:"unique_identifier", path:"images/Computer-Wallpaper-HD-Top-Desktop-Wall.jpg"});
				}
			}); */
		//upload image
			function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
					reader.onload = function (e) {
					$('#myCanvas').annotate('push', e.target.result);
					}
					reader.readAsDataURL(input.files[0]);
				}
			}
			$("#file").change(function () {
			readURL(this);
			
			});
			
			
			
			
			$("#btnCopy").on("click",function(){
			var canvas = document.getElementById("baseLayer_myCanvas");
			var dataURL = canvas.toDataURL();
			if(dataURL !== ""){
			$.ajax({
				type:'POST',
				url:'uploadimg.php',
				data:{heart:'beat',
					imgData:dataURL 
				},
					  success: function(data) {
						if(data){
							$("#successMsg").show();
						}
					  }
					})
			}else{
				alert('Image data is empty..');
			}

/* //console.log(dataURL);
var image = new Image();
image.src = dataURL1;
document.body.appendChild(image); */
			});
		});
		
	</script>


<button id="btnCopy">save</button>
</body>
</html>



