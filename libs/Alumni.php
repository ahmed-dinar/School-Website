<?php

/**
 * User: ahmed-dinar
 * Date: 6/9/17
 */
class Alumni
{

    /**
     * @param $uid
     * @param $db
     * @return mixed
     */
    public static function getUser($uid, $db){
        $_query = $db->prepare("SELECT * FROM `alumnai` WHERE `id` = :id LIMIT 1;");
        $_query->bindValue(":id", $uid);

        if( !$_query->execute() )
            die("Database error");

        return $_query->fetchAll(PDO::FETCH_OBJ)[0];
    }


    public static function getComments($pid, $db){

        $statement = "
SELECT `comment`.*, `alumnai`.`name`, `alumnai`.`img` FROM `comment` 
LEFT JOIN `alumnai` ON `comment`.`uid` = `alumnai`.`id` 
WHERE `comment`.`pid` = :pid 
ORDER BY `comment`.`posted` DESC;
";

        $_query = $db->prepare($statement);
        $_query->bindValue(":pid", $pid);

        if( !$_query->execute() )
            die("Database error");

        return $_query->fetchAll(PDO::FETCH_OBJ);
    }
}