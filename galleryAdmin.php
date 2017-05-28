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
if(isset($_POST['submitImg'])){
    try{
        if(empty($_POST['imgTitle'])){
            throw new Exception("Please Input your Image Title");
        }


        $uploaded_file=$_FILES['imgFile']['name'];
        $file_basename=substr($uploaded_file, 0,strripos($uploaded_file, '.'));
        if(empty($file_basename)){
            throw new Exception("Please Select your Image File");
        }else{
            $file_extension=substr($uploaded_file, strripos($uploaded_file, '.'));

            $statement=$db->prepare("SHOW TABLE STATUS LIKE 'gallery'");
            $statement->execute();
            $result=$statement->fetchAll();
            foreach($result as $row)
                $new_id=$row[10];

            $f1=$new_id.$file_extension;
            move_uploaded_file($_FILES['imgFile']['tmp_name'], 'gallery/'.$f1);
            $insertNoticeQry=mysql_query("insert into gallery (title,img_file) values('$_POST[imgTitle]','$f1')");
        }
    }
    catch(Exception $e){
        $errorNotice=$e->getMessage();
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
            <?php include 'includes/admin_side_menu.php' ?>
        </div>
        <div class="col-md-10">
            <h4 class="head-title">Add New Image To The Gallery</h4>
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


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/min.js"></script>
<!-----<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  ---->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>