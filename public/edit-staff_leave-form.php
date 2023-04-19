<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<?php

if (isset($_GET['id'])) {
    $ID = $db->escapeString($_GET['id']);
} else {
    // $ID = "";
    return false;
    exit(0);
}
if (isset($_POST['btnEdit'])) {
           
            $status = $db->escapeString(($_POST['status']));
            $error = array();

    //  if (!empty($from_date) && !empty($type) && !empty($reason)) {
    
        $sql_query = "UPDATE staff_leaves SET status='$status' WHERE id =  $ID";
        $db->sql($sql_query);
        $update_result = $db->getResult();
        if (!empty($update_result)) {
            $update_result = 0;
        } else {
            $update_result = 1;
        }

        // check update result
        if ($update_result == 1) {
            $error['update_leave'] = " <section class='content-header'><span class='label label-success'>Leave updated Successfully</span></section>";
        } else {
            $error['update_leave'] = " <span class='label label-danger'>Failed update Leave</span>";
        }


    // }
}


// create array variable to store previous data
$data = array();

$sql_query = "SELECT l.*,l.id AS id,l.status AS status,s.name,s.role,s.mobile,s.branch_id,b.short_code FROM `staff_leaves` l,`branches` b,`staffs` s WHERE s.branch_id=b.id AND l.staff_id=s.id AND  l.id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();
if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "staff_leaves.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>
        Edit Staff Leave Details<small><a href='staff_leaves.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Staff Leaves</a></small></h1>
    <small><?php echo isset($error['update_leave']) ? $error['update_leave'] : ''; ?></small>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
</section>
<section class="content">
    <!-- Main row -->

    <div class="row">
        <div class="col-md-8">

            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                </div>
                <form id="edit_user_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Name</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Mobile Number</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="mobile" value="<?php echo $res[0]['mobile']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Branch</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="short_code" value="<?php echo $res[0]['short_code']; ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Role</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="role" value="<?php echo $res[0]['role']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1"> Date</label> <i class="text-danger asterik">*</i>
                                    <input type="date"  class="form-control" name="date" value="<?php echo $res[0]['date']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-10">
                                     <label for="exampleInputEmail1">Reason</label><i class="text-danger asterik">*</i>
                                    <textarea type="text" rows="3" class="form-control" name="reason" readonly><?php echo $res[0]['reason']; ?></textarea>
                                </div>  
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-8">
                                    <label class="control-label">Status</label> <i class="text-danger asterik">*</i><br>
                                    <div id="status" class="btn-group">
                                        <label class="btn btn-warning" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="0" <?= ($res[0]['status'] == 0) ? 'checked' : ''; ?>>Pending
                                        </label>
                                        <label class="btn btn-success" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="1" <?= ($res[0]['status'] == 1) ? 'checked' : ''; ?>> Approved
                                        </label>
                                        <label class="btn btn-danger" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="2" <?= ($res[0]['status'] == 2) ? 'checked' : ''; ?>> Rejected
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnEdit">Update</button>

                    </div>
                </form>
            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<?php $db->disconnect(); ?>
