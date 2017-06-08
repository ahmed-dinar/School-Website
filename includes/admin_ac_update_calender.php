<?php
/**
 * Author: ahmed-dinar
 * Date: 6/5/17
 */
?>

<div class="col-md-6">
    <div id="changeFormWrapper" class="hidden" style="border: 1px solid #ddd;">

        <form method="post" action="" id="changeForm" enctype="multipart/form-data" >
            <table class="table" style="margin-bottom: 0;">
                <tbody>
                <tr><td width="15%">Class</td><td width="85%" id="classnameview"></td></tr>
                <tr><td width="15%">Group</td><td width="85%" id="groupnameview"></td></tr>
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
</div>
