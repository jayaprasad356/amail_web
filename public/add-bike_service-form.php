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
        $type = $db->escapeString($_POST['type']);
        $price = (isset($_POST['price']) && !empty($_POST['price'])) ? trim($db->escapeString($fn->xss_clean($_POST['price']))) : "";
    
        
        if (empty($bike_id)) {
            $error['bike_id'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($type)) {
            $error['type'] = " <span class='label label-danger'>Required!</span>";
        }
       
       if (!empty($bike_id) && !empty($type)) 
       {   
            if($type=='General'){
                $sql_query = "INSERT INTO bike_services (bike_id,type,price,status)VALUES('$bike_id','$type','$price',1)";
                $db->sql($sql_query);
            }
            elseif($type=='Emergency'){
                $sql_query = "INSERT INTO bike_services (bike_id,type,status)VALUES('$bike_id','$type',1)";
                $db->sql($sql_query);
            }
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_bike_service'] = "<section class='content-header'>
                                                <span class='label label-success'>Bike Service Added Successfully</span> </section>";
            } else {
                $error['add_bike_service'] = " <span class='label label-danger'>Failed</span>";
            }
            }
        }
?>
<section class="content-header">
    <h1>Add New Service <small><a href='bike_services.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Bike Services</a></small></h1>

    <?php echo isset($error['add_bike_service']) ? $error['add_bike_service'] : ''; ?>
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
                <form name="add_bike_service_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
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
                        <div class="form-group">
                            <label for="type">Type</label> <i class="text-danger asterik">*</i>
                                <select  name="type" id="type" class="form-control" required>
                                     <option value="none">-- Select Type --</option>
                                    <option value="General">General</option>
                                    <option value="Emergency">Emergency</option>
                                </select>   
                        </div>   
                        <div class="form-group" id="price" style="display: none">
                                        <label for="exampleInputEmail1">Price</label><?php echo isset($error['price']) ? $error['price'] : ''; ?>
                                        <input type="text" class="form-control" name="price" >
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
    $('#add_bike_service_form').validate({

        ignore: [],
        debug: false,
        rules: {
            bike_id: "required",
            type: "required",
        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>
<script>

$("#type").change(function() {
        type = $("#type").val();
        if(type == "none"){
            $("#price").hide();
        }
        if(type == "General"){
            $("#price").show();

        }
        if(type == "Emergency"){
            $("#price").hide();
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