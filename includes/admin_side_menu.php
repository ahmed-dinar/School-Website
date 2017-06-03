<?php
/**
 *  Author: Ahmed-Dinar
 *  Created: 29/05/2017
 */
?>
<div class="side-menu">
    <div>
        <h4>
            Control Panel
            <a  href="admin_logout.php" class="btn btn-xs btn-default text-bold" style="margin-top: 8px; border-radius: 1px; border: none; box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14),0 1px 5px 0 rgba(0,0,0,0.12),0 3px 1px -2px rgba(0,0,0,0.2);">
                Logout
            </a>
        </h4>
    </div>
    <div class="controlList">
        <ul class="admin-side-menu">
            <li <?php if($adminNav === 'notice') echo 'class="active"'; ?> >
                <a href="noticeAdmin.php">Notice and Events</a>
            </li>
            <li <?php if($adminNav === 'tas') echo 'class="active"'; ?> >
                <a href="adminTeacher.php">Teachers & Stuff</a>
            </li>
            <li <?php if($adminNav === 'gov') echo 'class="active"'; ?> >
                <a href="adminGoverningBody.php">Governing Body</a>
            </li>
            <li <?php if($adminNav === 'student') echo 'class="active"'; ?> >
                <a href="adminStudent.php">Students</a>
            </li>
            <li <?php if($adminNav === 'result') echo 'class="active"'; ?> >
                <a href="adminResult.php">Result</a>
            </li>
            <li <?php if($adminNav === 'alumni') echo 'class="active"'; ?> >
                <a href="adminAlumnai.php">Alumni</a>
            </li>
            <li <?php if($adminNav === 'academic') echo 'class="active"'; ?> >
                <a href="adminAcademic.php">Academic</a>
            </li>
            <li <?php if($adminNav === 'gallery') echo 'class="active"'; ?> >
                <a href="galleryAdmin.php">Gallery</a>
            </li>
        </ul>
    </div>
</div>