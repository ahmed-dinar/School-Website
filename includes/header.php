<?php
/**
 *  Author: Ahmed-Dinar
 *  Created: 29/05/2017
 */

//for active nav in navigation bar
$active_nav = isset($active_nav) ? $active_nav : "";
?>


<!----------  Banner ------>
<div class="container">
    <div class="page-header no-paddingBanner no-marginBanner">
        <img src="img/BSC.jpeg" class="img-responsive" style="width:100%;">
    </div>
</div>


<div class="container">
    <div class="navbar navbar-inverse" style="margin-bottom: 3px">

        <button type="button" class="navbar-toggle"
                data-toggle="collapse"
                data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <div class="navbar-collapse collapse">

            <ul class="nav navbar-nav navbar-right" style="margin-right: 5px">

                <li <?php if($active_nav=='home') echo "class=\"active\" "; ?> >
                    <a href="index">Home</a>
                </li>

                <li  class="dropdown <?php if($active_nav=='about') echo "active"; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> About Us <b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                        <li><a href="history.php">History</a></li>
                        <li class="divider"></li>
                        <li><a href="virtualCampusTour.php">Virtual Campus Tour</a></li>
                        <li class="divider"></li>
                        <li><a href="vision.php">Vision & Objectives</a></li>
                        <li class="divider"></li>
                        <li><a href="achievements.php">Achievements</a></li>
                        <li class="divider"></li>
                        <li><a href="infrastucture.php">Infrastucture</a></li>
                    </ul>
                </li>

                <li  class="dropdown <?php if($active_nav=='administration') echo "active"; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Administration <b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                        <li><a href="executiveBody.php">Govphperning Body</a></li>
                        <li class="divider"></li>
                        <li><a href="teacher_stuff.php">Teachers & Stuff</a></li>
                    </ul>
                </li>

                <li  class="dropdown <?php if($active_nav=='academic') echo "active"; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Academic <b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                        <li><a href="academicCalender.php"> Academic Calendar</a></li>
                        <li class="divider"></li>
                        <li><a href="syllabus.php">Book List & Syllabus</a></li>
                        <li class="divider"></li>
                        <li><a href="classRoutine.php">Class Routine</a></li>
                        <li class="divider"></li>
                        <li><a href="examSchedule.php">Exam Schedule</a></li>
                        <li class="divider"></li>
                        <li><a href="hscResult.php">Results</a></li> <!----------Already Done----->
                    </ul>
                </li>

                <li <?php if($active_nav=='students') echo "class=\"active\" "; ?> >
                    <a href="student.php">Students</a>
                </li>

                <li class="dropdown <?php if($active_nav=='result') echo "active"; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Result <b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Public Result</li>
                        <li><a href="sscResult.php">SSC</a></li>
                        <li><a href="hscResult.php">HSC</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Academic Result</li>
                        <li><a href="academicResult.php">Result</a></li>
                    </ul>
                </li>


                <li <?php if($active_nav=='alumni') echo "class=\"active\" "; ?> >
                    <a href="alumni.php">Alumni</a>
                </li>

                <li <?php if($active_nav=='gallery') echo "class=\"active\" "; ?> >
                    <a href="gallery.php">Gallery</a>
                </li>
                <li <?php if($active_nav=='residance') echo "class=\"active\" "; ?> >
                    <a href="#">Residance</a>
                </li>

            </ul>

        </div>

    </div>
</div>
