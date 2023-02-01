<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$sql = "SELECT id, name FROM categories ORDER BY id ASC";
$db->sql($sql);
$res = $db->getResult();

?>
<?php
if (isset($_POST['btnAdd'])) {

        $url = $db->escapeString(($_POST['url']));
        $error = array();
       
        if (empty($url)) {
            $error['url'] = " <span class='label label-danger'>Required!</span>";
        }
    
       
        if (!empty($url)) {
            $check_query = "SELECT * FROM valid_urls WHERE url = '$url'";
            $db->sql($check_query);
            $check_result = $db->getResult();
            if (empty($check_result)) {
                $sql_query = "INSERT INTO valid_urls (url)VALUES('$url')";
                $db->sql($sql_query);
                $result = $db->getResult();
                if (!empty($result)) {
                    $result = 0;
                } else {
                    $result = 1;
                }
                if ($result == 1) {
                    $error['add_url'] = "<section class='content-header'>
                                                    <span class='label label-success'> Valid URL Added Successfully</span> </section>";
                } else {
                    $error['add_url'] = " <span class='label label-danger'>Failed</span>";
                }
            } else {
                $error['add_url'] = " <span class='label label-danger'>URL already exists</span>";
            }
        }
    }        
?>
<section class="content-header">
    <h1>Add New Valid URL <small><a href='valid_urls.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Valid URLs</a></small></h1>

    <?php echo isset($error['add_url']) ? $error['add_url'] : ''; ?>
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
                <form url="add_url_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                       <div class="row">
                            <div class="form-group">
                                <div class='col-md-12'>
                                    <label for="exampleInputEmail1">Valid URL</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="url" required>
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