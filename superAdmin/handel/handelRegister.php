<?php
require_once '../../inc/conn.php';

if(isset($_POST['submit'])){
    //catch
    $name=trim(htmlspecialchars($_POST['name']));
    $email=trim(htmlspecialchars($_POST['email']));
    $password=trim(htmlspecialchars($_POST['password']));
    $phone = trim(htmlspecialchars($_POST['phone']));
  
//validation 
    $errors=[];
    //name
if(empty($_POST['name'])){
    $errors[]="name is requerd";

}elseif(!is_string($_POST['name'])){
    $errors[]="name must be string";  
}elseif(strlen($name)>=100){
    $errors[]="name must be less than 100"; 
}
//email validation (requerd, email ,100)
if(empty($_POST['email'])){
    $errors[]="email is requerd";

}elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $errors[]="you must write email form";  
}elseif(strlen($email)>=100){
    $errors[]="email must be less than 100"; 
}else {
    // Check if email already exists in the database
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Email already exists";
    }
}
//pasword
if(empty($_POST['password'])){
    $errors[]="password is requerd";

}elseif(! is_string($_POST['password'])){
    $errors[]="you must write pass form";  
}elseif(strlen($password)<6){
    $errors[]="password must be less than 100"; 
}
 // phone
 if (empty($_POST['phone'])) {
    $errors[] = "phone is required";
  } elseif (!ctype_digit($_POST['phone'])) {
    $errors[] = "phone must be numeric";
  } elseif (!preg_match('/^\d{8,15}$/', $phone)) {
    $errors[] = "phone must be between 8 and 15 digits";
  }
  //hash password
  $passwordHashed=password_hash($password,PASSWORD_DEFAULT);
  if(empty($errors)){
    $query = "INSERT INTO users (`name`, `email`, `password`, `phone`) VALUES ('$name', '$email', '$passwordHashed', '$phone')";
    $result= mysqli_query($conn,$query);

    if($result){
        header("location:../../Login.php");
    }else{
        $_SESSION['errors']=["error while insert data"];
        header("location:../redister.php");
    }
  }else{
    $_SESSION['errors']=$errors;
    header("location:../register.php"); 
  }

}else{
    header("location:../register.php");
    
}

?>