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
   
   
   if (!empty($brand) && !empty($bike_name) && !empty($cc) && !empty($hills_price)&& !empty($normal_price))
    {
             $sql_query = "UPDATE rental_category SET brand='$brand',bike_name='$bike_name',cc='$cc',hills_price='$hills_price',normal_price='$normal_price' WHERE id =  $ID";
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
                  	$error['update_rental_category'] = " <section class='content-header'><span class='label label-success'>Rental Category updated Successfully</span></section>";
			} else {
				$error['update_rental_category'] = " <span class='label label-danger'>Failed to update</span>";
			}
		}
	} 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM rental_category WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "rental_categories.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Rental Category<small><a href='rental_categories.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Rental Category</a></small></h1>
	<small><?php echo isset($error['update_rental_category']) ? $error['update_rental_category'] : ''; ?></small>
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
				</div><!-- /.box-header -->
				<!-- form start -->
				<form id="edit_product_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
						   <div class="row">
							    <div class="form-group">
								           <div class="col-md-4">
												<label for="exampleInputEmail1">Brand</label> <i class="text-danger asterik">*</i>
												<select id='brand' name="brand" class='form-control' required>
                                                <option value="none">Select</option>
                                                            <?php
                                                            $sql = "SELECT * FROM `models`";
                                                            $db->sql($sql);
                                                            $result = $db->getResult();
                                                            foreach ($result as $value) {
                                                            ?>
															 <option value='<?= $value['model'] ?>' <?=$value['model'] == $res[0]['brand'] ? ' selected="selected"' : '';?>><?= $value['model'] ?></option>
                                                               
                                                            <?php } ?>
                                                </select>
											</div>
									
											<div class="col-md-4">
												<label for="exampleInputEmail1">Bike Name</label><?php echo isset($error['bike_name']) ? $error['bike_name'] : ''; ?>
												<input type="text" class="form-control" name="bike_name" value="<?php echo $res[0]['bike_name']; ?>">
											</div>
								</div>
						   </div>
						   <hr>
						   <div class="row">
							    <div class="form-group">
									 <div class="col-md-4">
										<label for="exampleInputEmail1">CC</label><?php echo isset($error['cc']) ? $error['cc'] : ''; ?>
										<input type="number" class="form-control" name="cc" value="<?php echo $res[0]['cc']; ?>">
									 </div>
									 <div class="col-md-4">
										<label for="exampleInputEmail1">Hills Price</label><?php echo isset($error['hills_price']) ? $error['hills_price'] : ''; ?>
										<input type="number" class="form-control" name="hills_price" value="<?php echo $res[0]['hills_price']; ?>">
									 </div>
									 <div class="col-md-4">
										<label for="exampleInputEmail1">Normal Price</label><?php echo isset($error['normal_price']) ? $error['normal_price'] : ''; ?>
										<input type="number" class="form-control" name="normal_price" value="<?php echo $res[0]['normal_price']; ?>">
									 </div>
								</div>
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
