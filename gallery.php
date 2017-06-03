<?php
include('database/connect.php');
?>

<?php
if(isset($_REQUEST['id'])){
    $id=$_REQUEST['id'];
}
else{
    $id=0;
}
$post_date=date('d-m-Y');
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php $active_nav="gallery"; $page_title = "Photo Gallery"; include 'includes/head.php' ?>

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/lightbox.css" rel="stylesheet">

    <script src="js/wow.min.js"></script>
    <script src="js/min.js"></script>
    <script src="js/lightbox.min.js"></script>

</head>
<body>

<?php include 'includes/header.php'; ?>

<!------------Content Section (Add Your Code From Here)------------>

<div class="container">
    <div class="myGallery">
        <?php
        $test=0;
        $img=mysql_query("select * from gallery order by id desc");
        while($getImg=mysql_fetch_array($img)){
            $n=$getImg['img_file'];
            $test++;
            ?>

            <?php if($test==1){ ?>
                <div class="row">
                <div class="col-md-4">
                    <a href="gallery/<?php echo $n;?>" data-lightbox="vacation">
                        <img src="gallery/<?php echo $n;?>" width="353px" height="250px"  class="thumbnail"/>
                    </a>
                </div>
            <?php } else if($test==2){ ?>
                <div class="col-md-4">
                    <a href="gallery/<?php echo $n;?>" data-lightbox="Vacation">
                        <img src="gallery/<?php echo $n;?>" width="353px" height="250px" class="thumbnail"/>
                    </a>
                </div>
            <?php } else if($test==3){ ?>
                <div class="col-md-4">
                    <a href="gallery/<?php echo $n;?>" data-lightbox="Vacation">
                        <img src="gallery/<?php echo $n; $test=0; ?>" width="353px" height="250px" class="thumbnail"/>
                    </a>
                </div>
                </div>
            <?php } ?>

            <?php
        }  // end of while
        ?>

    </div>
</div>

<?php include 'includes/footer.php'  ?>


</body>
</html>