<?php
/**
 * User: ahmed-dinar
 * Date: 6/5/17
 */

include 'includes/core.php';


//make sure user is logged in
if( !isset($_SESSION["user"]) ) {
    header("Location: alumni_login.php");
    exit();
}

//set csrf token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
}


include('database/connect.php');
include 'includes/paginator.php';
require_once 'libs/Pagination.php';

require 'libs/FlashMessages.php';
$flashMsg = new \Plasticbrain\FlashMessages\FlashMessages();

parse_str($_SERVER['QUERY_STRING'], $urlQuery);


/**
 * Delete a post
 */
if( array_key_exists("delete",$urlQuery) ){

    $postId = $urlQuery["delete"];

    $_query = $db->prepare("SELECT `uid` FROM `post` WHERE `id` = :id LIMIT 1;");
    $_query->bindValue(":id", $postId);

    if( !$_query->execute() )
        die("Database error");

    if( $_query->rowCount() == 0 )
        die("404 Not Found");

    if( $_query->fetchAll(PDO::FETCH_OBJ)[0]->uid !== $_SESSION["user"]->id )
        die("403 Forbidden");

    $_query = $db->prepare("DELETE FROM `post` WHERE `id` = :id ");
    $_query->bindValue(":id", $postId);

    if( !$_query->execute() )
        die("Database error");

    $flashMsg->success("Post successfully deleted", "alumni_post.php");
    return;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'includes/alumni_post.php';
    return;
}

$userId = null;

//for pagination
$curPage = 1;


//for a specific user
if( array_key_exists("user",$urlQuery) ){
    $userId = $urlQuery["user"];

    $_query = $db->prepare( "SELECT `name` FROM `alumnai` WHERE `id` = :id");
    $_query->bindValue(':id', $userId);

    if( !$_query->execute() )
        die("Database error");

    if( $_query->rowCount() == 0 )
        die("404 Not Found");

    $username =  $_query->fetchAll(PDO::FETCH_OBJ)[0]->name;
}




//if page exists in url, validate it as integer
if( array_key_exists("page",$urlQuery) && filter_var($urlQuery["page"], FILTER_VALIDATE_INT) && $urlQuery["page"] > 0 ){
    $curPage = $urlQuery["page"];
}

$statement = "SELECT COUNT(*) as `count` FROM `post` WHERE `status` = 1";
if( !is_null($userId) )
    $statement .= " AND `uid` = :uid ";

$_query = $db->prepare($statement);

if( !is_null($userId) )
    $_query->bindValue(':uid', $userId);

if( !$_query->execute() )
    die("Database error");

$result = $_query->fetchAll(PDO::FETCH_OBJ)[0];
$pageLimit = 5;
$pagination = new Pagination($curPage, $pageLimit, $result->count);


$statement = "
SELECT `post`.*, `alumnai`.`name`  FROM `post` 
LEFT JOIN `alumnai`
ON `post`.`uid` = `alumnai`.`id`
WHERE `post`.`status` = 1 
";

if( !is_null($userId) )
    $statement .= " AND `post`.`uid` = :uid ";

$statement .= " ORDER  BY `post`.`posted` DESC LIMIT :limit OFFSET :offset;";

$_query = $db->prepare($statement);
$_query->bindValue(':limit', (int)$pagination->getLimit(), PDO::PARAM_INT);
$_query->bindValue(':offset', (int)$pagination->offset(), PDO::PARAM_INT);
if( !is_null($userId) )
    $_query->bindValue(':uid', $userId);

if( !$_query->execute() )
    die("Database error");

$postList = $_query->fetchAll(PDO::FETCH_OBJ);


/**
 * https://stackoverflow.com/a/4258963
 * @param $text
 * @return bool|string
 */
function readMore($text){

    $text = strip_tags($text);
    $maxChar = 350;
    if (strlen($text) > $maxChar) {

        // truncate string
        $stringCut = substr($text, 0, $maxChar);
        $coco = 0;
        $co = 0;
        for($i=0; $i<strlen($stringCut) && $coco<7; $i++){

            if( $stringCut[$i] === PHP_EOL ){
                $coco++;
                continue;
            }
            $co++;
            if($co===57)
                $coco++;
        }
        $stringCut = substr($text, 0, $i);
        $text = substr($stringCut, 0, strrpos($stringCut, ' '));
    }
    return $text;
}


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

            <?php
            //show flash messages
            if ($flashMsg->hasErrors()) {
                $flashMsg->display();
            }

            if ($flashMsg->hasMessages($flashMsg::SUCCESS)) {
                $flashMsg->display();
            }
            ?>


            <div class="panel panel-default" id="editorPanel">
                <div class="panel-heading"><i class="fa fa-pencil" aria-hidden="true"></i> Write post</div>
                <form method="post" action="alumni_post.php" id="alumiPostForm" name="alumiPostForm" enctype="multipart/form-data" accept-charset="utf-8"  >
                    <input name="title" id="title" class="form-control" style="margin-bottom: 10px; border: 0; border-bottom: 1px solid #ccc;" value="" placeholder="Title" />
                    <textarea id="postEditor" class="form-control" rows="4" name="content" placeholder="Write something..." ></textarea>
                    <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" id="csrf_token" name="csrf_token" />
                    <div class="panel-body" id="editorBtn">
                        <div class="pull-left">
                            <p style="float: left; margin-right: 6px;" class="text-bold">Add Image: </p> <input style="float: left;" type="file" name="file" />
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="pull-right btn btn-sm btn-primary" id="submitBtn" >Post</button>
                            <button class="pull-right btn btn-sm btn-default" id="resetBtn" style="margin-right: 10px;" >Reset</button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if( !is_null($userId) ){ ?>
                <h5 style="border-bottom: 1px solid #ddd; line-height: 2em; ">
                    <?php if( $userId === $_SESSION["user"]->id ){  ?>
                        <b>My Posts</b>
                    <?php }else{  ?>
                        Posts by <b><?php echo $username; ?></b>
                    <?php }  ?>
                </h5>
            <?php }  ?>

            <?php if(!empty($postList)){ ?>

                <?php foreach ($postList as $post){ ?>

                    <div class="post-wrapper">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>
                                    <a href="alumni_post_vew.php?post=<?php echo $post->id; ?>">
                                        <?php echo $post->title; ?>
                                    </a>
                                </h3>
                                <div class="post-info">
                                    <span>
                                        <i class="fa fa-user" aria-hidden="true"></i> by <a href="alumni_post.php?user=<?php echo $post->uid; ?>"><?php echo strtoupper($post->name); ?></a>
                                    </span>
                                    <span><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo strtoupper(date('l, F jS, Y', strtotime($post->posted)));  ?></span>
                                </div>
                            </div>
                            <div class="clearfix content-heading">
                                <img class="pull-left" height="300px" width="300px" src="alumni_post_img/<?php echo $post->img; ?>" />
                                <p><?php echo nl2br(readMore($post->content)); ?>... <a href="alumni_post_vew.php?post=<?php echo $post->id; ?>">Read More</a></p>
                            </div>

                            <?php if( !is_null($userId) && $post->uid === $_SESSION["user"]->id ){  ?>
                                <div class="clearfix" style="margin-top: 10px;">
                                    <a href="alumni_post.php?delete=<?php echo $post->id; ?>" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </a>
                                    <a href="edit_post?post=<?php echo $post->id; ?>" class="btn btn-sm btn-primary">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                <?php } ?>
                <?php showPagination($pagination, "alumni_post.php?"); ?>
            <?php } ?>

        </div>
    </div>
</div>


<script src="js/jquery.validate.min.js"></script>
<script>

    $( document ).ready(function() {
        $("#editorBtn").hide();
    });

    $('#postEditor').on("focus", function () {
        $("#editorPanel").addClass("focus-editor");
    });

    $('#title').on("focus", function () {
        $("#editorPanel").addClass("focus-editor");
    });

    $('#postEditor').on("blur", function () {
        $("#editorPanel").removeClass("focus-editor");
    });

    $('#title').on("blur", function () {
        $("#editorPanel").removeClass("focus-editor");
    });

    $("#resetBtn").on("click", function (e) {
        e.preventDefault();
        $('#title').val("");
        $('#postEditor').val("");
        $("#editorBtn").hide();
    });

    $('#postEditor').on("change keyup paste", function() {
        if( !$.trim( $(this).val() ) ){
            $("#editorBtn").hide();
        }else{
            $("#editorBtn").show();
        }
    });

    //validate from in front end
    $("#alumiPostForm").validate({
        rules: {
            title: {
                required: true,
                maxlength: 512
            },
            content: {
                required: true
            },
            file: {
                required: true
            }
        },
        messages: {
            title: {
                required: "",
                maxlength: ""
            },
            content: {
                required: ""
            },
            file: {
                required: ""
            }
        }
    });

</script>

<?php include 'includes/footer.php'  ?>


</body>