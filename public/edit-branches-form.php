<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$sql = "SELECT id,name,short_code FROM branches ORDER BY id ASC";
$db->sql($sql);
$res = $db->getResult();

?>
<?php
if (isset($_POST['btnUpdate'])) {

    $error = array();
    $name = $db->escapeString($_POST['name']);
    $short_code = $db->escapeString($_POST['short_code']);



    if (empty($error)) {
        // Sanitize input data
        $name = $db->escapeString($_POST['name']);
        $short_code = $db->escapeString($_POST['short_code']);
        $id = $db->escapeString($_POST['id']);

        // Update data in the database
        $sql_query = "UPDATE branches SET name='$name', short_code='$short_code' WHERE id='$id'";
        $db->sql($sql_query);
        $result = $db->getResult();
        if (!empty($result)) {
            $error['update_branches'] = "<section class='content-header'>
                                    <span class='label label-success'>BraUpdated Successfully</span></section>";
        } else {
            $error['update_branches'] = "<span class='label label-danger'>Failed</span>";
        }
    }
}
?>
    
?>
<section class="content-header">
    <h1>Update branches <small><a href='branches.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to branches</a></small></h1>

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
                <form url="update_branches_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                       <div class="row">
                            <div class="form-group">
                                <div class='col-md-12'>
                                    <label for="exampleInputEmail1">name</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>" required>
                                </div>
                                <div class='col-md-12'>
                                    <label for="exampleInputEmail1">short_code</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="short_code" value="<?php echo $res[0]['short_code']; ?>" required>
                                </div> 

                            </div>
                        </div>
                        
                    </div>
                  
                    <!-- /.box-body -->
                    <input type="hidden" name="id" value="<?php echo $res[0]['id']; ?>">
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnUpdate">Update</button>
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
    $('#add_url_form').validate({

        ignore: [],
        debug: false,
        rules: {
            url: "required",
        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>

<?php $db->disconnect(); ?>