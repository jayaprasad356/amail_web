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

        $bike_name = $db->escapeString(($_POST['bike_name']));
        $brand = $db->escapeString($_POST['brand']);
        $cc = $db->escapeString($_POST['cc']);
        
       
        if (empty($bike_name)) {
            $error['bike_name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($brand)) {
            $error['brand'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($cc)) {
            $error['cc'] = " <span class='label label-danger'>Required!</span>";
        }
      
       
       
       if ( !empty($bike_name) && !empty($brand) && !empty($cc)) {
           
            $sql_query = "INSERT INTO bikes (bike_name,brand,cc)VALUES('$bike_name','$brand','$cc')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                
                $error['add_bike'] = "<section class='content-header'>
                                                <span class='label label-success'>New Bike Added Successfully</span> </section>";
            } else {
                $error['add_bike'] = " <span class='label label-danger'>Failed</span>";
            }
            }
        }
?>
<section class="content-header">
    <h1>Add New Bike <small><a href='bikes.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to New Bikes</a></small></h1>
    <?php echo isset($error['add_bike']) ? $error['add_bike'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-8">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="add_bike_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                           <div class="row">
                                <div class="form-group">
                                   <div class="col-md-8">
                                            <label for="exampleInputEmail1">Bike Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['bike_name']) ? $error['bike_name'] : ''; ?>
                                            <input type="text" class="form-control" name="bike_name" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <label for="exampleInputEmail1">Brand</label> <i class="text-danger asterik">*</i><?php echo isset($error['brand']) ? $error['brand'] : ''; ?>
                                        <input type="text" class="form-control" name="brand" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-8">
                                            <label for="exampleInputEmail1">CC</label> <i class="text-danger asterik">*</i><?php echo isset($error['cc']) ? $error['cc'] : ''; ?>
                                            <input type="text" class="form-control" name="cc" required />
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
    $('#add_bike_form').validate({

        ignore: [],
        debug: false,
        rules: {
            bike_name: "required",
            brand: "required",
            cc: "required",
        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>
<?php $db->disconnect(); ?>