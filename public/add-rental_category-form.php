<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
if (isset($_POST['btnAdd'])) {

        $brand = $db->escapeString(($_POST['brand']));
        $bike_name = $db->escapeString($_POST['bike_name']);
        $cc = $db->escapeString($_POST['cc']);
        $hills_price = $db->escapeString($_POST['hills_price']);
        $normal_price = $db->escapeString($_POST['normal_price']);
        
      
        
        if (empty($brand)) {
            $error['brand'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($bike_name)) {
            $error['bike_name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($cc)) {
            $error['cc'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($hills_price)) {
            $error['hills_price'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($normal_price)) {
            $error['normal_price'] = " <span class='label label-danger'>Required!</span>";
        }
       
       
       if (!empty($brand) && !empty($bike_name) && !empty($cc) && !empty($hills_price)&& !empty($normal_price)) {
           
            $sql_query = "INSERT INTO rental_category (brand,bike_name,cc,hills_price,normal_price)VALUES('$brand','$bike_name','$cc','$hills_price','$normal_price')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_rental_category'] = "<section class='content-header'>
                                                <span class='label label-success'>Rental Category Added Successfully</span> </section>";
            } else {
                $error['add_rental_category'] = " <span class='label label-danger'>Failed</span>";
            }
            }
        }
?>
<section class="content-header">
    <h1>Add Rental Category <small><a href='rental_categories.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Rental Category</a></small></h1>

    <?php echo isset($error['add_rental_category']) ? $error['add_rental_category'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="add_product" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                           <div class="row">
                                 <div class="col-md-4 form-group">
                                        <label for="exampleInputEmail1">Brand</label> <i class="text-danger asterik">*</i>
                                        <select id='brand' name="brand" class='form-control' required>
                                                <option value="none">Select</option>
                                                            <?php
                                                            $sql = "SELECT * FROM `models`";
                                                            $db->sql($sql);

                                                            $result = $db->getResult();
                                                            foreach ($result as $value) {
                                                            ?>
                                                                <option value='<?= $value['model'] ?>'><?= $value['model'] ?></option>
                                                            <?php } ?>
                                        </select>
                                </div>
                                <div class="col-md-4 form-group">
                                        <label for="exampleInputEmail1">Bike Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['bike_name']) ? $error['bike_name'] : ''; ?>
                                        <input type="text" class="form-control" name="bike_name" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                            <label for="exampleInputEmail1">CC</label> <i class="text-danger asterik">*</i><?php echo isset($error['cc']) ? $error['cc'] : ''; ?>
                                            <input type="number" class="form-control"  name="cc" required>
                                    </div>
                                    <div class="col-md-4">
                                            <label for="exampleInputEmail1">Hills Price</label> <i class="text-danger asterik">*</i><?php echo isset($error['hills_price']) ? $error['hills_price'] : ''; ?>
                                            <input type="number" class="form-control"  name="hills_price" required>
                                    </div>
                                    <div class="col-md-4">
                                            <label for="exampleInputEmail1">Normal Price</label> <i class="text-danger asterik">*</i><?php echo isset($error['normal_price']) ? $error['normal_price'] : ''; ?>
                                            <input type="number" class="form-control"  name="normal_price" required>
                                    </div>

                                 </div>
                            </div>
                            <hr>
                  
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
                        <input type="reset" onClick="refreshPage()" class="btn-warning btn" value="Clear" />
                    </div>

                </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_product').validate({

        ignore: [],
        debug: false,
        rules: {
            brand: "required",
            bike_name: "required",
            hills_price: "required",
            normal_price: "required",
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