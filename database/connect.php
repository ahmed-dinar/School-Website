<?php

   mysql_connect('localhost','root','') or die('Can not connect to the database.');
   
   mysql_select_db('db_bsc') or die('Database Can not be found.');
  
  $dbhost='localhost';
  $dbname='db_bsc';
  $dbusername='root';
  $dbpassword='';
  
  try{
	    $db=new PDO("mysql:host={$dbhost};dbname={$dbname}",$dbusername,$dbpassword);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	  }
  
  catch(PDOException $e){
	    echo "Connection error: ".$e->getMessage();
	  }

?>