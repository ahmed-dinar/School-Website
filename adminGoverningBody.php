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
// Adding Governing Body..............................

if(isset($_POST['add_gvt'])){
    try{
        if(empty($_POST['t_name'])){
            throw new Exception("Please Input Teacher Name");
        }
        if(empty($_POST['t_qualification'])){
            throw new Exception("Please Input Teacher Qualification");
        }

        $name=$_POST['category'];
        if(empty($name)){
            throw new Exception('Please choose a Category.');
        }

        $uploaded_file=$_FILES['t_img']['name'];
        $file_basename=substr($uploaded_file, 0,strripos($uploaded_file, '.'));

        if(!empty($file_basename)){
            $file_extension=substr($uploaded_file, strripos($uploaded_file, '.'));

            $statement=$db->prepare("SHOW TABLE STATUS LIKE 'administration'");
            $statement->execute();
            $result=$statement->fetchAll();
            foreach($result as $row)
                $new_id=$row[10];

            $f1=$new_id.$file_extension;
            move_uploaded_file($_FILES['t_img']['tmp_name'], 'img_administration/'.$f1);
            if($name=='chairman'){
                $qual=1;
                $p1='সভাপতি';
                $p2='E';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$f1','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");

            }
            else if($name=='shochib'){
                $qual=2;
                $p1='সচিব';
                $p2='E';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$f1','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");

            }
            else if($name=='guardian'){
                $qual=3;
                $p1='অভিভাবক সদস্য';
                $p2='E';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$f1','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");

            }
            else if($name=='donner'){
                $qual=4;
                $p1='দাতা সদস্য';
                $p2='E';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$f1','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");

            }

        }else{
            if($name=='chairman'){
                $qual=1;
                $p1='সভাপতি ';
                $p2='E';
                $no_img='blank-profile.png';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$no_img','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");

            }
            else if($name=='shochib'){
                $qual=2;
                $p1='সচিব';
                $p2='E';
                $no_img='blank-profile.png';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$no_img','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");

            }
            else if($name=='guardian'){
                $qual=3;
                $p1='অভিভাবক সদস্য';
                $p2='E';
                $no_img='blank-profile.png';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$no_img','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");

            }
            else if($name=='donner'){
                $qual=4;
                $p1='দাতা সদস্য';
                $p2='E';
                $no_img='blank-profile.png';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$no_img','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");

            }
        }
    }
    catch(Exception $e2){
        $errorStuff=$e2->getMessage();
    }
}



// Update Gvt................

if(isset($_POST['update_gvt'])){
    try{
        if(empty($_POST['t_name'])){
            throw new Exception("Please Input Teacher Name");
        }
        if(empty($_POST['t_qualification'])){
            throw new Exception("Please Input Teacher Qualification");
        }

        $name=$_POST['category'];
        if(empty($name)){
            throw new Exception('Please choose a Category.');
        }

        $uploaded_file=$_FILES['t_img']['name'];
        $file_basename=substr($uploaded_file, 0,strripos($uploaded_file, '.'));

        if(!empty($file_basename)){
            $file_extension=substr($uploaded_file, strripos($uploaded_file, '.'));

            /*$statement=$db->prepare("SHOW TABLE STATUS LIKE 'administration'");
            $statement->execute();
            $result=$statement->fetchAll();
            foreach($result as $row)
                   $new_id=$row[10];*/

            $new_id=$_POST['u_id'];
            $f1=$new_id.$file_extension;
            $t_image=$_POST['img'];
            if($_POST['img']!='blank-profile.png'){
                unlink("img_administration/$t_image");
            }
            move_uploaded_file($_FILES['t_img']['tmp_name'], 'img_administration/'.$f1);
            if($name=='chairman'){
                $qual=1;
                $p1='সভাপতি';
                $p2='E';
                $updateStuffQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$f1',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");

            }
            else if($name=='shochib'){
                $qual=2;
                $p1='সচিব';
                $p2='E';
                $updateStuffQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$f1',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");

            }
            else if($name=='guardian'){
                $qual=3;
                $p1='অভিভাবক সদস্য';
                $p2='E';
                $updateStuffQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$f1',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");

            }
            else if($name=='donner'){
                $qual=4;
                $p1='দাতা সদস্য';
                $p2='E';
                $updateStuffQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$f1',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");

            }

        }else{
            if($name=='chairman'){
                $qual=1;
                $p1='সভাপতি';
                $p2='E';
                $updateStuffTeacherQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$_POST[img]',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");

            }
            else if($name=='shochib'){
                $qual=2;
                $p1='সচিব';
                $p2='E';
                $updateStuffTeacherQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$_POST[img]',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");

            }
            else if($name=='guardian'){
                $qual=3;
                $p1='অভিভাবক সদস্য';
                $p2='S';
                $updateStuffTeacherQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$_POST[img]',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");

            }
            else if($name=='donner'){
                $qual=4;
                $p1='দাতা সদস্য';
                $p2='E';
                $updateStuffTeacherQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$_POST[img]',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");

            }
        }
    }
    catch(Exception $e2){
        $errorStuffUpdate=$e2->getMessage();
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php $page_title = "Governing Body Control"; include 'includes/head.php' ?>

    <style>
        .teacherTable tr{
            margin-top:7px;
        }

        .teacherTable tr td{
            padding-top:8px;
        }

        .teacherTable tr td input{
            width:300px;
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
            <?php include 'includes/admin_side_menu.php' ?>
        </div>

        <div class="col-md-5">
            <h4 class="head-title">Add Executive Member's Information</h4>
            <form method="post" action="" enctype="multipart/form-data">
                <table class="teacherTable">
                    <tr>
                        <td>Name : </td>
                        <td><input type="text" name="t_name"></input></td>
                    </tr>
                    <tr>
                        <td>Qualification : </td>
                        <td><input type="text" name="t_qualification"></input></td>
                    </tr>

                    <tr>
                        <td>Select Designation: </td>
                        <td>

                            <select name="category">

                                <option value="chairman">সভাপতি </option>
                                <option value="shochib">সচিব</option>
                                <option value="guardian">অভিভাবক সদস্য</option>
                                <option value="donner">দাতা সদস্য</option>

                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Address : </td>
                        <td><input type="text" name="t_address"></td>
                    </tr>
                    <tr>
                        <td>Contact No. : </td>
                        <td><input type="text" name="t_cell"></td>
                    </tr>
                    <tr>
                        <td>Email : </td>
                        <td><input type="text" name="t_email"></td>
                    </tr>
                    <tr>
                        <td>About : </td>
                        <td><textarea rows="2" cols="32" name="t_about"></textarea></td>
                    </tr>
                    <tr>
                        <td>Choose Image :</td>
                        <td><input type="file" name="t_img"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="add_gvt" value="Submit" style="background-color:green;color:white;height:40px;border-radius:8px;"></td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="col-md-5">
            <div class="stuffEditDelete">
                <h4 class="head-title">Operations on Executive Member's Information</h4>
                <?php
                $test=0;
                $sr=0;
                $modalNumber=110;
                $getTeacherQry=mysql_query("select * from administration where position2='E' order by t_designation asc");
                while($get=mysql_fetch_array($getTeacherQry)){
                    $name=$get['t_name'];
                    $designation=$get['position'];
                    $qualification=$get['t_qualification'];
                    //$sub=$get['subject'];
                    $phn=$get['t_phn'];
                    $email=$get['t_mail'];
                    $address=$get['address'];
                    $about=$get['about'];
                    $img=$get['t_img'];
                    $get_id=$get['t_id'];
                    $test++;
                    $sr++;
                    $modalNumber++;
                    ?>
                    <table class="tbl2" width="100%">
                        <?php if($test==1){ ?>
                            <tr>
                                <th width="3%">Sr.&nbsp</th>
                                <th width="32%">Name</th>
                                <th width="33%">Designation</th>
                                <th width="32%">Operations</th>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td width="3%"><?php echo $sr;?></td>
                            <td width="32%"><?php echo $name;?></td>
                            <td width="33%"><?php echo $designation;?></td>

                            <td width="32%"><a href="#" data-toggle="modal" data-target="#modal<?php echo $modalNumber;?>">Edit | </a>
                                <div id="modal<?php echo $modalNumber;?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header"><h4>Update Information of <?php echo $name;?></h4></div>
                                            <div class="modal-body">
                                                <form method="post" action="" enctype="multipart/form-data">

                                                    <table class="teacherTable" background-color="green;">
                                                        <tr>
                                                            <td>Name : </td>
                                                            <td><input type="text" name="t_name" value="<?php echo $name;?>"></input></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Qualification : </td>
                                                            <td><input type="text" name="t_qualification" value="<?php echo $qualification;?>"></input></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Select Designation: </td>
                                                            <td>

                                                                <select name="category" value="<?php echo $designation;?>">

                                                                    <option value="chairman">সভাপতি </option>
                                                                    <option value="shochib">সচিব</option>
                                                                    <option value="guardian">অভিভাবক সদস্য</option>
                                                                    <option value="donner">দাতা সদস্য</option>

                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Address : </td>
                                                            <td><input type="text" name="t_address" value="<?php echo $address;?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Contact No. : </td>
                                                            <td><input type="text" name="t_cell" value="<?php echo $phn;?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Email : </td>
                                                            <td><input type="text" name="t_email" value="<?php echo $email;?>"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>About : </td>
                                                            <td><textarea rows="2" cols="32" name="t_about" value="<?php echo $about;?>"></textarea></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Choose Image :</td>
                                                            <td><input type="file" name="t_img"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <input type="hidden" name="u_id" value="<?php echo $get_id;?>"></input>
                                                            <input type="hidden" name="img" value="<?php echo $img;?>"></input>
                                                            <td><input type="submit" name="update_gvt" value="Update" style="background-color:green;color:white;height:40px;border-radius:8px;"></td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            </div>
                                            <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                                        </div>
                                    </div>
                                </div>
                                <a href="#">Delete</a>
                            </td>

                        </tr><br>
                    </table>
                <?php }?>
            </div>
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