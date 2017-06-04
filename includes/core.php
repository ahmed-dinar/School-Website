<?php
/**
 * Author: ahmed-dinar
 * Date: 6/5/17
 */

date_default_timezone_set('Asia/Dhaka');

//error_reporting(0);  //no report
//error_reporting(E_ALL);  //all error
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//start our session if not already started
if (!session_id()) {
    session_start();
}

