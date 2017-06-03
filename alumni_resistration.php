<?php
/**
 *  Author: Ahmed-Dinar
 *  Created: 29/05/2017
 */

error_reporting(E_ALL);

//start our session if not already started
if (!session_id()) {
    session_start();
}

include('database/connect.php');

//load config file
$config = require ('config/config.php');

require_once 'libs/SendMail.php';

require 'libs/FlashMessages.php';
$flashMsg = new \Plasticbrain\FlashMessages\FlashMessages();

//form validator
require_once 'libs/gump/gump.class.php';

//form database validation
require_once 'libs/VALIDATE.php';


//set csrf token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errorRedirect = "alumni_resistration.php";

    //if csrf token does not match, there something wrong, may be security issue
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "Invalid request";
        exit();
    }

    //if captcha not found in form, flash error and redirect
    /*if( !isset($_POST['g-recaptcha-response']) ) {
        $flashMsg->error("captcha error", $errorRedirect);
    }

    if( VALIDATE::captcha($_POST["g-recaptcha-response"]) ) {
        $flashMsg->error("captcha does not match", $errorRedirect);
    }*/

    $validator = new GUMP();
    $validated_data = validateForm($validator);
    if(!$validated_data) {
        $errHtml = "";
        foreach ($validator->get_readable_errors() as $readable_error) {
            $errHtml .= $readable_error."<br>";
        }
        $flashMsg->error($errHtml, $errorRedirect);
    }

    $emailAddr = $validated_data["email"];
    if( !VALIDATE::email($emailAddr, $db) ){
        $flashMsg->error("$emailAddr already taken", $errorRedirect);
    }

    $profileImg = VALIDATE::file("profileImg");
    if( array_key_exists("error", $profileImg) ){
        switch ($profileImg["type"]){
            case "404":
                $flashMsg->error("profile image is required", $errorRedirect);
            case "ext":
                $flashMsg->error("only jpg, jpeg & png files are allowed", $errorRedirect);
            case "size":
                $flashMsg->error("image file should be less than 1MB", $errorRedirect);
            default:
                $flashMsg->error("error while processing request", $errorRedirect);
        }
    }

    $validated_data["created"]  = date("Y-m-d H:i:s");
    $validated_data["tokenExpire"] = date("Y-m-d H:i:s", strtotime($validated_data["created"]) + (48 * 3600)); //48 hour
    $validated_data["token"] = bin2hex(openssl_random_pseudo_bytes(16));

    $alumniId = saveAlumni($validated_data,$db);
    if( !$alumniId ){
        $flashMsg->error("error while processing request", $errorRedirect);
    }

    if( !saveProfileImg($alumniId,$profileImg["ext"],$db) ){
        $flashMsg->error("error while processing request", $errorRedirect);
    }

    $confirmToken = $validated_data["token"];
    $verifyLink = "http://localhost/school/verify?token=".$confirmToken;
    $mailBody = 'Hello,'.$validated_data['name'].'<br><br>Please Follow the link to verify your email within 48 hours.<br><br>' .'<a href="'.$verifyLink.'">'.$verifyLink.'</a><br><br>Thank you,<br>Basundia School & College';

    $mail = new SendMail($emailAddr,'Alumni mail verification', 'BasundiaSC');
    $mail->setBody($mailBody);

    if( !$mail->send() ){
       // echo $mail->getError();
        $flashMsg->error("error while processing request", $errorRedirect);
    }

    $successMsg = "Successfully registered.<br>An email has been sent to $emailAddr. Please check the mail and follow instructions to complete registration.";
    $flashMsg->success($successMsg, "alumni.php");
}


/**
 * Move profile image to web dir and insert img name in db
 * @param $alumniId
 * @param $extn
 * @param $db
 * @return mixed
 */
function saveProfileImg($alumniId, $extn, $db){

    $moveImgName = $alumniId.".".$extn;

    //check if the photo has write permission
    if( !is_writable('img_alumni') ){
        //echo "img_alumni has not write permission!<br>";
        return false;
    }

    //remove the previous same named image
    if(file_exists('img_alumni/'.$moveImgName))
        unlink('img_alumni/'.$moveImgName);

    // move photo to image dir
    if( !move_uploaded_file($_FILES['profileImg']['tmp_name'], 'img_alumni/'.$moveImgName) )
        return false;

    $_query = $db->prepare("UPDATE `alumnai` SET `img` = :img WHERE `id` = :id");
    $_query->bindValue(':img', $moveImgName);
    $_query->bindValue(':id', $alumniId);

    return $_query->execute();
}



/**
 *  Validate alumni form
 * @param $validator
 * @return array
 */
function validateForm($validator){

    $_POST = $validator->sanitize($_POST);

    $validator->validation_rules(array(
        'name'    => 'required|alpha_space|max_len,100|min_len,3',
        'email'    => 'required|valid_email',
        'passingYear' => 'required|numeric|exact_len,4',
        'currentOrg' => 'max_len,50',
        'presentAddress' => 'required|max_len,80',
        'permanentAddress' => 'required|max_len,80',
        'currentStatus' => 'required|max_len,30',
        'phone' => 'numeric|max_len,20',
        'group' => 'required'
    ));

    $validator->filter_rules(array(
        'name' => 'trim|sanitize_string',
        'email' => 'trim|sanitize_email',
        'currentOrg' => 'trim|sanitize_string',
        'currentStatus' => 'trim|sanitize_string',
        'presentAddress' => 'trim|sanitize_string',
        'permanentAddress' => 'trim|sanitize_string',
        'group' => 'trim|sanitize_string',
    ));

    return $validator->run($_POST);
}


/**
 * Save alumni into database
 * @param $validated_data
 * @return bool
 */
function saveAlumni($validated_data, $db){

    $_query = $db->prepare("INSERT INTO `alumnai` (`name`, `passing_year`, `present_address`, `parmanent_address`, `current_status`, `group`, `current_org`, `email`, `phone`, `created`, `token`, `tokenExpire`) VALUES (:name, :passing_year, :present_address, :parmanent_address, :current_status, :group, :current_org, :email, :phone, :created, :token, :tokenExpire) ");
    $_query->bindValue(':name', $validated_data["name"]);
    $_query->bindValue(':passing_year', $validated_data["passingYear"]);
    $_query->bindValue(':present_address', $validated_data["presentAddress"]);
    $_query->bindValue(':parmanent_address', $validated_data["permanentAddress"]);
    $_query->bindValue(':current_status', $validated_data["currentStatus"]);
    $_query->bindValue(':group', $validated_data["group"]);
    $_query->bindValue(':current_org', $validated_data["currentOrg"]);
    $_query->bindValue(':email', $validated_data["email"]);
    $_query->bindValue(':phone', $validated_data["phone"]);
    $_query->bindValue(':created', $validated_data["created"]);
    $_query->bindValue(':token', $validated_data["token"]);
    $_query->bindValue(':tokenExpire', $validated_data["tokenExpire"]);

    if( !$_query->execute() ) return false;

    return $db->lastInsertId();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php $active_nav="alumni"; $page_title = "Alumni Members"; include 'includes/head.php' ?>
   <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="content container min-body" style="margin-bottom: 30px;">
    <div class="row">

        <div class="col-md-2">
            <?php $alumniActive="reg"; include "includes/alumni_side_menu.php"; ?>
        </div>

        <div class="col-md-10">
            <h4 class="head-title" style="margin-bottom: 20px;">Resister for alumni</h4>

            <?php
                //show flash messages
                if ($flashMsg->hasErrors()) {
                    $flashMsg->display();
                }

                if ($flashMsg->hasMessages($flashMsg::SUCCESS)) {
                    $flashMsg->display();
                }
            ?>

            <div class="col-md-7">

                <form action="alumni_resistration.php" method="post" id="alumniForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="inputName">Full name<sup>*</sup></label>
                        <input type="text" name="name" class="form-control" id="inputName" placeholder="Name" >
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1">Email address<sup>*</sup></label>
                        <input type="email" name="email" class="form-control" id="inputEmail1" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="passingYear">Passing Year / Batch<sup>*</sup></label>
                        <input type="text" name="passingYear" class="form-control" id="passingYear" placeholder="YYYY" >
                    </div>
                    <div class="form-group">
                        <label for="group">Group<sup>*</sup></label>
                        <select id="group" class="form-control" name="group">
                            <option value="">Select group</option>
                            <option value="Science">Science</option>
                            <option value="Humanities">Humanities</option>
                            <option value="Commerce">Commerce</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="currentStatus">Present Occupation with Designation<sup>*</sup></label>
                        <input type="text" name="currentStatus" class="form-control" id="currentStatus" placeholder="" >
                    </div>
                    <div class="form-group">
                        <label for="currentOrg">Organization</label>
                        <input type="text" name="currentOrg" class="form-control" id="currentOrg" placeholder="Working place/organization" >
                    </div>
                    <div class="form-group">
                        <label for="presentAddress">Present address<sup>*</sup></label>
                        <textarea name="presentAddress" class="form-control custom-control" id="presentAddress" rows="3" style="resize:none"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="permanentAddress">Permanent address<sup>*</sup></label>
                        <textarea name="permanentAddress" class="form-control custom-control" id="permanentAddress" rows="3" style="resize:none"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone<sup>*</sup></label>
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="mobile/phone" >
                    </div>
                    <!--  <div class="form-group">
                          <label for="inputPassword">Password</label>
                          <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
                      </div> -->
                    <div class="form-group">
                        <label for="profileImg">Upload your image<sup>*</sup></label>
                        <input type="file" name="profileImg" id="profileImg" />
                    </div>
                    <div class="form-group">
                        <!--<div class="g-recaptcha" data-sitekey="<?php echo $config->recaptcha->public; ?>"></div> -->
                    </div>

                    <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" id="csrf_token" name="csrf_token" />

                    <button type="submit" id="submitForm" class="btn btn-lg btn-primary">Submit</button>
                </form>

            </div>
        </div>

    </div>
</div>


<script src="js/jquery.validate.min.js"></script>
<script src="js/alumni_form_validate.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php include 'includes/footer.php'  ?>

</body>
