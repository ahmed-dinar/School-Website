<?php
/**
 * Author: ahmed-dinar
 * Date: 5/31/17
 */

error_reporting(E_ALL);

//start our session if not already started
if (!session_id()) {
    session_start();
}

parse_str($_SERVER['QUERY_STRING'], $url_query);

if( !array_key_exists("token", $url_query) ){
    echo "Invalid request";
    exit(0);
}

include('database/connect.php');

require 'libs/FlashMessages.php';
$flashMsg = new \Plasticbrain\FlashMessages\FlashMessages();

$token = $url_query["token"];

$_query = $db->prepare("SELECT `id` FROM `alumnai` WHERE `token` = :token");
$_query->bindValue(':token', $token);

if( !$_query->execute() ){
    echo "Error while processing request";
    exit(0);
}

if( $_query->rowCount() == 0 ){
    echo "Invalid token or expired";
    exit(0);
}

$result = $_query->fetchAll(PDO::FETCH_OBJ);
$tokenId = $result[0]->id;

$_query = $db->prepare("UPDATE `alumnai` SET `token` = :token, `status` = :stat WHERE `id` = :id ");
$_query->bindValue(':token', '');
$_query->bindValue(':stat', 1);
$_query->bindValue(':id', $tokenId);

if( !$_query->execute() ){
    echo "Error while processing request";
    exit(0);
}

$successMsg = '<h4>Account verified.Profile will be public after admin check.</h4>';
$flashMsg->success($successMsg, "alumni.php");