<?php
/**
 * User: ahmed-dinar
 * Date: 6/1/17
 */
include 'includes/core.php';

include('database/connect.php');
include 'includes/paginator.php';
require_once 'libs/Pagination.php';

parse_str($_SERVER['QUERY_STRING'], $urlQuery);

//for pagination
$curPage = 1;
$batch = null;

if( array_key_exists("batch", $urlQuery) ){
    $batch = $urlQuery["batch"];
    $input = (int)$batch;
    if( $input < 1000 || $input > 9000 )
        $batch = null;
}

//if page exists in url, validate it as integer
if( array_key_exists("page",$urlQuery) && filter_var($urlQuery["page"], FILTER_VALIDATE_INT) && $urlQuery["page"] > 0 ){
    $curPage = $urlQuery["page"];
}

$statement = "SELECT COUNT(*) as `count` FROM `alumnai` WHERE `status` = 2";
if( !is_null($batch) )
    $statement .= " AND `passing_year` = :passing_year ";

$_query = $db->prepare($statement);
if( !is_null($batch) )
    $_query->bindValue(":passing_year", $batch);

if( !$_query->execute() ){
    echo "Error while processing request";
    exit(0);
}


$result = $_query->fetchAll(PDO::FETCH_OBJ)[0];
$pageLimit = 100;
$pagination = new Pagination($curPage, $pageLimit, $result->count);


$statement = "SELECT * FROM `alumnai` WHERE `status` = 2 ";
if( !is_null($batch) )
    $statement .= " AND `passing_year` = :passing_year ";

$statement .= " ORDER BY `passing_year` DESC LIMIT :limit OFFSET :offset";

$_query = $db->prepare($statement);
if( !is_null($batch) ) {
    $_query->bindValue(":passing_year", $batch);
}
$_query->bindValue(':limit', (int)$pagination->getLimit(), PDO::PARAM_INT);
$_query->bindValue(':offset', (int)$pagination->offset(), PDO::PARAM_INT);


//database error
if( !$_query->execute() ){
    echo "Error while processing request";
    exit(0);
}

$alumniList = $_query->fetchAll(PDO::FETCH_OBJ);

$paginationUrl = "alumni_members.php?";
$paginationUrl .= is_null($batch) ? "" : "batch=$batch&";
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

        <?php $alumniActive="members"; include "includes/alumni_side_menu.php"; ?>

        <div class="col-md-6">
            <div class="panel panel-default" style="margin-top: 10px;">

                <div class="panel-heading" style="background-color: transparent; padding: 15px">
                    <h4 class="panel-title text-bold">
                        <?php if(!is_null($batch)){ ?>
                            <i class="fa fa-users"></i> Alumni Members - Batch <?php echo $batch; ?>
                        <?php }else{ ?>
                            <i class="fa fa-users"></i> Alumni Members
                        <?php } ?>
                    </h4>
                </div>
                <div class="table-responsive" style="border-bottom: 1px solid #ddd;">
                    <table class="table public-alumni-table">
                        <tr>
                            <?php
                            foreach ($alumniList as $almn){
                            $almn->img = $almn->img === '' ? 'blank-profile.png' : $almn->img;
                            echo "<td style=\"padding-left: 20px; width: 25%; \"><img src='img_alumni/$almn->img' width='100px' height='100px' /></td>";
                            ?>

                            <td>
                                <p><a href="alumniProfile.php?id=<?php echo $almn->id; ?>" style="color: #0f0f0f" class="text-bold" ><?php echo $almn->name; ?></a></p>
                                <p><?php echo $almn->current_status; ?></p>
                                <p><?php echo $almn->current_org; ?></p>
                                <p style="margin-bottom: 10px;">Batch - <?php echo $almn->passing_year; ?></p>


                                <?php if( !$almn->hide_phone ){ ?>
                                    <p><i class="fa fa-phone" aria-hidden="true"></i>  &nbsp;<?php echo $almn->phone; ?></p>
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

                <?php showPagination($pagination, $paginationUrl); ?>

            </div>

        </div>
        <div class="col-md-6">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Search Member</label>
                    <input value="" class="form-control" accept="num" id="batch" placeholder="batch or passing year" name="batch" />
                </div>
                <div class="form-group">
                    <button type="button" id="searchBtn" class="btn btn-primary btn-sm">Search</button>
                </div>
            </div>
        </div>

    </div>
</div>



<script src="js/jquery.numeric.min.js"></script>
<script>

    $( document ).ready(function() {
        //only allow number for year / batch
        $("#batch").numeric()
    });

    $( "#searchBtn" ).on( "click", function() {
        var batch = $("#batch").val();

        if( batch.match(/^\d+$/) && batch > 1000 && batch < 9000 ){
            window.location.replace("alumni_members.php?batch=" + batch);
        }
    });
</script>

<?php include 'includes/footer.php'  ?>


</body>

