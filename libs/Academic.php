<?php
/**
 * Created by PhpStorm.
 * User: ahmed-dinar
 */

/**
 * @param $type
 * @param $class
 * @param $group
 * @param $db
 * @return mixed
 */

function getAcademic($type, $class, $group, $db, $year = null){

    $statement = "SELECT * FROM `academic` WHERE `type`=:type ";

    if( !is_null($class) )
        $statement .= " AND `class` = :class ";

    if( !is_null($group) )
        $statement .= " AND `group` = :group ";

    if( !is_null($year) )
        $statement .= " AND `year` = :year ";

    $statement .= " ORDER BY `type` DESC, `class` ASC, `group` DESC;";
    $_query = $db->prepare($statement);
    $_query->bindValue(":type",$type);

    if( !is_null($class) )
        $_query->bindValue(":class",$class);

    if( !is_null($group) )
        $_query->bindValue(":group",$group);

    if( !is_null($year) )
        $_query->bindValue(":year",$year);

    if( !$_query->execute() ){
        echo "Error while processing error";
        exit(0);
    }

    return $_query->fetchAll(PDO::FETCH_OBJ);
}


/**
 * @param $academicFile
 * @param $flashMsg
 * @param $redirectTo
 */
function validateFile($academicFile, $flashMsg, $redirectTo){
    if( array_key_exists("error", $academicFile) ){
        switch ($academicFile["type"]){
            case "404":
                $flashMsg->error("file required", $redirectTo);
            case "ext":
                $flashMsg->error("only pdf, jpg, jpeg & png files are allowed", $redirectTo);
            default:
                $flashMsg->error("Error while processing request.s", $redirectTo);
        }
    }
}

/**
 * @param $type
 * @param $class
 * @param $group
 * @param $fileName
 * @param $db
 * @param $flashMsg
 * @param $redirectTo
 */
function saveAcademic($type, $class, $group, $fileName, $db, $flashMsg, $redirectTo, $year = null){

    $year = is_null($year) ? "" : $year;

    $statement = "INSERT INTO `academic`(`type`,`class`,`group`, `year`) VALUES(:type, :class, :group, :year)";
    $_query = $db->prepare($statement);
    $_query->bindValue(":type", $type);
    $_query->bindValue(":class", $class);
    $_query->bindValue(":group", $group);
    $_query->bindValue(":year", $year);

    if( !$_query->execute() || $_query->rowCount() == 0 )
        $flashMsg->error("Error while processing request", $redirectTo);

    if( !updateAcademic($db->lastInsertId(), $type, $fileName, $db) )
        $flashMsg->error("Error while processing request insert", $redirectTo);

    $flashMsg->success("$type Successfully Added", $redirectTo);
}



/**
 * @param $id
 * @param $file
 * @param $db
 * @param $flashMsg
 * @param $redirectTo
 * @return bool
 */
function updateAcademic($id, $type, $file, $db, $fieldName = "sylFile"){

    $tableName = $type === 'examSchedule' ? "exam_schedule" : "academic";
    $directory = $type === 'examSchedule' ? "exam_schedule_files" : "academic_files";

    $file = "$id.$file";

    //check if the photo has write permission
    if( !is_writable($directory) ){
       // die("academic_files has not write permission!<br>");

        return false;
    }

    //remove the previous same named image
    if( file_exists("$directory/$file") )
        unlink("$directory/$file");

    // move photo to image dir
    if( !move_uploaded_file($_FILES[$fieldName]['tmp_name'], "$directory/$file") ){
         // die("image not moved to academic_files<br>");

        return false;
    }

    $_query = $db->prepare("UPDATE `$tableName` SET `file` = :file WHERE `id` = :id");
    $_query->bindValue(":file", $file);
    $_query->bindValue(":id", $id);

    return $_query->execute();
}



/**
 * Alert error
 * @param $error
 */
function showError($error){
    echo '<div class="alert alert-danger" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>'.$error.'</div>';
    exit(0);
}


/**
 * get alumni action type view/delete/accept
 * @param $urlQuery
 * @return bool|string
 */
function getActionType($urlQuery){

    $allowedActions = array("calender","books","syllabus","examSchedule","classRoutine");

    if( array_key_exists("add", $urlQuery) ){
        $postType = $urlQuery["add"];
        if( !in_array($postType, $allowedActions) )
            return false;

        return $postType;
    }

    if( !array_key_exists("type", $urlQuery) )
        return false;

    if( !in_array($urlQuery["type"], $allowedActions) )
        return false;

    return $urlQuery["type"];
}


/**
 * @param $db
 * @param null $id
 * @param null $year
 * @param null $college
 * @param null $term
 * @return mixed
 */
function getExamSchedule($db, $id = null, $year = null, $college = null, $term = null){

    $statement = "SELECT * FROM `exam_schedule` ";
    $and = "";
    $where = "WHERE";
    if( !is_null($college) ) {
        $statement .= " WHERE `college` = :college ";
        $and = "AND";
        $where = "";
    }

    if( !is_null($id) ) {
        $statement .= " $where $and `id` = :id ";
        $and = "AND";
        $where = "";
    }

    if( !is_null($year) ) {
        $statement .= " $where $and `year` = :year ";
        $and = "AND";
        $where = "";
    }

    if( !is_null($term) )
        $statement .= " $where $and `term` = :term ";

    $_query = $db->prepare($statement);

    if( !is_null($college) )
        $_query->bindValue(":college", $college);

    if( !is_null($id) )
        $_query->bindValue(":id", $id);

    if( !is_null($year) )
        $_query->bindValue(":year", $year);

    if( !is_null($term) )
        $_query->bindValue(":term", $term);

    if( !$_query->execute() )
        die("database error");

    return $_query->fetchAll(PDO::FETCH_OBJ);
}


/**
 * Delete an academic entry from database as well as file
 * @param $id
 * @param $type
 * @param $db
 * @param $flashMsg
 * @param $typeName
 */
function deleteAcademic($id, $type, $db, $flashMsg, $typeName){

    $redirectTo = "adminAcademic.php?type=$type";
    $tableName = $type === 'examSchedule' ? "exam_schedule" : "academic";
    $directory = $type === 'examSchedule' ? "exam_schedule_files" : "academic_files";

    $_query = $db->prepare("SELECT `file` FROM `$tableName` WHERE `id` = :id LIMIT 1");
    $_query->bindValue(":id", $id);

    if( !$_query->execute()  )
        $flashMsg->error("Error while processing request",$redirectTo);

    if( $_query->rowCount() == 0 )
        $flashMsg->error("404, No such file",$redirectTo);

    $file = $_query->fetchAll(PDO::FETCH_OBJ)[0]->file;

    $_query = $db->prepare("DELETE FROM `$tableName` WHERE `id` = :id");
    $_query->bindValue(":id", $id);
    if( !$_query->execute()  )
        $flashMsg->error("Error while processing request",$redirectTo);

    //remove the previous same named image
    if(file_exists("$directory/$file"))
        unlink("$directory/$file");

    $flashMsg->success("$typeName Successfully deleted",$redirectTo);
}