<?php
 require_once('config.php');
 
 // create destinaton folder
if(!file_exists('upload')){
 mkdir('upload');
}

if(isset($_FILES['file'])){
   $max_upload= 2000000;
   $name=html_entity_decode($_POST['name']);
   $file=$_FILES['file'];
   $user_image=$_FILES['file']['name'];
   $img_size=$_FILES['file']['size'];
   $img_type=$_FILES['file']['type'];
   $img_format=array('jpg','png','gif','jpeg');
   $temp_name=$file['tmp_name'];
   $img_destination='upload/'.'User_'.uniqid().$user_image;
   $getextension=explode('.', $user_image);
    /* make lowercase name */
    $image_name=strtolower($img_destination);
   // get last extension like .jpg or .png or .gif
   $latsextension=(end($getextension));
   // check extension
   if(in_array($latsextension, $img_format)==false){
     echo "image format is invalid";
   }elseif($img_size>$max_upload){
      echo "Please upload image within 2M";
   }else{
	   
  	 move_uploaded_file($temp_name, $image_name);
	  $sql = "INSERT INTO user(name,image)
     VALUES ('$name','$image_name')";
     $insert=mysqli_query($conn, $sql);
	 if(isset($insert)){
		 echo "Image inserted Successfully";
	 }
    }
  }
  

?>
<form action="" method="post" enctype="multipart/form-data">
  <input type="text" name="name"  placeholder="Enter your name"/> <br />
  <input type="file" name="file" />
   <input type="submit" value="upload">
</form>






<?php 
 $sql = "SELECT * FROM user";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	?>
    <table border="1" cellpadding ="30">  
		     <tr> 
			   <td>Id</td>
			   <td>image</td>
			   <td>Action</td>
			 </tr>
			 <?php
    while($row = mysqli_fetch_assoc($result)) {
       ?>
          
			 <tr> 
			   <td><?php echo $row['user_id']?></td>
			   <td><?php echo $row['name']?></td>
			   <td><img width="100" src="<?php echo $row['image']?>" alt="images" /></td>
			   <td>
			    <a href="edit.php?edit=<?php echo $row['user_id']?>">edit</a>
			    <a href="delete.php?shamim=<?php echo $row['user_id']?>">delete</a>
			   </td>
			 </tr>
		    
	   
	   <?php
	    	
		
    }
	?>
	</table>
	<?php
} else {
    echo "0 results";
}

?>


