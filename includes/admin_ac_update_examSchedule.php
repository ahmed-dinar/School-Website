<?php
/**
 * Author: ahmed-dinar
 * Date: 6/7/17
 */
?>


<!-- Modal -->
<div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="changeModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="changeModalLabel"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update <?php echo $typeAlias[$type]; ?> File</h4>
            </div>
            <div class="modal-body">

                <form action="adminAcademic.php?type=examSchedule" id="examFormUpdate" method="post" name="examFormUpdate" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label>Title <sup>*</sup></label>
                        <input class="form-control" id="inputTitle" value="" type="text" name="title" />
                    </div>
                    <div class="form-group">
                        <label>Year <sup>*</sup></label>
                        <input class="form-control" id="inputYear" value="" type="text" name="year" />
                    </div>
                    <div class="form-group">
                        <label>Term</label>
                        <select class="form-control" id="term" name="term">
                            <option value="first">First term</option>
                            <option value="second">Second term</option>
                            <option value="final">Final</option>
                            <option value="ssc">SSC</option>
                            <option value="hsc">HSC</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Section</label>
                        <select class="form-control" id="college" name="college">
                            <option value="0">School</option>
                            <option value="1">College</option>
                        </select>
                    </div>
                    <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" id="csrf_token" name="csrf_token" />
                    <div class="form-group">
                        <label for="scFile">Select Exam Schedule File <sup>*</sup></label>
                        <input type="file" name="file" id="scFile" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-primary">Submit</button>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>

    $(".changeFile").on( "click", function(e) {
        e.preventDefault();

        var title = $(this).attr("examTitle");
        var year = $(this).attr("examYear");
        var term = $(this).attr("examTerm");
        var section = $(this).attr("examSection");
        var id = $(this).attr("id");
        var type = $(this).attr('acType');

        if (typeof title !== typeof undefined && title !== false) {
            $("#inputTitle").val(title);
        }

        if (typeof year !== typeof undefined && year !== false) {
            $("#inputYear").val(year);
        }

        if (typeof term !== typeof undefined && term !== false) {
            $('#term').val(term);
        }

        if (typeof section !== typeof undefined && section !== false) {
            $('#college').val(section);
        }

        var action = 'adminAcademic.php?type='+ type +'&change=' + id;
        $('#examFormUpdate').attr('action', action);

        console.log( $( this ).text() );
    });

    //validate from in front end
    $("#examFormUpdate").validate({
        rules: {
            title: {
                required: true,
                maxlength: 512
            },
            year: {
                required: true,
                rangelength: [4,4],
                number: true
            },
            file: {
                required: true
            }
        },
        messages: {
            title:{
                maxlength: "Title must be less than 512 characters long."
            },
            year: {
                number: "Please enter a valid year",
                rangelength: "Please enter a valid year"
            }
        }
    });
</script>
