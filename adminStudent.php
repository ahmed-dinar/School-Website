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
if(isset($_POST['student_submit'])){
    try{
        if(empty($_POST['ac_year'])){
            throw new Exception("Please Input Year");
        }

        $uploaded_file=$_FILES['students']['name'];
        $file_basename=substr($uploaded_file, 0,strripos($uploaded_file, '.'));
        if(empty($file_basename)){
            throw new Exception("Please Select your File");
        }
        $file_extension=substr($uploaded_file, strripos($uploaded_file, '.'));

        if($file_extension!='.pdf'){
            throw new Exception("Please choose a pdf file");
        }
        $statement=$db->prepare("SHOW TABLE STATUS LIKE 'student'");
        $statement->execute();
        $result=$statement->fetchAll();
        foreach($result as $row)
            $new_id=$row[10];

        $f1=$new_id.$file_extension;
        move_uploaded_file($_FILES['students']['tmp_name'], 'student/'.$f1);

        $setClass=0;
        $section='';
        $getClass=$_POST['classes'];
        if($getClass=="Six"){
            $setClass=6;
            $section='S';
        }
        else if($getClass=="Seven"){
            $setClass=7;
            $section='S';
        }
        else if($getClass=="Eight"){
            $setClass=8;
            $section='S';
        }
        else if($getClass=="Nine"){
            $setClass=9;
            $section='S';
        }
        else if($getClass=="Ten"){
            $setClass=10;
            $section='S';
        }
        else if($getClass=="Eleven"){
            $setClass=11;
            $section='C';
        }
        else if($getClass=="Twelve"){
            $setClass=12;
            $section='C';
        }
        $insertNoticeQry=mysql_query("insert into student (class,classString,section,ac_year,file) values('$setClass','$_POST[classes]','$section','$_POST[ac_year]','$f1')");
        $insertSuccessMsg="Data inserted successfully.";
    }
    catch(Exception $e){
        $errorStudent=$e->getMessage();
    }
}

// update
if(isset($_POST['update_student'])){
    try{
        if(empty($_POST['ac_year'])){
            throw new Exception("Please Input Year");
        }

        $uploaded_file=$_FILES['students']['name'];
        $file_basename=substr($uploaded_file, 0,strripos($uploaded_file, '.'));

        $setClass=0;
        $section='';
        $getClass=$_POST['classes'];
        if($getClass=="Six"){
            $setClass=6;
            $section='S';
        }
        else if($getClass=="Seven"){
            $setClass=7;
            $section='S';
        }
        else if($getClass=="Eight"){
            $setClass=8;
            $section='S';
        }
        else if($getClass=="Nine"){
            $setClass=9;
            $section='S';
        }
        else if($getClass=="Ten"){
            $setClass=10;
            $section='S';
        }
        else if($getClass=="Eleven"){
            $setClass=11;
            $section='C';
        }
        else if($getClass=="Twelve"){
            $setClass=12;
            $section='C';
        }

        if(!empty($file_basename)){
            $file_extension=substr($uploaded_file, strripos($uploaded_file, '.'));
            if($file_extension!='.pdf'){
                throw new Exception("Please choose a pdf file");
            }
            // Delete Previous File
            $getSF=$_POST['sf'];
            unlink("student/$getSF");

            // Add new File
            $new_id=$_POST['s_id'];
            $f1=$new_id.$file_extension;
            move_uploaded_file($_FILES['students']['tmp_name'], 'student/'.$f1);

            $updateStdQry=mysql_query("update student set class='$setClass',classString='$getClass',section='$section',ac_year='$_POST[ac_year]' where id='$_POST[s_id]' ");
            throw new Exception("Updated Successfully");
        }
        else{
            $updateARQry=mysql_query("update student set class='$setClass',classString='$getClass',section='$section',ac_year='$_POST[ac_year]' where id='$_POST[s_id]'");
            throw new Exception("Updated Successfully");
        }


        // $new_id=$_POST['u_id'];

    }
    catch(Exception $e2){
        $errorResultAcademic=$e2->getMessage();
    }
}



// Delete

if(isset($_REQUEST['sID'])){
    $sID=$_REQUEST['sID'];
    $pbrDelete=mysql_query("delete from student where id='$sID'");
    $sfile=$_REQUEST['sfile'];
    unlink("student/$sfile");
    $successMessage2="Data has been deleted successfully";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php include 'includes/head.php'; ?>

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
            <?php $adminNav='student'; include 'includes/admin_side_menu.php' ?>
        </div>

        <div class="col-md-5">
            <h4 style="background-color:#5C4283;color:#FFFFFF;height:30px;padding-top:3px;text-align:center;">Add Student Information</h4>
            <?php
            if(!empty($errorStudent)){echo "<h3 style='color:red'>".$errorStudent."</h3>";}
            if(isset($insertSuccessMsg)){
                echo "<h2 style='color:green'>".$insertSuccessMsg."</h2>";
            }
            ?>
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
                        <td>Year : </td>
                        <td><input type="text" name="ac_year"></input></td>
                    </tr>

                    <tr>
                        <td>Choose PDF File :</td>
                        <td><input type="file" name="students"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="student_submit" value="Submit" style="background-color:green;color:white;height:40px;border-radius:8px;"></td>
                    </tr>
                </table>
            </form>
        </div>

        <!--------CRUD on Student--------------->
        <div class="col-md-5">

            <div class="techerEditDelete">
                <h4 style="background-color:#5C4283;color:#FFFFFF;height:auto;padding:8px;text-align:center;">Operations on Student Information</h4>
                <?php
                if(isset($successMessage2)){
                    echo "<h3 style='color:green'>".$successMessage2."</h3>";
                }
                $test=0;
                $sr=0;
                $getStudentQry=mysql_query("select * from student order by class asc");
                while($get=mysql_fetch_array($getStudentQry)){
                    $getClass=$get['classString'];
                    $studentFile=$get['file'];
                    $student_year=$get['ac_year'];
                    $get_id=$get['id'];
                    $test++;
                    $sr++;
                    ?>
                    <table class="tbl2" width="100%">
                        <?php if($test==1){ ?>
                            <tr>
                                <th width="3%">Sr.&nbsp</th>
                                <th width="10%">Class</th>
                                <th width="22%">Year</th>
                                <th width="32%">Operations</th>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td width="3%"><?php echo $sr;?></td>
                            <td width="10%"><?php echo $getClass;?></td>
                            <td width="33%"><?php echo $student_year;?></td>

                            <td width="32%"><a href="#" data-toggle="modal" data-target="#modal<?php echo $sr;?>">Edit | </a>
                                <div id="modal<?php echo $sr;?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header"><h4>Update Student Data of Class <?php echo $getClass;?></h4></div>
                                            <div class="modal-body">
                                                <form method="post" action="" enctype="multipart/form-data">

                                                    <table class="teacherTable" background-color="green;">
                                                        <tr>
                                                            <td>Select Class : </td>

                                                            <td>
                                                                <select name="classes">
                                                                    <option value="<?php echo $getClass;?>"><?php echo $getClass;?></option>
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
                                                            <td>Year : </td>
                                                            <td><input type="text" name="ac_year" value="<?php echo $student_year;?>"></input></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Choose PDF File :</td>
                                                            <td><input type="file" name="students"></td>
                                                        </tr>

                                                        <tr>
                                                            <td></td>
                                                            <input type="hidden" name="s_id" value="<?php echo $get_id;?>"></input>
                                                            <input type="hidden" name="sf" value="<?php echo $studentFile;?>"></input>
                                                            <td><input type="submit" name="update_student" value="Update" style="background-color:green;color:white;height:40px;border-radius:8px;"></td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            </div>
                                            <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                                        </div>
                                    </div>
                                </div>
                                <a onclick='return confirmDelete();' href="adminStudent.php?sID=<?php echo $get_id;?>&sfile=<?php echo $studentFile;?>">Delete</a>
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