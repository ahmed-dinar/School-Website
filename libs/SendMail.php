<?php
/**
 * Author: ahmed-dinar
 * Date: 5/31/17
*/
date_default_timezone_set('Etc/UTC');

require 'PHPMailer/PHPMailerAutoload.php';

class SendMail
{
    protected $mail;
    protected $error = false;
    protected $body = false;
    protected $html = false;

    public function __construct($sendTo, $subject = "", $sendFrom = null){

        $config = require('config/config.php');

        $this->mail = new \PHPMailer;

        //Tell PHPMailer to use SMTP
        $this->mail->isSMTP();

        //set 0 for production
        $this->mail->SMTPDebug = 1;

        //Set the hostname of the mail server
        $this->mail->Host = 'smtp.gmail.com';

        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        //also, Gmail SMTP port for SSL: 465
        $this->mail->Port = 587;

        //Set the encryption system to use - ssl (deprecated) or tls
        $this->mail->SMTPSecure = 'tls';

        //Whether to use SMTP authentication
        $this->mail->SMTPAuth = true;

        //set credentials
        $this->mail->Username = $config->gmail->mail;
        $this->mail->Password = $config->gmail->password;

        //Set who the message is to be sent from
        if( !is_null($sendFrom) ){
            $this->mail->setFrom($config->gmail->mail, $sendFrom);
        }

        $this->mail->isHTML(true);

        //Set who the message is to be sent to
        $this->mail->addAddress($sendTo);

        $this->mail->Subject = $subject;
    }


    /**
     * Add mail message body
     * @param null $body
     */
    public function setBody($body = null){
        if( !is_null($body) ){
            $this->mail->Body = $body;
            $this->body = true;
        }
    }


    /**
     * Add a html template file as message body
     * @param null $templateFile
     * @param string $basedir
     */
    public function addTemplate($templateFile = null, $basedir = ''){
        if( !is_null($templateFile) ){
            $this->mail->msgHTML(file_get_contents($templateFile), $basedir);
            $this->html = true;
        }
    }


    /**
     * Add Attachment files
     * @param null $file
     */
    public function addAttachment($file = null){
        if( !is_null($file) ){
            $this->mail->addAttachment($file);
        }
    }

    /**
     * Send mail
     * @return bool
     */
    public function send(){

        if( !$this->body && !$this->html ){
            $this->error = "Mail body required";
            return false;
        }

        if ($this->mail->send()) {
            return true;
        }

        $this->error = $this->mail->ErrorInfo;
        return false;
    }

    /*
     * If error, get it
     */
    public function getError(){
        return $this->error;
    }
}