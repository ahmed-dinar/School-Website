<?php
/**
 * Author: ahmed-dinar
 * Date: 6/5/17
 */
include 'includes/core.php';

include('database/connect.php');
require_once 'libs/Academic.php';
require 'libs/FlashMessages.php';
$flashMsg = new \Plasticbrain\FlashMessages\FlashMessages();

$year = null;

parse_str($_SERVER['QUERY_STRING'], $urlQuery);

//validate year
if( array_key_exists("year",$urlQuery) )
    $year = $urlQuery["year"];

$academicInfo = getAcademic("calender", null, null, $db, $year);

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
        <div class="col-md-12">
            <div class="col-md-8" style="margin-top: 20px;">

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
                    <div class="panel-heading text-bold"><i class="fa fa-calendar"></i> Academic Calender</div>

                    <?php if(!empty($academicInfo)){ ?>

                        <table class="table table-bordered academic-table">
                            <thead>
                            <tr>
                                <th>Year</th>
                                <th>Download</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($academicInfo as $item){ ?>
                                    <th><?php echo $item->year; ?></th>
                                    <td>
                                        <a target="_blank" class="btn btn-sm btn-primary" href="academicFileView.php?type=calender&view=<?php echo $item->id; ?>">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </td>
                                </tr>
                            <?php }  ?>
                            </tbody>
                        </table>

                    <?php }else{ ?>
                        <div class="panel-heading text-center"><i class="fa fa-search-minus"></i> No calender found</div>
                    <?php } ?>

                </div>
            </div>


            <!--
            <div class="col-md-4">
                <div class="panel-body">

                    <div class="form-group">
                        <label>Select Class</label>
                        <select id="classList" name="class" class="form-control">
                            <option value="" <?php if( is_null($class)) echo "selected"; ?> >Select Class</option>
                            <?php for ($i = 0; $i < count($classAlias); $i++) { ?>
                                <option  value="<?php echo $i+6; ?>" <?php if($class == $i+6) echo "selected"; ?> ><?php echo $classAlias[$i]; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                </div>
            </div>
            -->


        </div>
    </div>
</div>

<script src="js/academicRedirect.js"></script>

<?php include 'includes/footer.php'  ?>


</body>
