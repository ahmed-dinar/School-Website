<?php
/**
 *  Author: Ahmed-Dinar
 *  Created: 29/05/2017
 */
if(!isset($alumniActive)) $alumniActive = "";
?>

<div class="col-md-12 alumni-nav-wrapper">
    <nav class="navbar navbar-default">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#alumni-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse alumni-navbar" id="alumni-navbar-collapse">

            <a href="alumni.php" class="<?php if($alumniActive === 'home') echo 'active'; ?> btn btn-default navbar-btn">
                <i class="fa fa-home"></i></i> Home
            </a>
            <a href="alumni_members.php" class="<?php if($alumniActive === 'members') echo 'active'; ?> btn btn-default navbar-btn">
                <i class="fa fa-users" aria-hidden="true"></i> Members
            </a>
            <a href="alumni_events.php" class="<?php if($alumniActive === 'events') echo 'active'; ?> btn btn-default navbar-btn">
                <i class="fa fa-calendar-check-o" aria-hidden="true"></i> Events
            </a>
            <a href="alumni_post.php" class="<?php if($alumniActive === 'post') echo 'active'; ?> btn btn-default navbar-btn">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Post
            </a>

            <?php if( isset($_SESSION['user']) ){ ?>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="<?php if($alumniActive === 'profile') echo 'active'; ?> dropdown-toggle nav-profile-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <img width="30" height="30" src="img_alumni/<?php echo $_SESSION['user']->img === '' ? 'blank-profile.png' : $_SESSION['user']->img; ?>" class="img-rounded"> Me <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="alumni_user">My account</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="alumni_logout.php">Log Out</a></li>
                        </ul>
                    </li>
                </ul>

            <?php }else{ ?>

                <div class="pull-right">
                    <a href="alumni_resistration.php" class="<?php if($alumniActive === 'res') echo 'active'; ?> btn btn-success navbar-btn pull-right">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i> Resister for alumni
                    </a>
                    <a href="alumni_login.php" class="<?php if($alumniActive === 'login') echo 'active'; ?> btn btn-default navbar-btn pull-right">
                        <i class="fa fa-sign-in" aria-hidden="true"></i> Login
                    </a>
                </div>

            <?php } ?>

        </div>

    </nav>
</div>


