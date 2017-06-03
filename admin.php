<?php
/**
 * Author: ahmed-dinar
 * Date: 5/30/17
 */
date_default_timezone_set('Asia/Dhaka');
//error_reporting(E_ALL);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//start our session if not already started
if (!session_id()) {
    session_start();
}

// if normal user logged in, redirect to normal page
if( isset($_SESSION['user']) ){
    header('Location: alumni.php' );
    exit(0);
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
}

include('database/connect.php');
require_once 'libs/Hash.php';

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

    if (!isset($_POST['password']) || !isset($_POST['username'])) {
        echo "Invalid request";
        exit(0);
    }

    $password = $_POST['password'];
    $username = $_POST['username'];

    if( !strlen($password) || !strlen($username) ){
        $flashMsg->error("username or password should not empty", "admin.php");
    }

    $_query = $db->prepare("SELECT * FROM `admin` WHERE `username` = :username");
    $_query->bindValue(':username', $username);

    //database error
    if( !$_query->execute() ){
        $flashMsg->error("Error while processing request", "admin.php");
    }

    //no token found
    if( $_query->rowCount() == 0 ){
        $flashMsg->error("Invalid username or password", "admin.php");
    }

    $result = $_query->fetchAll(PDO::FETCH_OBJ)[0];

    if( $result->password !== Hash::make($password, $result->salt) ){
        $flashMsg->error("Invalid username or password", "admin.php");
    }

    $_SESSION['admin'] = $result;
    header('Location: admin.php' );
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $page_title = "Control panel"; include 'includes/head.php' ?>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container">
    <div class="row">

        <?php if(isset($_SESSION['admin'])){ ?>
            <div class="col-md-2">
                <?php include 'includes/admin_side_menu.php' ?>
            </div>
            <div class="col-md-10">
                <h3>Welcome to admin panel</h3>
            </div>
        <?php }else{ ?>

            <div class="col-md-12">
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
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title text-bold text-center">Control Panel Login</h4>
                        </div>
                        <div class="panel-body" style="padding-top: 30px;">
                            <form method="post" action="admin.php" id="logform">

                                <div class="form-group input-icon">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <input id="iUsername" type="username" name="username" placeholder="Username" class="form-control">
                                </div>

                                <div class="form-group input-icon">
                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                    <input id="iPassword" type="password" name="password" placeholder="Password" class="form-control">
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
        <?php } ?>

    </div>
</div>


<?php include 'includes/footer.php'  ?>

<script src="js/bootstrap.min.js"></script>

</body>
</html>
