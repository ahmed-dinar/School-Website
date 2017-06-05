<?php
/**
 * User: ahmed-dinar
 * Date: 6/1/17
 */
include 'includes/core.php';

include('database/connect.php');

parse_str($_SERVER['QUERY_STRING'], $urlQuery);

//if page exists in url, validate it as integer
if( !array_key_exists("id",$urlQuery) && !filter_var($urlQuery["id"], FILTER_VALIDATE_INT) ){
    echo "Invalid request";
    exit(0);
}

$_query = $db->prepare("SELECT * FROM `alumnai` WHERE `id` = :id LIMIT 1");
$_query->bindValue(':id', $urlQuery["id"]);

//database error
if( !$_query->execute() ){
    echo "Error while processing request";
    exit(0);
}

if( $_query->rowCount() == 0 ){
    echo "404, no alumni found";
    exit(0);
}

$alumniInfo = $_query->fetchAll(PDO::FETCH_OBJ)[0];

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

        <div class="col-md-2" style="margin-top: 10px;">
            <img class="img-thumbnail" src="img_alumni/<?php echo $alumniInfo->img; ?>"  />
        </div>

        <div class="col-md-8" style="margin-top: 10px;">

            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th width="25%">Name</th>
                    <td><?php echo $alumniInfo->name; ?></td>
                </tr>

                <?php if( $alumniInfo->hide_email != 0 ){ ?>
                    <tr>
                        <th width="15%">Email</th>
                        <td><?php echo $alumniInfo->email; ?></td>
                    </tr>
                <?php } ?>

                <?php if( $alumniInfo->hide_phone != 0 ){ ?>
                    <tr>
                        <th width="15%">Phone</th>
                        <td><?php echo $alumniInfo->phone; ?></td>
                    </tr>
                <?php } ?>

                <tr>
                    <th width="15%">Passing year</th>
                    <td><?php echo $alumniInfo->passing_year; ?></td>
                </tr>
                <tr>
                    <th width="15%">Group</th>
                    <td><?php echo $alumniInfo->group; ?></td>
                </tr>
                <tr>
                    <th width="15%">Present Address</th>
                    <td><textarea rows="3" style="border: none; resize:none; width: 100%; box-sizing: border-box; padding: 5px;" readonly="readonly" ><?php echo $alumniInfo->present_address; ?></textarea></td>
                </tr>
                <tr>
                    <th width="15%">Parmanent Address</th>
                    <td><textarea rows="3" style="border: none; resize:none; width: 100%; box-sizing: border-box; padding: 5px;" readonly="readonly" ><?php echo $alumniInfo->parmanent_address; ?></textarea></td>
                </tr>
                <tr>
                    <th width="15%">About</th>
                    <td><textarea rows="3" style="border: none; resize:none; width: 100%; box-sizing: border-box; padding: 5px;" readonly="readonly" ><?php echo $alumniInfo->about; ?></textarea></td>
                </tr>
                <tr>
                    <th width="15%">Current Status</th>
                    <td><?php echo $alumniInfo->current_status; ?></td>
                </tr>
                <tr>
                    <th width="15%">Current Org</th>
                    <td><?php echo $alumniInfo->current_org; ?></td>
                </tr>
                </tbody>
            </table>

        </div>
        
    </div>
</div>


<?php include 'includes/footer.php'  ?>


</body>

