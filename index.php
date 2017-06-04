<?php
include 'includes/core.php';

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
}

include('database/connect.php');

if(isset($_REQUEST['id'])){
    $id=$_REQUEST['id'];
}
else{
    $id=0;
}
$post_date=date('d-m-Y');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $active_nav="home"; $page_title = "Home"; include 'includes/head.php' ?>

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/lightbox.css" rel="stylesheet">

    <script src="js/wow.min.js"></script>
    <script src="js/min.js"></script>
    <script src="js/lightbox.min.js"></script>
    <script>
        new WOW().init();
    </script>

</head>
<body style="">

<?php include 'includes/header.php'; ?>

<!--------------------------------- Implementing Carousel------------------------------------>
<div class="container">
    <div class="row">
        <div class="col-md-0"></div>
        <div class="col-md-9">
            <div id="mycarousel" class="carousel slide" data-ride="carousel" data-interval="2000">

                <ol class="carousel-indicators">
                    <li data-target="#mycarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#mycarousel" data-slide-to="1"></li>
                    <li data-target="#mycarousel" data-slide-to="2"></li>
                    <li data-target="#mycarousel" data-slide-to="3"></li>
                </ol>

                <div class="carousel-inner">

                    <!--Image 1-->
                    <div class="item active">
                        <img src="img/img11.jpg">
                        <!-- Image Caption
                        <div class="carousel-caption">
                          <h2>Theme 1</h2>
                        </div>  ---->
                    </div>

                    <!--Image 2-->
                    <div class="item">
                        <img src="img/img22.jpg">
                    </div>

                    <!--Image 3-->
                    <div class="item">
                        <img src="img/img33.jpg">
                    </div>

                    <!--Image 3-->
                    <div class="item">
                        <img src="img/SAM_5088.jpg">
                    </div>

                </div>

                <a class="left carousel-control" href="#mycarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#mycarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>

            </div>



            <!-----------------------ABOUT Basundia ------>
            <div class="welcome-banner welcome_bsc services wow rollIn" data-wow-delay=".6s">
                <div class="row">
                    <div class="col-md-2">
                        <img src="img/BSC_logo.jpg" style="width:120px;height:120px;float:left;padding:2px;margin-top:0px;">
                    </div>
                    <div class="col-md-10">
                        <marquee behavior="alternate" direction="left"> <h2 style="text-align:center;color:#ffff;width:80%;"><b>বসুন্দিয়া স্কুল এন্ড কলেজ (বি.এসকলেজ) এর ওয়েবসাইটে আপনাকে স্বাগতম, সুস্বাগতম !!! </b> </h2> </marquee>
                    </div>
                </div>
            </div>

            <div style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInDown;border:2px solid #E5E5E5;box-shadow:3px 3px 5px 4px #E5E5E5;" class="welcome_bsc services wow fadeInDown" data-wow-delay=".6s">
                <p style="padding:10px;">
                    অবিভক্ত বাংলার প্রাচীন জেলা যশোর এর ভৈরব নদীর তীর ঘেঁষে সদর উপজেলার প্রাণকেন্দ্র বসুন্দিয়া গ্রামে গড়ে উঠা বসুন্দিয়া স্কুল এন্ড কলেজ (বি.এসকলেজ) পরিবারের পক্ষ থেকে সকলকে আন্তরিক অভিনন্দন ও শুভেচ্ছা ।
                    বসুন্দিয়া স্কুল এন্ড কলেজ (বি.এসকলেজ) একটি ঐতিহ্যবাহী বিদ্যায়তন। এর রয়েছে প্রায় শত বছরের গৌরবময় ইতিহাস। অনেক কীর্তিমান ব্যক্তিত্ব এই বিদ্যালয়ের শিক্ষার্থী ছিলেন। বর্তমান বিশ্ব এখন জ্ঞান বিজ্ঞানে এগিয়েছে অনেকটা, আধুনিক  তথ্য-প্রযুক্তির অত্যাধুনিক ধারায় সিক্ত করেছে নিজেদেরকে। পিছিয়ে নেই আমরাও। তাই বর্তমানে প্রযুক্তি র্নিভর শিক্ষা ব্যবস্থা গড়ার ক্ষেত্রে আমরাও দৃঢ় প্রত্যয়ী।
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#AboutBSC" style="margin-left:44%;margin-top:5px;">Read More</button>
                </p>
                <div id="AboutBSC" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header"><h3><b>বসুন্দিয়া স্কুল এন্ড কলেজ এ আপনাকে স্বাগতম </b> </h3></div>
                            <div class="modal-body">
                                <p>
                                    অবিভক্ত বাংলার প্রাচীন জেলা যশোর এর ভৈরব নদীর তীর ঘেঁষে সদর উপজেলার প্রাণকেন্দ্র বসুন্দিয়া গ্রামে গড়ে উঠা বসুন্দিয়া স্কুল এন্ড কলেজ (বি.এসকলেজ) পরিবারের পক্ষ থেকে সকলকে আন্তরিক অভিনন্দন ও শুভেচ্ছা ।
                                    বসুন্দিয়া স্কুল এন্ড কলেজ (বি.এসকলেজ) একটি ঐতিহ্যবাহী বিদ্যায়তন। এর রয়েছে প্রায় শত বছরের গৌরবময় ইতিহাস। অনেক কীর্তিমান ব্যক্তিত্ব এই বিদ্যালয়ের শিক্ষার্থী ছিলেন। বর্তমান বিশ্ব এখন জ্ঞান বিজ্ঞানে এগিয়েছে অনেকটা, আধুনিক  তথ্য-প্রযুক্তির অত্যাধুনিক ধারায় সিক্ত করেছে নিজেদেরকে। পিছিয়ে নেই আমরাও। তাই বর্তমানে প্রযুক্তি র্নিভর শিক্ষা ব্যবস্থা গড়ার ক্ষেত্রে আমরাও দৃঢ় প্রত্যয়ী।
                                    ওয়েবসাইটের মাধ্যমে স্কুলের সকল তথ্য ছাত্র, শিক্ষক ও অভিভাবক কাছে দ্রুত পৌছে দেওয়ার ব্যবস্থা করা হয়েছে। ছাত্র ও শিক্ষকদের ডাটাবেজ তৈরি করে সকল তথ্য সংরক্ষণ করার করার পদক্ষেপ হাতে নেওয়া হয়েছে। আশা করছি ভবিষ্যতে ভর্তি কার্যক্রম থেকে শুরু করে ফলাফল প্রস্তুত করাসহ সকল কাজ অনলাইন সফটওয়ারের মাধ্যমে সম্পন্ন করা সম্ভব হবে। বিদ্যালয়ের আপডেট তথ্য সকলের কাছে পৌঁছে দেওয়ার জন্য বসুন্দিয়া স্কুল এন্ড কলেজ (বি.এসকলেজ) এর ওয়েব গুরুত্বপূর্ণ ভূমিকা পালন করবে।
                                    আমরা চাই শুধু বাংলাদেশ নয় সারা পৃথিবীর মানুষের কাছে আমাদের প্রিয় প্রতিষ্ঠান বসুন্দিয়া স্কুল এন্ড কলেজ (বি.এসকলেজ)  কে পরিচয় করিয়ে দিতে। তাই আমাদের ওয়েবসাইটটি উন্মুক্ত করে ছড়িয়ে দিতে চাই সর্বত্র। এর ফলে শিক্ষক-শিক্ষার্থী ও অভিভাবকের মধ্যে সুসম্পর্ক তৈরি হবে। এছাড়া আমাদের প্রতিষ্ঠানের শিক্ষার্থী, অভিভাবক শুভাকাক্সক্ষী, মহৎপ্রাণ ব্যক্তিগণ তাদের প্রিয় প্রতিষ্ঠানের ইতিহাস, ঐতিহ্য, শিক্ষক ও শিক্ষার্থীদের তথ্য, বিভিন্ন অর্জন, বিজ্ঞপ্তি ও অন্যান্য তথ্য সমূহ দেখে রোমাঞ্চিত হবেন, দূর থেকে আমাদেরকে আন্তরিকতার বন্ধনে আবদ্ধ করবেন।
                                </p>
                            </div>
                            <div class="modal-footer"><button type="button" class="btn btn-success" data-dismiss="modal">Close</button></div>
                        </div>
                    </div>
                </div>
            </div>


            <!-----------------------Nested grid Inside col-md-9 ------>
            <div class="nested_grid">
                <div class="row">
                    <div class="col-md-6">
                        <div style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInLeft;text-align:justify;background-color:#FFFFFF;border:2px solid #E5E5E5;box-shadow:3px 3px 5px 4px #E5E5E5" class="services wow fadeInLeft" data-wow-delay=".2s">
                            <h4 style="background-color:#5C4283;color:#FFFFFF;height:30px;padding-top:3px;text-align:center;">চেয়ারম্যান মহোদয়ের বার্তা</h4>
                            <div>
                                <img src="img/1.JPG" class="img-responsive" style="width:140px;height:140px;float:left;padding:8px;">
                            </div>
                            <p style="padding:10px;">
                                একটি জাতির সুন্দর ও সমৃদ্ধ ভবিষ্যৎ রচনায় প্রধান উপায় হলো শিক্ষা। শিক্ষার আলোর স্পর্শে একজন ব্যক্তি পূর্ণাঙ্গ মানুষ হিসাবে গড়ে ওঠে । এক্ষেত্রে প্রতিষ্ঠানের গুরুত্ব সর্বাধিক।  দশ দশকের বেশি সময় ধরে বসুন্দিয়া স্কুল এন্ড কলেজ বাংলাদেশের  শিক্ষার অগ্রগতি, আদর্শ এবং দক্ষতার ক্ষেত্রে নিষ্ঠার সাথে অগ্রণী ভূমিকা পালন করে আসছে। এই প্রতিষ্ঠানের শিক্ষার্থীদের সৃজনশীলতা ও মেধার পরিচয় ক্রমাগত দেশ বিদেশে ছড়িয়ে পড়ছে ।  ডিজিটাল বাংলাদেশ গড়ার লক্ষ্যে, এই সময়ের কথা মাথায় রেখে এবং তথ্য প্রযুক্তির ক্ষেত্রে সৃষ্টিশীলতা সম্ভাবনার ক্ষেত্র সৃষ্টির জন্য 'বসুন্দিয়া স্কুল এন্ড কলেজ এর ওয়েবসাইট' একটি সমৃদ্ধ সংযোজন।
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;text-align:justify;background-color:#FFFFFF;border:2px solid #E5E5E5;box-shadow:3px 3px 5px 4px #E5E5E5" class="services wow fadeInLeft" data-wow-delay=".4s">
                            <h4 style="background-color:#5C4283;color:#FFFFFF;height:30px;padding-top:3px;text-align:center;">অধ্যক্ষের বার্তা </h4>
                            <div style="">
                                <img src="img/2.jpg" class="img-responsive" style="width:140px;height:140px;float:left;padding:10px;">
                            </div>
                            <p style="padding:10px;">
                                একটি জাতির সুন্দর ও সমৃদ্ধ ভবিষ্যৎ রচনায় প্রধান উপায় হলো শিক্ষা। শিক্ষার আলোর স্পর্শে একজন ব্যক্তি পূর্ণাঙ্গ মানুষ হিসাবে গড়ে ওঠে । এক্ষেত্রে প্রতিষ্ঠানের গুরুত্ব সর্বাধিক।  দশ দশকের বেশি সময় ধরে বসুন্দিয়া স্কুল এন্ড কলেজ বাংলাদেশের  শিক্ষার অগ্রগতি, আদর্শ এবং দক্ষতার ক্ষেত্রে নিষ্ঠার সাথে অগ্রণী ভূমিকা পালন করে আসছে। এই প্রতিষ্ঠানের শিক্ষার্থীদের সৃজনশীলতা ও মেধার পরিচয় ক্রমাগত দেশ বিদেশে ছড়িয়ে পড়ছে ।  ডিজিটাল বাংলাদেশ গড়ার লক্ষ্যে, এই সময়ের কথা মাথায় রেখে এবং তথ্য প্রযুক্তির ক্ষেত্রে সৃষ্টিশীলতা সম্ভাবনার ক্ষেত্র সৃষ্টির জন্য 'বসুন্দিয়া স্কুল এন্ড কলেজ এর ওয়েবসাইট' একটি সমৃদ্ধ সংযোজন।
                            </p>
                        </div>
                    </div>

                    <!-----<div class="col-md-4">
                      <div style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInLeft;text-align:justify;background-color:#FFFFFF;" class="services wow fadeInLeft" data-wow-delay=".6s">
                       <h4 style="background-color:#5C4283;color:#FFFFFF;height:30px;padding-top:3px;text-align:center;">বসুন্দিয়া স্কুল এন্ড কলেজ</h4>
                        <div style="">
                          <img src="img/BSC_logo.jpg" class="img-responsive" style="width:140px;height:140px;float:left;padding:10px;">
                        </div>
                         <p style="padding:10px;">
                        একটি জাতির সুন্দর ও সমৃদ্ধ ভবিষ্যৎ রচনায় প্রধান উপায় হলো শিক্ষা। শিক্ষার আলোর স্পর্শে একজন ব্যক্তি পূর্ণাঙ্গ মানুষ হিসাবে গড়ে ওঠে । এক্ষেত্রে প্রতিষ্ঠানের গুরুত্ব সর্বাধিক।  দশ দশকের বেশি সময় ধরে বসুন্দিয়া স্কুল এন্ড কলেজ বাংলাদেশের  শিক্ষার অগ্রগতি, আদর্শ এবং দক্ষতার ক্ষেত্রে নিষ্ঠার সাথে অগ্রণী ভূমিকা পালন করে আসছে। এই প্রতিষ্ঠানের শিক্ষার্থীদের সৃজনশীলতা ও মেধার পরিচয় ক্রমাগত দেশ বিদেশে ছড়িয়ে পড়ছে ।  ডিজিটাল বাংলাদেশ গড়ার লক্ষ্যে, এই সময়ের কথা মাথায় রেখে এবং তথ্য প্রযুক্তির ক্ষেত্রে সৃষ্টিশীলতা সম্ভাবনার ক্ষেত্র সৃষ্টির জন্য 'বসুন্দিয়া স্কুল এন্ড কলেজ এর ওয়েবসাইট' একটি সমৃদ্ধ সংযোজন।
                         </p>
                      </div>
                    </div>  ------------>

                </div>
            </div>
            <!-----------------------Enf of Nested grid insi col-md-9 ------>

            <!-----------------------Google Map-------- ------>

            <div style="visibility: visible; animation-delay: 0.3s; animation-name: rollIn;margin-top:8px;border:2px solid #E5E5E5;box-shadow:3px 3px 5px 4px #E5E5E5" class="embed-responsive embed-responsive-16by9 services wow rollIn" data-wow-delay=".3s">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3138.7171383901928!2d89.36638981444426!3d23.13357721797647!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39ff09afb159701b%3A0x926347ab0e21d299!2sBasundia+School+%26+College!5e1!3m2!1sbn!2s!4v1493263869070" width="" height="" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>

        </div>

        <div class="col-md-3">
            <div style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInRight;background-color:#FFFFFF;" class="services wow fadeInRight" data-wow-delay=".2s">
                <div class="notice1"><img src="img/NoticeBoard.PNG" class="img-responsive"></div>  <!--------   Notice----->
                <div class="notice" style="padding-bottom:20px;text-align:justify;border:2px solid #E5E5E5;box-shadow:3px 3px 5px 4px #E5E5E5">
                    <?php
                    $test=0;
                    $total_notice=0;
                    $Notice=mysql_query("select * from noticeboard order by id desc");
                    while($get=mysql_fetch_array($Notice)){
                        $test++;
                        $total_notice++;
                        ?>
                        <p><a href="notice.php?notice_id=<?php echo $get['id']; ?>"><?php if($total_notice<=5){ ?><span class="fa fa-envelope" style="color:#5C4283;">&nbsp</span><?php }?><div style="margin-left:20px;margin-top:-32px;"><?php if($test==1 && $total_notice<=5){echo $get['notice_title'];echo '<img src="img/new.gif">';}else if($total_notice<=5){echo $get['notice_title'];echo "....Read More";}?></div></a></p>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;background-color:#FFFFFF;margin-top:20px;" class="eventHead services wow fadeInRight" data-wow-delay=".4s">
                <div class="notice1"><img src="img/events.PNG" class="img-responsive"></div>  <!--------   Event----->
                <div class="notice" style="padding-bottom:25px;text-align:justify;border:2px solid #E5E5E5;box-shadow:3px 3px 5px 4px #E5E5E5">
                    <?php
                    $total_events=0;
                    $Event=mysql_query("select * from events order by id desc");
                    while($get=mysql_fetch_array($Event)){
                        $total_events++;
                        ?>
                        <p><a href="event.php?event_id=<?php echo $get['id']; ?>"><?php if($total_events<=3){ ?><span class="fa fa-caret-right" style="color:#5C4283;">&nbsp</span><?php }?><div style="margin-left: 10px;margin-top:-32px;"><?php if($total_events<=3){echo $get['event_title'];}?></div></a></p>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInRight;background-color:#FFFFFF;margin-top:20px;" class="eventHead services wow fadeInRight" data-wow-delay=".6s"> <!--------   Links----->
                <div class="notice1"><img src="img/links.PNG" class="img-responsive"></div>  <!--------   Links----->
                <div class="notice" style="border:2px solid #E5E5E5;box-shadow:3px 3px 5px 4px #E5E5E5">
                    <div class="varsityLinks">
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
            </div>


            <div style="visibility: visible; animation-delay: 0.8s; animation-name: fadeInRight;background-color:#FFFFFF;margin-top:20px;" class="eventHead services wow fadeInRight" data-wow-delay=".8s"> <!--------   Links----->
                <div class="notice1"><img src="img/gallery.PNG" class="img-responsive"></div>   <!--------Gallery----->
                <div class="notice" style="border:2px solid #E5E5E5;box-shadow:3px 3px 5px 4px #E5E5E5">
                    <div>
                        <?php
                        $test=0;
                        $total_img=0;
                        $img=mysql_query("select * from gallery order by id desc");
                        while($getImg=mysql_fetch_array($img)){
                            $n=$getImg['img_file'];
                            $test++;
                            $total_img++;
                            ?>

                            <?php if($test==1 && $total_img<=9){ ?>
                                <div class="row">
                                <div class="col-md-4">
                                    <a href="gallery/<?php echo $n;?>" data-lightbox="vacation">
                                        <img src="gallery/<?php echo $n;?>" width="65px" height="65px" class="thumbnail"/>
                                    </a>
                                </div>
                            <?php } else if($test==2 && $total_img<=9){ ?>
                                <div class="col-md-4">
                                    <a href="gallery/<?php echo $n;?>" data-lightbox="Vacation">
                                        <img src="gallery/<?php echo $n;?>" width="65px" height="65px" class="thumbnail"/>
                                    </a>
                                </div>
                            <?php } else if($test==3 && $total_img<=9){ ?>
                                <div class="col-md-4">
                                    <a href="gallery/<?php echo $n;?>" data-lightbox="Vacation">
                                        <img src="gallery/<?php echo $n; $test=0; ?>" width="65px" height="65px" class="thumbnail"/>
                                    </a>
                                </div>
                                </div>
                            <?php } ?>

                            <?php
                        }  // end of while
                        ?>
                    </div>
                    <h4 style="text-align:center;margin-top:5px;"><a href="gallery.php" target="_blank">View All Gallery</a></h4>
                </div>
            </div>


            <!-- admin login  -->
            <?php if ( !isset($_SESSION['admin']) ){ ?>
            <div style="visibility: visible; animation-delay: 0.8s; animation-name: fadeInRight;background-color:#FFFFFF;margin-top:20px;" class="eventHead services wow fadeInRight" data-wow-delay=".8s"> <!--------   Links----->
                <div class="form-center" style="width: 270px;">

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title text-bold text-center">Admin Login</h4>
                        </div>
                        <div class="panel-body" style="padding-top: 30px;">
                            <form method="post" action="admin.php" id="logform">

                                <div class="form-group input-icon">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <input id="iUsername" type="username" name="username" placeholder="Username" class="form-control">
                                </div>

                                <div class="form-group input-icon">
                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                    <input id="iPassword" type="password" name="password" placeholder="Password" class="form-control">
                                </div>

                                <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" name="csrf_token" />
                                <div class="form-group text-center" style="margin-top: 10px;">
                                    <button type="submit" data-loading-text="Logging in.." class="btn btn-primary btn-block btn-md">Login</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-9">

        </div>

        <div class="col-md-3">

        </div>

    </div>
</div>

<?php include 'includes/footer.php'  ?>


</body>
</html>