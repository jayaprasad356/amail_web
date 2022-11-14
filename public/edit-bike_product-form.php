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
	$size = $db->escapeString($_POST['size']);
	$tyre_type = (isset($_POST['tyre_type']) && !empty($_POST['tyre_type'])) ? trim($db->escapeString($fn->xss_clean($_POST['tyre_type']))) : "";
	$wheel = (isset($_POST['wheel']) && !empty($_POST['wheel'])) ? trim($db->escapeString($fn->xss_clean($_POST['wheel']))) : "";
	$error = array();
		

		if (!empty($bike_id) && !empty($type) && !empty($size)) 
		{  
			if($type=='Tyre'){
                $sql_query = "UPDATE bike_product_size SET bike_id='$bike_id',type='$type',size='$size',wheel='$wheel',tyre_type='$tyre_type' WHERE id=$ID";
                $db->sql($sql_query);
            }
            elseif($type=='Puncture'){
                $sql_query = "UPDATE bike_product_size SET bike_id='$bike_id',type='$type',size='$size',wheel='',tyre_type='' WHERE id=$ID";
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
				
			       $error['update_bike_product_size'] = " <section class='content-header'><span class='label label-success'>Bike ProducT Size updated Successfully</span></section>";
			} else {
				$error['update_bike_product_size'] = " <span class='label label-danger'>Failed to update</span>";
			}
		}
	} 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM bike_product_size WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();


if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "bike_products.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Bike Product Size<small><a href='bike_products.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Bike Product Size</a></small></h1>
	<small><?php echo isset($error['update_bike_product_size']) ? $error['update_bike_product_size'] : ''; ?></small>
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
                                        <option value="Tyre"<?=$res[0]['type'] == 'Tyre' ? ' selected="selected"' : '';?>>Tyre</option>
                                        <option value="Puncture"<?=$res[0]['type'] == 'Puncture' ? ' selected="selected"' : '';?> >Puncture</option>
                                    </select>
							</div>
							<div class="form-group">
                                        <label for="exampleInputEmail1">Size</label><?php echo isset($error['size']) ? $error['size'] : ''; ?>
                                        <input type="text" class="form-control" name="size" value="<?php echo $res[0]['size']; ?>" >
                            </div>
							<div class="form-group" id="wheel" style="display: none">
                                <label class="control-label">Choose Wheel</label> <i class="text-danger asterik">*</i>
                                        <input type="radio" name="wheel" value="Front">   Front
                                        <input type="radio" name="wheel" value="Rear">   Rear
                             </div>
							<div class="form-group" id="tyre_type" style="display: none">
									<label >Tyre Type</label> <i class="text-danger asterik">*</i>
										<input type="radio" name="tyre_type" value="Tube Tyre"> Tube Tyre
										<input type="radio" name="tyre_type" value="Tubeless">   Tubeless
						
							</div>
							<?php
							if($res[0]['type']=='Tyre'){
								?>
								<div class="form-group" id="old_wheel">
                                   <label class="control-label">Choose Wheel</label> <i class="text-danger asterik">*</i>
								    <select id="wheel" name="wheel" class="form-control">
                                        <option value="Front"<?=$res[0]['wheel'] == 'Front' ? ' selected="selected"' : '';?>>Front</option>
                                        <option value="Rear"<?=$res[0]['wheel'] == 'Rear' ? ' selected="selected"' : '';?> >Rear</option>
                                    </select>
                                </div>
								<div class="form-group" id="old_tyre">
                                   <label class="control-label">Tyre Type</label> <i class="text-danger asterik">*</i>
								    <select id="tyre_type" name="tyre_type" class="form-control">
                                        <option value="Tube Tyre"<?=$res[0]['tyre_type'] == 'Tube Tyre' ? ' selected="selected"' : '';?>>Tube Tyre</option>
                                        <option value="Tubeless"<?=$res[0]['tyre_type'] == 'Tubeless' ? ' selected="selected"' : '';?> >Tubeless</option>
                                    </select>
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
            $("#wheel").hide();
            $("#tyre_type").hide();
			$("#old_wheel").hide();
            $("#old_tyre").hide();
        }
        if(type == "Tyre"){
            $("#wheel").show();
            $("#tyre_type").show();

        }
        if(type == "Puncture"){
            $("#wheel").hide();
            $("#tyre_type").hide();
			$("#old_wheel").hide();
            $("#old_tyre").hide();

        }
    });

</script>
<?php $db->disconnect(); ?>

