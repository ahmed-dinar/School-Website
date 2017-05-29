<?php
/**
 * Edited and comments added by Ahmed-Dinar, 30/05/2017
 *
 * mysql_connect and mysql_select_db is Deprecated, don't use it.
 * Check:
 * http://php.net/manual/en/function.mysql-connect.php
 * https://stackoverflow.com/a/16531304/4839437
 *
 */


mysql_connect('localhost','root','') or die('Can not connect to the database.');
mysql_select_db('db_bsc') or die('Database Can not be found.');

$dbhost='localhost';
$dbname='db_bsc';
$dbusername='root';
$dbpassword='';

try{
    $db = new PDO("mysql:host={$dbhost};dbname={$dbname}",$dbusername,$dbpassword);
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    die($e->getMessage());
}

?>