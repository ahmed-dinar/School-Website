<?php
/**
 * Author: ahmed-dinar
 * Date: 6/1/17
 */

include 'includes/core.php';

if( isset($_SESSION['user']) ){
    unset($_SESSION['user']);
}

header("Location: alumni.php");
exit(0);