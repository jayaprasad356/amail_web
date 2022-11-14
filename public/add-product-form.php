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

        $category = $db->escapeString(($_POST['category']));
        $product_name = $db->escapeString($_POST['product_name']);
        $brand = $db->escapeString($_POST['brand']);
        $description = $db->escapeString($_POST['description']);
        
        // get image info
        $menu_image = $db->escapeString($_FILES['product_image']['name']);
        $image_error = $db->escapeString($_FILES['product_image']['error']);
        $image_type = $db->escapeString($_FILES['product_image']['type']);

        // create array variable to handle error
        $error = array();
            // common image file extensions
        $allowedExts = array("gif", "jpeg", "jpg", "png");

        // get image file extension
        error_reporting(E_ERROR | E_PARSE);
        $extension = end(explode(".", $_FILES["product_image"]["name"]));
        
        if (empty($category)) {
            $error['category'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($product_name)) {
            $error['product_name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($brand)) {
            $error['brand'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($description)) {
            $error['description'] = " <span class='label label-danger'>Required!</span>";
        }
       
       
       if (!empty($category) && !empty($product_name) && !empty($brand) && !empty($description)) {
            $result = $fn->validate_image($_FILES["product_image"]);
                // create random image file name
                $string = '0123456789';
                $file = preg_replace("/\s+/", "_", $_FILES['product_image']['name']);
                $menu_image = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;
        
                // upload new image
                $upload = move_uploaded_file($_FILES['product_image']['tmp_name'], 'upload/products/' . $menu_image);
        
                // insert new data to menu table
                $upload_image = 'upload/products/' . $menu_image;

            
           
            $sql_query = "INSERT INTO products (category_id,product_name,brand,description,image)VALUES('$category','$product_name','$brand','$description','$upload_image')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $sql = "SELECT id FROM products ORDER BY id DESC LIMIT 1";
                $db->sql($sql);
                $res = $db->getResult();
                $product_id = $res[0]['id'];
                for ($i = 0; $i < count($_POST['model']); $i++) {
    
                    $model = $db->escapeString(($_POST['model'][$i]));
                    $price = $db->escapeString(($_POST['price'][$i]));
                    $sql = "INSERT INTO product_variant (product_id,model,price) VALUES('$product_id','$model','$price')";
                    $db->sql($sql);
                    $product_variant_result = $db->getResult();
                }
                if (!empty($product_variant_result)) {
                    $product_variant_result = 0;
                } else {
                    $product_variant_result = 1;
                }
                
                $error['add_product'] = "<section class='content-header'>
                                                <span class='label label-success'>Product Added Successfully</span> </section>";
            } else {
                $error['add_product'] = " <span class='label label-danger'>Failed</span>";
            }
            }
        }
?>
<section class="content-header">
    <h1>Add Product <small><a href='products.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Products</a></small></h1>

    <?php echo isset($error['add_product']) ? $error['add_product'] : ''; ?>
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
                    <h3 class="box-title">Add Product</h3>

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="add_product" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                           <div class="row">
                                <div class="form-group">
                                <div class="col-md-4">
                                            <label for="exampleInputEmail1">Product Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['product_name']) ? $error['product_name'] : ''; ?>
                                            <input type="text" class="form-control" name="product_name" required>
                                    </div>
                                    <div class='col-md-4'>
                                        <label for="">Category</label> <i class="text-danger asterik">*</i>
                                        <select id='category' name="category" class='form-control' required>
                                        <option value="">Select</option>
                                                <?php
                                                $sql = "SELECT * FROM `categories`WHERE status=1";
                                                $db->sql($sql);
                                                $result = $db->getResult();
                                                foreach ($result as $value) {
                                                ?>
                                                    <option value='<?= $value['id'] ?>'><?= $value['name'] ?></option>
                                            <?php } ?>
                                            </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Brand</label> <i class="text-danger asterik">*</i><?php echo isset($error['brand']) ? $error['brand'] : ''; ?>
                                        <input type="text" class="form-control" name="brand" required />
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                            <label for="exampleInputEmail1">Description</label> <i class="text-danger asterik">*</i><?php echo isset($error['description']) ? $error['description'] : ''; ?>
                                            <textarea type="text" class="form-control" rows="5" name="description" required></textarea>
                                    </div>
                                    <div class="col-md-4">
                                         <label for="exampleInputFile">Image</label> <i class="text-danger asterik">*</i><?php echo isset($error['product_image']) ? $error['product_image'] : ''; ?>
                                        <input type="file" name="product_image" onchange="readURL(this);" accept="image/png,  image/jpeg" id="product_image" required/>
                                        <img id="blah" src="#" alt="" />
                                    </div>

                                 </div>
                            </div>
                            <hr>
                            <div id="packate_div"  >
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">Model</label> <i class="text-danger asterik">*</i>
                                        <select id='model' name="model[]" class='form-control' required>
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
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">Price</label> <i class="text-danger asterik">*</i>
                                        <input type="text" class="form-control" name="price[]" required />
                                    </div>
                                </div>
                               
                                <div class="col-md-1">
                                    <label>Variation</label>
                                    <a class="add_packate_variation" title="Add variation of product" style="cursor: pointer;"><i class="fa fa-plus-square-o fa-2x"></i></a>
                                </div>
                                <div id="variations">
                                </div>
                            </div>
                        <hr>

         
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
    $('#add_product').validate({

        ignore: [],
        debug: false,
        rules: {
            product_name: "required",
            brand: "required",
            category_image: "required",
        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>
<script>
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var max_fields = 8;
        var wrapper = $("#packate_div");
        var add_button = $(".add_packate_variation");

        var x = 1;
        $(add_button).click(function (e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append('<div class="row"><div class="col-md-3"><div class="form-group"><label for="model">Model</label>' + '<select id=model name="model[]" class=form-control required><option value="none">Select</option><?php
                                                            $sql = "SELECT * FROM `models`";
                                                            $db->sql($sql);
                                                            $result = $db->getResult();
                                                            foreach ($result as $value) {
                                                            ?><option value="<?= $value['model'] ?>"><?= $value['model'] ?></option><?php } ?></select></div></div>'+'<div class="col-md-3"><div class="form-group"><label for="price">Price</label>'+'<input type="text" class="form-control" name="price[]" required /></div></div>'+'<div class="col-md-1" style="display: grid;"><label>Variation</label><a class="remove text-danger" style="cursor:pointer;"><i class="fa fa-times fa-2x"></i></a></div>'+'</div>');
            }
            else{
                alert('You Reached the limits')
            }
        });

        $(wrapper).on("click", ".remove", function (e) {
            e.preventDefault();
            $(this).closest('.row').remove();
            x--;
        })
    });
</script>

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>

<?php $db->disconnect(); ?>