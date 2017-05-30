<?php

/**
 * Author: ahmed-dinar
 * Date: 5/30/17
 */
class VALIDATE
{

    /**
     * Check if a email taken by someone else
     * @param $email_address
     * @param $db
     * @param string $tbl
     * @return bool
     */
    public static function email($email_address, $db, $tbl = 'alumnai'){

        $statement = "SELECT `id` FROM $tbl WHERE email = ? LIMIT 1";
        $_query = $db->prepare($statement);
        if( $_query->execute([$email_address]) )
            return $_query->rowCount() == 0 ? true : false;

        return false;
    }


    /**
     * Check if captcha valid
     * @param $captchaResponse
     * @return mixed
     */
    public static function captcha($captchaResponse){
        $config = require ('config/config.php');
        $data = array(
            'secret' => $config->recaptcha->secret,
            'response' => $captchaResponse
        );
        $options = array(
            'http' => array(
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $verify = file_get_contents($config->recaptcha->url, false, $context);
        $captcha_success = json_decode($verify);

        return $captcha_success->success;
    }

    /**
     * @param $formField
     * @param int $maxSize
     * @param array $allowedExts
     * @return array
     */
    public static function file($formField, $maxSize = 1048576, $allowedExts = array("jpg","jpeg","png") ){

        if(empty($_FILES)) {
            return array("type" => "empty", "error" => "no file");
        }

        $uploaded_file = $_FILES[$formField];

        if (!isset($uploaded_file['error']) || is_array($uploaded_file['error']) ) {
            return array("type" => "param", "error" => "invalid parameters");
        }

        if(!file_exists($uploaded_file['tmp_name']) || !is_uploaded_file($uploaded_file['tmp_name'])){
            return array("type" => "404", "error" => "please select file");
        }

        $file_extension = substr($uploaded_file['name'], strripos($uploaded_file['name'], '.')+1);
        if (!in_array($file_extension, $allowedExts)) {
            return array("type" => "ext", "error" => "please select a valid file");
        }

        if ($uploaded_file["size"] > $maxSize) {
            return array("type" => "size", "error" => "file size should be less than $maxSize");
        }

        return array("ext" => $file_extension);
    }

}