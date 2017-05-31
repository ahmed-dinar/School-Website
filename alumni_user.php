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
    header("Location: alumni.php");
    exit();
}

include('database/connect.php');

$_query = $db->prepare("SELECT * FROM `alumnai` WHERE `id` = :id LIMIT 1");
$_query->bindValue(":id", $_SESSION["user"]->id);

if( !$_query->execute() ){
    echo "Error while processing request";
    exit(0);
}

$user = $_query->fetchAll(PDO::FETCH_OBJ)[0];


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
                        <a class="btn btn-sm btn-default" href="#">Change Photo</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-8" style="margin-top: 10px;">

            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th width="25%">Name</th>
                    <td><?php echo $user->name; ?></td>
                </tr>
                <tr>
                    <th width="15%">Email</th>
                    <td><?php echo $user->email; ?></td>
                </tr>
                <tr>
                    <th width="15%">Phone</th>
                    <td><?php echo $user->phone; ?></td>
                </tr>
                <tr>
                    <th width="15%">Passing year</th>
                    <td><?php echo $user->passing_year; ?></td>
                </tr>
                <tr>
                    <th width="15%">Group</th>
                    <td><?php echo $user->group; ?></td>
                </tr>
                <tr>
                    <th width="15%">Present Address</th>
                    <td><textarea rows="3" style="border: none; resize:none; width: 100%; box-sizing: border-box; padding: 5px;" readonly="readonly" ><?php echo $user->present_address; ?></textarea></td>
                </tr>
                <tr>
                    <th width="15%">Parmanent Address</th>
                    <td><textarea rows="3" style="border: none; resize:none; width: 100%; box-sizing: border-box; padding: 5px;" readonly="readonly" ><?php echo $user->parmanent_address; ?></textarea></td>
                </tr>
                <tr>
                    <th width="15%">About</th>
                    <td><textarea rows="3" style="border: none; resize:none; width: 100%; box-sizing: border-box; padding: 5px;" readonly="readonly" ><?php echo $user->about; ?></textarea></td>
                </tr>
                <tr>
                    <th width="15%">Current Status</th>
                    <td><?php echo $user->current_status; ?></td>
                </tr>
                <tr>
                    <th width="15%">Current Org</th>
                    <td><?php echo $user->current_org; ?></td>
                </tr>
                </tbody>
            </table>

        </div>

    </div>
</div>


<?php include 'includes/footer.php'  ?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/min.js"></script>
<!-----<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  ---->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

</body>
