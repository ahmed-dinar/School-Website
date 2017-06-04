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
if(isset($_POST['submitNotice'])){
    try{
        if(empty($_POST['noticeTitle'])){
            throw new Exception("Please Input your Notice Title");
        }

        if(empty($_POST['noticeDes'])){
            throw new Exception("Please Input your Notice Description");
        }

        $noticeTitle=$_POST['noticeTitle'];
        $countWord=str_word_count($noticeTitle);
        echo $countWord;
        if($countWord>10){
            throw new Exception("Please add title within ten words!!!");
        }
        /* $uploaded_file=$_FILES['noticeFile']['name'];
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
             move_uploaded_file($_FILES['noticeFile']['tmp_name'], 'post_files/'.$f1); */
        $insertNoticeQry=mysql_query("insert into noticeboard (post_date,notice_title,notice) values('$post_date','$_POST[noticeTitle]','$_POST[noticeDes]')");
        $insertNoticeSuccess="Notice added successfully.";
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
        $insertEventSuccessMsg="Event added successfully.";
    }
    catch(Exception $e){
        $errorEvent=$e->getMessage();
    }
}



// Update Notice................

if(isset($_POST['update_notice'])){
    try{
        if(empty($_POST['noticeTitle'])){
            throw new Exception("Please Input your Notice Title for Update");
        }

        if(empty($_POST['noticeDes'])){
            throw new Exception("Please Input your Notice Description for Update");
        }

        $noticeTitle=$_POST['noticeTitle'];
        $countWord=str_word_count($noticeTitle);
        echo $countWord;
        if($countWord>10){
            throw new Exception("Please add title within ten words!!!");
        }

        $updateNoticeRQry=mysql_query("update noticeboard set post_date='$post_date',notice_title='$_POST[noticeTitle]',notice='$_POST[noticeDes]' where id='$_POST[nid]' ");
        $updateNoticeSuccess="Notice Updated successfully.";



        // $new_id=$_POST['u_id'];

    }
    catch(Exception $e2){
        $errorNoticeUpdate=$e2->getMessage();
    }
}

// Update Event................

if(isset($_POST['update_event'])){
    try{
        if(empty($_POST['eventTitle'])){
            throw new Exception("Please Input your Event Title for Update");
        }

        if(empty($_POST['eventDes'])){
            throw new Exception("Please Input your Event Description for Update");
        }

        $eventTitle=$_POST['eventTitle'];
        $countWord=str_word_count($eventTitle);
        echo $countWord;
        if($countWord>10){
            throw new Exception("Please add title within ten words!!!");
        }

        $updateNoticeRQry=mysql_query("update events set post_date='$post_date',event_title='$_POST[eventTitle]',event='$_POST[eventDes]' where id='$_POST[eid]' ");
        $updateEventSuccess="Event Updated successfully.";



        // $new_id=$_POST['u_id'];

    }
    catch(Exception $e2){
        $errorEventUpdate=$e2->getMessage();
    }
}


// Delete Notice

if(isset($_REQUEST['NID'])){
    $NID=$_REQUEST['NID'];
    $pbrDelete=mysql_query("delete from noticeboard where id='$NID'");
    $DeleteNoticesuccessMessage="Notice has been deleted successfully";
}

// Delete Event

if(isset($_REQUEST['EID'])){
    $EID=$_REQUEST['EID'];
    $pbrDelete=mysql_query("delete from events where id='$EID'");
    $DeleteEventsuccessMessage="Event has been deleted successfully";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $active_nav=""; $page_title = "Admin - Notice & Events"; include 'includes/head.php'; ?>
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
            <?php $adminNav='notice'; include 'includes/admin_side_menu.php' ?>
        </div>
        <div class="col-md-5">
            <h4 style="background-color:#5C4283;color:#FFFFFF;height:30px;padding-top:3px;text-align:center;">Add New Notice</h4>
            <?php
            if(!empty($errorNotice)){echo "<h3 style='color:red'>".$errorNotice."</h3>";}
            if(!empty($insertNoticeSuccess)){
                echo "<h2 style='color:green'>".$insertNoticeSuccess."</h2>";
            }
            ?>
            <form method="post" action="" enctype="multipart/form-data">
                <p>Type Notice Title: (Use Bangla or English, Within ten words will be bettre)</p>
                <textarea rows="2" cols="50" name="noticeTitle"></textarea><br><br>
                <p>Notice Description: (Use Bangla or English)</p>
                <textarea rows="6" cols="50" name="noticeDes"></textarea><br><br>

                <table style="">
                    <!-------<tr>
                      <td>Choose a file (file must be .pdf,.jpg,.png) :</td>
                      <td><input type="file" name="noticeFile"></td>
                    </tr>  ------->

                    <tr>
                        <td><input type="submit" name="submitNotice" value="Add Notice"></td>
                        <td></td>
                    </tr>
                </table>

            </form>
        </div>

        <div class="col-md-5">
            <h4 style="background-color:#5C4283;color:#FFFFFF;height:30px;padding-top:3px;text-align:center;">Add New Event</h4>
            <?php
            if(!empty($errorEvent)){echo "<h3 style='color:red'>".$errorEvent."</h3>";}
            if(isset($insertEventSuccessMsg)){
                echo "<h2 style='color:green'>".$insertEventSuccessMsg."</h2>";
            }
            ?>
            <form method="post" action="">
                <p>Type Event Title: (Use Bangla or English, Within ten words will be bettre)</p>
                <textarea rows="2" cols="50" name="eventTitle"></textarea><br><br>
                <p>Event Description: (Use Bangla or English)</p>
                <textarea rows="6" cols="50" name="eventDes"></textarea><br>
                <input type="submit" name="submitEvent" value="Add Event">
            </form>
        </div>
    </div>

    <!----------Update Delete Notice----------->
    <div class="col-md-6">
        <div class="techerEditDelete">
            <h4 style="background-color:#5C4283;color:#FFFFFF;height:auto;padding:8px;text-align:center;">Operations on Notice</h4>
            <?php
            if(!empty($errorNoticeUpdate)){echo "<h3 style='color:red'>".$errorNoticeUpdate."</h3>"; $errorNoticeUpdate="";}
            if(!empty($updateNoticeSuccess)){
                echo "<h2 style='color:green'>".$updateNoticeSuccess."</h2>";
                $updateNoticeSuccess="";
                $DeleteNoticesuccessMessage="";
                $errorNoticeUpdate="";
            }
            if(!empty($DeleteNoticesuccessMessage)){
                echo "<h2 style='color:green'>".$DeleteNoticesuccessMessage."</h2>";
                $DeleteNoticesuccessMessage="";
                $updateNoticeSuccess="";
                $errorNoticeUpdate="";
            }
            $test=0;
            $sr=0;
            $getNoticeQry=mysql_query("select * from noticeboard order by id desc");
            while($get=mysql_fetch_array($getNoticeQry)){
                $getNoticeTitle=$get['notice_title'];
                $getDate=$get['post_date'];
                $getNotice=$get['notice'];
                $get_nid=$get['id'];
                $test++;
                $sr++;
                ?>
                <table class="tbl2" width="100%">
                    <?php if($test==1){ ?>
                        <tr>
                            <th width="5%">Sr.&nbsp</th>
                            <th width="60%">Title</th>
                            <th width="20%">Date</th>
                            <th width="15%">Operations</th>
                        </tr>
                    <?php } ?>

                    <tr>
                        <td width="5%"><?php echo $sr;?></td>
                        <td width="60%"><?php echo $getNoticeTitle;?></td>
                        <td width="20%"><?php echo $getDate;?></td>

                        <td width="15%"><a href="#" data-toggle="modal" data-target="#modal<?php echo $sr;?>">Edit | </a>
                            <div id="modal<?php echo $sr;?>" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header"><h4>Update Notice</h4></div>
                                        <div class="modal-body">
                                            <form method="post" action="" enctype="multipart/form-data">
                                                <table>
                                                    <p>Type Notice Title: (Use Bangla or English, Within ten words will be bettre)</p>
                                                    <textarea rows="2" cols="50" name="noticeTitle" value="<?php echo $getNoticeTitle;?>"><?php echo $getNoticeTitle;?></textarea><br><br>
                                                    <p>Notice Description: (Use Bangla or English)</p>
                                                    <textarea rows="6" cols="50" name="noticeDes" value="<?php $getNotice;?>"><?php echo $getNoticeTitle;?></textarea><br><br>

                                                    <tr>
                                                        <td></td>
                                                        <input type="hidden" name="nid" value="<?php echo $get_nid;?>"></input>
                                                        <td><input type="submit" name="update_notice" value="Update" style="background-color:green;color:white;height:40px;border-radius:8px;"></td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </div>
                                        <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                                    </div>
                                </div>
                            </div>
                            <a onclick='return confirmDelete();' href="noticeAdmin.php?NID=<?php echo $get_nid;?>">Delete</a>
                        </td>

                    </tr><br>
                </table>
            <?php }?>
        </div>
    </div>

    <!----------Update Delete Events----------->
    <div class="col-md-6">
        <div class="techerEditDelete">
            <h4 style="background-color:#5C4283;color:#FFFFFF;height:auto;padding:8px;text-align:center;">Operations on Events</h4>
            <?php
            if(!empty($errorEventUpdate)){echo "<h3 style='color:red'>".$errorEventUpdate."</h3>";}
            if(!empty($updateEventSuccess)){
                echo "<h2 style='color:green'>".$updateEventSuccess."</h2>";
                $updateEventSuccess="";
                $DeleteEventsuccessMessage="";
            }
            if(!empty($DeleteEventsuccessMessage)){
                echo "<h2 style='color:green'>".$DeleteEventsuccessMessage."</h2>";
                $DeleteEventsuccessMessage="";
                $updateEventSuccess="";
            }
            $test=2000;
            $sr=0;
            $getNoticeQry=mysql_query("select * from events order by id desc");
            while($get=mysql_fetch_array($getNoticeQry)){
                $getEventTitle=$get['event_title'];
                $getDate=$get['post_date'];
                $getEvent=$get['event'];
                $get_eid=$get['id'];
                $test++;
                $sr++;
                ?>
                <table class="tbl2" width="100%">
                    <?php if($test==1){ ?>
                        <tr>
                            <th width="5%">Sr.&nbsp</th>
                            <th width="60%">Title</th>
                            <th width="20%">Date</th>
                            <th width="15%">Operations</th>
                        </tr>
                    <?php } ?>

                    <tr>
                        <td width="5%"><?php echo $sr;?></td>
                        <td width="60%"><?php echo $getEventTitle;?></td>
                        <td width="20%"><?php echo $getDate;?></td>

                        <td width="15%"><a href="#" data-toggle="modal" data-target="#modal<?php echo $test;?>">Edit | </a>
                            <div id="modal<?php echo $test;?>" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header"><h4>Update Event</h4></div>
                                        <div class="modal-body">
                                            <form method="post" action="" enctype="multipart/form-data">
                                                <table>
                                                    <p>Type Event Title: (Use Bangla or English, Within ten words will be bettre)</p>
                                                    <textarea rows="2" cols="50" name="eventTitle" value="<?php echo $getEventTitle;?>"><?php echo $getEventTitle;?></textarea><br><br>
                                                    <p>Event Description: (Use Bangla or English)</p>
                                                    <textarea rows="6" cols="50" name="eventDes" value="<?php $getEvent;?>"><?php echo $getEvent;?></textarea><br><br>

                                                    <tr>
                                                        <td></td>
                                                        <input type="hidden" name="eid" value="<?php echo $get_eid;?>"></input>
                                                        <td><input type="submit" name="update_event" value="Update" style="background-color:green;color:white;height:40px;border-radius:8px;"></td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </div>
                                        <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                                    </div>
                                </div>
                            </div>
                            <a onclick='return confirmDelete();' href="noticeAdmin.php?EID=<?php echo $get_eid;?>">Delete</a>
                        </td>

                    </tr><br>
                </table>
            <?php }?>
        </div>
    </div>

</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>