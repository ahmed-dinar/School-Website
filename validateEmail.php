<?php
/**
 *  Author: Ahmed-Dinar
 *  Created: 30/05/2017
 *
 *  For validating email for registration process , if an email already registered, returns false
 *  Only accept ajax request
 *  TODO: maybe add an option to check if ajax, or die. Possible? Also already added csrf, why not use it?
 */

include('database/connect.php');

if( isset($_POST['email']) ) {

    $email = $_POST['email'];
    $_query = $db->prepare('SELECT * FROM alumnai WHERE email = ? LIMIT 1');

    if( $_query->execute([$email]) ){
        $_count = $_query->rowCount();
        if( !$_count ){
            echo "true";
        }
        else{
            echo "false";
        }
    }
    else{
        echo "false";
    }
}else{
    echo "false";
}
