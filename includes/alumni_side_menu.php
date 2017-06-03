<?php
/**
 *  Author: Ahmed-Dinar
 *  Created: 29/05/2017
 */
?>
<div class="side-menu">
    <h4>
        <div class="clearfix">Alumni</div>

        <?php if(isset($_SESSION["user"])){ ?>
            <a  href="alumni_logout.php" class="btn btn-xs btn-default text-bold" style="margin-top: 8px; border-radius: 1px; border: none; box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14),0 1px 5px 0 rgba(0,0,0,0.12),0 3px 1px -2px rgba(0,0,0,0.2);">
                Logout
            </a>
        <?php }  ?>
    </h4>

    <div class="controlList">
        <ul class="admin-side-menu">
            <li  <?php if($alumniActive==='members') echo 'class="active"'; ?> >
                <a href="alumni_members.php">Members</a>
            </li>
            <li  <?php if($alumniActive==='events') echo 'class="active"'; ?> >
                <a href="#">Events</a>
            </li>

            <?php if(!isset($_SESSION["user"])){ ?>
                <li  <?php if($alumniActive==='reg') echo 'class="active"'; ?> >
                    <a href="alumni_resistration.php">Be Member</a>
                </li>
                <li  <?php if($alumniActive==='login') echo 'class="active"'; ?> >
                    <a href="alumni_login.php">Member Login</a>
                </li>
            <?php }else{  ?>
                <li  <?php if($alumniActive==='my') echo 'class="active"'; ?> >
                    <a href="alumni_user.php">My Account</a>
                </li>
            <?php }  ?>

        </ul>
    </div>
</div>