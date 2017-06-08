<?php
/**
 * Author: ahmed-dinar
 * Date: 6/5/17
 */
?>



<!-- Modal -->
<div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="changeModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="changeModalLabel">Update <?php echo $type; ?> File</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="" name="changeForm" id="changeForm" enctype="multipart/form-data" >
                    <table class="table" style="margin-bottom: 0;">
                        <tbody>

                        <?php if($type == 'calender'){ ?>
                            <tr>
                                <th width="15%">Year</th>
                                <td width="85%"><input class="form-control" id="calenderYear" name="year" placeholder="YYYY"  /></td>
                            </tr>
                        <?php }else{ ?>
                            <tr><td width="15%">Class</td><td width="85%" id="classnameview"></td></tr>
                            <tr><td width="15%">Group</td><td width="85%" id="groupnameview"></td></tr>
                        <?php } ?>


                        <tr>
                            <td colspan="2">
                                <div class="fileSelect">
                                    <div class="form-group"><label>Select <?php echo $type; ?> File (image or pdf)</label>
                                        <input type="file" name="sylFile" id="sylFile" />
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-md btn-primary">Submit</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

