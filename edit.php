<?php
 require_once('config.php');
    $id=$_GET['edit'];
   $sql = "SELECT * FROM user WHERE user_id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);


 // create destinaton folder
if(!file_exists('upload')){
 mkdir('upload');
}

if( $_SERVER['REQUEST_METHOD'] == 'POST') {
   $max_upload= 2000000;
   $name=mysqli_real_escape_string($conn,$_POST['name']);
   $file=$_FILES['file'];
   $user_image=$_FILES['file']['name'];
   $img_size=$_FILES['file']['size'];
   $img_type=$_FILES['file']['type'];
   $img_format=array('jpg','png','gif','jpeg');
   $temp_name=$file['tmp_name'];
   $img_destination='upload/'.'User_'.uniqid().$user_image;
    $image_name=strtolower($img_destination);
   $getextension=explode('.', $user_image);
   // get last extension like .jpg or .png or .gif
   $latsextension=(end($getextension));
   if(!empty($user_image)){
	   if(in_array($latsextension, $img_format)==false){
		 echo "image format is invalid";
	   }elseif($img_size>$max_upload){
		  echo "Please upload image within 2M";
	   }else{
		 $sql = "UPDATE user SET name='$name',image='$image_name' WHERE user_id=$id";
		 mysqli_query($conn, $sql);
		 $image=$row['image'];
		 unlink($image);
		 move_uploaded_file($temp_name, $image_name);
		 header('Location:');
		}
   }else{
	   $sql = "UPDATE user SET name='$name' WHERE user_id=$id";
		 mysqli_query($conn, $sql);
		 header('Location:'); 
   }
  }
  

?>
<form action="" method="post" enctype="multipart/form-data">

  <input type="text" name="name" value="<?php echo $row['name'];?>"/>
  <br />
  <input type="file" name="file" value="<?php echo $row['image'];?>"/> <br />
   <img width="150" src="<?php echo $row['image'];?>" alt="img" /> <br />
   <input type="submit" value="update">
  
</form>

