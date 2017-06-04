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

// get result id................
if(isset($_REQUEST['result_id'])){
    $get_r_id=$_REQUEST['result_id'];
}
else{
    header('location:index.php');
}

$qryResultSqarch=mysql_query("select file from local_result where id='$get_r_id'");
while($getFile=mysql_fetch_array($qryResultSqarch)){
    $rFile=$getFile['file'];
}
if(!empty($rFile)){
    $file='academic_result/'.$rFile;
    $filename=$rFile;
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="'.$filename.'"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Range: bytes');
    @readfile($file);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head.php'; ?>
</head>
<body>


</body>
</html>