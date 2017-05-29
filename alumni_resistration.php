<?php
/**
 *  Author: Ahmed-Dinar
 *  Created: 29/05/2017
 */

error_reporting(E_ERROR | E_WARNING | E_PARSE);

//start our session if not already started
if (!session_id()) {
    session_start();
}

//load config file
$config = require ('config/config.php');

require 'includes/FlashMessages.php';
$msg = new \Plasticbrain\FlashMessages\FlashMessages();

//form validator
require 'includes/gump.class.php';


//set csrf token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //if csrf token does not match, there something wrong, may be security issue
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "Invalid request";
        exit();
    }

    //if captcha not found in form, flash error and redirect
    if( !isset($_POST['g-recaptcha-response']) ) {
        $msg->error("captcha error", "alumni_resistration.php");
    }

    if( validateCaptcha($_POST["g-recaptcha-response"]) ) {
        $msg->error("captcha does not match", "alumni_resistration.php");
    }

    $validator = new GUMP();
    $_POST = $validator->sanitize($_POST);

    $validator->validation_rules(array(
        'name'    => 'required|alpha_space|max_len,100|min_len,3',
        'email'    => 'required|valid_email',
        'passingYear' => 'required|numeric|exact_len,4',
        'currentOrg' => 'max_len,50',
        'presentAddress' => 'required|max_len,80',
        'permanentAddress' => 'required|max_len,80',
        'currentStatus' => 'max_len,30',
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

    $validated_data = $validator->run($_POST);

    if(!$validated_data) {
        $errHtml = "";
        foreach ($validator->get_readable_errors() as $readable_error) {
            $errHtml .= $readable_error."<br>";
        }
        $msg->error($errHtml, "alumni_resistration.php");
    } else {
        foreach ($validated_data as $vdata) {
            echo $vdata."<br>";
        }
    }


    // header('Location: alumni_resistration.php', true, 302);
    // exit();
}



/**
 * Validate recaptcha
 * @param $captchaResponse
 */
function validateCaptcha($captchaResponse) {
    global $config;
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

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php $active_nav="alumni"; $page_title = "Alumni Members"; include 'includes/head.php' ?>
    <script src="js/jquery.validate.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="content container min-body" style="margin-bottom: 30px;">
    <div class="row">

        <div class="col-md-2">
            <?php include "includes/alumni_side_menu.php"; ?>
        </div>

        <div class="col-md-10">
            <h4 class="head-title" style="margin-bottom: 20px;">Resister for alumni</h4>

            <?php
            //show flash messages
            if ($msg->hasErrors()) {
                $msg->display();
            }
            ?>

            <div class="col-md-7">

                <form action="alumni_resistration.php" method="post" id="resForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="inputName">Full name<sup>*</sup></label>
                        <input type="text" name="name" class="form-control" id="inputName" placeholder="Name" >
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1">Email address<sup>*</sup></label>
                        <input type="email" name="email" class="form-control" id="inputEmail1" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="passingYear">Passing Year<sup>*</sup></label>
                        <input type="text" name="passingYear" class="form-control" id="passingYear" placeholder="YYYY" >
                    </div>
                    <div class="form-group">
                        <label for="group">Group<sup>*</sup></label>
                        <select id="group" class="form-control" name="group">
                            <option value="">Select group</option>
                            <option value="sc">Science</option>
                            <option value="hum">Humanities</option>
                            <option value="com">Commerce</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="currentStatus">Current Position</label>
                        <input type="text" name="currentStatus" class="form-control" id="currentStatus" placeholder="" >
                    </div>
                    <div class="form-group">
                        <label for="currentOrg">Current Organization</label>
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
                        <div class="g-recaptcha" data-sitekey="<?php echo $config->recaptcha->public; ?>"></div>
                    </div>

                    <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" id="csrf_token" name="csrf_token" />

                    <button type="submit" id="submitForm" class="btn btn-lg btn-primary">Submit</button>
                </form>

            </div>
        </div>

    </div>
</div>

<script>

    //validate from in front end
    $("#ressForm").validate({
        rules: {
            name: {
                required: true,
                rangelength: [3,100]
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: "validateEmail.php",
                    type: "post",
                    data: {
                        email: function() {
                            return $( "#inputEmail1" ).val();
                        },
                        csrf: function () {
                            return $( "#csrf_token" ).val();
                        }
                    }
                }
            },
            passingYear: {
                required: true,
                number: true,
                rangelength: [4, 4]
            },
            currentOrg: {
                required: false,
                maxlength: 50
            },
            presentAddress: {
                required: true,
                maxlength: 80
            },
            permanentAddress: {
                required: true,
                maxlength: 80
            },
            currentStatus: {
                required: false,
                maxlength: 30
            },
            phone: {
                required: true,
                number: true,
                maxlength: 20
            },
            group: {
                required: true
            },
            // password: {},
            profileImg: {
                required: true,
                accept: "image/jpg,image/jpeg,image/png,image/gif",
                filesize: 1048576
            }
        },
        messages: {
            name:{
                rangelength: "Name must be between 3 and 100 characters long."
            },
            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address.",
                remote: jQuery.validator.format("{0} is already taken.")
            },
            profileImg: {
                required: 'Image is required',
                accept: "File must be JPEG or PNG, less than 1MB",
                filesize: "File must be JPEG or PNG, less than 1MB"
            },
            passingYear: {
                number: "Please enter a valid year",
                rangelength: "Please enter a valid year"
            },
            phone: {
                number: "Please enter a valid phone number"
            }
        }
    });

</script>

<script src="js/bootstrap.min.js"></script>

<?php include 'includes/footer.php'  ?>



</body>
