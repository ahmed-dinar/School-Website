<?php
/**
 * Author: ahmed-dinar
 * Date: 6/1/17
 */

//start our session if not already started
if (!session_id()) {
    session_start();
}

if( isset($_SESSION['user']) ){
    unset($_SESSION['user']);
}

header("Location: alumni.php");
exit(0);