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

            $date = $db->escapeString(($_POST['date']));
            $amount = $db->escapeString(($_POST['amount']));
            $remarks = $db->escapeString(($_POST['remarks']));
            $error = array();

     if (!empty($date) && !empty($amount) && !empty($remarks)) 
		{

        $sql_query = "UPDATE expenses SET date='$date', amount='$amount', remarks='$remarks' WHERE id =  $ID";
        $db->sql($sql_query);
        $update_result = $db->getResult();
        if (!empty($update_result)) {
            $update_result = 0;
        } else {
            $update_result = 1;
        }

        // check update result
        if ($update_result == 1) {
            $error['update_expenses'] = " <section class='content-header'><span class='label label-success'>expenses updated Successfully</span></section>";
        } else {
            $error['update_expenses'] = " <span class='label label-danger'>Failed update</span>";
        }
    }
}


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM expenses WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "expenses.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>
        Edit expenses<small><a href='expenses.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to expenses</a></small></h1>
    <small><?php echo isset($error['update_expenses']) ? $error['update_expenses'] : ''; ?></small>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
</section>
<section class="content">
    <!-- Main row -->

    <div class="row">
        <div class="col-md-10">

            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
               </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form url="edit-expenses-form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                       <div class="row">
                            <div class="form-group">
                                <div class='col-md-12'>
                                    <label for="exampleInputdate">date</label> <i class="text-danger asterik">*</i>
                                    <input type="date" class="form-control" name="date" value="<?php echo $res[0]['date']; ?>">
                                </div>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                            <div class='col-md-12'>
                                    <label for="exampleInputamount">amount</label> <i class="text-danger asterik">*</i>
                                    <input type="text"  class="form-control" name="amount" value="<?php echo $res[0]['amount']; ?>">
                                </div>
                                <br>
                                <div class="form-group">
                                <div class='col-md-12'>
                                    <label for="exampleInputremarks">remarks</label> <i class="text-danger asterik">*</i>
                                    <textarea type="text" rows="3" class="form-control" name="remarks" value="<?php echo $res[0]['remarks']; ?>"></textarea>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>