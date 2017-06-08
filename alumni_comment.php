<?php
/**
 * Author: ahmed-dinar
 * Date: 6/9/17
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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token'] || !isset($_POST['comment'])  )  {
        die("invalid request");
    }

    parse_str($_SERVER['QUERY_STRING'], $urlQuery);

    if( !array_key_exists("post",$urlQuery) ){
        die("invalid request");
    }

    require_once 'libs/VALIDATE.php';
    $postId = $urlQuery["post"];

    if( !VALIDATE::exists('id', $postId, $db, "post") ){
        header("Location: 404.php");
        exit();
    }

    $redirectTo = "alumni_post_vew.php?post=$postId";
    $content = $_POST["comment"];

    $len = mb_strlen($content, 'UTF-8');
    if( $len > 999 )
        $flashMsg->error("Comment must be less than 1000 characters long.",$redirectTo);


    $statement = "INSERT INTO `comment` SET `uid` = :uid, `pid` = :pid, `content` = :content ";
    $_query = $db->prepare($statement);
    $_query->bindValue(":uid", $_SESSION["user"]->id);
    $_query->bindValue(":pid", $postId);
    $_query->bindValue(":content", $content);

    if( !$_query->execute() )
        die("database error");

    $flashMsg->success("Comment posted", $redirectTo);
    return;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1 style="margin: 0 auto; width: 200px; margin-top: 200px; text-align: center;">404</h1>
</body>
</html>

