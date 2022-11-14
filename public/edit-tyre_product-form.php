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

if (isset($_POST['btnEdit'])) {

	      $error = array();
		  $brand = $db->escapeString(($_POST['brand']));
		  $size = $db->escapeString($_POST['size']);
		  $wheel = $db->escapeString($_POST['wheel']);
		  $pattern = $db->escapeString($_POST['pattern']);
		  $tyre_type = $db->escapeString($_POST['tyre_type']);
		  $amount = $db->escapeString($_POST['amount']);
		  $delivery_charges = $db->escapeString($_POST['delivery_charges']);
		  $fitting_charges = $db->escapeString($_POST['fitting_charges']);
		  $actual_price = $db->escapeString($_POST['actual_price']);
		  $final_price = $db->escapeString($_POST['final_price']);
		  $status = $db->escapeString($_POST['status']);

		  if (!empty($brand) && !empty($size) && !empty($wheel)&& !empty($pattern)&& !empty($tyre_type)&&!empty($amount) && !empty($delivery_charges) && !empty($fitting_charges)&& !empty($actual_price)&& !empty($final_price)) 
       {   
				$sql_query = "UPDATE tyre_products SET brand='$brand',size='$size',wheel='$wheel',pattern='$pattern',tyre_type='$tyre_type',amount='$amount',delivery_charges='$delivery_charges',fitting_charges='$fitting_charges',actual_price='$actual_price',final_price='$final_price',status='$status' WHERE id=$ID";
				$db->sql($sql_query);
				$update_result = $db->getResult();
				if (!empty($update_result)) {
					$update_result = 0;
				} else {
					$update_result = 1;
				}

				// check update result
				if ($update_result == 1) {
					
					$error['update_tyre_product'] = " <section class='content-header'><span class='label label-success'>Tyre Product updated Successfully</span></section>";
				} else {
					$error['update_tyre_product'] = " <span class='label label-danger'>Failed to update</span>";
				}
			}
	} 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM tyre_products WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();


if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "tyre_products.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Tyre Product<small><a href='tyre_products.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Tyre Product</a></small></h1>
	<small><?php echo isset($error['update_tyre_product']) ? $error['update_tyre_product'] : ''; ?></small>
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
				<form id="edit_tyre_product_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
					<div class="row">
                            <div class="form-group">
                                   <div class="col-md-4">
                                        <label for="exampleInputEmail1">Brand</label><i class="text-danger asterik">*</i><?php echo isset($error['brand']) ? $error['brand'] : ''; ?>
                                        <input type="text" class="form-control" name="brand" value="<?php echo $res[0]['brand']; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Size</label><i class="text-danger asterik">*</i><?php echo isset($error['size']) ? $error['size'] : ''; ?>
                                        <input type="number" class="form-control" name="size" value="<?php echo $res[0]['size']; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Wheel Type</label><i class="text-danger asterik">*</i><?php echo isset($error['wheel']) ? $error['wheel'] : ''; ?>
                                        <select  name="wheel" id="wheel" class="form-control">
												<option value="Front tyre"<?=$res[0]['wheel'] == 'Front tyre' ? ' selected="selected"' : '';?>>Front tyre</option>
												<option value="Rear tyre"<?=$res[0]['wheel'] == 'Rear tyre' ? ' selected="selected"' : '';?>>Rear tyre</option>
                                        </select>   
                                    </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                   <div class="col-md-4">
                                        <label for="exampleInputEmail1">Pattern</label><i class="text-danger asterik">*</i><?php echo isset($error['pattern']) ? $error['pattern'] : ''; ?>
                                        <input type="text" class="form-control" name="pattern" value="<?php echo $res[0]['pattern']; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Tyre Type</label><i class="text-danger asterik">*</i><?php echo isset($error['tyre_type']) ? $error['tyre_type'] : ''; ?>
                                        <select  name="tyre_type" id="tyre_type" class="form-control" required>
												<option value="Tube"<?=$res[0]['tyre_type'] == 'Tube' ? ' selected="selected"' : '';?>>Tube</option>
												<option value="Tubeless"<?=$res[0]['tyre_type'] == 'Tubeless' ? ' selected="selected"' : '';?>>Tubeless</option>
                                        </select>   
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Amount</label><i class="text-danger asterik">*</i><?php echo isset($error['amount']) ? $error['amount'] : ''; ?>
                                        <input type="number" class="form-control" name="amount" value="<?php echo $res[0]['amount']; ?>">
                                    </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                     <div class="col-md-4">
                                        <label for="exampleInputEmail1">Delivery Charges</label><i class="text-danger asterik">*</i><?php echo isset($error['delivery_charges']) ? $error['delivery_charges'] : ''; ?>
                                        <input type="number" class="form-control" name="delivery_charges" value="<?php echo $res[0]['delivery_charges']; ?>">
                                    </div> 
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Fitting Charges</label><i class="text-danger asterik">*</i><?php echo isset($error['fitting_charges']) ? $error['fitting_charges'] : ''; ?>
                                        <input type="number" class="form-control" name="fitting_charges" value="<?php echo $res[0]['fitting_charges']; ?>">
                                    </div>
									<div class="col-md-4">
                                        <label for="exampleInputEmail1">Actual Price</label><i class="text-danger asterik">*</i><?php echo isset($error['actual_price']) ? $error['actual_price'] : ''; ?>
                                        <input type="number" class="form-control" name="actual_price" value="<?php echo $res[0]['actual_price']; ?>">
                                    </div> 
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Final Price</label><i class="text-danger asterik">*</i><?php echo isset($error['final_price']) ? $error['final_price'] : ''; ?>
                                        <input type="number" class="form-control" name="final_price" value="<?php echo $res[0]['final_price']; ?>">
                                    </div>
									<div class='col-md-4'>
                                        <label class="control-label">Stock</label> <i class="text-danger asterik">*</i>
                                        <div id="status" class="form-group">
                                            <label class="btn btn-danger" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="status" value="0" <?= ($res[0]['status'] == 0) ? 'checked' : ''; ?>> Not-Available
                                            </label>
                                            <label class="btn btn-success" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="status" value="1" <?= ($res[0]['status'] == 1) ? 'checked' : ''; ?>> Available
                                            </label>
                                        </div>
						            </div>
                            </div>
                        </div>

					</div>
					<!-- /.box-body -->
                       
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

