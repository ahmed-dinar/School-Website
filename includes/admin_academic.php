<?php
/**
 * Author: ahmed-dinar
 * Date: 6/3/17
 */



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $redirectTo = "adminAcademic.php?type=$type";
    require_once 'libs/VALIDATE.php';


    /**
     * Change file
     */
    if( array_key_exists("change",$urlQuery) ){

        $id = $urlQuery["change"];

        if( !VALIDATE::exists('id', $id, $db, 'academic') )
            $flashMsg->error("Error while processing requests", $redirectTo);

        $academicFile = VALIDATE::academicFile("sylFile");
        validateFile($academicFile, $flashMsg, $redirectTo);

        if( !updateAcademic($id, $type, $academicFile["ext"], $db) )
            $flashMsg->error("Error while processing request update", $redirectTo);

        $flashMsg->success("$type Successfully updated",$redirectTo);
        return;
    }


    //calender or classRoutine action, (only file and year)
    if( $type === 'calender' || $type === 'classRoutine' ){

        if( !isset($_POST['year']) )
            die("invalid request");

        $year = $_POST['year'];
        $input = (int)$year;
        if($input < 1000 || $input > 5100)
            $flashMsg->error("Invalid year", $redirectTo);

        $academicFile = VALIDATE::academicFile("sylFile");
        validateFile($academicFile, $flashMsg, $redirectTo);

        $academicInfo = getAcademic($type, null, null, $db, $year);

        if( empty($academicInfo) )
            saveAcademic($type, '', '', $academicFile["ext"], $db, $flashMsg, $redirectTo, $year);
        else
            $flashMsg->error("A $type of year $year already added.Please update it from list below.", $redirectTo);

        $flashMsg->success("unknown action", $redirectTo);
        return;
    }

    /*********  FOR syllabus and book list *************/

    //needs class
    if( !isset($_POST["class"]) ||  $_POST['class'] == ''  )
        $flashMsg->error("Please select a class", "adminAcademic.php?type=$type");

    //needs group
    if( !isset($_POST["group"]) ||  $_POST['group'] == ''  )
        $flashMsg->error("Please select a Group", "adminAcademic.php?type=$type");

    //validate file
    $academicFile = VALIDATE::academicFile("sylFile");
    validateFile($academicFile, $flashMsg, $redirectTo);

    $class = $_POST["class"];
    $group = $_POST["group"];
    $redirectTo = "adminAcademic.php?type=$type&class=$class&group=$group";
    $academicInfo = getAcademic($type,$class, $group, $db);

    if( empty($academicInfo) )
        saveAcademic($type, $class, $group, $academicFile["ext"], $db,  $flashMsg, $redirectTo);
    else if( !updateAcademic($academicInfo[0]->id, $type, $academicFile["ext"], $db) )
        $flashMsg->error("Error while processing request update", $redirectTo);
    else
        $flashMsg->success("$typeAlias[$type] Successfully Updated", $redirectTo);

    return;
}


$class = null;
$group = null;

//validate class
if( array_key_exists("class",$urlQuery) )
    $class = $urlQuery["class"];

//validate group
if( array_key_exists("group",$urlQuery)  ){
    if( $urlQuery["group"] !== "Science" && $urlQuery["group"] !== "Humanities" && $urlQuery["group"] !== "Commerce" )
        showError("Invalid group $urlQuery[group]");

    $group = $urlQuery["group"];
}

$academicInfo = getAcademic($type, $class, $group, $db);
$classAlias = array("Six","Seven","Eight","Nine", "Ten", "College 1st", "College 2nd");

?>

<?php if($type === 'calender' || $type === 'classRoutine'){ ?>


    <div class="col-md-6">
        <form method="post" name="addForm"  action="adminAcademic.php?add=<?php echo $type; ?>" enctype="multipart/form-data" >
            <div class="form-group">
                <label>Year</label>
                <input class="form-control" name="year" placeholder="YYYY"  />
            </div>

            <div class="form-group">
                <label>Select <?php echo $typeAlias[$type]; ?> File (image or pdf)</label>
                <input type="file" name="sylFile" id="sylFile" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-md btn-primary">Add <?php echo $typeAlias[$type]; ?></button>
            </div>
        </form>
    </div>


    <?php if(!empty($academicInfo)){ ?>
        <div class="col-md-12" style="margin-top: 20px;">
            <table class="table">
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Year</th>
                    <th>View</th>
                    <th>Change</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($academicInfo as $item){ ?>
                    <tr>
                        <td><?php echo $item->type; ?></td>
                        <th><?php echo $item->year; ?></th>
                        <td>
                            <a target="_blank" class="btn btn-xs btn-info" href="academicFileView.php?type=<?php echo $type; ?>&view=<?php echo $item->id; ?>">
                                <i class="fa fa-eye"></i> View
                            </a>
                        </td>
                        <td>
                            <button forYear="<?php echo $item->year; ?>" classAlias="<?php echo $classAlias[$item->class-6]; ?>" groupName="<?php echo $item->group; ?>"   id="<?php echo $item->id; ?>"  acType="<?php echo $item->type; ?>"  class="btn btn-xs btn-primary changeFile" data-toggle="modal" data-target="#changeModal" >
                                <i class="fa fa-pencil"></i> Change
                            </button>
                        </td>
                        <td>
                            <a class="btn btn-xs btn-danger" href="adminAcademic.php?type=<?php echo $type; ?>&delete=<?php echo $item->id; ?>">
                                <i class="fa fa-trash-o"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php }  ?>
                </tbody>
            </table>
        </div>
    <?php }else{ ?>
        <div class="col-md-12">
            <div class="well text-center">No <?php echo $typeAlias[$type]; ?> added yet</div>
        </div>
    <?php } ?>


<?php }else{ ?>


    <div class="col-md-6">

        <form method="post" action="adminAcademic.php?add=<?php echo $type; ?>" enctype="multipart/form-data" >

            <div class="form-group">
                <label>Select Class</label>
                <select id="classList" name="class" class="form-control">
                    <option value="" <?php if( is_null($class)) echo "selected"; ?> >Select Class</option>
                    <?php for ($i = 0; $i < count($classAlias); $i++) { ?>
                        <option  value="<?php echo $i+6; ?>" <?php if($class == $i+6) echo "selected"; ?> ><?php echo $classAlias[$i]; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label>Select Group</label>
                <select id="groupList" name="group" class="form-control">
                    <option value="" <?php if( is_null($group)) echo "selected"; ?> >Select Group</option>
                    <option value="Science" <?php if($group === "Science") echo "selected"; ?> >Science</option>
                    <option value="Humanities" <?php if($group === "Humanities") echo "selected"; ?> >Humanities</option>
                    <option value="Commerce" <?php if($group === "Commerce") echo "selected"; ?> >Commerce</option>
                </select>
            </div>

            <?php if(empty($academicInfo)){ ?>
                <div class="fileSelect">
                    <div class="form-group">
                        <label>Select <?php echo $typeAlias[$type]; ?> File (image or pdf)</label>
                        <input type="file" name="sylFile" id="sylFile" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-primary">Add <?php $typeAlias[$type]; ?></button>
                    </div>
                </div>
            <?php  } ?>

        </form>

    </div>


    <div class="col-md-12" style="margin-top: 20px;">
    <?php if(!empty($academicInfo)){ ?>

            <table class="table">
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Class</th>
                    <th>Group</th>
                    <th>View</th>
                    <th>Change</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($academicInfo as $item){ ?>
                    <tr>
                        <td><?php echo $item->type; ?></td>
                        <td><?php echo $classAlias[$item->class-6]; ?></td>
                        <td><?php echo $item->group; ?></td>
                        <td>
                            <a target="_blank" class="btn btn-xs btn-info" href="academicFileView.php?type=<?php echo $type; ?>&view=<?php echo $item->id; ?>">
                                <i class="fa fa-eye"></i> View
                            </a>
                        </td>
                        <td>
                            <button classAlias="<?php echo $classAlias[$item->class-6]; ?>" groupName="<?php echo $item->group; ?>"   id="<?php echo $item->id; ?>"  acType="<?php echo $item->type; ?>"  class="btn btn-xs btn-primary changeFile" data-toggle="modal" data-target="#changeModal" >
                                <i class="fa fa-pencil"></i> Change
                            </button>
                        </td>
                        <td>
                            <a class="btn btn-xs btn-danger" href="adminAcademic.php?type=<?php echo $type; ?>&delete=<?php echo $item->id; ?>">
                                <i class="fa fa-trash-o"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php }  ?>
                </tbody>
            </table>

    <?php }else{ ?>
        <div class="well text-center">
            No <b><?php echo $typeAlias[$type]; ?></b> added yet
            <?php if (!is_null($class) ){ $idx = (int)$class - 6; echo " of <b>class $classAlias[$idx]</b>"; }?>
            <?php if (!is_null($group) ) echo " of <b> $group group</b>"; ?>.
        </div>
    <?php } ?>
    </div>
<?php } ?>


<?php include 'admin_ac_update.php'; ?>

<script>



    $(function() {

        $('.changeFile').on('click',function (e) {
            e.preventDefault();

            var id = $(this).attr('id');
            var type = $(this).attr('acType');
            var classAlias = $(this).attr('classAlias');
            var group = $(this).attr('groupName');
            var year = $(this).attr('forYear');

            if (typeof classAlias !== typeof undefined && classAlias !== false) {
                $("#classnameview").html(classAlias);
            }

            if (typeof group !== typeof undefined && group !== false) {
                $("#groupnameview").html(group);
            }

            if (typeof year !== typeof undefined && year !== false) {
                $("#calenderYear").val(year);
            }

            var action = 'adminAcademic.php?type='+ type +'&change=' + id;
            $('#changeForm').attr('action', action);


        });

        // bind change event to select
        $('#classList').on('change', function() {
            var targetClass = $(this).val();
            var targetGroup = $("#groupList").val();
            redirectTO(targetClass,targetGroup);
        });

        $('#groupList').on('change', function() {
            var targetGroup = $(this).val();
            var targetClass = $("#classList").val();
            redirectTO(targetClass,targetGroup);
        });
    });

    function redirectTO(targetClass, targetGroup) {
        var url = 'adminAcademic.php?type=<?php echo $type; ?>';
        if( targetClass !== ''  )
            url += '&class='+ targetClass;
        if( targetGroup !== '' )
            url += '&group='+ targetGroup;
        window.location.replace(url);
    }

</script>
