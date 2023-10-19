<?php require_once 'inc/conn.php';?> 
<?php require_once 'inc/header.php' ;?>
<!-- Page Content -->
<div class="page-heading products-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="text-content">
          <h4>new Post</h4>
          <h2>add new personal post</h2>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
require_once 'inc/success.php';
require_once 'inc/errors.php';

?>
<?php 

if((empty($_GET['id']))){
  header("location:index.php");
}
$id=$_GET['id'];
$query="select * from posts where id=$id";
$result=mysqli_query($conn,$query);
if(mysqli_num_rows($result)==1){
  $post=mysqli_fetch_assoc($result);
}else{
 $msg="post not found";
}
?>

<div class="best-features about-features">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="section-heading">
          <h2>Our Background</h2>
        </div>
      </div>
     
    
      <!-- علطول col هنا هبدا اكتب قبل -->
<?php if(!empty($post)){?>
      <div class="col-md-6">
        <div class="right-image">
          <img src="assets/images/postImage/<?php echo $post['image'];?>" alt="">
        </div>
      </div>
      <div class="col-md-6">
        <div class="left-content">
          <h4><?php echo $post['title'];?></h4>
          <p><?php echo $post['body'];?></p>
          <p><?php echo $post['created_at'];?></p>
          <div class="d-flex justify-content-center">
              <a href="editPost.php?id=<?php echo $post['id'];?>" class="btn btn-success mr-3 "> edit post</a>
          <!-- هنا لما هعل -->
              <a href="handel/handelDeletePost.php?id=<?php echo $post['id'];?>"  onclick="alert('are you sure')" class="btn btn-danger "> delete post</a>
          </div>
        </div>
      </div>
      <?php }?>
    </div>
  </div>
</div>

<?php require_once 'inc/footer.php' ?>