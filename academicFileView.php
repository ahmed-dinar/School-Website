<?php
/**
 * User: ahmed-dinar
 * Date: 6/3/17
 */
date_default_timezone_set('Asia/Dhaka');
//error_reporting(E_ALL);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//start our session if not already started
if (!session_id()) {
    session_start();
}

parse_str($_SERVER['QUERY_STRING'], $urlQuery);
$type = getActionType($urlQuery);

//invalid or no action in url query
if( $type == false ){
    echo "<h3>Forbidden</h3>";
    exit(0);
}

include('database/connect.php');

$id = $urlQuery["view"];

$_query = $db->prepare("SELECT * FROM `academic` WHERE `id`=:id LIMIT 1");
$_query->bindValue(":id",$id);

if( !$_query->execute() ){
    echo "Error while processing request";
    exit(0);
}

if( $_query->rowCount() == 0 ){
    echo "404, no file found";
    exit(0);
}

$fileName = $_query->fetchAll(PDO::FETCH_OBJ)[0]->file;

if( !file_exists("academic_files/$fileName") ){
    echo "404, file not found";
    exit(0);
}


$file_extension = substr($fileName, strripos($fileName, '.')+1);
$content_type = "";
switch ($file_extension){
    case "jpg":
    case "jpeg":
        $content_type = "image/jpeg";
        break;
    case "png":
        $content_type = "image/png";
        break;
    case "pdf":
        $content_type = "application/pdf";
        break;
    default:
        echo "Unknown file type";
        exit(0);
}


header("Content-type: $content_type");
header('Content-Disposition: inline; filename="'.$filename.'"');
header('Content-Transfer-Encoding: binary');
header('Accept-Range: bytes');
header('Content-Length: ' . filesize("academic_files/$fileName"));
@readfile("academic_files/$fileName");


/**
 * get alumni action type view/delete/accept
 * @param $urlQuery
 * @return bool|string
 */
function getActionType($urlQuery){

    $allowedActions = array("calender","books","syllabus","examRoutine");

    if( !array_key_exists("type", $urlQuery) || !array_key_exists("view", $urlQuery) )
        return false;

    if( !in_array($urlQuery["type"], $allowedActions) )
        return false;

    return $urlQuery["type"];
}

?>
