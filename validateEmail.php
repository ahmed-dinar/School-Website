<?php
/**
 *  Author: Ahmed-Dinar
 *  Created: 30/05/2017
 *
 *  For validating email for registration process , if an email already registered, returns false
 *  Only accept ajax request
 *  TODO: maybe add an option to check if ajax, or die. Possible? Also already added csrf, why not use it?
 */

require_once 'database/connect.php';
require_once 'libs/VALIDATE.php';

if( isset($_POST['email']) ) {

    $email = $_POST['email'];

    if( !VALIDATE::email($email, $db) )
        echo "false";
    else
        echo "true";

}else{
    echo "Forbidden";
}
