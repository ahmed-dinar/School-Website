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

//set csrf token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
}

include('database/connect.php');
require 'libs/FlashMessages.php';
$flashMsg = new \Plasticbrain\FlashMessages\FlashMessages();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once 'libs/VALIDATE.php';


    //if csrf token does not match, there something wrong, may be security issue
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid request");
    }

    if( !isset($_POST["content"]) || !isset($_POST["title"]) || !isset($_POST["postId"]) ){
        die("Invalid request");
    }

    $_query = $db->prepare("SELECT `uid` FROM `post` WHERE `id` = :id LIMIT 1;");
    $_query->bindValue(":id", $_POST["postId"]);

    if( !$_query->execute() )
        die("Database error");

    if( $_query->rowCount() == 0 )
        die("404 Not Found");

    //make sure the logged in user is the owner of this post
    if( $_query->fetchAll(PDO::FETCH_OBJ)[0]->uid !== $_SESSION["user"]->id )
        die("403 Forbidden");

    $postId = $_POST["postId"];
    $contents = $_POST["content"];
    $title = $_POST["title"];
    $redirectTo = "edit_post.php?post=$postId";

    if( strlen(trim($contents)) == 0 )
        $flashMsg->error("Content required.", $redirectTo);

    if( strlen(trim($title)) == 0 )
        $flashMsg->error("Title required.", $redirectTo);

    $_query = $db->prepare("UPDATE `post` SET `title` = :title, `content` = :content WHERE `id` = :id ");
    $_query->bindValue(":title", $title);
    $_query->bindValue(":content", $contents);
    $_query->bindValue(":id", $postId);

    if( !$_query->execute() )
        die("Database error");

    //no file selected for updating image of this post, return success
    if( !file_exists($_FILES["imgFile"]['tmp_name']) || !is_uploaded_file($_FILES["imgFile"]['tmp_name']) )
        $flashMsg->success("Post Successfully Updated.", $redirectTo);

    $directory = "alumni_post_img";
    $maxImageSize = 2097152; //2MB
    $imageFile = VALIDATE::file("imgFile", $maxImageSize);

    if( array_key_exists("error", $imageFile) ){
        switch ($imageFile["type"]){
            case "404":
                $flashMsg->error("image required", $redirectTo);
            case "ext":
                $flashMsg->error("only jpg, jpeg & png files are allowed", $redirectTo);
            case "size":
                $flashMsg->error("image size should less than 2 MB", $redirectTo);
            default:
                $flashMsg->error("Error while processing request.", $redirectTo);
        }
    }

    $file = $postId.".".$imageFile["ext"];

    //remove the previous same named image
    if( file_exists("$directory/$file") )
        unlink("$directory/$file");

    // move photo to image dir
    if( !move_uploaded_file($_FILES["imgFile"]['tmp_name'], "$directory/$file") ){
        die("Error, permission denied type 2");

        // return false;
    }

    $_query = $db->prepare("UPDATE `post` SET `img` = :img WHERE `id` = :id");
    $_query->bindValue(":img", $file);
    $_query->bindValue(":id", $postId);

    if( !$_query->execute() )
        die("Database error");

    $flashMsg->success("Post Successfully Updated.", $redirectTo);
    return;
}


parse_str($_SERVER['QUERY_STRING'], $urlQuery);
if( !array_key_exists("post",$urlQuery) )
    die("Invalid request");

$postId = $urlQuery["post"];

$_query = $db->prepare("SELECT * FROM `post` WHERE `id` = :id LIMIT 1;");
$_query->bindValue(":id", $postId);

if( !$_query->execute() )
    die("Database error");

if( $_query->rowCount() == 0 )
    die("404 Not Found");

$post = $_query->fetchAll(PDO::FETCH_OBJ)[0];

if( $post->uid !== $_SESSION["user"]->id )
    die("403 Forbidden");

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

        <form method="post" action="edit_post.php?post=<?php echo $post->id; ?>" id="alumiPostForm" name="alumiPostForm" enctype="multipart/form-data"  >

            <div class="edit-post">
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

                    <div class="panel-heading clearfix">
                        <h4 class="pull-left"><i class="fa fa-pencil" aria-hidden="true"></i> Edit post</h4>
                        <a href="alumni_post?delete=<?php echo $post->id; ?>" class="pull-right btn btn-xs btn-danger">
                            <i class="fa fa-trash-o" aria-hidden="true"></i> Delete Post</a>
                    </div>


                    <div class="form-group">
                        <label>Title</label>
                        <input name="title" id="title" class="form-control" value="<?php echo $post->title; ?>" placeholder="Title" />
                    </div>

                    <div class="form-group">
                        <label>Content</label>
                        <textarea class="form-control" rows="18" name="content" placeholder="Write something..." ><?php echo $post->content; ?></textarea>
                    </div>

                    <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" id="csrf_token" name="csrf_token" />
                    <input type="hidden" value="<?php echo $post->id; ?>"  name="postId" />

                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-primary" id="submitBtn" >Submit</button>
                    </div>

                </div>
                <div class="col-md-4 img-div" >
                    <div class="form-group">
                        <img src="alumni_post_img/<?php echo $post->img; ?>" height="300" width="200" >
                    </div>

                    <div class="form-group">
                        <label>Change Image</label>
                        <input type="file" name="imgFile" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<script src="js/jquery.validate.min.js"></script>
<script>

    //validate from in front end
    $("#alumiPostForm").validate({
        rules: {
            title: {
                required: true,
                maxlength: 512
            },
            content: {
                required: true
            }
        }
    });

</script>

<?php include 'includes/footer.php'  ?>


</body>
