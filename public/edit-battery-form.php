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
		  $warranty = $db->escapeString($_POST['warranty']);
		  $amount = $db->escapeString($_POST['amount']);
		  $delivery_charges = $db->escapeString($_POST['delivery_charges']);
		  $fitting_charges = $db->escapeString($_POST['fitting_charges']);
		  $actual_price = $db->escapeString($_POST['actual_price']);
		  $final_price = $db->escapeString($_POST['final_price']);
		  $status = $db->escapeString($_POST['status']);

		  if (!empty($brand) && !empty($warranty) &&!empty($amount) && !empty($delivery_charges) && !empty($fitting_charges)&& !empty($actual_price)&& !empty($final_price)) 
       {   
				$sql_query = "UPDATE batteries SET brand='$brand',warranty='$warranty',amount='$amount',delivery_charges='$delivery_charges',fitting_charges='$fitting_charges',actual_price='$actual_price',final_price='$final_price',status='$status' WHERE id=$ID";
				$db->sql($sql_query);
				$update_result = $db->getResult();
				if (!empty($update_result)) {
					$update_result = 0;
				} else {
					$update_result = 1;
				}

				// check update result
				if ($update_result == 1) {
					
					$error['update_battery'] = " <section class='content-header'><span class='label label-success'>Battery Details updated Successfully</span></section>";
				} else {
					$error['update_battery'] = " <span class='label label-danger'>Failed to update</span>";
				}
			}
	} 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM batteries WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();


if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "batteries.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Battery<small><a href='batteries.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Batteries</a></small></h1>
	<small><?php echo isset($error['update_battery']) ? $error['update_battery'] : ''; ?></small>
	<ol class="breadcrumb">
		<li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
	</ol>
</section>
<section class="content">
	<!-- Main row -->

	<div class="row">
		<div class="col-md-8">
		
			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
				</div><!-- /.box-header -->
				<!-- form start -->
				<form id="edit_battery_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
					<div class="row">
                            <div class="form-group">
                                   <div class="col-md-6">
                                        <label for="exampleInputEmail1">Brand</label><i class="text-danger asterik">*</i><?php echo isset($error['brand']) ? $error['brand'] : ''; ?>
                                        <input type="text" class="form-control" name="brand" value="<?php echo $res[0]['brand']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">warranty</label><i class="text-danger asterik">*</i><?php echo isset($error['warranty']) ? $error['warranty'] : ''; ?>
                                        <input type="number" class="form-control" name="warranty" value="<?php echo $res[0]['warranty']; ?>">
                                    </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Amount</label><i class="text-danger asterik">*</i><?php echo isset($error['amount']) ? $error['amount'] : ''; ?>
                                        <input type="number" class="form-control" name="amount" value="<?php echo $res[0]['amount']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Delivery Charges</label><i class="text-danger asterik">*</i><?php echo isset($error['delivery_charges']) ? $error['delivery_charges'] : ''; ?>
                                        <input type="number" class="form-control" name="delivery_charges" value="<?php echo $res[0]['delivery_charges']; ?>">
                                    </div> 
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Fitting Charges</label><i class="text-danger asterik">*</i><?php echo isset($error['fitting_charges']) ? $error['fitting_charges'] : ''; ?>
                                        <input type="number" class="form-control" name="fitting_charges" value="<?php echo $res[0]['fitting_charges']; ?>">
                                    </div>
									<div class="col-md-6">
                                        <label for="exampleInputEmail1">Actual Price</label><i class="text-danger asterik">*</i><?php echo isset($error['actual_price']) ? $error['actual_price'] : ''; ?>
                                        <input type="number" class="form-control" name="actual_price" value="<?php echo $res[0]['actual_price']; ?>">
                                    </div> 
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Final Price</label><i class="text-danger asterik">*</i><?php echo isset($error['final_price']) ? $error['final_price'] : ''; ?>
                                        <input type="number" class="form-control" name="final_price" value="<?php echo $res[0]['final_price']; ?>">
                                    </div>
									<div class='col-md-6'>
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

