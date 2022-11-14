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
		  $bike_id = $db->escapeString(($_POST['bike_id']));
		  $front_tube_less = $db->escapeString($_POST['front_tube_less']);
		  $front_tube_tyre = $db->escapeString($_POST['front_tube_tyre']);
		  $rear_tube_less = $db->escapeString($_POST['rear_tube_less']);
		  $rear_tube_tyre = $db->escapeString($_POST['rear_tube_tyre']);
		  $status = $db->escapeString($_POST['status']);

		  if (!empty($bike_id) && !empty($front_tube_less) && !empty($front_tube_tyre)&& !empty($rear_tube_less)&& !empty($rear_tube_tyre)) 
          {  
				$sql_query = "UPDATE puncture_services SET bike_id='$bike_id',front_tube_less='$front_tube_less',front_tube_tyre='$front_tube_tyre',rear_tube_less='$rear_tube_less',rear_tube_tyre='$rear_tube_tyre',status='$status' WHERE id=$ID";
				$db->sql($sql_query);
				$update_result = $db->getResult();
				if (!empty($update_result)) {
					$update_result = 0;
				} else {
					$update_result = 1;
				}

				// check update result
				if ($update_result == 1) {
					
					$error['update_service'] = " <section class='content-header'><span class='label label-success'>Bike Puncture Services updated Successfully</span></section>";
				} else {
					$error['update_service'] = " <span class='label label-danger'>Failed to update</span>";
				}
			}
	} 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM puncture_services WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();


if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "puncture_services.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Bike Puncture Service<small><a href='puncture_services.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Bike Puncture Service</a></small></h1>
	<small><?php echo isset($error['update_service']) ? $error['update_service'] : ''; ?></small>
	<ol class="breadcrumb">
		<li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
	</ol>
</section>
<section class="content">
	<!-- Main row -->

	<div class="row">
		<div class="col-md-10">
		
			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
				</div><!-- /.box-header -->
				<!-- form start -->
				<form id="edit_puncture_service_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
						<div class="row">
							<div class="form-group">
								<div class="col-md-6">
								    <label for="exampleInputEmail1">Choose Bike</label><i class="text-danger asterik">*</i>
									<select id='bike_id' name="bike_id" class='form-control' required>
									   <option value="none">-- Select --</option>
												<?php
													$sql = "SELECT * FROM `bikes`";
													$db->sql($sql);
													$result = $db->getResult();
													foreach ($result as $value) {
												?>
													<option value='<?= $value['id'] ?>' <?= $value['id']==$res[0]['bike_id'] ? 'selected="selected"' : '';?>><?= $value['bike_name'] ?></option>
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
                                        <input type="number" class="form-control" name="front_tube_less"  value="<?php echo $res[0]['front_tube_less']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Front Tube Price</label><i class="text-danger asterik">*</i><?php echo isset($error['front_tube_tyre']) ? $error['front_tube_tyre'] : ''; ?>
                                        <input type="number" class="form-control" name="front_tube_tyre"  value="<?php echo $res[0]['front_tube_tyre']; ?>">
                                    </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Rear Tubeless Price</label><i class="text-danger asterik">*</i><?php echo isset($error['rear_tube_less']) ? $error['rear_tube_less'] : ''; ?>
                                        <input type="number" class="form-control" name="rear_tube_less"  value="<?php echo $res[0]['rear_tube_less']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Rear Tube Price</label><i class="text-danger asterik">*</i><?php echo isset($error['rear_tube_tyre']) ? $error['rear_tube_tyre'] : ''; ?>
                                        <input type="number" class="form-control" name="rear_tube_tyre"  value="<?php echo $res[0]['rear_tube_tyre']; ?>">
                                    </div>
                            </div>
                        </div>
						<br>
						<div class="row">
							<div class="form-group">
								<div class="col-md-6">
									<label for="">Status</label> <i class="text-danger asterik">*</i>
										<select id="status" name="status" class="form-control">
										<option value="1"<?=$res[0]['status'] == '1' ? ' selected="selected"' : '';?>>Booked</option>
											<option value="2"<?=$res[0]['status'] == '2' ? ' selected="selected"' : '';?>>Completed</option>
											<option value="0"<?=$res[0]['status'] == '0' ? ' selected="selected"' : '';?> >Cancelled</option>
										</select>
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

