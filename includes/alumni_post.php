<?php
/**
 * Author: ahmed-dinar
 * Date: 6/8/17
 */

require_once 'libs/VALIDATE.php';

$redirectTo = "alumni_post.php";
$directory = "alumni_post_img";

//check if the photo has write permission
if( !is_writable($directory) ){
     die("Error, permission denied");

   // return false;
}


//if csrf token does not match, there something wrong, may be security issue
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid request");
}

if( !isset($_POST["content"]) || !isset($_POST["title"]) ){
    die("Invalid request");
}

$maxImageSize = 2097152; //1MB
$imageFile = VALIDATE::file("file", $maxImageSize);

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

$contents = $_POST["content"];
$title = $_POST["title"];

if( strlen(trim($contents)) == 0 )
    $flashMsg->error("Content required.", $redirectTo);

if( strlen(trim($title)) == 0 )
    $flashMsg->error("Title required.", $redirectTo);


$uid = $_SESSION["user"]->id;

$_query = $db->prepare("INSERT INTO `post` SET `uid` = :uid, `title` = :title, `content` = :content ");
$_query->bindValue(":uid", $uid);
$_query->bindValue(":title", $title);
$_query->bindValue(":content", $contents);

if( !$_query->execute() )
    die("Database error");

$id = $db->lastInsertId();
$file = $id.".".$imageFile["ext"];

//remove the previous same named image
if( file_exists("$directory/$file") )
    unlink("$directory/$file");


// move photo to image dir
if( !move_uploaded_file($_FILES["file"]['tmp_name'], "$directory/$file") ){
    die("Error, permission denied type 2");

   // return false;
}

$_query = $db->prepare("UPDATE `post` SET `img` = :img WHERE `id` = :id");
$_query->bindValue(":img", $file);
$_query->bindValue(":id", $id);

if( !$_query->execute() )
    die("Database error");

$flashMsg->success("Successfully Posted.", $redirectTo);