<?php
/**
 * Author: ahmed-dinar
 * Date: 5/31/17
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

parse_str($_SERVER['QUERY_STRING'], $urlQuery);
$actionType = getActionType($urlQuery);

//invalid or no action in url query
if( $actionType == false ){
    echo "<h3>Forbidden</h3>";
    exit(0);
}

include('database/connect.php');
require_once 'libs/VALIDATE.php';
require 'libs/FlashMessages.php';
$flashMsg = new \Plasticbrain\FlashMessages\FlashMessages();

$id = $urlQuery[$actionType];

if( !VALIDATE::exists('id', $id, $db) ){
    echo "<h3>404, Not found</h3>";
    exit(0);
}

/**
 * Delete an alumni
 */
if( $actionType === 'delete' ){
    $_query = $db->prepare("DELETE FROM `alumnai` WHERE `id` = :id");
    $_query->bindValue(':id', $id);

    if( !$_query->execute() ){
        $flashMsg->error('<i class="fa fa-times-circle-o"></i> Error while processing request', "adminAlumnai.php");
    }
    $flashMsg->success('<i class="fa fa-check-circle-o"></i> Alumni successfully deleted', "adminAlumnai.php");
}


/**
 * Accept alumni and make it public
 */
if( $actionType === 'accept' || $actionType === 'hide' ){
    $stat = $actionType === 'accept' ? 2 : 1;
    $_query = $db->prepare("UPDATE `alumnai` SET `status` = :status WHERE `id` = :id");
    $_query->bindValue(':id', $id);
    $_query->bindValue(':status', $stat);

    if( !$_query->execute() ){
        $flashMsg->error('<i class="fa fa-times-circle-o"></i> Error while processing request', "adminAlumnai.php");
    }
    $msgg = $actionType === 'accept' ? 'accepted' : 'hidden';
    $flashMsg->success('<i class="fa fa-check-circle-o"></i> Alumni '.$msgg, "adminAlumnai.php");
}



$_query = $db->prepare("SELECT * FROM `alumnai` WHERE `id` = :id");
$_query->bindValue(':id', $id);

if( !$_query->execute() ){
    $flashMsg->error('<i class="fa fa-times-circle-o"></i> Error while processing request', "adminAlumnai.php");
}

$alumniData = $_query->fetchAll(PDO::FETCH_OBJ)[0];


/**
 * get alumni action type view/delete/accept
 * @param $urlQuery
 * @return bool|string
 */
function getActionType($urlQuery){
    if( array_key_exists("view", $urlQuery) ){
        return "view";
    }
    if( array_key_exists("delete", $urlQuery) ){
        return "delete";
    }
    if( array_key_exists("accept", $urlQuery) ){
        return "accept";
    }
    if( array_key_exists("hide", $urlQuery) ){
        return "hide";
    }
    return false;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $page_title = "Control panel"; include 'includes/head.php' ?>
    <!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">-->
    <link href="css/font-awesome.min.css" rel="stylesheet" />
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-2">
            <?php $adminNav='alumni'; include 'includes/admin_side_menu.php' ?>
        </div>

        <div class="col-md-10">
            <?php $actvAlmNav = $alumniData->status < 1 ? "unverified" : "verified"; include 'includes/adminAlumniNav.php' ?>
        </div>


        <div class="col-md-2" style="margin-top: 10px;">
            <img class="img-thumbnail" src="img_alumni/<?php echo $alumniData->img; ?>"  />

            <table class="table" style="margin-top: 10px;">
                <tbody>
                    <tr>
                        <td style="text-align: center; border: none;">
                            <a class="btn btn-sm btn-danger" href="adminAlumniAction.php?delete=<?php echo $alumniData->id; ?>">Delete</a>
                        </td>
                    </tr>
                    <?php if($alumniData->status==1){ ?>
                    <tr>
                        <td style="text-align: center; border: none;">
                            <a class="btn btn-sm btn-success" href="adminAlumniAction.php?accept=<?php echo $alumniData->id; ?>">Accept</a>
                        </td>
                    </tr>
                    <?php }else if($alumniData->status==2){ ?>
                        <tr>
                            <td style="text-align: center; border: none;">
                                <a class="btn btn-sm btn-warning" href="adminAlumniAction.php?hide=<?php echo $alumniData->id; ?>">Hide</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>

        <div class="col-md-8" style="margin-top: 10px;">

                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th width="25%">Name</th>
                        <td><?php echo $alumniData->name; ?></td>
                    </tr>

                    <tr>
                        <th width="15%">Email</th>
                        <td><?php echo $alumniData->email; ?></td>
                    </tr>
                    <tr>
                        <th width="15%">Phone</th>
                        <td><?php echo $alumniData->phone; ?></td>
                    </tr>
                    <tr>
                        <th width="15%">Passing year</th>
                        <td><?php echo $alumniData->passing_year; ?></td>
                    </tr>
                    <tr>
                        <th width="15%">Group</th>
                        <td><?php echo $alumniData->group; ?></td>
                    </tr>
                    <tr>
                        <th width="15%">Present Address</th>
                        <td><textarea rows="3" style="border: none; resize:none; width: 100%; box-sizing: border-box; padding: 5px;" readonly="readonly" ><?php echo $alumniData->present_address; ?></textarea></td>
                    </tr>
                    <tr>
                        <th width="15%">Parmanent Address</th>
                        <td><textarea rows="3" style="border: none; resize:none; width: 100%; box-sizing: border-box; padding: 5px;" readonly="readonly" ><?php echo $alumniData->parmanent_address; ?></textarea></td>
                    </tr>
                    <tr>
                        <th width="15%">About</th>
                        <td><textarea rows="3" style="border: none; resize:none; width: 100%; box-sizing: border-box; padding: 5px;" readonly="readonly" ><?php echo $alumniData->about; ?></textarea></td>
                    </tr>
                    <tr>
                        <th width="15%">Current Status</th>
                        <td><?php echo $alumniData->current_status; ?></td>
                    </tr>
                    <tr>
                        <th width="15%">Current Org</th>
                        <td><?php echo $alumniData->current_org; ?></td>
                    </tr>
                    </tbody>
                </table>

        </div>


    </div>
</div>


<?php include 'includes/footer.php'  ?>

<script src="js/bootstrap.min.js"></script>


</body>
</html>

