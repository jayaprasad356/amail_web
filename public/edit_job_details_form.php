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

            $language = $db->escapeString(($_POST['language']));
            $link = $db->escapeString(($_POST['link']));
            $error = array();

     if (!empty($language) && !empty($link)) 
		{

        $sql_query = "UPDATE job_details SET language='$language', link='$link' WHERE id =  $ID";
        $db->sql($sql_query);
        $update_result = $db->getResult();
        if (!empty($update_result)) {
            $update_result = 0;
        } else {
            $update_result = 1;
        }

        // check update result
        if ($update_result == 1) {
            $error['update_job_details'] = " <section class='content-header'><span class='label label-success'>job_details updated Successfully</span></section>";
        } else {
            $error['update_job_details'] = " <span class='label label-danger'>Failed update</span>";
        }
    }
}


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM job_details WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "job_details.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>
        Edit jobs<small><a href='job_details.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to jobs</a></small></h1>
    <small><?php echo isset($error['update_job_details']) ? $error['update_job_details'] : ''; ?></small>
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
                <form id="edit_job_details_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-6'>
                                    <label for="exampleInputEmail1">language</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="language" value="<?php echo $res[0]['language']; ?>">
                                </div>
                            </div>
                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                               <div class="col-md-6">
                                    <label for="exampleInputEmail1">link</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="link" value="<?php echo $res[0]['link']; ?>">
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