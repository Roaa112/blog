<?php
require_once '../inc/conn.php';
if(isset($_POST['submit'])&&(!empty($_GET['id']))){
    $id=$_GET['id'];
    $query="select * from posts where id=$id";
    $result=mysqli_query($conn,$query);
    $old_image=mysqli_fetch_assoc($result)['image'];
    if(mysqli_num_rows($result)==1){
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
    }
    else{
        $newName=$old_image;
    }

    if(empty($errors)){

        $query="update posts set `title`='$title',`body`='$body',`image`='$newName',`user_id`='1' where id=$id";
        $result= mysqli_query($conn,$query);
        if($result){

            if(isset($_FILES['image'])&& $_FILES['image']['name']){
                unlink("../assets/images/postImage/$old_image");
                move_uploaded_file($tmp_name,"../assets/images/postImage/$newName");
            }
            $_SESSION['success']="post updated successfuly";
            header("location:../viewPost.php?id=$id");
        }else{
            $_SESSION['errors']=["error while update"];
            header("location:../editPost.php?id=$id");
        }
    }else {
        $_SESSION['errors']=$errors;
        header("location:../editPost.php?id=$id");
    }

    }else{
        $_SESSION['errors']=["this post is not exist"];
        header("location:../index.php");
    }
}else{
    header("location:../index.php");
}



?>