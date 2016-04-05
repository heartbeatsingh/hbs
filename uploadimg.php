<?php

   if(isset($_POST['heart']) AND $_POST['heart'] === 'beat'){ 
	   $imgData = $_POST['imgData'];
	   $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imgData));
	   $imgPath = 'uploadnew/new-'.time().'.png';
	   $isUpload = file_put_contents($imgPath,$data);
	   echo ($isUpload) ? true : false;
	   
   }
?>