<?php
require_once '../inc/conn.php';
if(isset($_SESSION['user_id'])){

if(isset($_GET['id'])){
    $id=$_GET['id'];

    $query="select * from posts where id=$id";
    $result=mysqli_query($conn,$query);


    if(mysqli_num_rows($result)==1){
        $old_image=mysqli_fetch_assoc($result)['image'];
        if(!empty($old_image)){
        unlink("../assets/images/postImage/$old_image");
        }
        $query ="delete from posts where id=$id";
        $result=mysqli_query($conn,$query);

        if($result){
            
            $_SESSION['success']="post deleted successfuly";
            header("location:../index.php");
        }else{
            $_SESSION['errors']=["error while delete"];
            header("location:../index.php");
        }


    }else{
        $_SESSION['errors']=["there is no post with this is id"];
        header("location:../index.php");
    }

}else{
    header("location:../index.php.php");
}

}else{
    header("location:../Login.php");
}


?>