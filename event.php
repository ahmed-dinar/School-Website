<?php
include 'includes/core.php';
include('database/connect.php');

if(isset($_REQUEST['event_id'])){
    $get_event_id=$_REQUEST['event_id'];
}
else{
    $id=0;
}
$post_date=date('d-m-Y');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head.php'; ?>
</head>
<body>

<?php include 'includes/header.php'; ?>

<!------------Content Section (Add Your Code From Here)------------>

<div class="showNotice">
    <div class="container">
        <div class="col-md-8">
            <?php
            $eventQry=mysql_query("select * from events where id='$get_event_id'");
            while($getVal=mysql_fetch_array($eventQry)){
                //$getFile=$getVal['file_name'];
                $getEventTitle=$getVal['event_title'];
                $getEvent=$getVal['event'];
                $getDate=$getVal['post_date'];
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo $getEventTitle;?> </div>
                <div class="panel-body" style="text-align:justify"><?php echo $getDate; echo '<p style=\"text-align:justify\">'.$getEvent.'<p>';?></div>
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

<?php include 'includes/footer.php'; ?>
</body>
</html>