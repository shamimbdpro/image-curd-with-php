<?php
 require_once('config.php');

   $id=$_GET['shamim'];
 
 
$sql = "SELECT * FROM user";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);     
$sql = "DELETE FROM user WHERE user_id=$id";
if (mysqli_query($conn, $sql)) {
     $image=$row['image'];
	unlink($image);
    echo "Record deleted successfully";
	header('Location:index.php');
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
 
 ?>