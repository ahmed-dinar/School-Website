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

require_once 'libs/Alumni.php';
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
$user = Alumni::getUser($_SESSION["user"]->id, $db);
if( $user->img === '' )
    $user->img = 'blank-profile.png';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php $active_nav="alumni"; $page_title = "Alumni Members"; include 'includes/head.php' ?>
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:600|Open+Sans:400,600,700" rel="stylesheet">
    <script src="js/moment.min.js"></script>
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

            <?php $comments = Alumni::getComments($post->id, $db);  ?>

            <div class="comments">


                <?php
                if ($flashMsg->hasErrors()) {
                    $flashMsg->display();
                }

                if ($flashMsg->hasMessages($flashMsg::SUCCESS)) {
                    $flashMsg->display();
                }
                ?>

                <h5 class="text-bold"><i class="fa fa-comments" aria-hidden="true"></i> Comments (<?php echo count($comments); ?>)</h5>

                <table class="table comment-table">
                    <tbody>

                    <tr>
                        <td><img src="img_alumni/<?php echo $user->img; ?>" width="48" height="48" /></td>
                        <td>
                            <form method="post" action="alumni_comment.php?post=<?php echo $post->id; ?>" name="comment-form" accept-charset="utf-8" >
                                <div style="margin-bottom: 6px;">
                                    <textarea id="commentBox" class="form-control" rows="2" name="comment" placeholder="Leave a comment..." ></textarea>
                                </div>
                                <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" id="csrf_token" name="csrf_token" />
                                <button type="submit" id="commentBtn" class="btn btn-sm btn-primary">Post</button>
                            </form>
                        </td>
                    </tr>

                    <?php foreach ($comments as $comment){
                        if($comment->img === '')
                            $comment->img = "blank-profile.png";
                    ?>
                        <tr>
                            <td><img src="img_alumni/<?php echo $comment->img; ?>" width="48" height="48" /></td>
                            <td>
                                <div class="clearfix comment-info"><a href="alumniProfile.php?id=<?php echo $comment->uid; ?>"><?php echo $comment->name; ?></a> <span><?php echo $comment->posted; ?></span></div>
                                <p><?php echo nl2br($comment->content); ?></p>
                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>

<script>

    $( document ).ready(function() {
        $("#commentBtn").hide();

        $(".comment-info span").each(function(i, postedAt) {
            var postTime = moment( $(postedAt).text() );
            if( postTime.isValid() ){
                $(postedAt).text( postTime.fromNow() );
            }
        });

    });

    $('#commentBox').on("change keyup paste", function() {
        if( !$.trim( $(this).val() ) ){
            $("#commentBtn").hide();
        }else{
            $("#commentBtn").show();
        }
    });

</script>

<?php include 'includes/footer.php'  ?>


</body>



