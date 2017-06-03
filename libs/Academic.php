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

function getAcademic($type, $class, $group, $db){

    $statement = "SELECT * FROM `academic` WHERE `type`=:type ";

    if( !is_null($class) )
        $statement .= " AND `class` = :class ";

    if( !is_null($group) )
        $statement .= " AND `group` = :group ";

    $statement .= " ORDER BY `type` DESC, `class` ASC, `group` DESC;";
    $_query = $db->prepare($statement);
    $_query->bindValue(":type",$type);

    if( !is_null($class) )
        $_query->bindValue(":class",$class);

    if( !is_null($group) )
        $_query->bindValue(":group",$group);

    if( !$_query->execute() ){
        echo "Error while processing error";
        exit(0);
    }

    return $_query->fetchAll(PDO::FETCH_OBJ);
}