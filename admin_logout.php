<?php
/**
 * Created by PhpStorm.
 * User: ahmed-dinar
 */

//start our session if not already started
if (!session_id()) {
    session_start();
}

if( isset($_SESSION['admin']) ){
    unset($_SESSION['admin']);
}

header("Location: admin.php");
exit(0);