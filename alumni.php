<?php
/**
 *  Author: Ahmed-Dinar
 *  Created: 29/05/2017
 */

include 'includes/core.php';

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
    <link href="css/font-awesome.min.css" rel="stylesheet" />
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="content container min-body">
    <div class="row">

        <?php $alumniActive="home"; include "includes/alumni_side_menu.php"; ?>

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


</body>
