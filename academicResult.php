<?php
include 'includes/core.php';
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
    <?php $active_nav="result"; include 'includes/head.php'; ?>

    <style>
        table tr td{
            margin-top:8px;
            font-size:20px;
            text-align:center;
        }
    </style>

</head>
<body>
<?php include 'includes/header.php'; ?>

<!------------Content Section (Add Your Code From Here)------------>

<div class="container">
    <div class="row">
        <!----------<div class="col-md-3"></div> ------->
        <div class="col-md-12">
            <?php
            $test=0;
            $tempYear=0;
            $getAcademicResultQry=mysql_query("select * from local_result order by result_year desc,id desc");
            while($get=mysql_fetch_array($getAcademicResultQry)){
                $className=$get['class'];
                $title=$get['title'];
                $resultFile=$get['file'];
                $result_year=$get['result_year'];
                $publish_date=$get['publish_date'];
                $get_id=$get['id'];
                $test++;
                if($test==1){
                    $tempYear=$result_year;
                }
                ?>
                <?php if($test==1){?>
                    <h4 style="background-color:#5C4283;color:#FFFFFF;height:30px;padding-top:3px;text-align:center;">Academic Result of <?php echo $result_year;?></h4>
                <?php } if($result_year==$tempYear-1){?>
                    <h4 style="background-color:#5C4283;color:#FFFFFF;height:30px;padding-top:3px;text-align:center;margin-top:15px;">Academic Result of <?php echo $result_year;?></h4>
                    <?php $tempYear=$result_year;}?>
                <div style="border:2px solid #E5E5E5;box-shadow:3px 3px 5px 4px #E5E5E5;">
                    <table width="100%">
                        <tr>
                            <td width="25%"><?php echo $title;?></td>
                            <td width="25%"><?php echo $className;?></td>
                            <td width="25%"><?php echo $publish_date;?></td>
                            <td width="25%"><a href="academicResultView.php?result_id=<?php echo $get_id;?>" target="_blank">View Result</a></td>
                        </tr>
                    </table>
                </div>

            <?php }?>  <!---------End While------------>
        </div>
        <!---------- <div class="col-md-3"></div>  ----------->
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>