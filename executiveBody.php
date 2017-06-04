<?php
include 'includes/core.php';
include('database/connect.php');


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

    <?php  $active_nav="administration";  $page_title = "Executive Members"; include 'includes/head.php' ?>

    <link href="css/animate.css" rel="stylesheet">
    <script src="js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>

</head>
<body>

<?php include 'includes/header.php'; ?>

<!------------Content Section (Add Your Code From Here)------------>
<div class="container">

    <div class="stuffShow">
        <h4 style="background-color:#5C4283;color:#FFFFFF;height:auto;padding:8px;text-align:center;">All Executive Members</h4>
        <?php
        $test=0;
        $getTeacherQry=mysql_query("select * from administration where position2='E' order by t_designation asc");
        while($get=mysql_fetch_array($getTeacherQry)){
            $name=$get['t_name'];
            $designation=$get['position'];
            $img=$get['t_img'];
            $phone=$get['t_phn'];
            $get_id=$get['t_id'];
            $test++;
            ?>

            <div class="row">
                <div class="col-md-6">
                    <div style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInLeft;border:3px solid #F0F0F0;height:155px;" class="services wow fadeInLeft" data-wow-delay=".2s">
                        <div class="img_sec" style="float:left;">
                            <img src="img_administration/<?php echo $img;?>" width="150px" height="150px" class="thumbnail"/>
                        </div>
                        <div class="name_sec" style="padding-left:170px;padding-top:8px;">
                            <h4><b><a href="biography.php?t_id=<?php echo $get_id;?>"><?php echo $name;?></a></b></h4>
                            <p><?php echo $designation;?></p>
                            <p><?php echo $phone;?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>

</div>

<?php include 'includes/footer.php'  ?>


</body>
</html>