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
    <?php $active_nav="student"; $page_title = "Student"; include 'includes/head.php' ?>

    <style>
        table tr td{
            margin-top:0px;
            font-size:20px;
            text-align:center;
        }
        table{
            margin-top:0px;
            padding-top:0px;
        }
    </style>

</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container min-body">
    <div class="row">
        <!----------<div class="col-md-3"></div> ------->
        <div class="col-md-12">

            <div style="border-bottom:3px solid #5C4283;border-left:3px solid #5C4283;border-right:3px solid #5C4283;">
                <h4 style="background-color:#5C4283;color:#FFFFFF;height:30px;margin-top:3px;text-align:center;padding-top:3px;">Students of School Section</h4>

                <?php
                $test=0;
                $getAcademicResultQry=mysql_query("select * from `student` where `section`='S' order by `class` asc");
                if (!$getAcademicResultQry) {
                    //die(mysql_error());
                    die("database error");
                }
                while($get=mysql_fetch_array($getAcademicResultQry)){
                    $className=$get['classString'];
                    $sFile=$get['file'];
                    $ac_year=$get['ac_year'];
                    $get_id=$get['id'];
                    $test++;
                    ?>



                    <div style="border:2px solid #E5E5E5;">
                        <table width="100%">
                            <tr>
                                <td width="33.33%"><?php echo $className;?></td>
                                <td width="33.33%"><?php echo $ac_year;?></td>
                                <td width="33.33%"><a href="studentView.php?s_id=<?php echo $get_id;?>" target="_blank">View Student</a></td>
                            </tr>
                        </table>
                    </div>

                <?php }?>		 <!---------End While------------>
            </div>
        </div>
        <!---------- <div class="col-md-3"></div>  ----------->
    </div>

    <!----------College Section ------->
    <div class="row">
        <!----------<div class="col-md-3"></div> ------->
        <div class="col-md-12">

            <div style="border-bottom:3px solid #5C4283;border-left:3px solid #5C4283;border-right:3px solid #5C4283;margin-top:15px;">
                <h4 style="background-color:#5C4283;color:#FFFFFF;height:30px;margin-top:3px;text-align:center;padding-top:3px;">Students of College Section</h4>

                <?php
                $test=0;
                $getAcademicResultQry=mysql_query("select * from student where section='C' order by class asc");
                if (!$getAcademicResultQry) {
                    //die(mysql_error());
                    die("database error");
                }
                while($get=mysql_fetch_array($getAcademicResultQry)){
                    $className=$get['classString'];
                    $sFile=$get['file'];
                    $ac_year=$get['ac_year'];
                    $get_id=$get['id'];
                    $test++;
                    ?>



                    <div style="border:2px solid #E5E5E5;">
                        <table width="100%">
                            <tr>
                                <td width="33.33%"><?php echo $className;?></td>
                                <td width="33.33%"><?php echo $ac_year;?></td>
                                <td width="33.33%"><a href="studentView.php?s_id=<?php echo $get_id;?>" target="_blank">View Student</a></td>
                            </tr>
                        </table>
                    </div>

                <?php }?>		 <!---------End While------------>
            </div>
        </div>
        <!---------- <div class="col-md-3"></div>  ----------->
    </div>
</div>

<?php include 'includes/footer.php'  ?>

</body>
</html>