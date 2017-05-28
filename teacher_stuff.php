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
    <?php $active_nav="administration"; $page_title = "Teachers & Stuff"; include 'includes/head.php' ?>

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
    <div class="showTeacher">
        <h4 style="background-color:#5C4283;color:#FFFFFF;height:auto;padding:8px;text-align:center;">Teachers of Basundia School and College</h4>
        <?php
        $test=0;
        $getTeacherQry=mysql_query("select * from administration where position2='T' order by t_designation asc");
        while($get=mysql_fetch_array($getTeacherQry)){
            $name=$get['t_name'];
            $designation=$get['position'];
            $img=$get['t_img'];
            $subject=$get['subject'];
            $get_id=$get['t_id'];
            $test++;
            ?>

            <?php if($test==1){ ?>
                <div class="row">
                <div class="col-md-6">
                    <div style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInLeft;border:2px solid #E5E5E5;box-shadow:3px 3px 5px 4px #E5E5E5;height:155px" class="services wow fadeInLeft" data-wow-delay=".2s">
                        <div class="img_sec" style="float:left;">
                            <img src="img_administration/<?php echo $img;?>" width="150px" height="150px" class="thumbnail"/>
                        </div>
                        <div class="name_sec" style="padding-left:170px;padding-top:8px;">
                            <h4><b><a href="biography.php?t_id=<?php echo $get_id;?>"><?php echo $name;?></a></b></h4>
                            <p><?php echo $designation;?></p>
                            <p><?php echo $subject;?></p>
                        </div>
                    </div>
                </div>
            <?php } else if($test==2){ ?>
                <div class="col-md-6">
                    <div style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInRight;border:2px solid #E5E5E5;box-shadow:3px 3px 5px 4px #E5E5E5;height:155px" class="services wow fadeInRight" data-wow-delay=".6s">
                        <div class="img_sec" style="float:left;">
                            <img src="img_administration/<?php echo $img;?>" width="150px" height="150px" class="thumbnail"/>
                        </div>
                        <div class="name_sec" style="padding-left:170px;padding-top:8px;">
                            <h4><b><a href="biography.php?t_id=<?php echo $get_id;?>"><?php echo $name;?></a></b></h4>
                            <p><?php echo $designation;$test=0;?></p>
                            <p><?php echo $subject;?></p>
                        </div>
                    </div>
                </div>
                </div>
            <?php }?>
        <?php }?>
    </div>

    <div class="stuffShow">
        <h4 style="background-color:#5C4283;color:#FFFFFF;height:auto;padding:8px;text-align:center;">All Stuff</h4>
        <?php
        $test=0;
        $getTeacherQry=mysql_query("select * from administration where position2='S' order by t_designation asc");
        while($get=mysql_fetch_array($getTeacherQry)){
            $name=$get['t_name'];
            $designation=$get['position'];
            $img=$get['t_img'];
            //$subject=$get['subject'];
            $get_id=$get['t_id'];
            $test++;
            ?>

            <?php if($test==1){ ?>
                <div class="row">
                <div class="col-md-6">
                    <div style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInLeft;border:2px solid #E5E5E5;box-shadow:3px 3px 5px 4px #E5E5E5;height:155px;" class="services wow fadeInLeft" data-wow-delay=".2s">
                        <div class="img_sec" style="float:left;">
                            <img src="img_administration/<?php echo $img;?>" width="150px" height="150px" class="thumbnail"/>
                        </div>
                        <div class="name_sec" style="padding-left:170px;padding-top:8px;">
                            <h4><b><a href="biography.php?t_id=<?php echo $get_id;?>"><?php echo $name;?></a></b></h4>
                            <p><?php echo $designation;?></p>
                        </div>
                    </div>
                </div>
            <?php } else if($test==2){ ?>
                <div class="col-md-6">
                    <div style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInRight;border:2px solid #E5E5E5;box-shadow:3px 3px 5px 4px #E5E5E5;height:155px" class="services wow fadeInRight" data-wow-delay=".6s">
                        <div class="img_sec" style="float:left;">
                            <img src="img_administration/<?php echo $img;?>" width="150px" height="150px" class="thumbnail"/>
                        </div>
                        <div class="name_sec" style="padding-left:170px;padding-top:8px;">
                            <h4><b><a href="biography.php?t_id=<?php echo $get_id;?>"><?php echo $name;?></a></b></h4>
                            <p><?php echo $designation;$test=0;?></p>
                        </div>
                    </div>
                </div>
                </div>
            <?php }?>
        <?php }?>
    </div>


</div>


<?php include 'includes/footer.php'  ?>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/min.js"></script>
<!-----<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  ---->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>