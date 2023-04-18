<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;



?>
<?php
if (isset($_POST['btnAdd'])) {

        $title = $db->escapeString(($_POST['title']));
        $link = $db->escapeString(($_POST['link']));
        $type = $db->escapeString(($_POST['type']));
        $error = array();
       
        if (empty($title)) {
            $error['title'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($link)) {
            $error['link'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($type)) {
            $error['type'] = " <span class='label label-danger'>Required!</span>";
        }
       
   
           
       if (!empty($title) && !empty($link) && !empty($type) ) 
       {
        $sql_query = "SELECT * FROM job_details WHERE title = '$title'";
        $db->sql($sql_query);
        $res = $db->getResult();
        $num = $db->numRows($res);
        if ($num >= 1) {
            $error['add_job_details'] = " <span class='label label-danger'>Admin Already Added</span>";
            
        }else{
            $sql_query = "INSERT INTO job_details (title,link,type)VALUES('$title','$link','$type')";
            $db->sql($sql_query);
            $result = $db->getResult();

            if ($result == 1) {
                echo $num;
                
                $error['add_job_details'] = "<section class='content-header'>
                                                <span class='label label-success'>job_details Added Successfully</span> </section>";
            } else {
                $error['add_job_details'] = " <span class='label label-danger'>Failed</span>";
            }
        }
            
        }
           

    }
?>
<section class="content-header">
    <h1>Add New job <small><a href='job_details.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to jobs</a></small></h1>

   
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form url="add-job-details-form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                       <div class="row">
                            <div class="form-group">
                                <div class='col-md-12'>
                                    <label for="exampleInputtitle">title</label> <i class="text-danger asterik">*</i>
                                    <input type="title" class="form-control" name="title" required>
                                </div>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-12'>
                                    <label for="exampleInputEmail1">link</label> <i class="text-danger asterik">*</i>
                                    <textarea type="text" rows="3" class="form-control" name="link" required></textarea>
                                </div>
                                
                                 <br>
                                <div class='col-md-12'>
                                <label for="exampleInputtype">type</label> <i class="text-danger asterik">*</i>
                                 <select id='type' name="type"  class='form-control'>
                                    <option value="job">job</option>
                                    <option value="info">info</option>
                            </select>
                            </div>
                            </div>
                        </div>
                    </div>
                
                  
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
                        <input type="reset" onClick="refreshPage()" class="btn-warning btn" value="Clear" />
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_leave_form').validate({

        ignore: [],
        debug: false,
        rules: {
        reason: "required",
            date: "required",
        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>
<script>
    $(document).ready(function () {
        $('#user_id').select2({
        width: 'element',
        placeholder: 'Type in name to search',

    });
    });

    if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

</script>

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>

<?php $db->disconnect(); ?>