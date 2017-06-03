<?php
/**
 * Author: ahmed-dinar
 * Date: 6/1/17
 */
date_default_timezone_set('Asia/Dhaka');
//error_reporting(E_ALL);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//start our session if not already started
if (!session_id()) {
    session_start();
}

// make sure admin logged in
if( !isset($_SESSION['admin']) ){
    echo "<h3>Forbidden</h3>";
    exit(0);
}

//set csrf token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
}

include('database/connect.php');
require_once 'libs/gump/gump.class.php';
require_once 'libs/VALIDATE.php';
require 'libs/FlashMessages.php';
$flashMsg = new \Plasticbrain\FlashMessages\FlashMessages();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $redirectTo = "adminAlumniAdd.php";

    //if csrf token does not match, there something wrong, may be security issue
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "Invalid request";
        exit();
    }

    $validator = new GUMP();
    $validated_data = validateForm($validator);
    if(!$validated_data) {
        $errHtml = "";
        foreach ($validator->get_readable_errors() as $readable_error) {
            $errHtml .= $readable_error."<br>";
        }
        $flashMsg->error($errHtml, $redirectTo);
    }

    $emailAddr = $validated_data["email"];
    if( !VALIDATE::email($emailAddr, $db) ){
        $flashMsg->error("$emailAddr already taken", $redirectTo);
    }

    $profileImg = VALIDATE::file("profileImg");
    if( array_key_exists("error", $profileImg) ){
        switch ($profileImg["type"]){
            case "404":
                $flashMsg->error("profile image is required", $redirectTo);
            case "ext":
                $flashMsg->error("only jpg, jpeg & png files are allowed", $redirectTo);
            case "size":
                $flashMsg->error("image file should be less than 1MB", $redirectTo);
            default:
                $flashMsg->error("error while processing request", $redirectTo);
        }
    }

    $validated_data["created"]  = date("Y-m-d H:i:s");
    $validated_data["tokenExpire"] = date("Y-m-d H:i:s", strtotime($validated_data["created"]) + (48 * 3600)); //48 hour
    $validated_data["token"] = bin2hex(openssl_random_pseudo_bytes(16));

    $alumniId = saveAlumni($validated_data,$db);
    if( !$alumniId )
        $flashMsg->error("error while processing request", $redirectTo);

    if( !saveProfileImg($alumniId,$profileImg["ext"],$db) )
        $flashMsg->error("error while processing request", $redirectTo);

    $flashMsg->success("Alumni Successfully added", "adminAlumnai.php?status=unverified");
    return;
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

    if( !$_query->execute() )
        return false;

    return $db->lastInsertId();
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $active_nav="alumni"; $page_title = "Alumni Members"; include 'includes/head.php' ?>
    <link href="css/font-awesome.min.css" rel="stylesheet" />
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="content container min-body" style="margin-bottom: 30px;">
    <div class="row">

        <div class="col-md-2">
            <?php $adminNav='alumni'; include 'includes/admin_side_menu.php' ?>
        </div>

        <div class="col-md-10">

            <?php $stat = "add"; include 'includes/adminAlumniNav.php' ?>




            <?php
            //show flash messages
            if ($flashMsg->hasErrors()) {
                $flashMsg->display();
            }

            if ($flashMsg->hasMessages($flashMsg::SUCCESS)) {
                $flashMsg->display();
            }
            ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Add a new Alumni</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-7">

                        <form action="adminAlumniAdd.php" method="post" id="alumniForm" enctype="multipart/form-data">
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

                            <div class="form-group">
                                <label for="profileImg">Add profile image<sup>*</sup></label>
                                <input type="file" name="profileImg" id="profileImg" />
                            </div>

                            <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" id="csrf_token" name="csrf_token" />

                            <button type="submit" id="submitForm" class="btn btn-lg btn-primary">Submit</button>
                        </form>

                    </div>
                </div>
            </div>


        </div>

    </div>
</div>


<script src="js/jquery.validate.min.js"></script>
<script src="js/alumni_form_validate.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php include 'includes/footer.php'  ?>

</body>

