<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
if (isset($_POST['btnAdd'])) {


        $pincode = $db->escapeString($fn->xss_clean($_POST['pincode']));
      

        if (empty($pincode)) {
            $error['pincode'] = " <span class='label label-danger'>Required!</span>";
        }
      

        if (!empty($pincode) ) {

            
           
            $sql_query = "INSERT INTO deliver_pincodes (pincode)VALUE('$pincode')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_pincode'] = " <section class='content-header'><span class='label label-success'>Pincode Added Successfully</span></section>";
            } else {
                $error['add_pincode'] = " <span class='label label-danger'>Failed To add pincode</span>";
            }
            }
        }
?>
<section class="content-header">
    <h1>Add Pincode<small><a href='pincodes.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Pincodes</a></small></h1>

    <?php echo isset($error['add_pincode']) ? $error['add_pincode'] : ''; ?>
   
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-4">
        <ol class="breadcrumb">
            <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
        </ol>
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Pincode</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form name="add_pincode" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Pincode</label><?php echo isset($error['pincode']) ? $error['pincode'] : ''; ?>
                            <input type="number" class="form-control" name="pincode" required>
                        </div>                  
                    </div>
                  
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
                        <input type="reset" class="btn-warning btn" value="Clear" />
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<script>
        $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>
<?php $db->disconnect(); ?>