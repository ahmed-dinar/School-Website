<?php
/**
 * Author: ahmed-dinar
 * Date: 5/31/17
 */

include 'includes/core.php';

include('database/connect.php');
require_once 'libs/Hash.php';

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
}

require 'libs/FlashMessages.php';
$flashMsg = new \Plasticbrain\FlashMessages\FlashMessages();


/**
 * For setting password
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    //if csrf token or confirmation token does not found, there something wrong, may be security issue
    if (
        !isset($_POST['csrf_token'])
        || $_POST['csrf_token'] !== $_SESSION['csrf_token']
        || !isset($_POST['token'])
    ) {
        echo "Invalid request";
        exit(0);
    }

    $token = $_POST['token'];
    $tokenId = isTokenExpired($token, $db);
    if( $tokenId == false ){
        echo "Invalid token or expired";
        exit(0);
    }

    if( !isset($_POST['password']) || !isset($_POST['confirm_password'])){
        $flashMsg->error("password should not empty", "verify.php?token=$token");
    }

    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if( $password !== $confirm_password ){
        $flashMsg->error("password does not match", "verify.php?token=$token");
    }

    $salt = Hash::salt(32);
    $hashedPassword = Hash::make($password, $salt);

    $_query = $db->prepare("UPDATE `alumnai` SET `token` = :token, `status` = :stat, `password` = :password, `salt` = :salt  WHERE `id` = :id ");
    $_query->bindValue(':token', '');
    $_query->bindValue(':stat', 1);
    $_query->bindValue(':id', $tokenId);
    $_query->bindValue(':password', $hashedPassword);
    $_query->bindValue(':salt', $salt);

    if( !$_query->execute() ){
        echo "Error while processing request";
        exit(0);
    }

    $successMsg = '<h4><i class="fa fa-check-circle-o" aria-hidden="true"></i> Account verified.<br>Profile will be public and you can login after admin approval.</h4>';
    $flashMsg->success($successMsg, "alumni.php");

    return;
}


parse_str($_SERVER['QUERY_STRING'], $url_query);

//if get request and no token found, its invalid
if( !array_key_exists("token", $url_query) ){
    echo "Invalid request";
    exit(0);
}


$token = $url_query["token"];
$tokenId = isTokenExpired($token, $db);
if( $tokenId == false ){
    echo "Invalid token or expired";
    exit(0);
}

/**
 * @param $token
 * @param $db
 * @return bool
 */
function isTokenExpired($token, $db){

    $_query = $db->prepare("SELECT `id`,`tokenExpire` FROM `alumnai` WHERE `token` = :token");
    $_query->bindValue(':token', $token);

    //database error
    if( !$_query->execute() ){
        echo "Error while processing request";
        exit(0);
    }

    //no token found
    if( $_query->rowCount() == 0 ){
        return false;
    }

    $result = $_query->fetchAll(PDO::FETCH_OBJ);
    $tokenId = $result[0]->id;
    $tokenExpire = $result[0]->tokenExpire;
    $now = date("Y-m-d H:i:s");

    //token expired
    if( $now > $tokenExpire ){
        return false;
    }

    return $tokenId;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $active_nav="alumni"; $page_title = "Alumni Members"; include 'includes/head.php' ?>
</head>
<body>
<div class="form-center">
    <?php
    //show flash messages
    if ($flashMsg->hasErrors()) {
        $flashMsg->display();
    }

    if ($flashMsg->hasMessages($flashMsg::SUCCESS)) {
        $flashMsg->display();
    }
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title text-bold text-center">Set password for your alumni account</h4>
        </div>
        <div class="panel-body" style="padding: 24px">
            <form method="post" action="verify.php" id="verifyform">
                <div class="form-group input-icon">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                    <input type="password" name="password" placeholder="Password" class="form-control">
                </div>

                <div class="form-group input-icon">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control">
                </div>

                <input type="hidden" value="<?php echo $token; ?>" name="token" />
                <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" name="csrf_token" />

                <div class="form-group text-center" style="margin-top: 10px;">
                    <button type="submit" data-loading-text="Submitting.." class="btn btn-primary btn-block btn-md">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


</body>

