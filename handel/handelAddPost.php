<?php
require_once '../inc/conn.php';

if(isset($_POST['submit'])){
    
    //catch 
    $title=trim(htmlspecialchars($_POST['title']));
    $body=trim(htmlspecialchars($_POST['body']));

     //validation
     $errors=[];
     //title
     if(empty($title)){
         $errors[]="title is requerd";
     }elseif(is_numeric($title)){
         $errors[]="title must be string";  
     }
     //body
     if(empty($body)){
         $errors[]="body is requerd";
     }elseif(is_numeric($body)){
         $errors[]="body must be string";  
     }
 
//validationلو دخل صورة هعمل ال 
    if(isset($_FILES['image'])&& $_FILES['image']['name']){
        $image=    $_FILES['image'];
        $tmp_name=$image['tmp_name'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $size= $image['size']/(1024*1024);
        $error=$image['error'];


    
    if($imag['error']!=0){
        $errors[]="image not exist";
    }elseif($size>1){
        $errors[]="image is too large";
    }elseif(!in_array($ext,["png","gif","jpg", "jpeg"])){
        $errors[]="image ext ";
    }
        $newName=uniqid().".".$ext;
    }else{
        $newName=null;
    }
    if(empty($errors)){
        $id=$_SESSION['user_id'];
        //insert
        $query="insert into posts(`title`,`body`,`image`,`user_id`) values('$title','$body','$newName','$id')";
        $result= mysqli_query($conn,$query);
    if($result){
         if(isset($_FILES['image'])&& $_FILES['image']['name']){
                move_uploaded_file($tmp_name,"../assets/images/postImage/$newName");
            }
             $_SESSION['success']="user inserted succesfuly";
            //  $num_pages=$_SESSION["num_pages"];
            //?page=$num_pages
            header("location:../index.php?page=1");

        }else{
            $_SESSION['errors']=['error while insert'];
        }
    }else{
        $_SESSION['errors']=$errors;
        header("location:../addPost.php");
    
    }
}else{
    header("location:../addPost.php");

}



?>