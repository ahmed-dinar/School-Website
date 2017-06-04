<?php
include 'includes/core.php';

//if admin not logged in
if( !isset($_SESSION['admin']) ){
    header('Location: admin.php' );
    exit(0);
}

include('database/connect.php');

if(isset($_REQUEST['id'])){
    $id=$_REQUEST['id'];
}
else{
    $id=0;
}
$post_date=date("d-m-Y");
?>

<?php
// Public Result
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
            //throw new Exception(mysql_error());
            throw new Exception("Inserted Successfully");
        }

    }
    catch(Exception $e){
        $errorResult=$e->getMessage();
    }
}
?>

<?php
// Academic REsult
if(isset($_POST['academic_submit'])){
    try{
        $class=$_POST['classes'];
        $title=$_POST['xm_title'];

        if(empty($class)){
            throw new Exception("Please Select a Exam Name");
        }
        if(empty($title)){
            throw new Exception("Please Select a Group Name");
        }

        if(empty($_POST['ac_year'])){
            throw new Exception("Please Enter Year");
        }

        $uploaded_file=$_FILES['academic_result']['name'];
        $file_basename=substr($uploaded_file, 0,strripos($uploaded_file, '.'));
        if(empty($file_basename)){
            throw new Exception("Please Select your result File");
        }
        $file_extension=substr($uploaded_file, strripos($uploaded_file, '.'));
        if($file_extension!='.pdf'){
            throw new Exception("Please choose a pdf file");
        }

        $statement=$db->prepare("SHOW TABLE STATUS LIKE 'local_result'");
        $statement->execute();
        $result=$statement->fetchAll();
        foreach($result as $row)
            $new_id=$row[10];

        $f1=$new_id.$file_extension;
        move_uploaded_file($_FILES['academic_result']['tmp_name'], 'academic_result/'.$f1);

        $qry=mysql_query("insert into local_result values(null,'$class','$title','$_POST[ac_year]','$post_date','$f1')");
        throw new Exception("Inserted Successfully");

    }
    catch(Exception $e){
        $errorResultAcademic=$e->getMessage();
    }
}
?>

<?php


// Update Academic Result................

if(isset($_POST['update_AR'])){
    try{
        if(empty($_POST['ac_year'])){
            throw new Exception("Please Input Year");
        }

        $uploaded_file=$_FILES['academic_result']['name'];
        $file_basename=substr($uploaded_file, 0,strripos($uploaded_file, '.'));
        if(!empty($file_basename)){
            $file_extension=substr($uploaded_file, strripos($uploaded_file, '.'));
            if($file_extension!='.pdf'){
                throw new Exception("Please choose a pdf file");
            }
            // Delete Previous File
            $getRF=$_POST['rf'];
            unlink("academic_result/$getRF");

            // Add new File
            $new_id=$_POST['u_id'];
            $f1=$new_id.$file_extension;
            move_uploaded_file($_FILES['academic_result']['tmp_name'], 'academic_result/'.$f1);

            $updateARQry=mysql_query("update local_result set class='$_POST[classes]',title='$_POST[xm_title]',result_year='$_POST[ac_year]' where id='$_POST[u_id]' ");
            throw new Exception("Updated Successfully");
        }
        else{
            $updateARQry=mysql_query("update local_result set class='$_POST[classes]',title='$_POST[xm_title]',result_year='$_POST[ac_year]' where id='$_POST[u_id]' ");
            throw new Exception("Updated Successfully");
        }


        // $new_id=$_POST['u_id'];

    }
    catch(Exception $e2){
        $errorResultAcademic=$e2->getMessage();
    }
}

// Delete Public Result

if(isset($_REQUEST['pbrID'])){
    $pbrID=$_REQUEST['pbrID'];
    $pbrDelete=mysql_query("delete from result_public where id='$pbrID'");
    $pbrfile=$_REQUEST['pbrfile'];
    unlink("public_result/$pbrfile");
    $successMessage="Data has been deleted successfully";
}

// Delete Acadeemic Result

if(isset($_REQUEST['acrID'])){
    $acrID=$_REQUEST['acrID'];
    $pbrDelete=mysql_query("delete from local_result where id='$acrID'");
    $acrfile=$_REQUEST['acrfile'];
    unlink("academic_result/$acrfile");
    $successMessage2="Data has been deleted successfully";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head.php'; ?>
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

    <script type="text/javascript">
        function confirmDelete(){
            return confirm("Do you sure want to delete this data?");
        }
    </script>

</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-2">
            <?php $adminNav='result'; include 'includes/admin_side_menu.php' ?>
        </div>
        <div class="col-md-5">

            <h4 style="background-color:#5C4283;color:#FFFFFF;height:30px;padding-top:3px;text-align:center;">Relese Public Result</h4>
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

            <h4 style="background-color:#5C4283;color:#FFFFFF;height:30px;padding-top:3px;text-align:center;">Relese Academic Result</h4>
            <?php if(!empty($errorResultAcademic)){echo "<h3 style='color:red'>".$errorResultAcademic."</h3>";}?>
            <form method="post" action="" enctype="multipart/form-data">
                <table class="teacherTable">

                    <tr>
                        <td>Select Class : </td>

                        <td>
                            <select name="classes">
                                <option value="Six">Six</option>
                                <option value="Seven">Seven</option>
                                <option value="Eight">Eight</option>
                                <option value="Nine">Nine</option>
                                <option value="Ten">Ten</option>
                                <option value="Eleven">Eleven</option>
                                <option value="Twelve">Twelve</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Select Title : </td>

                        <td>
                            <select name="xm_title">
                                <option value="First Term Result">First Term Result</option>
                                <option value="Second Term Result">Second Term Result</option>
                                <option value="Final Result">Final Result</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Year : </td>
                        <td><input type="text" name="ac_year"></input></td>
                    </tr>

                    <tr>
                        <td>Choose PDF File :</td>
                        <td><input type="file" name="academic_result"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="academic_submit" value="Submit" style="background-color:green;color:white;height:40px;border-radius:8px;"></td>
                    </tr>
                </table>
            </form>

        </div>

    </div>
</div>
<!----------update result-------->
<!----------Public result-------->
<div class="container">
    <div class="row">
        <div class="col-md-6">

            <div class="techerEditDelete">
                <h4 style="background-color:#5C4283;color:#FFFFFF;height:auto;padding:8px;text-align:center;">Operations on Public Result</h4>
                <?php
                if(isset($successMessage)){
                    echo "<h2 style='color:green'>".$successMessage."</h2>";
                }
                $test=0;
                $sr=0;
                $getPublicResultQry=mysql_query("select * from result_public order by id desc");
                while($get=mysql_fetch_array($getPublicResultQry)){
                    $examName=$get['exam_name'];
                    $group=$get['group'];
                    $result_year=$get['result_year'];
                    $fileName=$get['file_name'];
                    $get_id=$get['id'];
                    $test++;
                    $sr++;
                    ?>
                    <table class="tbl2" width="100%">
                        <?php if($test==1){ ?>
                            <tr>
                                <th width="20%">Sr.&nbsp</th>
                                <th width="20%">Exam</th>
                                <th width="20%">Group</th>
                                <th width="20%">Year</th>
                                <th width="20%">Operations</th>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td width="20%"><?php echo $sr;?></td>
                            <td width="20%"><?php echo $examName;?></td>
                            <td width="20%"><?php echo $group;?></td>
                            <td width="20%"><?php echo $result_year;?></td>

                            <td width="32%">
                                <a onclick='return confirmDelete();' href="adminResult.php?pbrID=<?php echo $get_id;?>&pbrfile=<?php echo $fileName;?>">Delete</a>
                            </td>

                        </tr><br>
                    </table>
                <?php }?>
            </div>

        </div>

        <!----------Acadeemic result-------->
        <div class="col-md-6">
            <div class="techerEditDelete">
                <h4 style="background-color:#5C4283;color:#FFFFFF;height:auto;padding:8px;text-align:center;">Operations on Acadeemic Result</h4>
                <?php
                if(isset($successMessage2)){
                    echo "<h2 style='color:green'>".$successMessage2."</h2>";
                }
                $test=0;
                $sr=0;
                $getPublicResultQry=mysql_query("select * from local_result order by id desc");
                while($get=mysql_fetch_array($getPublicResultQry)){
                    $className=$get['class'];
                    $title=$get['title'];
                    $resultFile=$get['file'];
                    $result_year=$get['result_year'];
                    $publish_date=$get['publish_date'];
                    $get_acid=$get['id'];
                    $test++;
                    $sr++;
                    ?>
                    <table class="tbl2" width="100%">
                        <?php if($test==1){ ?>
                            <tr>
                                <th width="3%">Sr.&nbsp</th>
                                <th width="10%">Class</th>
                                <th width="33%">Exam Title</th>
                                <th width="22%">Year</th>
                                <th width="32%">Operations</th>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td width="3%"><?php echo $sr;?></td>
                            <td width="10%"><?php echo $className;?></td>
                            <td width="33%"><?php echo $title;?></td>
                            <td width="22%"><?php echo $result_year;?></td>

                            <td width="32%"><a href="#" data-toggle="modal" data-target="#modal<?php echo $sr;?>">Edit | </a>
                                <div id="modal<?php echo $sr;?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header"><h4>Update Result of Class <?php echo $className;?></h4></div>
                                            <div class="modal-body">
                                                <form method="post" action="" enctype="multipart/form-data">

                                                    <table class="teacherTable" background-color="green;">
                                                        <tr>
                                                            <td>Select Class : </td>

                                                            <td>
                                                                <select name="classes">
                                                                    <option value="<?php echo $className;?>"><?php echo $className;?></option>
                                                                    <option value="Six">Six</option>
                                                                    <option value="Seven">Seven</option>
                                                                    <option value="Eight">Eight</option>
                                                                    <option value="Nine">Nine</option>
                                                                    <option value="Ten">Ten</option>
                                                                    <option value="Eleven">Eleven</option>
                                                                    <option value="Twelve">Twelve</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Select Title : </td>

                                                            <td>
                                                                <select name="xm_title">
                                                                    <option value="<?php echo $title;?>"><?php echo $title;?></option>
                                                                    <option value="First Term Result">First Term Result</option>
                                                                    <option value="Second Term Result">Second Term Result</option>
                                                                    <option value="Final Result">Final Result</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Year : </td>
                                                            <td><input type="text" name="ac_year" value="<?php echo $result_year;?>"></input></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Choose PDF File :</td>
                                                            <td><input type="file" name="academic_result"></td>
                                                        </tr>

                                                        <tr>
                                                            <td></td>
                                                            <input type="hidden" name="u_id" value="<?php echo $get_acid;?>"></input>
                                                            <input type="hidden" name="rf" value="<?php echo $resultFile;?>"></input>
                                                            <td><input type="submit" name="update_AR" value="Update" style="background-color:green;color:white;height:40px;border-radius:8px;"></td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            </div>
                                            <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                                        </div>
                                    </div>
                                </div>
                                <a onclick='return confirmDelete();' href="adminResult.php?acrID=<?php echo $get_acid;?>&acrfile=<?php echo $resultFile;?>">Delete</a>
                            </td>

                        </tr><br>
                    </table>
                <?php }?>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>