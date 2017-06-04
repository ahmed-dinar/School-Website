<?php
include 'includes/core.php';
include('database/connect.php');

if(isset($_REQUEST['id'])){
    $id=$_REQUEST['id'];
}
else{
    $id=0;
}

if(isset($_REQUEST['t_id'])){
    $get_t_id=$_REQUEST['t_id'];
}
else{
    header('location:teacher_stuff.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php $active_nav="administration"; $page_title = "Profile"; include 'includes/head.php' ?>

    <style>
        .tbl1{
            width:35%;
        }
        .tbl1 tr{
        }
        .tbl1 tr td{
            font-size:20px;
            padding:12px;
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<!------------Content Section (Add Your Code From Here)------------>

<div class="profile">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="profileBody" style="border:2px solid #E5E5E5;">
                    <?php
                    $test=0;
                    $getTeacherQry=mysql_query("select * from administration where t_id='$get_t_id'");
                    while($get=mysql_fetch_array($getTeacherQry)){
                        $name=$get['t_name'];
                        $designation=$get['position'];
                        $qualification=$get['t_qualification'];
                        $img=$get['t_img'];
                        $subject=$get['subject'];
                        $phn=$get['t_phn'];
                        $email=$get['t_mail'];
                        $address=$get['address'];
                        $about=$get['about'];
                        $get_id=$get['t_id'];
                        $test++;
                    }
                    ?>
                    <h3 style="border-bottom:3px solid #5C4283; padding:10px;color:green">Personal Profile</h3>
                    <div class="profileHead">
                        <div style="float:left;"><img src="img_administration/<?php echo $img;?>" width="180" height="180"></div>
                        <div style="padding-top:25px;padding-left:200px">
                            <h3><b><?php echo $name;?></b></h3>
                            <h4><?php echo $designation;?></h4>
                            <h4><b>Basundia School & College</b></h4>
                        </div>
                    </div>
                    <div class="profileTbl" style="margin-top:50px">
                        <table class="tbl1">
                            <tr>
                                <td>Address :</td>&nbsp
                                <td><?php echo $address;?></td>
                            </tr>
                            <tr>
                                <td>Qualification :</td>&nbsp
                                <td><?php echo $qualification;?></td>
                            </tr>
                            <tr>
                                <td>Contact No. :</td>&nbsp
                                <td><?php echo $phn;?></td>
                            </tr>
                            <tr>
                                <td>Email :</td>&nbsp
                                <td><?php echo $email;?></td>
                            </tr>
                            <tr>
                                <td>About :</td>&nbsp
                                <td><p><?php echo $about;?></p></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'  ?>


</body>
</html>