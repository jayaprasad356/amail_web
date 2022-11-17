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

            $name = $db->escapeString(($_POST['name']));
            $device_id = $db->escapeString(($_POST['device_id']));
            $mobile = $db->escapeString(($_POST['mobile']));
            $password = $db->escapeString(($_POST['password']));
            $dob = $db->escapeString(($_POST['dob']));
            $email = $db->escapeString(($_POST['email']));
            $city = $db->escapeString(($_POST['city']));
            $earn = (isset($_POST['earn']) && !empty($_POST['earn'])) ? $db->escapeString($_POST['earn']) : "0";
            $referrals = (isset($_POST['referrals']) && !empty($_POST['referrals'])) ? $db->escapeString($_POST['referrals']) : "0";
            $balance = (isset($_POST['balance']) && !empty($_POST['balance'])) ? $db->escapeString($_POST['balance']) : "0";
            $codes = (isset($_POST['codes']) && !empty($_POST['codes'])) ? $db->escapeString($_POST['codes']) : "";
            $error = array();

     if (!empty($name) && !empty($mobile) && !empty($password)&& !empty($dob) && !empty($email)&& !empty($city)) 
		{

        $sql_query = "UPDATE users SET name='$name', mobile='$mobile', password='$password', dob='$dob', email='$email', city='$city', earn='$earn', referrals='$referrals', balance='$balance', codes='$codes',device_id='$device_id' WHERE id =  $ID";
        $db->sql($sql_query);
        $update_result = $db->getResult();
        if (!empty($update_result)) {
            $update_result = 0;
        } else {
            $update_result = 1;
        }

        // check update result
        if ($update_result == 1) {
            $error['update_users'] = " <section class='content-header'><span class='label label-success'>Users updated Successfully</span></section>";
        } else {
            $error['update_users'] = " <span class='label label-danger'>Failed update users</span>";
        }
    }
}


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM users WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "users.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>
        Edit User<small><a href='users.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Users</a></small></h1>
    <small><?php echo isset($error['update_users']) ? $error['update_users'] : ''; ?></small>
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
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id="edit_user_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-6'>
                                    <label for="exampleInputEmail1">Name</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>">
                                </div>
                                <div class='col-md-6'>
                                    <label for="exampleInputEmail1">Device Id</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="device_id" value="<?php echo $res[0]['device_id']; ?>">
                                </div>
                            </div>
                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Phone Number</label><i class="text-danger asterik">*</i>
                                    <input type="number" class="form-control" name="mobile" value="<?php echo $res[0]['mobile']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Password</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="password" value="<?php echo $res[0]['password']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Date of Birth</label><i class="text-danger asterik">*</i>
                                    <input type="date" class="form-control" name="dob" value="<?php echo $res[0]['dob']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">E-mail</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="email" value="<?php echo $res[0]['email']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">City</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="city" value="<?php echo $res[0]['city']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Earn</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="earn" value="<?php echo $res[0]['earn']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Referrals</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="referrals" value="<?php echo $res[0]['referrals']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Balance</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="balance" value="<?php echo $res[0]['balance']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Codes</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="codes" value="<?php echo $res[0]['codes']; ?>">
                                </div>
                                
                            </div>
                        </div>
                        <br>
                        <div class="row">
									<div class="form-group col-md-12">
										<label class="control-label">Status</label><i class="text-danger asterik">*</i><br>
										<div id="status" class="btn-group">
											<label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
												<input type="radio" name="status" value="0" <?= ($res[0]['status'] == 0) ? 'checked' : ''; ?>> Not-verified
											</label>
											<label class="btn btn-success" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
												<input type="radio" name="status" value="1" <?= ($res[0]['status'] == 1) ? 'checked' : ''; ?>> Verified
											</label>
                                            <label class="btn btn-danger" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
												<input type="radio" name="status" value="2" <?= ($res[0]['status'] == 2) ? 'checked' : ''; ?>> Blocked
											</label>
										</div>
									</div>
							</div>

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