<?php
/**
 * User: ahmed-dinar
 * Date: 6/1/17
 */
date_default_timezone_set('Asia/Dhaka');
//error_reporting(E_ALL);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//start our session if not already started
if (!session_id()) {
    session_start();
}

include('database/connect.php');
include 'includes/paginator.php';
require_once 'libs/Pagination.php';


$_query = $db->prepare("SELECT COUNT(*) as `count` FROM `alumnai` WHERE `status` = 2");
if( !$_query->execute() ){
    echo "Error while processing request";
    exit(0);
}

parse_str($_SERVER['QUERY_STRING'], $urlQuery);

//for pagination
$curPage = 1;

//if page exists in url, validate it as integer
if( array_key_exists("page",$urlQuery) && filter_var($urlQuery["page"], FILTER_VALIDATE_INT) && $urlQuery["page"] > 0 ){
    $curPage = $urlQuery["page"];
}

$result = $_query->fetchAll(PDO::FETCH_OBJ)[0];
$pageLimit = 100;
$pagination = new Pagination($curPage, $pageLimit, $result->count);

$_query = $db->prepare("SELECT * FROM `alumnai` WHERE `status` = 2 LIMIT :limit OFFSET :offset");
$_query->bindValue(':limit', (int)$pagination->getLimit(), PDO::PARAM_INT);
$_query->bindValue(':offset', (int)$pagination->offset(), PDO::PARAM_INT);

//database error
if( !$_query->execute() ){
    echo "Error while processing request";
    exit(0);
}

$alumniList = $_query->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $active_nav="alumni"; $page_title = "Alumni Members"; include 'includes/head.php' ?>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="content container min-body">
    <div class="row">

        <div class="col-md-2">
            <?php $alumniActive="members"; include "includes/alumni_side_menu.php"; ?>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default" style="margin-top: 10px;">

                <div class="panel-heading">
                    <h4 class="panel-title text-bold">Alumni Members</h4>
                </div>
                <div class="table-responsive" style="border-bottom: 1px solid #ddd;">
                    <table class="table public-alumni-table">
                        <tr>
                        <?php
                        foreach ($alumniList as $almn){

                            echo "<td style=\"padding-left: 20px; width: 25%; \"><img src='img_alumni/$almn->img' width='100px' height='100px' /></td>";
                            ?>

                            <td>
                                <p><a href="alumniProfile.php?id=<?php echo $almn->id; ?>" style="color: #0f0f0f" class="text-bold" ><?php echo $almn->name; ?></a></p>
                                <p><?php echo $almn->current_status; ?></p>
                                <p><?php echo $almn->current_org; ?></p>

                                <?php if( !$almn->hide_phone ){ ?>
                                    <p style="margin-top: 8px;"><i class="fa fa-phone" aria-hidden="true"></i>  &nbsp;<?php echo $almn->phone; ?></p>
                                <?php } ?>

                                <?php if( !$almn->hide_email ){ ?>
                                    <p><i class="fa fa-envelope-o" aria-hidden="true"></i>  &nbsp;<?php echo $almn->email; ?></p>
                                <?php } ?>

                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div style="padding-left: 10px; font-size: 13px;" class="help-block" >
                    <?php echo 'showing '.count($alumniList).' of total '.$pagination->getTotal().' items'; ?>
                </div>

                <?php showPagination($pagination, "alumni_members.php?"); ?>

            </div>

        </div>

    </div>
</div>


<?php include 'includes/footer.php'  ?>


</body>

