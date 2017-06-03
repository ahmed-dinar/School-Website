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
$post_date=date("d-m-Y");
?>

<?php
if(isset($_POST['submitNotice'])){
    try{
        if(empty($_POST['noticeTitle'])){
            throw new Exception("Please Input your Notice Title");
        }

        if(empty($_POST['noticeDes'])){
            throw new Exception("Please Input your Notice Description");
        }


        $uploaded_file=$_FILES['noticeFile']['name'];
        $file_basename=substr($uploaded_file, 0,strripos($uploaded_file, '.'));
        if(empty($file_basename)){
            $insertNoticeQry=mysql_query("insert into noticeboard (post_date,notice_title,notice) values('$post_date','$_POST[noticeTitle]','$_POST[noticeDes]')");
        }else{
            $file_extension=substr($uploaded_file, strripos($uploaded_file, '.'));

            $statement=$db->prepare("SHOW TABLE STATUS LIKE 'noticeboard'");
            $statement->execute();
            $result=$statement->fetchAll();
            foreach($result as $row)
                $new_id=$row[10];

            $f1=$new_id.$file_extension;
            move_uploaded_file($_FILES['noticeFile']['tmp_name'], 'post_files/'.$f1);
            $insertNoticeQry=mysql_query("insert into noticeboard (post_date,notice_title,notice,file_name) values('$post_date','$_POST[noticeTitle]','$_POST[noticeDes]','$f1')");
        }
    }
    catch(Exception $e){
        $errorNotice=$e->getMessage();
    }
}


if(isset($_POST['submitEvent'])){
    try{
        if(empty($_POST['eventTitle'])){
            throw new Exception("Please Input your Event Title");
        }

        if(empty($_POST['eventDes'])){
            throw new Exception("Please Input your Event Description");
        }
        $insertNoticeQry=mysql_query("insert into events (post_date,event_title,event) values('$post_date','$_POST[eventTitle]','$_POST[eventDes]')");
    }
    catch(Exception $e){
        $errorEvent=$e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $page_title = "Notice & Event Control"; include 'includes/head.php' ?>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-2">
            <?php $adminNav='notice'; include 'includes/admin_side_menu.php' ?>
        </div>
        <div class="col-md-5">
            <h4 class="head-title">Add New Notice</h4>
            <form method="post" action="" enctype="multipart/form-data">
                <p>Type Notice Title: (Use Bangla or English, Within ten words will be bettre)</p>
                <textarea rows="2" cols="50" name="noticeTitle"></textarea><br><br>
                <p>Notice Description: (Use Bangla or English)</p>
                <textarea rows="6" cols="50" name="noticeDes"></textarea><br><br>

                <table style="">
                    <tr>
                        <td>Choose a file (file must be .pdf,.jpg,.png) :</td>
                        <td><input type="file" name="noticeFile"></td>
                    </tr>

                    <tr>
                        <td><input type="submit" name="submitNotice" value="Add Notice"></td>
                        <td></td>
                    </tr>
                </table>

            </form>
        </div>

        <div class="col-md-5">
            <h4 class="head-title">Add New Event</h4>
            <form method="post" action="">
                <p>Type Event Title: (Use Bangla or English, Within ten words will be bettre)</p>
                <textarea rows="2" cols="50" name="eventTitle"></textarea><br><br>
                <p>Event Description: (Use Bangla or English)</p>
                <textarea rows="6" cols="50" name="eventDes"></textarea><br>
                <input type="submit" name="submitEvent" value="Add Event">
            </form>
        </div>
    </div>
</div>


<?php include 'includes/footer.php'  ?>


</body>
</html>