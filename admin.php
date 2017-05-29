<?php
/**
 * Author: ahmed-dinar
 * Date: 5/30/17
 */
include('database/connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $page_title = "Governing Body Control"; include 'includes/head.php' ?>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-2">
            <?php include 'includes/admin_side_menu.php' ?>
        </div>

        <div class="col-md-10">

            <div class="form-center">
                <div class="panel panel-info">
                    <div class="panel-heading">Control Panel Login</div>
                    <div class="panel-body" style="padding-top: 30px;">
                        <form method="post" action="admin.php" id="logform">

                            <div class="form-group input-icon">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <input id="iUsername" type="username" name="username" placeholder="Username" class="form-control valpop" required>
                            </div>

                            <div class="form-group input-icon">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                <input id="iPassword" type="password" name="password" placeholder="Password" class="form-control valpop" required>
                            </div>


                            <div class="form-group text-center" style="margin-top: 10px;">
                                <button type="submit" data-loading-text="Logging in.." class="btn btn-success btn-block btn-md">Login</button>
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
</html>
