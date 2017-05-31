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
if(isset($_POST['r_submit'])){
    try{
        $nameExam=$_POST['categoryExam'];
        $nameGroup=$_POST['categoryGroup'];

        if(empty($nameExam)){
            throw new Exception("Please Select a Exam Name");
        }
        if(empty($nameGroup)){
            throw new Exception("Please Select a Group Name");
        }
        if(empty($_POST['re_year'])){
            throw new Exception("Please Enter Year");
        }

        $uploaded_file=$_FILES['exam_result']['name'];
        $file_basename=substr($uploaded_file, 0,strripos($uploaded_file, '.'));
        if(empty($file_basename)){
            throw new Exception("Please Select your Image File");
        }
        $file_extension=substr($uploaded_file, strripos($uploaded_file, '.'));
        if($file_extension!='.pdf'){
            throw new Exception("Please choose a pdf file");
        }

        //check whether the result is already is already exist or not..............
        $test=0;
        $qryCheck=mysql_query("select * from result_public where result_year='$_POST[re_year]' and exam_name='$nameExam'");
        while($get=mysql_fetch_array($qryCheck)){
            $grp=$get['group'];
            if($grp==$nameGroup){
                $test++;
            }
        }
        if($test>=1){
            throw new Exception("This result is already exist.");
        }

        $statement=$db->prepare("SHOW TABLE STATUS LIKE 'result_public'");
        $statement->execute();
        $result=$statement->fetchAll();
        foreach($result as $row)
            $new_id=$row[10];

        $f1=$new_id.$file_extension;
        move_uploaded_file($_FILES['exam_result']['tmp_name'], 'public_result/'.$f1);
        if($nameGroup=='Science'){
            $pri=1;
            $qry=mysql_query("insert into result_public values(null,'$nameExam','$pri','$nameGroup','$_POST[re_year]','$f1')");
            throw new Exception(mysql_error());
        }
        else if($nameGroup=='Commerce'){
            $pri=2;
            $qry=mysql_query("insert into result_public values(null,'$nameExam','$pri','$nameGroup','$_POST[re_year]','$f1')");
            throw new Exception(mysql_error());
        }
        else if($nameGroup=='Arts'){
            $pri=3;
            $qry=mysql_query("insert into result_public values(null,'$nameExam','$pri','$nameGroup','$_POST[re_year]','$f1')");
            throw new Exception(mysql_error());
        }

    }
    catch(Exception $e){
        $errorResult=$e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php $page_title = "Result Control"; include 'includes/head.php' ?>

    <style>
        .teacherTable tr{
            margin-top:7px;
        }

        .teacherTable tr td{
            padding-top:8px;
        }

        .teacherTable tr td input{
            width:;
        }
        .teacherTable tr td select option{
            width:278px;
        }



    </style>

</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-2">
            <?php $adminNav='result'; include 'includes/admin_side_menu.php' ?>
        </div>
        <div class="col-md-5">

            <h4 class="head-title">Relese Public Result</h4>
            <?php if(!empty($errorResult)){echo "<h3 style='color:red'>".$errorResult."</h3>";}?>
            <form method="post" action="" enctype="multipart/form-data">
                <table class="teacherTable">
                    <tr>
                        <td>Select Exam Name : </td>

                        <td>
                            <select name="categoryExam">

                                <option value="HSC">HSC</option>
                                <option value="SSC">SSC</option>

                            </select>
                        </td>

                    </tr>
                    <tr>
                        <td>Year : </td>
                        <td><input type="text" name="re_year"></input></td>
                    </tr>
                    <tr>
                        <td>Select Group : </td>

                        <td>
                            <select name="categoryGroup">

                                <option value="Science">Science</option>
                                <option value="Commerce">Commerce</option>
                                <option value="Arts">Arts</option>

                            </select>
                        </td>

                    </tr>
                    <tr>
                        <td>Choose PDF File :</td>
                        <td><input type="file" name="exam_result"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="r_submit" value="Submit" style="background-color:green;color:white;height:40px;border-radius:8px;"></td>
                    </tr>
                </table>
            </form>

        </div>

        <div class="col-md-5">

        </div>

    </div>
</div>

<!----------update result-------->

<?php include 'includes/footer.php'  ?>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/min.js"></script>
<!-----<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  ---->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>