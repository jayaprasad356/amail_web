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

	    $bike_id = $db->escapeString(($_POST['bike_id']));
	    $type = $db->escapeString($_POST['type']);
        $price = (isset($_POST['price']) && !empty($_POST['price'])) ? trim($db->escapeString($fn->xss_clean($_POST['price']))) : "";
		$status = $db->escapeString($_POST['status']);
		$error = array();
		

		if ( !empty($bike_id) && !empty($type)) 
		{
			if($type=='General'){
                $sql_query = "UPDATE bike_services SET bike_id='$bike_id',type='$type',price='$price',status='$status' WHERE id=$ID";
                $db->sql($sql_query);
            }
            elseif($type=='Emergency'){
                $sql_query = "UPDATE bike_services SET bike_id='$bike_id',type='$type',price='',status='$status' WHERE id=$ID";
                $db->sql($sql_query);
            }
             $update_result = $db->getResult();
			if (!empty($update_result)) {
				$update_result = 0;
			} else {
				$update_result = 1;
			}

			// check update result
			if ($update_result == 1) {
				
			       $error['update_service'] = " <section class='content-header'><span class='label label-success'>Services updated Successfully</span></section>";
			} else {
				$error['update_service'] = " <span class='label label-danger'>Failed to update</span>";
			}
		}
	} 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM bike_services WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();


if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "bike_services.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Bike Service<small><a href='bike_services.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Bike Service</a></small></h1>
	<small><?php echo isset($error['update_service']) ? $error['update_service'] : ''; ?></small>
	<ol class="breadcrumb">
		<li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
	</ol>
</section>
<section class="content">
	<!-- Main row -->

	<div class="row">
		<div class="col-md-6">
		
			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
				</div><!-- /.box-header -->
				<!-- form start -->
				<form id="edit_bike_service_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
							<div class="form-group">
									<label for="exampleInputEmail1">Choose Bike</label> <i class="text-danger asterik">*</i>
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
							<div class="form-group">
							     <label for="">Service Type</label> <i class="text-danger asterik">*</i> <?php echo isset($error['type']) ? $error['type'] : ''; ?><br>
                                    <select id="type" name="type" class="form-control">
                                        <option value="none">-- Select --</option>
                                        <option value="General"<?=$res[0]['type'] == 'General' ? ' selected="selected"' : '';?>>General</option>
                                        <option value="Emergency"<?=$res[0]['type'] == 'Emergency' ? ' selected="selected"' : '';?> >Emergency</option>
                                    </select>
							</div>
							<div class="form-group" id="price" style="display: none">
                                        <label for="exampleInputEmail1">Price</label><?php echo isset($error['price']) ? $error['price'] : ''; ?>
                                        <input type="text" class="form-control" name="price" >
                            </div>
							<div class="form-group">
							       <label for="">Status</label> <i class="text-danger asterik">*</i>
                                    <select id="status" name="status" class="form-control">
									   <option value="1"<?=$res[0]['status'] == '1' ? ' selected="selected"' : '';?>>Booked</option>
                                        <option value="2"<?=$res[0]['status'] == '2' ? ' selected="selected"' : '';?>>Completed</option>
                                        <option value="0"<?=$res[0]['status'] == '0' ? ' selected="selected"' : '';?> >Cancelled</option>
                                    </select>

							</div>
							<?php
							if($res[0]['type']=='General'){
								?>
								<div class="form-group" id="old_price">
							         	<label for="exampleInputEmail1">Price</label><?php echo isset($error['price']) ? $error['price'] : ''; ?>
										<input type="text" class="form-control" name="price" value="<?php echo $res[0]['price']; ?>">
								</div>
							<?php } ?>
									
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
<script>

$("#type").change(function() {
        type = $("#type").val();
        if(type == "none"){
            $("#price").hide();
			$("#old_price").hide();

        }
        if(type == "General"){
            $("#price").show();
            $("#old_price").hide();

        }
        if(type == "Emergency"){
            $("#price").hide();
			$("#old_price").hide();

        }
    });

</script>
<?php $db->disconnect(); ?>

