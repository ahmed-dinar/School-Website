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
// Add Teacher..................
if(isset($_POST['t_submit'])){
    try{
        if(empty($_POST['t_name'])){
            throw new Exception("Please Input Teacher Name");
        }
        if(empty($_POST['t_qualification'])){
            throw new Exception("Please Input Teacher Qualification");
        }
        if(empty($_POST['t_sub'])){
            throw new Exception("Please Input Teacher Subject");
        }

        $name=$_POST['category'];
        if(empty($name)){
            throw new Exception('Please choose a Category.');
        }

        //check whether the principal is already exist or not..............
        $test=0;
        $t_pri=1;
        $qryCheck=mysql_query("select t_designation from administration where position2='T' ");
        while($get=mysql_fetch_array($qryCheck)){
            $pri=$get['t_designation'];
            if($pri==$t_pri){
                $test++;
            }
        }
        if($test>=1){
            throw new Exception("This Principal is already exist. Change it first!!!!!");
        }

        $uploaded_file=$_FILES['t_img']['name'];
        $file_basename=substr($uploaded_file, 0,strripos($uploaded_file, '.'));

        // Checking whether the user uploading image or not......................
        if(!empty($file_basename)){
            $file_extension=substr($uploaded_file, strripos($uploaded_file, '.'));

            $statement=$db->prepare("SHOW TABLE STATUS LIKE 'administration'");
            $statement->execute();
            $result=$statement->fetchAll();
            foreach($result as $row)
                $new_id=$row[10];

            $f1=$new_id.$file_extension;
            move_uploaded_file($_FILES['t_img']['tmp_name'], 'img_administration/'.$f1);
            if($name=='principal'){
                $qual=1;
                $p1='Principal';
                $p2='T';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,subject,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_sub]','$_POST[t_cell]','$_POST[t_email]','$f1','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");
                $insertSuccessMsg="Teacher information added successfully.";
            }
            else if($name=='ahm'){
                $qual=2;
                $p1='Assistant Head Master';
                $p2='T';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,subject,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_sub]','$_POST[t_cell]','$_POST[t_email]','$f1','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");
                $insertSuccessMsg="Teacher information added successfully.";
            }
            else if($name=='at'){
                $qual=3;
                $p1='Assistant Teacher';
                $p2='T';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,subject,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_sub]','$_POST[t_cell]','$_POST[t_email]','$f1','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");
                $insertSuccessMsg="Teacher information added successfully.";
            }

        }else{
            // If user is not uploading any image .....set default image...........
            if($name=='principal'){
                $qual=1;
                $p1='Principal';
                $p2='T';
                $no_img='blank-profile.png';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,subject,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_sub]','$_POST[t_cell]','$_POST[t_email]','$no_img','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");
                $insertSuccessMsg="Teacher information added successfully.";
            }
            else if($name=='ahm'){
                $qual=2;
                $p1='Assistant Head Master';
                $p2='T';
                $no_img='blank-profile.png';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,subject,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_sub]','$_POST[t_cell]','$_POST[t_email]','$no_img','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");
                $insertSuccessMsg="Teacher information added successfully.";
            }
            else if($name=='at'){
                $qual=3;
                $p1='Assistant Teacher';
                $p2='T';
                $no_img='blank-profile.png';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,subject,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_sub]','$_POST[t_cell]','$_POST[t_email]','$no_img','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");
                $insertSuccessMsg="Teacher information added successfully.";
            }
        }
    }
    catch(Exception $e2){
        $errorTeacher=$e2->getMessage();
    }
}



// Adding Stuff..............................

if(isset($_POST['add_stuff'])){
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
            if($name=='libralian'){
                $qual=1;
                $p1='সহকারী গ্রন্থাগারিক';
                $p2='S';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$f1','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");
                $insertStuffSuccessMsg="Staff information added successfully.";
            }
            else if($name=='oa'){
                $qual=2;
                $p1='অফিস সহকারী ';
                $p2='S';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$f1','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");
                $insertStuffSuccessMsg="Staff information added successfully.";
            }
            else if($name=='nanny'){
                $qual=3;
                $p1='আয়া';
                $p2='S';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$f1','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");
                $insertStuffSuccessMsg="Staff information added successfully.";
            }
            else if($name=='dhoptori'){
                $qual=4;
                $p1='দপ্তরী';
                $p2='S';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$f1','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");
                $insertStuffSuccessMsg="Staff information added successfully.";
            }

        }else{
            if($name=='libralian'){
                $qual=1;
                $p1='সহকারী গ্রন্থাগারিক';
                $p2='S';
                $no_img='blank-profile.png';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$no_img','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");
                $insertStuffSuccessMsg="Staff information added successfully.";
            }
            else if($name=='oa'){
                $qual=2;
                $p1='অফিস সহকারী ';
                $p2='S';
                $no_img='blank-profile.png';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$no_img','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");
                $insertStuffSuccessMsg="Staff information added successfully.";
            }
            else if($name=='nanny'){
                $qual=3;
                $p1='আয়া';
                $p2='S';
                $no_img='blank-profile.png';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$no_img','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");
                $insertStuffSuccessMsg="Staff information added successfully.";
            }
            else if($name=='dhoptori'){
                $qual=4;
                $p1='দপ্তরী';
                $p2='S';
                $no_img='blank-profile.png';
                $insertTeacherQry=mysql_query("insert into administration (t_name,t_designation,t_qualification,t_phn,t_mail,t_img,position,position2,address,about) values('$_POST[t_name]','$qual','$_POST[t_qualification]','$_POST[t_cell]','$_POST[t_email]','$no_img','$p1','$p2','$_POST[t_address]','$_POST[t_about]')");
                $insertStuffSuccessMsg="Staff information added successfully.";
            }
        }
    }
    catch(Exception $e2){
        $errorStuff=$e2->getMessage();
    }
}


// update Teacher...................
if(isset($_POST['update_teacher'])){
    try{
        if(empty($_POST['t_name'])){
            throw new Exception("Please Input Teacher Name");
        }
        if(empty($_POST['t_qualification'])){
            throw new Exception("Please Input Teacher Qualification");
        }
        if(empty($_POST['t_sub'])){
            throw new Exception("Please Input Teacher Subject");
        }

        $name=$_POST['category'];
        if(empty($name)){
            throw new Exception('Please choose a Category.');
        }

        //check whether the principal is already exist or not..............
        $qryCheckPrincipal=mysql_query("select position from administration where t_id='$_POST[u_id]' ");
        while($get=mysql_fetch_array($qryCheckPrincipal)){
            $getPosition=$get['position'];
        }
        if($getPosition!='Principal'){
            $test=0;
            $t_pri=1;
            $qryCheck=mysql_query("select t_designation from administration where position2='T' ");
            while($get=mysql_fetch_array($qryCheck)){
                $pri=$get['t_designation'];
                if($pri==$t_pri){
                    $test++;
                }
            }
            if($test>=1){
                throw new Exception("This Principal is already exist. Change it first!!!!!");
            }
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
            if($name=='principal'){
                $qual=1;
                $p1='Principal';
                $p2='T';
                $updateTeacherQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',subject='$_POST[t_sub]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$f1',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");
                $updateTeacherSuccess="Teacher information updated successfully!";
            }
            else if($name=='ahm'){
                $qual=2;
                $p1='Assistant Head Master';
                $p2='T';
                $updateTeacherQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',subject='$_POST[t_sub]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$f1',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");
                $updateTeacherSuccess="Teacher information updated successfully!";
            }
            else if($name=='at'){
                $qual=3;
                $p1='Assistant Teacher';
                $p2='T';
                $updateTeacherQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',subject='$_POST[t_sub]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$f1',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");
                $updateTeacherSuccess="Teacher information updated successfully!";
            }

        }else{
            if($name=='principal'){
                $qual=1;
                $p1='Principal';
                $p2='T';
                $updateTeacherQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',subject='$_POST[t_sub]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$_POST[img]',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");
                $updateTeacherSuccess="Teacher information updated successfully!";
            }
            else if($name=='ahm'){
                $qual=2;
                $p1='Assistant Head Master';
                $p2='T';
                $updateTeacherQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',subject='$_POST[t_sub]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$_POST[img]',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");
                $updateTeacherSuccess="Teacher information updated successfully!";
            }
            else if($name=='at'){
                $qual=3;
                $p1='Assistant Teacher';
                $p2='T';
                $updateTeacherQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',subject='$_POST[t_sub]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$_POST[img]',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");
                $updateTeacherSuccess="Teacher information updated successfully!";
            }
        }
    }
    catch(Exception $e2){
        $errorTeacherUpdate=$e2->getMessage();
    }
}


// Update Stuff................

if(isset($_POST['update_stuff'])){
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
            if($name=='libralian'){
                $qual=1;
                $p1='সহকারী গ্রন্থাগারিক';
                $p2='S';
                $updateStuffQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$f1',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");
                $updateStaffSuccess="Staff information updated successfully!";
            }
            else if($name=='oa'){
                $qual=2;
                $p1='অফিস সহকারী ';
                $p2='S';
                $updateStuffQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$f1',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");
                $updateStaffSuccess="Staff information updated successfully!";
            }
            else if($name=='nanny'){
                $qual=3;
                $p1='আয়া';
                $p2='S';
                $updateStuffQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$f1',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");
                $updateStaffSuccess="Staff information updated successfully!";
            }
            else if($name=='dhoptori'){
                $qual=4;
                $p1='দপ্তরী';
                $p2='S';
                $updateStuffQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$f1',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");
                $updateStaffSuccess="Staff information updated successfully!";
            }

        }else{
            if($name=='libralian'){
                $qual=1;
                $p1='সহকারী গ্রন্থাগারিক';
                $p2='S';
                $updateStuffTeacherQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$_POST[img]',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");
                $updateStaffSuccess="Staff information updated successfully!";
            }
            else if($name=='oa'){
                $qual=2;
                $p1='অফিস সহকারী ';
                $p2='S';
                $updateStuffTeacherQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$_POST[img]',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");
                $updateStaffSuccess="Staff information updated successfully!";
            }
            else if($name=='nanny'){
                $qual=3;
                $p1='আয়া';
                $p2='S';
                $updateStuffTeacherQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$_POST[img]',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");
                $updateStaffSuccess="Staff information updated successfully!";
            }
            else if($name=='dhoptori'){
                $qual=4;
                $p1='দপ্তরী';
                $p2='S';
                $updateStuffTeacherQry=mysql_query("update administration set t_name='$_POST[t_name]',t_designation='$qual',t_qualification='$_POST[t_qualification]',t_phn='$_POST[t_cell]',t_mail='$_POST[t_email]',t_img='$_POST[img]',position='$p1',position2='$p2',address='$_POST[t_address]',about='$_POST[t_about]' where t_id='$_POST[u_id]' ");
                $updateStaffSuccess="Staff information updated successfully!";
            }
        }
    }
    catch(Exception $e2){
        $errorStuffUpdate=$e2->getMessage();
    }
}


// Delete Teacher

if(isset($_REQUEST['TID'])){
    $TID=$_REQUEST['TID'];
    $pbrDelete=mysql_query("delete from administration where t_id='$TID'");
    $t_image=$_REQUEST['getImg'];
    if($_REQUEST['getImg']!='blank-profile.png'){
        unlink("img_administration/$t_image");
    }
    $DeleteTeacherSuccessMessage="Data has been deleted successfully";
}

//Delete Stuff

if(isset($_REQUEST['SID'])){
    $SID=$_REQUEST['SID'];
    $pbrDelete=mysql_query("delete from administration where t_id='$SID'");
    $t_image=$_REQUEST['getImg'];
    if($_REQUEST['getImg']!='blank-profile.png'){
        unlink("img_administration/$t_image");
    }
    $DeleteStaffSuccessMessage="Data has been deleted successfully";
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
            <?php $adminNav='tas'; include 'includes/admin_side_menu.php' ?>
        </div>
        <!-------------Adding Teacher------------->
        <div class="col-md-5">
            <h4 style="background-color:#5C4283;color:#FFFFFF;height:30px;padding-top:3px;text-align:center;">Add Teacher's Information</h4>
            <?php
            if(!empty($errorTeacher)){echo "<h3 style='color:red'>".$errorTeacher."</h3>";}
            if(!empty($insertSuccessMsg)){
                echo "<h3 style='color:green'>".$insertSuccessMsg."</h3>";
            }
            ?>
            <form method="post" action="" enctype="multipart/form-data">
                <table class="teacherTable">
                    <tr>
                        <td>Name : </td>
                        <td><input type="text" name="t_name" placeholder="Required"></input></td>
                    </tr>
                    <tr>
                        <td>Qualification : </td>
                        <td><input type="text" name="t_qualification" placeholder="Required"></input></td>
                    </tr>
                    <tr>
                        <td>Subject : </td>
                        <td><input type="text" name="t_sub" placeholder="Required"></td>
                    </tr>

                    <tr>
                        <td>Select Designation*: </td>
                        <td>

                            <select name="category">

                                <option value="principal">অধ্যক্ষ</option>
                                <option value="ahm">সকারী প্রধান শিক্ষক </option>
                                <option value="at">সহকারী শিক্ষক</option>

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
                        <td><input type="submit" name="t_submit" value="Submit" style="background-color:green;color:white;height:40px;border-radius:8px;"></td>
                    </tr>
                </table>
            </form>

            <!------------------Edit Delite Function of Teacher's------------------->

        </div>

        <!-------------Adding Stuff------------->
        <div class="col-md-5">
            <h4 style="background-color:#5C4283;color:#FFFFFF;height:30px;padding-top:3px;text-align:center;">Add Stuff's Information</h4>
            <?php
            if(!empty($errorStuff)){echo "<h3 style='color:red'>".$errorStuff."</h3>";}
            if(!empty($insertStuffSuccessMsg)){
                echo "<h3 style='color:green'>".$insertStuffSuccessMsg."</h3>";
            }
            ?>
            <form method="post" action="" enctype="multipart/form-data">
                <table class="teacherTable">
                    <tr>
                        <td>Name : </td>
                        <td><input type="text" name="t_name" placeholder="Required"></input></td>
                    </tr>
                    <tr>
                        <td>Qualification : </td>
                        <td><input type="text" name="t_qualification" placeholder="Required"></input></td>
                    </tr>

                    <tr>
                        <td>Select Designation<span>*</span> : </td>
                        <td>

                            <select name="category">

                                <option value="libralian">সহকারী গ্রন্থাগারিক</option>
                                <option value="oa">অফিস সহকারী </option>
                                <option value="nanny">আয়া</option>
                                <option value="dhoptori">দপ্তরী</option>

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
                        <td><input type="submit" name="add_stuff" value="Submit" style="background-color:green;color:white;height:40px;border-radius:8px;"></td>
                    </tr>
                </table>
            </form>
        </div>

    </div>
</div>

<!-----------------Edit Delete Operations--------------->
<!-------------Operations on Teacher------------->
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="techerEditDelete">
                <h4 style="background-color:#5C4283;color:#FFFFFF;height:auto;padding:8px;text-align:center;">Operations on Teacher's Information</h4>
                <?php
                if(!empty($errorTeacherUpdate)){echo "<h3 style='color:red'>".$errorTeacherUpdate."</h3>"; $errorTeacherUpdate="";}
                if(!empty($updateTeacherSuccess)){
                    echo "<h3 style='color:green'>".$updateTeacherSuccess."</h3>";
                    $updateTeacherSuccess="";
                    $DeleteTeacherSuccessMessage="";
                    $errorTeacherUpdate="";
                }
                if(!empty($DeleteTeacherSuccessMessage)){
                    echo "<h3 style='color:green'>".$DeleteTeacherSuccessMessage."</h3>";
                    $updateTeacherSuccess="";
                    $DeleteTeacherSuccessMessage="";
                    $errorTeacherUpdate="";
                }
                $test=0;
                $sr=0;
                $getTeacherQry=mysql_query("select * from administration where position2='T' order by t_designation asc");
                while($get=mysql_fetch_array($getTeacherQry)){
                    $name=$get['t_name'];
                    $designation=$get['position'];
                    $qualification=$get['t_qualification'];
                    $sub=$get['subject'];
                    $phn=$get['t_phn'];
                    $email=$get['t_mail'];
                    $address=$get['address'];
                    $about=$get['about'];
                    $img=$get['t_img'];
                    $get_tid=$get['t_id'];
                    $test++;
                    $sr++;
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

                            <td width="32%"><a href="#" data-toggle="modal" data-target="#modal<?php echo $sr;?>">Edit | </a>
                                <div id="modal<?php echo $sr;?>" class="modal fade" role="dialog">
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
                                                            <td>Subject : </td>
                                                            <td><input type="text" name="t_sub" value="<?php echo $sub;?>"></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Select Designation: </td>
                                                            <td>

                                                                <select name="category">
                                                                    <option value="principal">অধ্যক্ষ</option>
                                                                    <option value="ahm">সকারী প্রধান শিক্ষক </option>
                                                                    <option value="at">সহকারী শিক্ষক</option>

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
                                                            <td><textarea rows="2" cols="32" name="t_about" value="<?php echo $about;?>"><?php echo $about;?></textarea></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Choose Image :</td>
                                                            <td><input type="file" name="t_img"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <input type="hidden" name="u_id" value="<?php echo $get_tid;?>"></input>
                                                            <input type="hidden" name="img" value="<?php echo $img;?>"></input>
                                                            <td><input type="submit" name="update_teacher" value="Update" style="background-color:green;color:white;height:40px;border-radius:8px;"></td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            </div>
                                            <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                                        </div>
                                    </div>
                                </div>
                                <a onclick='return confirmDelete();' href="adminTeacher.php?TID=<?php echo $get_tid;?>&getImg=<?php echo $img;?>">Delete</a>
                            </td>

                        </tr><br>
                    </table>
                <?php }?>
            </div>
        </div>

        <!-------------Operations on Stuff------------->
        <div class="col-md-6">
            <div class="stuffEditDelete">
                <h4 style="background-color:#5C4283;color:#FFFFFF;height:auto;padding:8px;text-align:center;">Operations on Stuff's Information</h4>
                <?php
                if(!empty($errorStuffUpdate)){echo "<h3 style='color:red'>".$errorStuffUpdate."</h3>"; $errorStuffUpdate="";}
                if(!empty($updateStaffSuccess)){
                    echo "<h3 style='color:green'>".$updateStaffSuccess."</h3>";
                    $updateStaffSuccess="";
                    $DeleteStaffSuccessMessage="";
                    $errorStuffUpdate="";
                }
                if(!empty($DeleteStaffSuccessMessage)){
                    echo "<h3 style='color:green'>".$DeleteStaffSuccessMessage."</h3>";
                    $updateStaffSuccess="";
                    $DeleteStaffSuccessMessage="";
                    $errorStuffUpdate="";
                }
                $test=0;
                $sr=0;
                $modalNumber=110;
                $getTeacherQry=mysql_query("select * from administration where position2='S' order by t_designation asc");
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

                                                                <select name="category">
                                                                    <option value="libralian">সহকারী গ্রন্থাগারিক</option>
                                                                    <option value="oa">অফিস সহকারী </option>
                                                                    <option value="nanny">আয়া</option>
                                                                    <option value="dhoptori">দপ্তরী</option>

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
                                                            <td><textarea rows="2" cols="32" name="t_about" value="<?php echo $about;?>"><?php echo $about;?></textarea></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Choose Image :</td>
                                                            <td><input type="file" name="t_img"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <input type="hidden" name="u_id" value="<?php echo $get_id;?>"></input>
                                                            <input type="hidden" name="img" value="<?php echo $img;?>"></input>
                                                            <td><input type="submit" name="update_stuff" value="Update" style="background-color:green;color:white;height:40px;border-radius:8px;"></td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            </div>
                                            <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                                        </div>
                                    </div>
                                </div>
                                <a onclick='return confirmDelete();' href="adminTeacher.php?SID=<?php echo $get_id;?>&getImg=<?php echo $img;?>">Delete</a>
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