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

    <?php $active_nav="result"; $page_title = "HSC Result"; include 'includes/head.php' ?>

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
            $getHSCResultQry=mysql_query("select * from result_public where exam_name='HSC' order by result_year desc,exam_priority asc");
            while($get=mysql_fetch_array($getHSCResultQry)){
                $examName=$get['exam_name'];
                $group=$get['group'];
                $result_year=$get['result_year'];
                $resultFile=$get['file_name'];
                $get_id=$get['id'];
                $test++;
                if($test==1){
                    $tempYear=$result_year;
                }
                ?>
                <?php if($test==1){?>
                    <h4 class="head-title">HSC Result of <?php echo $result_year;?></h4>
                <?php } if($result_year==$tempYear-1){?>
                    <h4 class="head-title">HSC Result of <?php echo $result_year;?></h4>
                    <?php $tempYear=$result_year;}?>
                <div style="border:2px solid #E5E5E5;box-shadow:3px 3px 5px 4px #E5E5E5;">
                    <table width="100%">
                        <tr>
                            <td width="33.33%"><?php echo $group;?></td>
                            <td width="33.33%"><?php echo $examName;?></td>
                            <td width="33.33%"><a href="hscSscResultView.php?result_id=<?php echo $get_id;?>" target="_blank">View Result</a></td>
                        </tr>
                    </table>
                </div>

            <?php }?>  <!---------End While------------>
        </div>
        <!---------- <div class="col-md-3"></div>  ----------->
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