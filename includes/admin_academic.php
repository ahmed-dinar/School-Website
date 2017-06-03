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
        if( array_key_exists("error", $academicFile) ){
            switch ($academicFile["type"]){
                case "404":
                    $flashMsg->error("file is required", $redirectTo);
                case "ext":
                    $flashMsg->error("only pdf, jpg, jpeg & png files are allowed", $redirectTo);
                default:
                    $flashMsg->error("error while processing requests", $redirectTo);
            }
        }

        if( !updateAcademic($id, $academicFile["ext"], $db) )
            $flashMsg->error("Error while processing request update", $redirectTo);

        $flashMsg->success("$type Successfully updated",$redirectTo);
        return;
    }


    if( !isset($_POST["class"]) ||  $_POST['class'] == ''  )
        $flashMsg->error("Please select a class", "adminAcademic.php?type=$type");

    if( !isset($_POST["group"]) ||  $_POST['group'] == ''  )
        $flashMsg->error("Please select a Group", "adminAcademic.php?type=$type");


    $academicFile = VALIDATE::academicFile("sylFile");
    if( array_key_exists("error", $academicFile) ){
        switch ($academicFile["type"]){
            case "404":
                $flashMsg->error("file is required", $redirectTo);
            case "ext":
                $flashMsg->error("only pdf, jpg, jpeg & png files are allowed", $redirectTo);
            default:
                $flashMsg->error("error while processing requests", $redirectTo);
        }
    }

    $class = $_POST["class"];
    $group = $_POST["group"];
    $redirectTo = "adminAcademic.php?type=$type&class=$class&group=$group";
    $academicInfo = getAcademic($type,$class, $group, $db);

    if( empty($academicInfo) )
        saveAcademic($type, $class, $group, $academicFile["ext"], $db,  $flashMsg, $redirectTo);
    else if( !updateAcademic($academicInfo[0]->id, $academicFile["ext"], $db) )
        $flashMsg->error("Error while processing request update", $redirectTo);
    else
        $flashMsg->success("$type Successfully Updated", $redirectTo);

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

/**
 * @param $type
 * @param $class
 * @param $group
 * @param $fileName
 * @param $db
 * @param $flashMsg
 * @param $redirectTo
 */
function saveAcademic($type, $class, $group, $fileName, $db, $flashMsg, $redirectTo){

    $_query = $db->prepare("INSERT INTO `academic`(`type`,`class`,`group`) VALUES(:type, :class, :group)");
    $_query->bindValue(":type", $type);
    $_query->bindValue(":class", $class);
    $_query->bindValue(":group", $group);

    if( !$_query->execute() || $_query->rowCount() == 0 )
        $flashMsg->error("Error while processing request", $redirectTo);

    if( !updateAcademic($db->lastInsertId(), $fileName, $db) )
        $flashMsg->error("Error while processing request insert", $redirectTo);

    $flashMsg->success("$type Successfully Added", $redirectTo);
}


/**
 * @param $id
 * @param $file
 * @param $db
 * @param $flashMsg
 * @param $redirectTo
 * @return bool
 */
function updateAcademic($id, $file, $db){

    $file = "$id.$file";

    //check if the photo has write permission
    if( !is_writable('academic_files') ){
        // echo "academic_files has not write permission!<br>";
        //exit(0);
        return false;
    }

    //remove the previous same named image
    if(file_exists('academic_files/'.$file))
        unlink('academic_files/'.$file);

    // move photo to image dir
    if( !move_uploaded_file($_FILES['sylFile']['tmp_name'], 'academic_files/'.$file) ){
        //  echo "image not moved to academic_files<br>";
        //exit(0);
        return false;
    }


    $_query = $db->prepare("UPDATE `academic` SET `file` = :file WHERE `id` = :id");
    $_query->bindValue(":file", $file);
    $_query->bindValue(":id", $id);

    if( !$_query->execute() || $_query->rowCount() == 0 )
        return false;

    return true;
}


/**
 * @param $type
 * @param $class
 * @param $group
 * @param $db
 * @return mixed
 */
function getAcademic($type, $class, $group, $db){

    $statement = "SELECT * FROM `academic` WHERE `type`=:type ";

    if( !is_null($class) )
        $statement .= " AND `class` = :class ";

    if( !is_null($group) )
        $statement .= " AND `group` = :group ";

    $statement .= " ORDER BY `type` DESC, `class` ASC, `group` DESC;";
    $_query = $db->prepare($statement);
    $_query->bindValue(":type",$type);

    if( !is_null($class) )
        $_query->bindValue(":class",$class);

    if( !is_null($group) )
        $_query->bindValue(":group",$group);

    if( !$_query->execute() ){
        echo "Error while processing error";
        exit(0);
    }

    return $_query->fetchAll(PDO::FETCH_OBJ);
}


/**
 * Alert error
 * @param $error
 */
function showError($error){
    echo '<div class="alert alert-danger" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>'.$error.'</div>';
    exit(0);
}

?>

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
                    <label>Select <?php echo $type; ?> File (image or pdf)</label>
                    <input type="file" name="sylFile" id="sylFile" />
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-md btn-primary">Submit</button>
                </div>
            </div>
        <?php  } ?>

    </form>

</div>

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


<?php if(!empty($academicInfo)){ ?>
    <div class="col-md-12" style="margin-top: 20px;">
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
                        <button classAlias="<?php echo $classAlias[$item->class-6]; ?>" groupName="<?php echo $item->group; ?>"   id="<?php echo $item->id; ?>"  acType="<?php echo $item->type; ?>"  class="btn btn-xs btn-primary changeFile" >
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
<?php } ?>


<script>

    $(function() {

        $('.changeFile').on('click',function (e) {
            e.preventDefault();

            var id = $(this).attr('id');
            var type = $(this).attr('acType');
            var classAlias = $(this).attr('classAlias');
            var group = $(this).attr('groupName');


            if( $("#changeFormWrapper").hasClass('hidden') ){
                $("#changeFormWrapper").removeClass('hidden');
            }
            else if( $("#classnameview").html() === classAlias ){
                $("#changeFormWrapper").addClass('hidden');
                return;
            }

            var action = 'adminAcademic.php?type='+ type +'&change=' + id;
            $('#changeForm').attr('action', action);
            $("#classnameview").html(classAlias);
            $("#groupnameview").html(group);
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
