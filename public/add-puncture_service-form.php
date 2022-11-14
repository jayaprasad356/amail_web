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

        $bike_id = $db->escapeString(($_POST['bike_id']));
        $front_tube_less = $db->escapeString($_POST['front_tube_less']);
        $front_tube_tyre = $db->escapeString($_POST['front_tube_tyre']);
        $rear_tube_less = $db->escapeString($_POST['rear_tube_less']);
        $rear_tube_tyre = $db->escapeString($_POST['rear_tube_tyre']);

        
        if (empty($bike_id)) {
            $error['bike_id'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($front_tube_less)) {
            $error['front_tube_less'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($front_tube_tyre)) {
            $error['front_tube_tyre'] = " <span class='label label-danger'>Required!</span>";
        } 
         if (empty($rear_tube_less)) {
            $error['rear_tube_less'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($rear_tube_tyre)) {
            $error['rear_tube_tyre'] = " <span class='label label-danger'>Required!</span>";
        }
       
       if (!empty($bike_id) && !empty($front_tube_less) && !empty($front_tube_tyre)&& !empty($rear_tube_less)&& !empty($rear_tube_tyre)) 
       {   
           
                $sql_query = "INSERT INTO puncture_services (bike_id,front_tube_less,front_tube_tyre,rear_tube_less,rear_tube_tyre,status)VALUES('$bike_id','$front_tube_less','$front_tube_tyre','$rear_tube_less','$rear_tube_tyre',1)";
                $db->sql($sql_query);
                $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_puncture_service'] = "<section class='content-header'>
                                                <span class='label label-success'>Puncture Service Added Successfully</span> </section>";
            } else {
                $error['add_puncture_service'] = " <span class='label label-danger'>Failed</span>";
            }
            }
        }
?>
<section class="content-header">
    <h1>Add Bike Puncture Service <small><a href='puncture_services.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Bike Puncture Services</a></small></h1>

    <?php echo isset($error['add_puncture_service']) ? $error['add_puncture_service'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-10">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="add_puncture_service_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for=""> Choose Bike</label> <i class="text-danger asterik">*</i>
                                    <select id='bike_id' name="bike_id" class='form-control' required>
                                        <option value="">-- Select --</option>
                                                <?php
                                                    $sql = "SELECT id,bike_name FROM `bikes`";
                                                    $db->sql($sql);
                                                    $result = $db->getResult();
                                                    foreach ($result as $value) {
                                                ?>
                                                    <option value='<?= $value['id'] ?>'><?= $value['bike_name'] ?></option>
                                            <?php } ?>
                                     </select>
                                </div>
                             </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Front Tubeless Price</label><i class="text-danger asterik">*</i><?php echo isset($error['front_tube_less']) ? $error['front_tube_less'] : ''; ?>
                                        <input type="number" class="form-control" name="front_tube_less" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Front Tube Price</label><i class="text-danger asterik">*</i><?php echo isset($error['front_tube_tyre']) ? $error['front_tube_tyre'] : ''; ?>
                                        <input type="number" class="form-control" name="front_tube_tyre" required>
                                    </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Rear Tubeless Price</label><i class="text-danger asterik">*</i><?php echo isset($error['rear_tube_less']) ? $error['rear_tube_less'] : ''; ?>
                                        <input type="number" class="form-control" name="rear_tube_less" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Rear Tube Price</label><i class="text-danger asterik">*</i><?php echo isset($error['rear_tube_tyre']) ? $error['rear_tube_tyre'] : ''; ?>
                                        <input type="number" class="form-control" name="rear_tube_tyre" required>
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
    $('#add_puncture_service_form').validate({

        ignore: [],
        debug: false,
        rules: {
            bike_id: "required",
            rear_tube_less: "required",
            rear_tube_tyre: "required",
            front_tube_less: "required",
            front_tube_tyre: "required",
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