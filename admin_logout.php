<?php
/**
 * Created by PhpStorm.
 * User: ahmed-dinar
 */

include 'includes/core.php';

if( isset($_SESSION['admin']) ){
    unset($_SESSION['admin']);
}

header("Location: admin.php");
exit(0);