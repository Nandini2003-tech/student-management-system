<?php
 include('1-auth.php');
 include('3-config.php');

 $id =$_GET['id'];
 
//  file get query
 $fileQuery ="select file from students2 where id='$id'";
 $getFileData =  mysqli_query($conn, $fileQuery);
 $row = mysqli_fetch_assoc($getFileData);
//  file delete
 if(file_exists($row['file'])){
    unlink($row['file']);
}

 $query = "delete  from students2 where id ='$id'";
 $data= mysqli_query($conn, $query);

 if($data){
    header("Location:6-display-student.php?msg=delete");
    exit();
 }else{
    echo "Failed to delete";
 }
?>