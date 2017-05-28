<?php $active_nav = isset($active_nav) ? $active_nav : ""; ?>

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

                <li  class="dropdown <?php if($active_nav=='administration') echo "active"; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Administration <b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                        <li><a href="executiveBody">Govphperning Body</a></li>
                        <li class="divider"></li>
                        <li><a href="teacher_stuff">Teachers & Stuff</a></li>
                    </ul>
                </li>

                <li <?php if($active_nav=='students') echo "class=\"active\" "; ?> >
                    <a href="#">Students</a>
                </li>
                <li <?php if($active_nav=='alumni') echo "class=\"active\" "; ?> >
                    <a href="alumni.php">Alumni</a>
                </li>

                <li class="dropdown <?php if($active_nav=='result') echo "active"; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Result <b class="caret"></b> </a>
                    <ul class="dropdown-menu">
                        <li><a href="sscResult">SSC</a></li>
                        <li class="divider"></li>
                        <li><a href="hscResult">HSC</a></li>
                    </ul>
                </li>
                <li <?php if($active_nav=='gallery') echo "class=\"active\" "; ?> >
                    <a href="gallery.php">Gallery</a>
                </li>
                <li <?php if($active_nav=='residance') echo "class=\"active\" "; ?> >
                    <a href="#">Residance</a>
                </li>
                <li <?php if($active_nav=='about') echo "class=\"active\" "; ?> >
                    <a href="about.php">About</a>
                </li>
            </ul>

        </div>

    </div>
</div>
