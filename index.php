<?php require_once 'inc/conn.php';?>
<?php require_once 'inc/header.php' ?>
    <!-- Page Content -->
    <!-- Banner Starts Here -->

    <div class="banner header-text">
      <div class="owl-banner owl-carousel">
        <div class="banner-item-01">
          <div class="text-content">
            <!-- <h4>Best Offer</h4> -->
            <!-- <h2>New Arrivals On Sale</h2> -->
          </div>
        </div>
        <div class="banner-item-02">
          <div class="text-content">
            <!-- <h4>Flash Deals</h4> -->
            <!-- <h2>Get your best products</h2> -->
          </div>
        </div>
        <div class="banner-item-03">
          <div class="text-content">
            <!-- <h4>Last Minute</h4> -->
            <!-- <h2>Grab last minute deals</h2> -->
          </div>
        </div>
      </div>
    </div>
    <!-- Banner Ends Here -->
    <?php
    if(isset($_GET['page'])){
      $page=$_GET['page'];
    }else {
      $page=1;
    }

$limit=3;
$offset=($page-1)*$limit;
//number of pages
$query="select count(id) as total from posts ";
$result=mysqli_query($conn,$query);

if(mysqli_num_rows($result)>0){
  $total=mysqli_fetch_assoc($result)['total'];

}
$num_pages=ceil($total/$limit);
// $_SESSION['num_pages']=$num_pages;
if($page>$num_pages ){
  // header("location:index.php?page=1");
  //or ودي الافصل علشان لو غيرت اسم الصفحة
  header("location:".$_SERVER['PHP_SELF']."?page=$num_pages");
}elseif($page<1){
  header("location:".$_SERVER['PHP_SELF']."?page=1");
}

$query="select * from posts order by id limit $limit offset $offset";
$result=mysqli_query($conn,$query);

if(mysqli_num_rows($result)>0){
  $posts=mysqli_fetch_all($result,MYSQLI_ASSOC);

}else{
  $msg="there is no posts to show";
}
?>

    <div class="latest-products">
      <div class="container">
       <?php
       require_once 'inc/success.php';
       ?>
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Latest Posts</h2>
             
            </div>
          </div>
          <!-- علطول col هنا هبدا اكتب قبل -->
          <?php
            if(!empty($posts)):
             foreach($posts as $post):?>
          <div class="col-md-4">
            <div class="product-item">
              <a href="#"><img src="assets/images/postImage/<?php echo $post['image']?>" alt=""></a>
              <div class="down-content">
                <a href="#"><h4><?php echo $post['title']?></h4></a>
                <h6>created_at</h6>
                <p> <?php echo $post['created_at']?></p>
                
                <div class="d-flex justify-content-end">
                  <a href="viewPost.php?id=<?php echo $post['id']?>" class="btn btn-info "> view</a>
                </div>
                
              </div>
            </div>
          </div>
          <!-- هنا هبدا اكتب النهاية -->
          <?php 
          endforeach;
          else:
            echo $msg;
          endif;
          ?>
          
        </div>
      </div>
    </div>
<div class="contener d-flex justify-content-center" >
<nav aria-label="Page navigation example">
  <ul class="pagination">
   
    <li class="page-item <?php if($page==1) echo "disabled"?>">
      <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page=".$page-1 ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <li class="page-item"><a class="page-link" ><?php echo $page ."of".$num_pages?></a></li>

    <li class="page-item <?php if($page==$num_pages) echo "disabled"?>">
      <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page=".$page+1 ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
</div>

 
    
<?php require_once 'inc/footer.php' ?>
