<?php
/**
 * Author: ahmed-dinar
 * Date: 6/4/17
 */
include 'includes/core.php';

include('database/connect.php');
require_once 'libs/Academic.php';
require 'libs/FlashMessages.php';
$flashMsg = new \Plasticbrain\FlashMessages\FlashMessages();

$class = null;
$group = null;

parse_str($_SERVER['QUERY_STRING'], $urlQuery);

//validate class
if( array_key_exists("class",$urlQuery) )
    $class = $urlQuery["class"];

//validate group
if( array_key_exists("group",$urlQuery)  ){
    if( $urlQuery["group"] !== "Science" && $urlQuery["group"] !== "Humanities" && $urlQuery["group"] !== "Commerce" )
    {
        echo "Group invalid";
        exit(0);
    }

    $group = $urlQuery["group"];
}


$academicInfo = getAcademic("classRoutine", $class, $group, $db);
$classAlias = array("Six","Seven","Eight","Nine", "Ten", "College 1st", "College 2nd");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $active_nav="academic"; $page_title = "Alumni Members"; include 'includes/head.php' ?>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="content container min-body">
    <div class="row">


            <div class="col-md-8" style="margin-top: 20px;">
                <div class="panel panel-default">
                    <div class="panel-heading text-bold"><i class="fa fa-calendar"></i> Class Routine</div>

                    <?php if(!empty($academicInfo)){ ?>

                        <table class="table table-bordered academic-table">
                            <thead>
                            <tr>
                                <th>Year</th>
                                <th>Download</th>
                                <th width="10%"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($academicInfo as $item){ ?>
                                <tr>
                                    <td><?php echo $item->year; ?></td>
                                    <td>
                                        <a target="_blank" class="btn btn-sm btn-primary" href="academicFileView.php?type=classRoutine&view=<?php echo $item->id; ?>">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </td>
                                    <td><div style="color: red; font-size: 22px;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></div></td>
                                </tr>
                            <?php }  ?>
                            </tbody>
                        </table>

                    <?php }else{ ?>
                        <div class="panel-heading text-center"><i class="fa fa-search-minus"></i> No routine found</div>
                    <?php } ?>

                </div>
            </div>


    </div>
</div>





<?php include 'includes/footer.php'  ?>




</body>
