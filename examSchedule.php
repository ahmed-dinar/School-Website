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

$term = array_key_exists("term",$urlQuery) ? $urlQuery["term"] : null;
$section = array_key_exists("section",$urlQuery) ? $urlQuery["section"] : null;
$year = array_key_exists("year",$urlQuery) ? $urlQuery["year"] : null;


$AND = "";
$WHERE = "WHERE";
$statement = "SELECT * FROM `exam_schedule`  ";

if( !is_null($term) ){
    $statement .= " WHERE `term` = :term ";
    $WHERE = "";
    $AND  = "AND";
}

if( !is_null($section) ){
    $statement .= " $WHERE $AND `college` = :section ";
    $WHERE = "";
    $AND  = "AND";
}

if( !is_null($year) )
    $statement .= " $WHERE $AND `year` = :year ";

$statement .= " ORDER BY `year` DESC, `college` ASC, `term` ASC;";

$_query = $db->prepare($statement);

if( !is_null($term) )
    $_query->bindValue(":term", $term);

if( !is_null($section) )
    $_query->bindValue(":section", $section === 'school' ? '0' : '1');

if( !is_null($year) )
    $_query->bindValue(":year", $year);

if( !$_query->execute() )
    die("Database error");

$schedules =  $_query->fetchAll(PDO::FETCH_OBJ);
$termAlias = array(
    "first" => "First Term",
    "second" => "Second Term",
    "final" => "Final",
    "ssc" => "SSC",
    "hsc" => "HSC"
);

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

            <div class="col-md-9" style="margin-top: 20px;">

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
                    <div class="panel-heading text-bold"><i class="fa fa-calendar"></i> Exam Schedule</div>

                    <?php if(!empty($schedules)){ ?>

                        <table class="table table-bordered academic-table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Term</th>
                                <th>Section</th>
                                <th>Year</th>
                                <th>Download</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($schedules as $item){ ?>
                                <tr>
                                    <td><?php echo $item->title; ?></td>
                                    <td><?php echo $termAlias[$item->term]; ?></td>
                                    <td><?php echo $item->college == 0 ? "School" : "College"; ?></td>
                                    <td><?php echo $item->year; ?></td>
                                    <td>
                                        <a target="_blank" class="btn btn-sm btn-primary" href="academicFileView.php?type=examSchedule&view=<?php echo $item->id; ?>">
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


            <div class="col-md-3">
                <div class="panel-body">

                    <div class="form-group">
                        <label>Select Section</label>
                        <select id="sectionList" name="section" class="form-control">
                            <option value="" <?php if( is_null($section)) echo "selected"; ?> >Any</option>
                            <option value="school" <?php if( $section === 'school' ) echo "selected"; ?> >School</option>
                            <option value="college" <?php if( $section === 'college' ) echo "selected"; ?> >College</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Select Term</label>
                        <select id="termList" name="term" class="form-control">
                            <option value="" <?php if( is_null($term) ) echo "selected"; ?> >Any</option>
                            <?php foreach ($termAlias as $termId => $termName){ ?>
                                <option value="<?php echo $termId; ?>" <?php if( $term === $termId ) echo "selected"; ?> ><?php echo $termName; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                </div>
            </div>

    </div>
</div>

<script>

    $(function() {

        // bind change event to select
        $('#termList').on('change', function() {
            var targetTerm = $(this).val();
            var targetSection = $("#sectionList").val();
            redirectTO(targetTerm,targetSection);
        });

        $('#sectionList').on('change', function() {
            var targetSection = $(this).val();
            var targetTerm = $("#termList").val();
            redirectTO(targetTerm,targetSection);
        });
    });

    function redirectTO(targetTerm, targetSection) {
        var url = 'examSchedule.php';
        var isand = false;
        if( targetTerm !== ''  ) {
            url += '?term=' + targetTerm;
            isand = true;
        }
        if( targetSection !== '' ) {
            url += isand ? '&' : '?';
            url += 'section=' + targetSection;
        }
        window.location.replace(url);
    }

</script>



<?php include 'includes/footer.php'  ?>




</body>
