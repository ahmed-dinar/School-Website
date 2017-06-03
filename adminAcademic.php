<?php
/**
 * Author: ahmed-dinar
 * Date: 6/3/17
 */
date_default_timezone_set('Asia/Dhaka');
//error_reporting(E_ALL);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//start our session if not already started
if (!session_id()) {
    session_start();
}

// make sure admin logged in
if( !isset($_SESSION['admin']) ){
    echo "<h3>Forbidden</h3>";
    exit(0);
}

parse_str($_SERVER['QUERY_STRING'], $urlQuery);
$type = getActionType($urlQuery);

//invalid or no action in url query
if( $type == false ){
    echo "<h3>Forbidden</h3>";
    exit(0);
}

include('database/connect.php');
require 'libs/FlashMessages.php';
$flashMsg = new \Plasticbrain\FlashMessages\FlashMessages();


/**
 * Processing post request
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "includes/admin_ac_$type.php";
    return;
}


/**
 * Delete an item
 */
if( array_key_exists("delete",$urlQuery) ){
    $_query = $db->prepare("DELETE FROM `academic` WHERE `id` = :id");
    $_query->bindValue(":id", $urlQuery["delete"]);
    if( !$_query->execute() || $_query->rowCount() == 0  )
        $flashMsg->error("Erro while processing request","adminAcademic.php?type=$type&class=6&group=Science");

    $flashMsg->success("$type Successfully deleted","adminAcademic.php?type=$type&class=6&group=Science");
    return;
}


/**
 * get alumni action type view/delete/accept
 * @param $urlQuery
 * @return bool|string
 */
function getActionType($urlQuery){

    $allowedActions = array("calender","books","syllabus","examRoutine");

    if( array_key_exists("add", $urlQuery) ){
        $postType = $urlQuery["add"];
        if( !in_array($postType, $allowedActions) )
            return false;

        return $postType;
    }

    if( !array_key_exists("type", $urlQuery) )
        return false;

    if( !in_array($urlQuery["type"], $allowedActions) )
        return false;

    return $urlQuery["type"];
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php $page_title = "Control panel"; include 'includes/head.php' ?>
    <!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">-->
    <link href="css/font-awesome.min.css" rel="stylesheet" />
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

                include "includes/admin_ac_$type.php";
            ?>
        </div>
    </div>
</div>




<?php include 'includes/footer.php'  ?>



</body>
</html>

