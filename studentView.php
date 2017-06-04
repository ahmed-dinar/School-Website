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

// get Student Class id................
if(isset($_REQUEST['s_id'])){
    $get_s_id=$_REQUEST['s_id'];
}
else{
    header('location:index.php');
}

$qryStudeentSqarch=mysql_query("select file from student where id='$get_s_id'");
while($getFile=mysql_fetch_array($qryStudeentSqarch)){
    $sFile=$getFile['file'];
}
if(!empty($sFile)){
    $file='student/'.$sFile;
    $filename=$sFile;
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

<?php include 'includes/header.php'; ?>
<?php include 'includes/footer.php'; ?>
</body>
</html>