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
            $datetime = date('Y-m-d H:i:s');

            $name = $db->escapeString(($_POST['name']));
            $device_id = $db->escapeString(($_POST['device_id']));
            $mobile = $db->escapeString(($_POST['mobile']));
            $password = $db->escapeString(($_POST['password']));
            $dob = $db->escapeString(($_POST['dob']));
            $email = $db->escapeString(($_POST['email']));
            $city = $db->escapeString(($_POST['city']));
            $status = $db->escapeString(($_POST['status']));
            $refer_code = $db->escapeString(($_POST['refer_code']));
            $joined_date = $db->escapeString(($_POST['joined_date']));
            $code_generate_time = $db->escapeString(($_POST['code_generate_time']));
            $withdrawal_status = $db->escapeString(($_POST['withdrawal_status']));
            $refer_bonus_sent = (isset($_POST['refer_bonus_sent']) && !empty($_POST['refer_bonus_sent'])) ? $db->escapeString($_POST['refer_bonus_sent']) : 0;
            $referred_by = (isset($_POST['referred_by']) && !empty($_POST['referred_by'])) ? $db->escapeString($_POST['referred_by']) : "";
            $earn = (isset($_POST['earn']) && !empty($_POST['earn'])) ? $db->escapeString($_POST['earn']) : 0;
            $code_generate = (isset($_POST['code_generate']) && !empty($_POST['code_generate'])) ? $db->escapeString($_POST['code_generate']) : 0;
            $total_referrals = (isset($_POST['total_referrals']) && !empty($_POST['total_referrals'])) ? $db->escapeString($_POST['total_referrals']) : 0;
            $balance = (isset($_POST['balance']) && !empty($_POST['balance'])) ? $db->escapeString($_POST['balance']) : "0";
            $today_codes = (isset($_POST['today_codes']) && !empty($_POST['today_codes'])) ? $db->escapeString($_POST['today_codes']) : 0;
            $total_codes = (isset($_POST['total_codes']) && !empty($_POST['total_codes'])) ? $db->escapeString($_POST['total_codes']) : 0;
            $error = array();

     if (!empty($name) && !empty($mobile) && !empty($password)&& !empty($dob) && !empty($email)&& !empty($city) && !empty($refer_code) && !empty($code_generate_time)) {

        if($status == 1 && !empty($referred_by) && $refer_bonus_sent != 1){
            $code_bonus = 1000 * COST_PER_CODE;
            $referral_bonus = 550;
            $sql_query = "UPDATE users SET `total_referrals` = total_referrals + 1,`earn` = earn + $referral_bonus,`balance` = balance + $referral_bonus WHERE refer_code =  '$referred_by' AND status = 1";
            $db->sql($sql_query);
            $res = $db->getResult();
            if (empty($res)) {

                $sql_query = "SELECT * FROM users WHERE refer_code =  '$referred_by'";
                $db->sql($sql_query);
                $res = $db->getResult();
                $user_id = $res[0]['id'];
                $sql_query = "INSERT INTO transactions (user_id,amount,datetime,type)VALUES($user_id,$referral_bonus,'$datetime','refer_bonus')";
                $db->sql($sql_query);
                $code_generate = $res[0]['code_generate'];
                if($code_generate == 1){
                    $sql_query = "UPDATE users SET `earn` = earn + $code_bonus,`balance` = balance + $code_bonus WHERE refer_code =  '$referred_by' AND code_generate = 1";
                    $db->sql($sql_query);
                    $sql_query = "INSERT INTO transactions (user_id,amount,codes,datetime,type)VALUES($user_id,$code_bonus,1000,'$datetime','code_bonus')";
                    $db->sql($sql_query);
                }
                $sql_query = "UPDATE users SET refer_bonus_sent = 1 WHERE id =  $ID";
                $db->sql($sql_query);

            }


        }
    
        $sql_query = "UPDATE users SET name='$name', mobile='$mobile', password='$password', dob='$dob', email='$email', city='$city', refer_code='$refer_code', referred_by='$referred_by', earn='$earn', total_referrals='$total_referrals', balance='$balance', withdrawal_status=$withdrawal_status,total_codes=$total_codes, today_codes=$today_codes,device_id='$device_id',status = $status,code_generate = $code_generate,code_generate_time = $code_generate_time,joined_date = '$joined_date' WHERE id =  $ID";
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
                    <input type="hidden" class="form-control" name="refer_bonus_sent" value="<?php echo $res[0]['refer_bonus_sent']; ?>">
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
                                    <input type="date" class="form-control" name="dob" value="<?php echo $res[0]['dob']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">E-mail</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="email" value="<?php echo $res[0]['email']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">City</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="city" value="<?php echo $res[0]['city']; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Earn</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="earn" value="<?php echo $res[0]['earn']; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Referred By</label>
                                    <input type="text" class="form-control" name="referred_by" value="<?php echo $res[0]['referred_by']; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Refer Code</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="refer_code" value="<?php echo $res[0]['refer_code']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Total Referrals</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="total_referrals" value="<?php echo $res[0]['total_referrals']; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Balance</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="balance" value="<?php echo $res[0]['balance']; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Today Codes</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="today_codes" value="<?php echo $res[0]['today_codes']; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Total Codes</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="total_codes" value="<?php echo $res[0]['total_codes']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Code Generate</label><br>
                                    <input type="checkbox" id="code_generate_button" class="js-switch" <?= isset($res[0]['code_generate']) && $res[0]['code_generate'] == 1 ? 'checked' : '' ?>>
                                    <input type="hidden" id="code_generate_status" name="code_generate" value="<?= isset($res[0]['code_generate']) && $res[0]['code_generate'] == 1 ? 1 : 0 ?>">
                                </div>

                            </div>
                            <div class="col-md-3">
                                    <label for="exampleInputEmail1">Code Generate Time</label><i class="text-danger asterik">*</i>
                                    <input type="number" class="form-control" name="code_generate_time" value="<?php echo $res[0]['code_generate_time']; ?>">
                                </div>
                            <div class="col-md-3">
                                    <label for="exampleInputEmail1">Joined Date</label><i class="text-danger asterik">*</i>
                                    <input type="date" class="form-control" name="joined_date" value="<?php echo $res[0]['joined_date']; ?>">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Withdrawal Status</label><br>
                                    <input type="checkbox" id="withdrawal_button" class="js-switch" <?= isset($res[0]['withdrawal_status']) && $res[0]['withdrawal_status'] == 1 ? 'checked' : '' ?>>
                                    <input type="hidden" id="withdrawal_status" name="withdrawal_status" value="<?= isset($res[0]['withdrawal_status']) && $res[0]['withdrawal_status'] == 1 ? 1 : 0 ?>">
                                </div>
                            </div>
                        </div>
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

<script>
    var changeCheckbox = document.querySelector('#code_generate_button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        if ($(this).is(':checked')) {
            $('#code_generate_status').val(1);

        } else {
            $('#code_generate_status').val(0);
        }
    };
</script>

<script>
    var changeCheckbox = document.querySelector('#withdrawal_button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        if ($(this).is(':checked')) {
            $('#withdrawal_status').val(1);

        } else {
            $('#withdrawal_status').val(0);
        }
    };
</script>