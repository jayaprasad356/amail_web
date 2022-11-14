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
$sql = "SELECT * FROM showrooms WHERE id = '$ID'";
$db->sql($sql);
$res = $db->getResult();
if (isset($_POST['btnEdit'])) {

	    $showroom_name = $db->escapeString(($_POST['showroom_name']));
		$mobile = $db->escapeString(($_POST['mobile']));
		$password = $db->escapeString(($_POST['password']));
		$alternate_mobile = $db->escapeString(($_POST['alternate_mobile']));
		$brand= $db->escapeString(($_POST['brand']));
		$working_hours = $db->escapeString(($_POST['working_hours']));
		$address = $db->escapeString(($_POST['address']));
		$pincode = $db->escapeString(($_POST['pincode']));
		$gst_tin= $db->escapeString(($_POST['gst_tin']));
		$account_no = $db->escapeString(($_POST['account_no']));
		$ifsc_code = $db->escapeString(($_POST['ifsc_code']));
		$status = $db->escapeString(($_POST['status']));

		$error = array();

		if (empty($showroom_name)) {
			$error['showroom_name'] = "Showroom Name is required";
		}
		if (empty($mobile)) {
			$error['mobile'] = "Mobile is required";
		}
		if (empty($password)) {
			$error['password'] = "Password is required";
		}
		if (empty($alternate_mobile)) {
			$error['alternate_mobile'] = "Alternate Mobile is required";
		}
		if (empty($brand)) {
			$error['brand'] = "Brand is required";
		}
		if (empty($working_hours)) {
			$error['working_hours'] = "Working Hours is required";
		}
		if (empty($address)) {
			$error['address'] = "Address is required";
		}
		if (empty($pincode)) {
			$error['pincode'] = "Pincode is required";
		}
		if (empty($gst_tin)) {
			$error['gst_tin'] = "GST Tin is required";
		}
		if (empty($account_no)) {
			$error['account_no'] = "Account No is required";
		}
		if (empty($ifsc_code)) {
			$error['ifsc_code'] = "IFSC Code is required";
		}
		

	    if(!empty($showroom_name)&& !empty($mobile)&& !empty($password)&& !empty($alternate_mobile)&& !empty($brand)&& !empty($working_hours)&& !empty($address)&& !empty($pincode)&& !empty($gst_tin)&& !empty($account_no)&& !empty($ifsc_code))
		{
             $sql_query = "UPDATE showroom SET showroom_name = '$showroom_name', mobile = '$mobile', password = '$password', alternate_mobile = '$alternate_mobile', brand = '$brand', working_hours = '$working_hours', address = '$address', pincode = '$pincode', gst_tin = '$gst_tin', account_no = '$account_no', ifsc_code = '$ifsc_code',status='$status' WHERE id = '$ID'";
			 $db->sql($sql_query);
			 $res = $db->getResult();
             $update_showroom = $db->getResult();
			if (!empty($update_showroom)) {
				$update_showroom = 0;
			} else {
				$update_showroom = 1;
			}

			// check update result
			if ($update_showroom == 1) {
				$error['update_showroom'] = " <section class='content-header'><span class='label label-success'>Showroom Details updated Successfully</span></section>";
			} else {
				$error['update_showroom'] = " <span class='label label-danger'>Failed to update</span>";
			}
		}
	} 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM showroom WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "showrooms.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Showroom<small><a href='showrooms.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Showrooms</a></small></h1>
	<small><?php echo isset($error['update_showroom']) ? $error['update_showroom'] : ''; ?></small>
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
					<h3 class="box-title">Edit Showroom</h3>
				</div><!-- /.box-header -->
				<!-- form start -->
				<form id="edit_showroom_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
						   <div class="row">
							    <div class="form-group">
									<div class='col-md-3'>
									    <label for="exampleInputEmail1">Showroom Name</label><?php echo isset($error['showroom_name']) ? $error['showroom_name'] : ''; ?>
										<input type="text" class="form-control" name="showroom_name" value="<?php echo $res[0]['showroom_name']; ?>">
									          
									</div>
									 <div class="col-md-3">
										<label for="exampleInputEmail1">Mobile Number</label><?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
										<input type="text" class="form-control" name="mobile" value="<?php echo $res[0]['mobile']; ?>">
									 </div>
									 <div class="col-md-3">
										<label for="exampleInputEmail1">Password</label><?php echo isset($error['password']) ? $error['password'] : ''; ?>
										<input type="text" class="form-control" name="password" value="<?php echo $res[0]['password']; ?>">
									 </div>
									 <div class="col-md-3">
										<label for="exampleInputEmail1">Alternate Mobile Number</label><?php echo isset($error['alternate_mobile']) ? $error['alternate_mobile'] : ''; ?>
										<input type="text" class="form-control" name="alternate_mobile" value="<?php echo $res[0]['alternate_mobile']; ?>">
									 </div>
								</div>
						   </div>
						   <hr>
						   <div class="row">
							    <div class="form-group">
									 
									 <div class="col-md-3">
									     <label for="exampleInputEmail1">Brand</label><?php echo isset($error['brand']) ? $error['brand'] : ''; ?>
										<input type="text" class="form-control" name="brand" value="<?php echo $res[0]['brand']; ?>">
									 </div>
									 <div class="col-md-3">
									     <label for="exampleInputEmail1">Address</label><?php echo isset($error['address']) ? $error['address'] : ''; ?>
										<input type="text" class="form-control" name="address" value="<?php echo $res[0]['address']; ?>">
									 </div>
									 <div class="col-md-3">
										<label for="exampleInputEmail1">Pincode</label><?php echo isset($error['pincode']) ? $error['pincode'] : ''; ?>
										<input type="number" class="form-control" name="pincode" value="<?php echo $res[0]['pincode']; ?>">
									 </div>
									 <div class="col-md-3">
										<label for="exampleInputEmail1">Working Hours</label><?php echo isset($error['working_hours']) ? $error['working_hours'] : ''; ?>
										<input type="text"  class="form-control" name="working_hours" value="<?php echo $res[0]['working_hours']; ?>">
									 </div>

								</div>
						   </div>
						   <hr>
						   <div class="row">
							    <div class="form-group">
									
									 <div class="col-md-3">
									     <label for="exampleInputEmail1">GST TIN</label><?php echo isset($error['gst_tin']) ? $error['gst_tin'] : ''; ?>
										<input type="text" class="form-control" name="gst_tin" value="<?php echo $res[0]['gst_tin']; ?>">
									 </div>
									 <div class="col-md-3">
									     <label for="exampleInputEmail1">Account Number</label><?php echo isset($error['account_no']) ? $error['account_no'] : ''; ?>
										<input type="number" class="form-control" name="account_no" value="<?php echo $res[0]['account_no']; ?>">
									 </div>
									 <div class="col-md-3">
										<label for="exampleInputEmail1">IFSC Code</label><?php echo isset($error['ifsc_code']) ? $error['ifsc_code'] : ''; ?>
										<input type="text" class="form-control" name="ifsc_code" value="<?php echo $res[0]['ifsc_code']; ?>">
								    </div>
								</div>

						   </div>
						   <hr>
						   <div class="row">
							  <div class="form-group">
								<div class="col-md-4">
									<label class="control-label">Status</label>
									<div id="status" class="btn-group">
										<label class="btn btn-default" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
											<input type="radio" name="status" value="0" <?= ($res[0]['status'] == 0) ? 'checked' : ''; ?>> Deactivated
										</label>
										<label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
											<input type="radio" name="status" value="1" <?= ($res[0]['status'] == 1) ? 'checked' : ''; ?>> Activated
										</label>
									</div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
