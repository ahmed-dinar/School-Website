<?php
/**
 * Author: ahmed-dinar
 * Date: 6/3/17
 */
if(!isset($type)) $type="";
?>

<div style="margin-top: 10px; margin-bottom: 15px;" class="clearfix">
    <ul class="nav nav-tabs">
        <li role="presentation" <?php if($type==='syllabus') echo 'class="active"'; ?> >
            <a href="adminAcademic.php?type=syllabus"><i class="fa fa-list-alt"></i> Syllabus</a>
        </li>
        <li role="presentation" <?php if($type==='books') echo 'class="active"'; ?> >
            <a href="adminAcademic.php?type=books"><i class="fa fa-book"></i> Books</a>
        </li>
        <li role="presentation" <?php if($type==='calender') echo 'class="active"'; ?> >
            <a href="adminAcademic.php?type=calender"><i class="fa fa-calendar"></i> Calender</a>
        </li>
        <li role="presentation" <?php if($type==='examRoutine') echo 'class="active"'; ?> >
            <a href="adminAcademic.php?type=examRoutine"><i class="fa fa-calendar-check-o"></i> Exam Routine</a>
        </li>
        <li role="presentation" <?php if($type==='classRoutine') echo 'class="active"'; ?> >
            <a href="adminAcademic.php?type=classRoutine"><i class="fa fa-calendar-o"></i> Class Routine</a>
        </li>
    </ul>
</div>
