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

	    $bike_name = $db->escapeString($_POST['bike_name']);
        $brand = $db->escapeString($_POST['brand']);
        $cc = $db->escapeString($_POST['cc']);
		$error = array();
	

		if (!empty($bike_name) && !empty($brand) && !empty($cc)) 
		{
             $sql_query = "UPDATE bikes SET bike_name='$bike_name',brand='$brand',cc='$cc' WHERE id =$ID";
			 $db->sql($sql_query);
             $update_result = $db->getResult();
			if (!empty($update_result)) {
				$update_result = 0;
			} else {
				$update_result = 1;
			}

			// check update result
			if ($update_result == 1) {
			              $error['update_bike'] = " <section class='content-header'><span class='label label-success'>New Bike updated Successfully</span></section>";
			} else {
			        	$error['update_bike'] = " <span class='label label-danger'>Failed to update</span>";
			}
		}
	} 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM bikes WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "bikes.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit New Bike<small><a href='bikes.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to New Bikes</a></small></h1>
	<small><?php echo isset($error['update_bike']) ? $error['update_bike'] : ''; ?></small>
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
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form id="edit_bike_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
						   <div class="row">
							    <div class="form-group">
									 <div class="col-md-8">
										<label for="exampleInputEmail1">Bike Name</label><?php echo isset($error['bike_name']) ? $error['bike_name'] : ''; ?>
										<input type="text" class="form-control" name="bike_name" value="<?php echo $res[0]['bike_name']; ?>">
									 </div>
								</div>
						   </div>
						   <br>
						   <div class="row">
								<div class="form-group">
								   <div class="col-md-8">
										<label for="exampleInputEmail1">Brand</label><?php echo isset($error['brand']) ? $error['brand'] : ''; ?>
										<input type="text" class="form-control" name="brand" value="<?php echo $res[0]['brand']; ?>">
									 </div>	
								</div>
						   </div>
						   <br>
						   <div class="row">
							    <div class="form-group">
									 <div class="col-md-8">
										<label for="exampleInputEmail1">cc</label><?php echo isset($error['cc']) ? $error['cc'] : ''; ?>
										<input type="text" class="form-control" name="cc" value="<?php echo $res[0]['cc']; ?>">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
