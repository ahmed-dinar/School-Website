<?php
include('database/connect.php');
?>

<?php
if(isset($_REQUEST['notice_id'])){
    $get_notice_id=$_REQUEST['notice_id'];
}
else{
    $get_notice_id=0;
}
$post_date=date('d-m-Y');
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php $active_nav="notice"; $page_title = "Notice"; include 'includes/head.php' ?>

</head>
<body>

<?php include 'includes/header.php'; ?>

<!------------Content Section (Add Your Code From Here)------------>

<div class="showNotice">
    <div class="container">
        <div class="col-md-8">
            <?php
            $noticeQry=mysql_query("select * from noticeboard where id='$get_notice_id'");
            $getFile = null;
            $getNoticeTitle = null;
            $getNotice = null;
            $getDate = null;
            while($getVal=mysql_fetch_array($noticeQry)){
                $getFile=$getVal['file_name'];
                $getNoticeTitle=$getVal['notice_title'];
                $getNotice=$getVal['notice'];
                $getDate=$getVal['post_date'];
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo $getNoticeTitle;?> </div>
                <div class="panel-body" style="text-align:justify"><?php echo $getDate; echo '<p style=\"text-align:justify\">'.$getNotice.'<p>';?></div>
            </div>
            <?php
            if(!empty($getFile)){
                $file='post_files/'.$getFile;
                $filename=$getFile;
                header('Content-type: application/pdf');
                header('Content-Disposition: inline; filename="'.$filename.'"');
                header('Content-Transfer-Encoding: binary');
                header('Accept-Range: bytes');
                @readfile($file);
            }
            ?>
        </div>
        <div class="col-md-4"></div>
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