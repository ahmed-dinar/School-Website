<?php
include('database/connect.php');
?>

<?php
if(isset($_REQUEST['notice_id'])){
    $get_notice_id=$_REQUEST['notice_id'];
}
else{
    $id=0;
}
$post_date=date('d-m-Y');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $page_title = "Test"; include 'includes/head.php' ?>
</head>
<body>

<?php include 'includes/header.php'; ?>

<!------------Content Section (Add Your Code From Here)------------>

<div class="showNotice">
    <div class="container">
        <?php
        $test=0;
        $Notice=mysql_query("select * from noticeboard order by id desc");
        while($get=mysql_fetch_array($Notice)){
            $n=$get['notice_title'];
            $test++;

            ?>

            <?php if($test==1){ ?>
                <div class="row">
                <div class="col-md-4"><?php echo $n; ?></div>
            <?php } else if($test==2){ ?>
                <div class="col-md-2-4"><?php echo $n; $test=0; ?></div>
                </div>
            <?php } ?>

            <?php
        }
        ?>
    </div>
</div>



<!----------Footer Start------------------->
<div class="container">
    <div class="myFooter">
        <div class="row">
            <h4 style="text-align:center;">This Site is Developed By 2009 Batch Students</h4>
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <div class="varsityLinks">
                    <h5 style="color:#008ACB; font-size:17px">Some Renowned University Links<h5/>
                        <ul>
                            <li><a href="">Jessore University of Science & Technology (JUST)</a></li>
                            <li><a href="">Bangladesh University of Engineering & Technology (BUET)</a></li>
                            <li><a href="">Rajshahi University of Engineering & Technology (RUET)</a></li>
                            <li><a href="">Khulna University of Engineering & Technology (KUET)</a></li>
                            <li><a href="">Chittagong University of Engineering & Technology (CUET)</a></li>
                            <li><a href="">University of Dhaka (DU)</a></li>
                            <li><a href="">Rajshahi University (RU)</a></li>
                        </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="varsityLinks">
                    <h5 style="color:#008ACB; font-size:17px">Some Important Links<h5/>
                        <ul>
                            <li><a href="http://www.dshe.gov.bd" target="_blank">মাধ্যমিক ও উচ্চশিক্ষা অধিদপ্তর</a></li>
                            <li><a href="http://www.educationboardresults.gov.bd" target="_blank">মাধ্যমিক ও উচ্চ মাধ্যমিক পরীক্ষার ফল</a></li>
                            <li><a href="http://www.dpe.gov.bd" target="_blank">প্রাথমিক শিক্ষা অধিদপ্তর</a></li>
                            <li><a href="http://www.mopme.gov.bd" target="_blank">প্রাথমিক ও গনশিক্ষা মন্ত্রনালয়</a></li>
                            <li><a href="http://www.nape.gov.bd" target="_blank">জাতীয় প্রাথমিক শিক্ষা একাডেমী (নেপ)</a></li>
                            <li><a href="http://www.moedu.gov.bd" target="_blank">শিক্ষা মন্ত্রণালয় </a></li>
                            <li><a href="http://www.nctb.gov.bd" target="_blank">জাতীয় শিক্ষাক্রম ও পাঠ্যপুস্তক বোর্ড (এনসিটিবি)</a></li>
                        </ul>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/min.js"></script>
<!-----<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  ---->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>