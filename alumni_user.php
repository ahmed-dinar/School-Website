<?php
/**
 * User: ahmed-dinar
 * Date: 6/1/17
 */
error_reporting(E_ALL);

//start our session if not already started
if (!session_id()) {
    session_start();
}

if( !isset($_SESSION["user"]) ){
    header("Location: alumni_login.php");
    exit(0);
}

//set csrf token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
}


include('database/connect.php');

//form validator
require_once 'libs/gump/gump.class.php';

//form database validation
require_once 'libs/VALIDATE.php';
require 'libs/FlashMessages.php';
$flashMsg = new \Plasticbrain\FlashMessages\FlashMessages();


$_query = $db->prepare("SELECT * FROM `alumnai` WHERE `id` = :id LIMIT 1");
$_query->bindValue(":id", $_SESSION["user"]->id);

if( !$_query->execute() ){
    echo "Error while processing request";
    exit(0);
}

$user = $_query->fetchAll(PDO::FETCH_OBJ)[0];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errorRedirect = "alumni_user.php";

    //if csrf token does not match, there something wrong, may be security issue
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "Invalid request";
        exit(0);
    }

    parse_str($_SERVER['QUERY_STRING'], $urlQuery);
    if( isset($urlQuery['image']) ){
        updateProfileImage($user->id, $db, $errorRedirect, $flashMsg);
        return;
    }

    $validator = new GUMP();
    $validated_data = validateForm($validator);
    if(!$validated_data) {
        $errHtml = "";
        foreach ($validator->get_readable_errors() as $readable_error) {
            $errHtml .= $readable_error."<br>";
        }
        $flashMsg->error($errHtml, $errorRedirect);
    }


    if( isset($_POST["email"]) ) {
        $emailAddr = $_POST["email"];
        if (!VALIDATE::email($emailAddr, $db) && $user->email !== $_POST["email"] ) {
            $flashMsg->error("$emailAddr already taken", $errorRedirect);
        }
    }

    if( !updateAlumni($user->id,$db) )
        $flashMsg->error("Error while processing request", "alumni_user.php");



    $flashMsg->success("Successfully updated", "alumni_user.php");
    return;
}


/**
 * @param $userid
 * @param $db
 * @param $errorRedirect
 * @param $flashMsg
 * @return bool
 */
function updateProfileImage($userid,$db,$errorRedirect, $flashMsg){

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

    $moveImgName = $userid.".".$profileImg["ext"];

    //check the folder has write permission, important for debugging!
    if( !is_writable('img_alumni') )
        return false;

    //remove the previous image
    if(file_exists('img_alumni/'.$moveImgName))
        unlink('img_alumni/'.$moveImgName);

    //move image
    if( !move_uploaded_file($_FILES['profileImg']['tmp_name'], 'img_alumni/'.$moveImgName) )
        return false;

    $_query = $db->prepare("UPDATE `alumnai` SET `img` = :img WHERE `id` = :id");
    $_query->bindValue(':img', $moveImgName);
    $_query->bindValue(':id', $userid);

    if( !$_query->execute() )
        $flashMsg->error("Successfully updated", "alumni_user.php");
}





/**
 * @param $userid
 * @param $db
 * @return bool
 */
function updateAlumni($userid,$db){

    $fields = array("name","passing_year","present_address","parmanent_address","current_status","group","current_org","about","email","phone","hide_email","hide_phone");

    $columns = "UPDATE `alumnai` SET ";

    $comma = '';
    foreach ($_POST as $field_name => $field){
        if( !in_array($field_name, $fields) || $field == '' ){
            unset($_POST[$field_name]);
            continue;
        }

        if( $field_name == 'hide_email' || $field_name == 'hide_phone' ){
            $_POST[$field_name] = '1';
        }

        $columns .= " $comma`$field_name` = :$field_name";
        $comma = ',';
    }

    if( !array_key_exists("hide_email", $_POST) ) {
        $_POST['hide_email'] = '0';
        $columns .= " $comma`hide_email` = :hide_email";
    }

    if( !array_key_exists("hide_phone", $_POST) ) {
        $_POST['hide_phone'] = '0';
        $columns .= " $comma`hide_phone` = :hide_phone";
    }

    $columns .= " WHERE `id` = :id ";

    echo "$columns<br><br>";

    $_query = $db->prepare($columns);
    foreach ($_POST as $field_name => $field)
        $_query->bindValue(":$field_name", $field);

    $_query->bindValue(":id", $userid);

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
        'name'    => 'alpha_space|max_len,100|min_len,3',
        'email'    => 'valid_email',
        'passing_year' => 'numeric|exact_len,4',
        'current_org' => 'max_len,50',
        'present_address' => 'max_len,80',
        'parmanent_address' => 'max_len,80',
        'current_status' => 'max_len,30',
        'phone' => 'max_len,20'
    ));

    $validator->filter_rules(array(
        'name' => 'trim|sanitize_string',
        'email' => 'trim|sanitize_email',
        'current_org' => 'trim|sanitize_string',
        'current_status' => 'trim|sanitize_string',
        'present_address' => 'trim|sanitize_string',
        'parmanent_address' => 'trim|sanitize_string',
        'group' => 'trim|sanitize_string',
    ));

    return $validator->run($_POST);
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

<div class="content container min-body">
    <div class="row">

        <div class="col-md-2">
            <?php $alumniActive="my"; include "includes/alumni_side_menu.php"; ?>
        </div>

        <div class="col-md-2" style="margin-top: 10px;">
            <img class="img-thumbnail" src="img_alumni/<?php echo $user->img; ?>"  />
            <table class="table" style="margin-top: 10px;">
                <tbody>
                <tr>
                    <td style="text-align: center; border: none;">
                        <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#myModal">Change Photo</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>


        <div class="col-md-8" style="margin-top: 10px;">

            <?php
            //show flash messages
            if ($flashMsg->hasErrors()) {
                $flashMsg->display();
            }

            if ($flashMsg->hasMessages($flashMsg::SUCCESS)) {
                $flashMsg->display();
            }
            ?>

            <form action="alumni_user.php" method="post" id="alumniForm" >

                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th width="25%">Name</th>
                        <td>
                            <input type="text" name="name" value="<?php echo $user->name; ?>" class="form-control"  placeholder="Name" >
                        </td>
                    </tr>
                    <tr>
                        <th width="15%">Email</th>
                        <td>
                            <input type="email" name="email" value="<?php echo $user->email; ?>" class="form-control"  placeholder="Email">
                        </td>
                    </tr>
                    <tr>
                        <th width="15%">Phone</th>
                        <td>
                            <input type="text" name="phone" value="<?php echo $user->phone; ?>" class="form-control" placeholder="mobile/phone" >
                        </td>
                    </tr>
                    <tr>
                        <th width="15%">Passing year</th>
                        <td>
                            <input type="text" name="passing_year" value="<?php echo $user->passing_year; ?>" class="form-control" placeholder="YYYY" >
                        </td>
                    </tr>
                    <tr>
                        <th width="15%">Group</th>
                        <td>
                            <select class="form-control" name="group">
                                <option value="">Select group</option>
                                <option value="Science" <?php if($user->group === 'Science' ) echo 'selected'; ?> >Science</option>
                                <option value="Humanities" <?php if($user->group === 'Humanities' ) echo 'selected'; ?> >Humanities</option>
                                <option value="Commerce" <?php if($user->group === 'Commerce' ) echo 'selected'; ?> >Commerce</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th width="15%">Present Address</th>
                        <td>
                            <textarea name="present_address" class="form-control custom-control" rows="3" style="resize:none"><?php echo $user->present_address; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th width="15%">Parmanent Address</th>
                        <td>
                            <textarea name="parmanent_address" class="form-control custom-control" rows="3" style="resize:none"><?php echo $user->parmanent_address; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th width="15%">About</th>
                        <td>
                            <textarea name="about" class="form-control custom-control" rows="3" ><?php echo $user->about; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th width="15%">Designation</th>
                        <td>
                            <input type="text" value="<?php echo $user->current_status; ?>" name="current_status" class="form-control"  placeholder="" >
                        </td>
                    </tr>
                    <tr>
                        <th width="15%">Organization</th>
                        <td>
                            <input type="text" value="<?php echo $user->current_org; ?>" name="current_org" class="form-control"  placeholder="Working place/organization" >
                        </td>
                    </tr>
                    <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" id="csrf_token" name="csrf_token" />
                    <tr>
                        <th></th>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="hide_email" <?php if($user->hide_email == 1 ) echo 'checked'; ?>  > Hide Email
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="hide_phone" <?php if($user->hide_phone == 1 ) echo 'checked'; ?> > Hide Phone
                                </label>
                            </div>
                        </td>
                    </tr>

                    </tbody>
                </table>
                <button type="submit"  class="btn btn-md btn-primary">UPDATE</button>

            </form>

        </div>

    </div>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Change Profile Picture</h4>
            </div>
            <div class="modal-body">
                <form action="alumni_user.php?image=true" method="post"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="profileImg">Select your Photo (jpg / jpeg /  png)</label>
                        <input type="file" name="profileImg" id="profileImg" />
                    </div>
                    <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" id="csrf_token" name="csrf_token" />
                    <button type="submit" class="btn btn-md btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<?php include 'includes/footer.php'  ?>


</body>
