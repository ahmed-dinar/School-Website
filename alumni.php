<?php
/**
 *  Author: Ahmed-Dinar
 *  Created: 29/05/2017
 */

error_reporting(E_ALL);

//start our session if not already started
if (!session_id()) {
    session_start();
}

include('database/connect.php');

//load config file
$config = require ('config/config.php');

require 'libs/FlashMessages.php';
$flashMsg = new \Plasticbrain\FlashMessages\FlashMessages();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $active_nav="alumni"; $page_title = "Alumni Members"; include 'includes/head.php' ?>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="content container min-body">
    <div class="row">

        <div class="col-md-2">
            <?php include "includes/alumni_side_menu.php"; ?>
        </div>

        <div class="col-md-9">
            <div class="panel-body">
            <?php
                //show flash messages
                if ($flashMsg->hasErrors()) {
                    $flashMsg->display();
                }

                if ($flashMsg->hasMessages($flashMsg::SUCCESS)) {
                    $flashMsg->display();
                }
            ?>
            </div>
        </div>

    </div>
</div>


<?php include 'includes/footer.php'  ?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/min.js"></script>
<!-----<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  ---->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

</body>
