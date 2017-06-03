<?php
/**
 * Author: ahmed-dinar
 * Date: 6/1/17
 */
?>



<div style="margin-top: 10px; margin-bottom: 15px;" class="clearfix">
    <ul class="nav nav-tabs">
        <li role="presentation" <?php if($stat==='verified') echo 'class="active"'; ?> >
            <a href="adminAlumnai.php"><i class="fa fa-check"></i> Verified</a>
        </li>
        <li role="presentation" <?php if($stat==='unverified') echo 'class="active"'; ?> >
            <a href="adminAlumnai.php?status=unverified"><i class="fa fa-times"></i> Unverified</a>
        </li>
        <li role="presentation" <?php if($stat==='accepted') echo 'class="active"'; ?> >
            <a href="adminAlumnai.php?status=accepted"><i class="fa fa-eye"></i> Accepted</a>
        </li>
        <li role="presentation" <?php if($stat==='add') echo 'class="active"'; ?> >
            <a href="adminAlumniAdd.php"><i class="fa fa-plus"></i> Add</a>
        </li>
    </ul>
</div>
