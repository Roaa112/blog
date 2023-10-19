<?php
require_once '../inc/conn.php';

if(isset($_POST['submit'])){ 
    $email=trim(htmlspecialchars($_POST['email']));
    $password=trim(htmlspecialchars($_POST['password']));
    //validation 
    $errors=[];
    //email validation (requerd, email ,100)
    if(empty($_POST['email'])){
       $errors[]="email is requerd";

    }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
       $errors[]="you must write email form";  
    }elseif(strlen($email)>=100){
       $errors[]="email must be less than 100"; 
    }
    //pasword
   if(empty($_POST['password'])){
       $errors[]="password is requerd";
   }elseif(! is_string($_POST['password'])){
       $errors[]="you must write pass form";  
   }elseif(strlen($password)<6){
       $errors[]="password must be less than 100"; 
    }
    if(empty($errors)){
        $query="select * from users where `email`='$email'";
        $result= mysqli_query($conn,$query);
        if(mysqli_num_rows($result)==1){
            //كدا اتاكدت ان في شخص عندة الايميل دة ناقص اتاكد من ال باسورد
            $row = mysqli_fetch_assoc($result);
            $oldpassword = $row['password'];
            $name = $row['name'];
            $user_id = $row['id'];

            //لا تستخدم غير مرة واحدة mysqli_fetch_assocهنا عملت مشكلة ان 

           if( password_verify($password,$oldpassword)){
            $_SESSION['success']="welcome ".$name;
            $_SESSION['user_id']=$user_id;
            header("location:../index.php?page=1");
           
           }else{
            $_SESSION['errors']=["email or pass isnot currect"];
            header("location:../Login.php");
           }
        }else{
            $_SESSION['errors']=["this account not exist"];
            header("location:../Login.php");
        }
        
      }else{
        $_SESSION['errors']=$errors;
        header("location:../Login.php");
      }

}else{
    header("location:../Login.php");
    
}

?>