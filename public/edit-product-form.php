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
$sql = "SELECT * FROM `models`";
$db->sql($sql);
$model_res = $db->getResult();
if (isset($_POST['btnEdit'])) {

	    $category = $db->escapeString(($_POST['category']));
	    $product_name = $db->escapeString($_POST['product_name']);
        $brand = $db->escapeString($_POST['brand']);
        $description = $db->escapeString($_POST['description']);
		$error = array();

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

		

		if ( !empty($category) && !empty($product_name) && !empty($brand) && !empty($description)) 
		{
			if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0 && !empty($_FILES['image'])) {
				//image isn't empty and update the image
				$old_image = $db->escapeString($_POST['old_image']);
				$extension = pathinfo($_FILES["image"]["name"])['extension'];
		
				$result = $fn->validate_image($_FILES["image"]);
				$target_path = 'upload/products/';
				
				$filename = microtime(true) . '.' . strtolower($extension);
				$full_path = $target_path . "" . $filename;
				if (!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)) {
					echo '<p class="alert alert-danger">Can not upload image.</p>';
					return false;
					exit();
				}
				if (!empty($old_image)) {
					unlink($old_image);
				}
				$upload_image = 'upload/products/' . $filename;
				$sql = "UPDATE products SET `image`='" . $upload_image . "' WHERE `id`=" . $ID;
				$db->sql($sql);
			}
			
             $sql_query = "UPDATE products SET category_id='$category',product_name='$product_name',brand='$brand',description='$description' WHERE id =  $ID";
			 $db->sql($sql_query);
			 $res = $db->getResult();
             $update_result = $db->getResult();
			if (!empty($update_result)) {
				$update_result = 0;
			} else {
				$update_result = 1;
			}

			// check update result
			if ($update_result == 1) {
				for ($i = 0; $i < count($_POST['model']); $i++) {
					$product_id = $db->escapeString(($_POST['product_variant_id'][$i]));
					$model = $db->escapeString(($_POST['model'][$i]));
					$price = $db->escapeString(($_POST['price'][$i]));
					$sql = "UPDATE product_variant SET model='$model',price='$price' WHERE id = $product_id";
					$db->sql($sql);

				}
				if (
					isset($_POST['insert_model']) && isset($_POST['insert_price'])
				) {
					for ($i = 0; $i < count($_POST['insert_model']); $i++) {
						$model = $db->escapeString(($_POST['insert_model'][$i]));
						$price = $db->escapeString(($_POST['insert_price'][$i]));
						$sql = "INSERT INTO product_variant (product_id,model,price) VALUES('$ID','$model','$price')";
						$db->sql($sql);

					}

				}

			$error['update_product'] = " <section class='content-header'><span class='label label-success'>Product updated Successfully</span></section>";
			} else {
				$error['update_product'] = " <span class='label label-danger'>Failed to update</span>";
			}
		}
	} 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM products WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

$sql_query = "SELECT * FROM product_variant WHERE product_id =" . $ID;
$db->sql($sql_query);
$resslot = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "products.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Product<small><a href='products.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Products</a></small></h1>
	<small><?php echo isset($error['update_product']) ? $error['update_product'] : ''; ?></small>
	<ol class="breadcrumb">
		<li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
	</ol>
</section>
<section class="content">
	<!-- Main row -->

	<div class="row">
		<div class="col-md-12">
		
			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Product</h3>
				</div><!-- /.box-header -->
				<!-- form start -->
				<form id="edit_product_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
					    <input type="hidden" id="old_image" name="old_image"  value="<?= $res[0]['image']; ?>">
						   <div class="row">
							    <div class="form-group">
									<div class='col-md-4'>
									          <label for="exampleInputEmail1">Model</label> <i class="text-danger asterik">*</i>
												<select id='category' name="category" class='form-control' required>
                                                <option value="none">Select</option>
                                                            <?php
                                                            $sql = "SELECT * FROM `categories`";
                                                            $db->sql($sql);

                                                            $result = $db->getResult();
                                                            foreach ($result as $value) {
                                                            ?>
															 <option value='<?= $value['id'] ?>' <?= $value['id']==$res[0]['category_id'] ? 'selected="selected"' : '';?>><?= $value['name'] ?></option>
                                                               
                                                            <?php } ?>
                                                </select>
									</div>
									 <div class="col-md-4">
										<label for="exampleInputEmail1">Product Name</label><?php echo isset($error['product_name']) ? $error['product_name'] : ''; ?>
										<input type="text" class="form-control" name="product_name" value="<?php echo $res[0]['product_name']; ?>">
									 </div>
									 <div class="col-md-4">
										<label for="exampleInputEmail1">Brand</label><?php echo isset($error['brand']) ? $error['brand'] : ''; ?>
										<input type="text" class="form-control" name="brand" value="<?php echo $res[0]['brand']; ?>">
									 </div>
								</div>
						   </div>
						   <hr>
						   <div class="row">
							    <div class="form-group">
									 <div class="col-md-4">
										<label for="exampleInputEmail1">Description</label><?php echo isset($error['description']) ? $error['description'] : ''; ?>
										<input type="text" class="form-control" name="description" value="<?php echo $res[0]['description']; ?>">
									 </div>
									 <div class="col-md-4">
									     <label for="exampleInputFile">Image</label>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image" id="image">
                                        <p class="help-block"><img id="blah" src="<?php echo $res[0]['image']; ?>" style="max-width:100%" /></p>
									 </div>
								</div>
						   </div>
						   <hr>
						   
						 <div id="variations">
							<?php
							$i=0;
							foreach ($resslot as $row) {
								?>
								<div id="packate_div">
									<div class="row">
									<input type="hidden" class="form-control" name="product_variant_id[]" id="product_variant_id" value='<?= $row['id']; ?>' />


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
															 <option value='<?= $value['model'] ?>' <?=$row['model'] == $value['model'] ? ' selected="selected"' : '';?>><?= $value['model'] ?></option>
                                                               
                                                            <?php } ?>
                                                </select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group packate_div">
												<label for="exampleInputEmail1"> Price</label> <i class="text-danger asterik">*</i>
												<input type="text" class="form-control" name="price[]" value="<?php echo $row['price'] ?>" required />
											</div>
										</div>

										<?php if ($i == 0) { ?>
												<div class='col-md-1'>
													<label>Variation</label>
													<a id="add_packate_variation" title='Add variation of product' style='cursor: pointer;'><i class="fa fa-plus-square-o fa-2x"></i></a>
												</div>
											<?php } else { ?>
												<div class="col-md-1" style="display: grid;">
													<label>Remove</label>
													<a class="remove_variation text-danger" data-id="data_delete" title="Remove variation of product" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a>
												</div>
											<?php } ?>
									</div>
									<?php $i++; } ?> 
								</div>
								

							<hr>
					
					
					
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var max_fields = 7;
        var wrapper = $("#packate_div");
        var add_button = $("#add_packate_variation");

        var x = 1;
        $(add_button).click(function (e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
				$(wrapper).append('<div class="row"><div class="col-md-3"><div class="form-group"><label for="model">Model</label>' + '<select id=model name="insert_model[]" class=form-control required><option value="none">Select</option>'+
																'<?php
																foreach ($model_res as  $row) {
																	echo "<option value=" . $row['model'] . ">" . $row['model'] . "</option>";
																}
																?>' 
															+'</select></div></div>'+'<div class="col-md-3"><div class="form-group"><label for="price">Price</label>'+'<input type="text" class="form-control" name="insert_price[]" required /></div></div>'+'<div class="col-md-1" style="display: grid;"><label>Variation</label><a class="remove text-danger" style="cursor:pointer;"><i class="fa fa-times fa-2x"></i></a></div>'+'</div>');
            } else {
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
<script>
    $(document).on('click', '.remove_variation', function() {
        if ($(this).data('id') == 'data_delete') {
            if (confirm('Are you sure? Want to delete this row')) {
                var id = $(this).closest('div.row').find("input[id='product_variant_id']").val();
                $.ajax({
                    url: 'public/db-operation.php',
                    type: "post",
                    data: 'id=' + id + '&delete_variant=1',
                    success: function(result) {
                        if (result) {
                            location.reload();
                        } else {
                            alert("Variant not deleted!");
                        }
                    }
                });
            }
        } else {
            $(this).closest('.row').remove();
        }
    });
</script>

