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
    $mobile = $db->escapeString(($_POST['mobile']));
    $password = $db->escapeString(($_POST['password']));
    $dob = $db->escapeString(($_POST['dob']));
    $email = $db->escapeString(($_POST['email']));
    $city = $db->escapeString(($_POST['city']));
    $earn = $db->escapeString(($_POST['earn']));
    $referrals = $db->escapeString(($_POST['referrals']));
    $balance = $db->escapeString(($_POST['balance']));
    $codes = $db->escapeString(($_POST['codes']));
    $error = array();

    if (empty($name)) {
        $error['name'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($mobile)) {
        $error['mobile'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($password)) {
        $error['password'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($dob)) {
        $error['dob'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($email)) {
        $error['email'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($city)) {
        $error['city'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($earn)) {
        $error['earn'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($referrals)) {
        $error['referrals'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($balance)) {
        $error['balance'] = " <span class='label label-danger'>Required!</span>";
    }
    if (empty($codes)) {
        $error['codes'] = " <span class='label label-danger'>Required!</span>";
    } {

        $sql_query = "UPDATE users SET name='$name', mobile='$mobile', password='$password', dob='$dob', email='$email', city='$city', earn='$earn', referrals='$referrals', balance='$balance', codes='$codes' WHERE id =  $ID";
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
        Edit Users<small><a href='users.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Users</a></small></h1>
    <small><?php echo isset($error['update_users']) ? $error['update_users'] : ''; ?></small>
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
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id="edit_panchangam_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-6'>
                                    <label for="exampleInputEmail1">Name</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>">

                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Phone Number</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="mobile" value="<?php echo $res[0]['mobile']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Password</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="password" value="<?php echo $res[0]['password']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Date of Birth</label><i class="text-danger asterik">*</i>
                                    <input type="date" class="form-control" name="dob" value="<?php echo $res[0]['dob']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">E-mail</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="email" value="<?php echo $res[0]['email']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">City</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="city" value="<?php echo $res[0]['city']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Earn</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="earn" value="<?php echo $res[0]['earn']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Referrals</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="referrals" value="<?php echo $res[0]['referrals']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Earn</label><i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="earn" value="<?php echo $res[0]['earn']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
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
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php $db->disconnect(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>