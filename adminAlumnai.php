<?php
/**
 * Author: ahmed-dinar
 * Date: 5/30/17
 */
date_default_timezone_set('Asia/Dhaka');
//error_reporting(E_ALL);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//start our session if not already started
if (!session_id()) {
    session_start();
}

// if normal user logged in, redirect to normal page
if( isset($_SESSION['user']) ){
    header('Location: alumni.php' );
    exit(0);
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
}

include('database/connect.php');

include 'includes/paginator.php';
require_once 'libs/Pagination.php';
require 'libs/FlashMessages.php';
$flashMsg = new \Plasticbrain\FlashMessages\FlashMessages();

parse_str($_SERVER['QUERY_STRING'], $urlQuery);

$stat = 'verified';
if( array_key_exists("status",$urlQuery) &&
    ( $urlQuery["status"] === 'verified' ||  $urlQuery["status"] === 'unverified' ||  $urlQuery["status"] === 'accepted'  )
){
    $stat = $urlQuery["status"];
}


/**
 * @param $curPae
 * @param $db
 * @param string $status
 * @return array
 */
function getAlumni($curPae, $db, $status = 'verified'){

    $stat = 1;
    if( $status === 'unverified' ){
        $stat = 0;
    }
    else if( $status === 'accepted' ){
        $stat = 2;
    }

    $_query = $db->prepare("SELECT COUNT(*) as `count` FROM `alumnai` WHERE `status` = :status");
    $_query->bindValue(":status", $stat);

    if( !$_query->execute() ){
        echo "Error while processing request";
        exit(0);
    }

    $result = $_query->fetchAll(PDO::FETCH_OBJ)[0];
    $pageLimit = 100;
    $pagination = new Pagination($curPae, $pageLimit, $result->count);

    $_query = $db->prepare("SELECT * FROM `alumnai` WHERE `status` = :status LIMIT :limit OFFSET :offset");
    $_query->bindValue(':status', $stat);
    $_query->bindValue(':limit', (int)$pagination->getLimit(), PDO::PARAM_INT);
    $_query->bindValue(':offset', (int)$pagination->offset(), PDO::PARAM_INT);

    //database error
    if( !$_query->execute() ){
        echo "Error while processing request";
        exit(0);
    }

    $result = $_query->fetchAll(PDO::FETCH_OBJ);

    return array(
        "data" => $result,
        "pagination" => $pagination
    );
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $page_title = "Control panel"; include 'includes/head.php' ?>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-2">
            <?php $adminNav='alumni'; include 'includes/admin_side_menu.php' ?>
        </div>
        <div class="col-md-10">

            <?php include 'includes/adminAlumniNav.php' ?>

            <?php
            //show flash messages
            if ($flashMsg->hasErrors()) {
                $flashMsg->display();
            }

            if ($flashMsg->hasMessages($flashMsg::SUCCESS)) {
                $flashMsg->display();
            }
            ?>

            <div class="panel panel-default" style="margin-top: 10px;">

                <div class="panel-heading">
                    <h4 class="panel-title text-bold">
                        <?php
                            if( $stat === 'unverified' ){
                                echo 'Email Unverified Alumni List';
                            }else if( $stat === 'accepted' ){
                                echo 'Public Alumni List';
                            }else{
                                echo 'Email Verified Alumni List';
                            }
                        ?>
                    </h4>
                </div>
                <div class="table-responsive" style="border-bottom: 1px solid #ddd;">
                    <table class="table alumni-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Year</th>
                            <th>Group</th>
                            <th>Phone</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Accept</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $curPage = 1;

                        //if page exists in url, validate it as integer
                        if( array_key_exists("page",$urlQuery) && filter_var($urlQuery["page"], FILTER_VALIDATE_INT) && $urlQuery["page"] > 0 ){
                            $curPage = $urlQuery["page"];
                        }

                        $verifiedAlumni = getAlumni($curPage,$db,$stat);
                        $in = 1;
                        foreach ($verifiedAlumni["data"] as $almn){
                            echo "<tr indx=\"".($in-1)."\" >";
                            echo "<td>$in</td>";
                            echo "<td><img src='img_alumni/$almn->img' width='50px' height='50px' /></td>";
                            echo "<td>$almn->name</td>";
                            echo "<td>$almn->email</td>";
                            echo "<td>$almn->passing_year</td>";
                            echo "<td>$almn->group</td>";
                            echo "<td>$almn->phone</td>";
                            echo '<td><a href="adminAlumniAction.php?view='.$almn->id.'" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Edit</a></td>';

                            if( $almn->status < 2 ){
                                echo '<td><a href="adminAlumniAction.php?accept='.$almn->id.'" class="btn btn-xs btn-success"><i class="fa fa-check""></i> Accept</a></td>';
                            }else{
                                echo '<td><a href="adminAlumniAction.php?hide='.$almn->id.'" class="btn btn-xs btn-warning"><i class="fa fa-eye-slash""></i> Hide</a></td>';
                            }
                            echo '<td><a href="adminAlumniAction.php?delete='.$almn->id.'" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a></td>';

                            echo "</tr>";
                            $in++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

                <div style="padding-left: 10px; font-size: 13px;" class="help-block" >
                    <?php echo 'showing '.count($verifiedAlumni["data"]).' of total '.$verifiedAlumni["pagination"]->getTotal().' items'; ?>
                </div>

                <?php showPagination($verifiedAlumni["pagination"], "adminAlumnai.php?status=$stat&"); ?>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'  ?>


</body>
</html>
