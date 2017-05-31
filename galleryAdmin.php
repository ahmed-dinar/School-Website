<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

//start our session if not already started
if (!session_id()) {
    session_start();
}

include('database/connect.php');

require 'libs/FlashMessages.php';
$msg = new \Plasticbrain\FlashMessages\FlashMessages();

if(isset($_REQUEST['id'])){
    $id=$_REQUEST['id'];
}
else{
    $id=0;
}
$post_date=date("d-m-Y");


if(isset($_POST['submitImg'])){

    try{

        if(empty($_POST['imgTitle'])){
            throw new Exception("Please Input your Image Title");
        }

        $uploaded_file=$_FILES['imgFile']['name'];
        $file_basename=substr($uploaded_file, 0,strripos($uploaded_file, '.'));

        if(empty($file_basename)){
            throw new Exception("Please Select your Image File");
        }

        $file_extension=substr($uploaded_file, strripos($uploaded_file, '.'));

        $statement = $db->prepare("SHOW TABLE STATUS LIKE 'gallery'");
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
            $new_id = $row[10];

        $f1 = $new_id.$file_extension;
        move_uploaded_file($_FILES['imgFile']['tmp_name'], 'gallery/'.$f1);
        $insertNoticeQry = mysql_query("insert into gallery (title,img_file) values('$_POST[imgTitle]','$f1')");

    }
    catch(Exception $e){
        $msg->error($e->getMessage(), "galleryAdmin.php");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php $page_title = "Gallery Control"; include 'includes/head.php' ?>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-2">
            <?php $adminNav='gallery'; include 'includes/admin_side_menu.php' ?>
        </div>
        <div class="col-md-10">
            <h4 class="head-title">Add New Image To The Gallery</h4>

            <?php
            //show flash messages
            if ($msg->hasErrors()) {
                $msg->display();
            }
            ?>

            <form method="post" action="" enctype="multipart/form-data">
                <p>Type Image Caption: (Use Bangla or English, Within few words will be bettre)</p>
                <textarea rows="2" cols="50" name="imgTitle"></textarea><br><br>
                <table style="">
                    <tr>
                        <td>Choose a file (file must be jpg,png,JPG,PNG,jpeg) :</td>
                        <td><input type="file" name="imgFile"></td>
                    </tr>

                    <tr>
                        <td><input type="submit" name="submitImg" value="Upload Image" style="background-color:green;color:white;height:40px;border-radius:8px;"></td>
                        <td></td>
                    </tr>
                </table>

            </form>
        </div>

    </div>
</div>


<?php include 'includes/footer.php'  ?>

<script src="js/bootstrap.min.js"></script>

</body>
</html>