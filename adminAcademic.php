<?php
/**
 * Author: ahmed-dinar
 * Date: 6/3/17
 */
include 'includes/core.php';

//if admin not logged in
if( !isset($_SESSION['admin']) ){
    header('Location: admin.php' );
    exit(0);
}

require_once 'libs/Academic.php';

parse_str($_SERVER['QUERY_STRING'], $urlQuery);
$type = getActionType($urlQuery);

//invalid or no action in url query
if( $type == false ){
    echo "<h3>Invalid type</h3>";
    exit(0);
}

$typeAlias = array(
    "calender" => "Calender",
    "syllabus" => "Syllabus & Book List",
    "examSchedule" => "Exam Schedule",
    "classRoutine" => "Class Routine"
);


include('database/connect.php');
require 'libs/FlashMessages.php';
$flashMsg = new \Plasticbrain\FlashMessages\FlashMessages();


/**
 * Delete an item
 */
if( array_key_exists("delete",$urlQuery) ){
    deleteAcademic($urlQuery["delete"], $type, $db, $flashMsg, $typeAlias[$type]);
    return;
}


/**
 * Exam schedule
 */
if( $type === 'examSchedule' ){
    include 'includes/admin_exam_schedule.php';
    return;
}

/**
 * Processing post request
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "includes/admin_academic.php";
    return;
}

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


                include "includes/admin_academic.php";
            ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'  ?>

</body>
</html>

