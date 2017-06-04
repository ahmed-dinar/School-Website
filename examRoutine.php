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


$academicInfo = getAcademic("examRoutine", $class, $group, $db);
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
        <div class="col-md-12">

            <div class="col-md-8" style="margin-top: 20px;">
                <div class="panel panel-default">
                    <div class="panel-heading text-bold"><i class="fa fa-calendar"></i> Exam Schedule</div>

                    <?php if(!empty($academicInfo)){ ?>

                        <table class="table table-bordered academic-table">
                            <thead>
                            <tr>
                                <th>Class</th>
                                <th>Group</th>
                                <th>Download</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($academicInfo as $item){ ?>
                                <tr>
                                    <td><?php echo $classAlias[$item->class-6]; ?></td>
                                    <td><?php echo $item->group; ?></td>
                                    <td>
                                        <a target="_blank" class="btn btn-sm btn-primary" href="academicFileView.php?type=examRoutine&view=<?php echo $item->id; ?>">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </td>
                                </tr>
                            <?php }  ?>
                            </tbody>
                        </table>

                    <?php }else{ ?>
                        <div class="panel-heading text-center"><i class="fa fa-search-minus"></i> No routine found</div>
                    <?php } ?>

                </div>
            </div>


            <div class="col-md-4">
                <div class="panel-body">

                    <?php
                    //show flash messages
                    if ($flashMsg->hasErrors()) {
                        $flashMsg->display();
                    }

                    if ($flashMsg->hasMessages($flashMsg::SUCCESS)) {
                        $flashMsg->display();
                    }
                    ?>

                    <div class="form-group">
                        <label>Select Class</label>
                        <select id="classList" name="class" class="form-control">
                            <option value="" <?php if( is_null($class)) echo "selected"; ?> >Select Class</option>
                            <?php for ($i = 0; $i < count($classAlias); $i++) { ?>
                                <option  value="<?php echo $i+6; ?>" <?php if($class == $i+6) echo "selected"; ?> ><?php echo $classAlias[$i]; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Select Group</label>
                        <select id="groupList" name="group" class="form-control">
                            <option value="" <?php if( is_null($group)) echo "selected"; ?> >Select Group</option>
                            <option value="Science" <?php if($group === "Science") echo "selected"; ?> >Science</option>
                            <option value="Humanities" <?php if($group === "Humanities") echo "selected"; ?> >Humanities</option>
                            <option value="Commerce" <?php if($group === "Commerce") echo "selected"; ?> >Commerce</option>
                        </select>
                    </div>

                </div>
            </div>



        </div>
    </div>
</div>

<script>

    $(function() {

        // bind change event to select
        $('#classList').on('change', function() {
            var targetClass = $(this).val();
            var targetGroup = $("#groupList").val();
            redirectTO(targetClass,targetGroup);
        });

        $('#groupList').on('change', function() {
            var targetGroup = $(this).val();
            var targetClass = $("#classList").val();
            redirectTO(targetClass,targetGroup);
        });
    });

    function redirectTO(targetClass, targetGroup) {
        var url = 'examRoutine.php';
        var isand = false;
        if( targetClass !== ''  ) {
            url += '?class=' + targetClass;
            isand = true;
        }
        if( targetGroup !== '' ) {
            url += isand ? '&' : '?';
            url += 'group=' + targetGroup;
        }
        window.location.replace(url);
    }

</script>



<?php include 'includes/footer.php'  ?>




</body>
