<?php
/**
 * Author: Ahmed-Dinar
 * Date: 5/31/17
 */
date_default_timezone_set('Asia/Dhaka');
//error_reporting(E_ALL);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//start our session if not already started
if (!session_id()) {
    session_start();
}

if( isset($_SESSION['user']) ){
    header('Location: alumni.php' );
    exit(0);
}


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

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "Invalid request";
        exit(0);
    }

    if (!isset($_POST['password']) || !isset($_POST['email'])) {
        echo "Invalid request";
        exit(0);
    }

    $password = $_POST['password'];
    $email = $_POST['email'];

    if( !strlen($password) || !strlen($email) ){
        $flashMsg->error("email or password should not empty", "alumni_login.php");
    }

    $_query = $db->prepare("SELECT `id`, `salt`, `status`, `password` FROM `alumnai` WHERE `email` = :email");
    $_query->bindValue(':email', $email);

    //database error
    if( !$_query->execute() ){
        $flashMsg->error("Error while processing request", "alumni_login.php");
    }

    //no token found
    if( $_query->rowCount() == 0 ){
        $flashMsg->error("Invalid email or password", "alumni_login.php");
    }

    $result = $_query->fetchAll(PDO::FETCH_OBJ)[0];

    if( $result->password !== Hash::make($password, $result->salt) ){
        $flashMsg->error("Invalid email or password", "alumni_login.php");
    }

    if( $result->status < 2 ){
        $flashMsg->error("Your account needs admin approval.", "alumni_login.php");
    }

    $_SESSION['user'] = $result;
    header('Location: alumni.php' );
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $active_nav="alumni"; $page_title = "Alumni Members"; include 'includes/head.php' ?>
    <link href="css/font-awesome.min.css" rel="stylesheet" />
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="content container min-body">
    <div class="row">

        <div class="col-md-2">
            <?php $alumniActive="login"; include "includes/alumni_side_menu.php"; ?>
        </div>

        <div class="col-md-9">
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
                        <h4 class="panel-title text-bold text-center">Member Login</h4>
                    </div>
                    <div class="panel-body" style="padding: 24px">
                        <form method="post" action="alumni_login.php" id="logform">
                            <div class="form-group input-icon">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <input type="email" name="email" placeholder="Email" class="form-control">
                            </div>

                            <div class="form-group input-icon">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                <input type="password" name="password" placeholder="Password" class="form-control">
                            </div>
                            <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" name="csrf_token" />
                            <div class="form-group text-center" style="margin-top: 10px;">
                                <button type="submit" data-loading-text="Logging in.." class="btn btn-primary btn-block btn-md">Login</button>
                            </div>
                        </form>
                        <a href="#" class="forgot-password pull-right">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<?php include 'includes/footer.php'  ?>


<script src="js/bootstrap.min.js"></script>

</body>
