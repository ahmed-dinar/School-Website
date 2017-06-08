<?php
/**
 * Author: ahmed-dinar
 * Date: 6/6/17
 */


//set csrf token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
}


/**
 * Processing post request
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $redirectTo = "adminAcademic.php?type=examSchedule";
    require_once 'libs/VALIDATE.php';

    //if csrf token does not match, there something wrong, may be security issue
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid request");
    }

    if( !isset($_POST['title']) || $_POST['title'] === '' ){
        $flashMsg->error("title is required", $redirectTo);
    }

    if( !isset($_POST['year']) || $_POST['year'] === '' ){
        $flashMsg->error("year is required", $redirectTo);
    }

    $academicFile = VALIDATE::academicFile("file");
    validateFile($academicFile, $flashMsg, $redirectTo);

    $title = $_POST['title'];
    $year = $_POST['year'];
    $term = $_POST['term'];
    $college = $_POST['college'];

    if( strlen($title) > 512 ){
        $flashMsg->error("title must be less than 512 characters long", $redirectTo);
    }

    $input = (int)$year;
    if($input < 1000 || $input > 5100)
        $flashMsg->error("Invalid year", $redirectTo);


    //check if the file folder has write permission
    if( !is_writable('exam_schedule_files') ){
       //  die("exam_schedule_files has not write permission!<br>");

        $flashMsg->error("Error while processing request.",$redirectTo);
    }


    /**
     * Change file
     */
    if( array_key_exists("change", $urlQuery) ){

        $id = $urlQuery["change"];

        if( !VALIDATE::exists('id', $id, $db, 'exam_schedule') )
            $flashMsg->error("404, No such file.", $redirectTo);

        $academicFile = VALIDATE::academicFile("file");
        validateFile($academicFile, $flashMsg, $redirectTo);

        if( !updateAcademic($id, $type, $academicFile["ext"], $db, "file") )
            $flashMsg->error("Error while processing request updatessss", $redirectTo);

        $flashMsg->success("$type Successfully updated",$redirectTo);
        return;
    }


    $_query = $db->prepare("INSERT INTO `exam_schedule`(`title`,`term`,`college`,`year`) VALUES(:title, :term, :college, :year) ");
    $_query->bindValue(":title", $title);
    $_query->bindValue(":term", $term);
    $_query->bindValue(":college", $college);
    $_query->bindValue(":year", $year);

    if( !$_query->execute() )
        $flashMsg->error("Error while processing request.",$redirectTo);

    $id = $db->lastInsertId();
    $file = $academicFile["ext"];
    $file = "$id.$file";

    //remove the previous same named image
    if(file_exists('exam_schedule_files/'.$file))
        unlink('exam_schedule_files/'.$file);


    // move photo to image dir
    if( !move_uploaded_file($_FILES['file']['tmp_name'], "exam_schedule_files/$file") ){
        // die("image not moved to academic_files<br>");

        $flashMsg->error("Error while processing request.",$redirectTo);
    }

    $_query = $db->prepare("UPDATE `exam_schedule` SET `file` = :file WHERE `id` = :id");
    $_query->bindValue(":file", $file);
    $_query->bindValue(":id", $id);

    if( !$_query->execute() )
        $flashMsg->error("Error while processing request.",$redirectTo);

    $flashMsg->success("Exam Schedule added.",$redirectTo);
    return;
}


/**
 * Delete an item
 */
if( array_key_exists("delete",$urlQuery) ){
    $_query = $db->prepare("DELETE FROM `exam_schedule` WHERE `id` = :id");
    $_query->bindValue(":id", $urlQuery["delete"]);
    if( !$_query->execute()  )
        $flashMsg->error("Error while processing request","adminAcademic.php?type=$type");

    $flashMsg->success("$type Successfully deleted","adminAcademic.php?type=$type");
    return;
}


$college = array_key_exists("college",$urlQuery) ? $urlQuery["college"] : null;
$year = array_key_exists("year",$urlQuery) ? $urlQuery["year"] : null;
$term = array_key_exists("term",$urlQuery) ? $urlQuery["term"] : null;

$schedule = getExamSchedule($db, null, $year, $college, $term);

$termAlias = array(
        "first" => "First Term",
        "second" => "Second Term",
        "final" => "Final",
        "ssc" => "SSC",
        "hsc" => "HSC"
);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php $page_title = "Control panel"; include 'includes/head.php' ?>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container">
    <div class="row">

        <div class="col-md-2">
            <?php $adminNav='academic'; include 'includes/admin_side_menu.php' ?>
        </div>

        <div class="col-md-10">
            <?php
            include 'includes/admin_ac_nav.php';


            if ($flashMsg->hasErrors()) {
                $flashMsg->display();
            }

            if ($flashMsg->hasMessages($flashMsg::SUCCESS)) {
                $flashMsg->display();
            }

            ?>

            <div class="col-md-6">
                <form action="adminAcademic.php?type=examSchedule" id="examForm" method="post" name="examForm" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label>Title <sup>*</sup></label>
                        <input class="form-control" type="text" name="title" />
                    </div>
                    <div class="form-group">
                        <label>Year <sup>*</sup></label>
                        <input class="form-control" type="text" name="year" />
                    </div>
                    <div class="form-group">
                        <label>Term</label>
                        <select class="form-control" name="term">
                            <option value="first">First term</option>
                            <option value="second">Second term</option>
                            <option value="final">Final</option>
                            <option value="ssc">SSC</option>
                            <option value="hsc">HSC</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Section</label>
                        <select class="form-control" name="college">
                            <option value="0">School</option>
                            <option value="1">College</option>
                        </select>
                    </div>
                    <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" id="csrf_token" name="csrf_token" />
                    <div class="form-group">
                        <label for="scFile">Select Exam Schedule File <sup>*</sup></label>
                        <input type="file" name="file" id="scFile" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-primary">Submit</button>
                    </div>
                </form>
            </div>

            <div class="col-md-12">
            <?php if(empty($schedule)){ ?>
                <div class="well text-center">No <?php echo $typeAlias[$type]; ?> added yet</div>
            <?php }else{ ?>


                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Term</th>
                            <th>Section</th>
                            <th>Year</th>
                            <th>View</th>
                            <th>Change</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schedule as $sch){ ?>
                            <tr>
                                <td><?php echo $sch->title; ?></td>
                                <td><?php echo $termAlias[$sch->term]; ?></td>
                                <td><?php echo $sch->college? "College" : "School"; ?></td>
                                <td><?php echo $sch->year; ?></td>
                                <td>
                                    <a target="_blank" class="btn btn-xs btn-info" href="academicFileView.php?type=<?php echo $type; ?>&view=<?php echo $sch->id; ?>">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                </td>
                                <td>
                                    <button acType="<?php echo $type; ?>" examTitle="<?php echo $sch->title; ?>" examYear="<?php echo $sch->year; ?>" examTerm="<?php echo $sch->term; ?>" examSection="<?php echo $sch->college; ?>" id="<?php echo $sch->id; ?>"  class="btn btn-xs btn-primary changeFile" data-toggle="modal" data-target="#changeModal" >
                                        <i class="fa fa-pencil"></i> Change
                                    </button>
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-danger" href="adminAcademic.php?type=<?php echo $type; ?>&delete=<?php echo $sch->id; ?>">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            <?php } ?>
            </div>

        </div>
    </div>
</div>

<script src="js/jquery.validate.min.js"></script>
<script>

    //validate from in front end
    $("#examForm").validate({
        rules: {
            title: {
                required: true,
                maxlength: 512
            },
            year: {
                required: true,
                rangelength: [4,4],
                number: true
            },
            file: {
                required: true
            }
        },
        messages: {
            title:{
                maxlength: "Title must be less than 512 characters long."
            },
            year: {
                number: "Please enter a valid year",
                rangelength: "Please enter a valid year"
            }
        }
    });
</script>

<?php include 'includes/admin_ac_update_examSchedule.php'  ?>

<?php include 'includes/footer.php'  ?>



</body>
</html>

