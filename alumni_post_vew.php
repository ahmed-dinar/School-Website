<?php
/**
 * Author: ahmed-dinar
 * Date: 6/8/17
 */
include 'includes/core.php';

//make sure user is logged in
if( !isset($_SESSION["user"]) ) {
    header("Location: alumni_login.php");
    exit();
}

include('database/connect.php');
require 'libs/FlashMessages.php';
$flashMsg = new \Plasticbrain\FlashMessages\FlashMessages();


parse_str($_SERVER['QUERY_STRING'], $urlQuery);
if( !array_key_exists("post",$urlQuery) )
    die("404, not found");

$id = $urlQuery["post"];
$statement = "
SELECT `post`.*, `alumnai`.`name`  FROM `post` 
LEFT JOIN `alumnai`
ON `post`.`uid` = `alumnai`.`id`
WHERE `post`.`id` = :id
LIMIT 1
";

$_query = $db->prepare($statement);
$_query->bindValue(':id', $id);

if( !$_query->execute() )
    die("Database error");

if( $_query->rowCount() == 0 )
    die("404, not found");

$post = $_query->fetchAll(PDO::FETCH_OBJ)[0];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php $active_nav="alumni"; $page_title = "Alumni Members"; include 'includes/head.php' ?>
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:600|Source+Sans+Pro|Open+Sans:400,600,700" rel="stylesheet">
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="content container min-body">
    <div class="row">

        <?php $alumniActive="post"; include "includes/alumni_side_menu.php"; ?>

        <div class="col-md-8">
            <div class="post-view">
                <h3><?php echo $post->title; ?></h3>
                <div class="post-info">
                    <span><i class="fa fa-user" aria-hidden="true"></i> by <?php echo strtoupper($post->name); ?></span>
                    <span><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo strtoupper(date('l, F jS, Y', strtotime($post->posted)));  ?></span>
                </div>
                <img height="748px" width="300px" src="alumni_post_img/<?php echo $post->img; ?>" />
                <p><?php echo nl2br($post->content); ?></p>
            </div>
        </div>
    </div>
</div>



<?php include 'includes/footer.php'  ?>


</body>



