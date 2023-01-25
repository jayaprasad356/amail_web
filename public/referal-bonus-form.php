<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

if (isset($_POST['btnAdd'])) {
    $user_id = $db->escapeString(($_POST['user_id']));
    $error = array();

    if (!empty($user_id)) {
        $refer_bonus_codes = $function->getSettingsVal('refer_bonus_codes');
        $code_bonus = $refer_bonus_codes * COST_PER_CODE;
        $referral_bonus = $function->getSettingsVal('refer_bonus_amount');
        $datetime = date('Y-m-d H:i:s');
        $sql_query = "UPDATE users SET `total_referrals` = total_referrals + 1,`earn` = earn + $referral_bonus,`refer_balance` = refer_balance + $referral_bonus WHERE id =  '$user_id' AND status = 1";
        $db->sql($sql_query);
        $res = $db->getResult();
        if (empty($res)) {
            $sql = "SELECT * FROM `users` WHERE id =  '$user_id'";
            $db->sql($sql);
            $ures = $db->getResult();

            $sql_query = "INSERT INTO transactions (user_id,amount,datetime,type)VALUES($user_id,$referral_bonus,'$datetime','refer_bonus')";
            $db->sql($sql_query);
            $code_generate = $ures[0]['code_generate'];
            if($code_generate == 1){
                $sql_query = "UPDATE users SET `earn` = earn + $code_bonus,`balance` = balance + $code_bonus,`today_codes` = today_codes + $refer_bonus_codes,`total_codes` = total_codes + $refer_bonus_codes WHERE id =  '$user_id' AND code_generate = 1";
                $db->sql($sql_query);
                $sql_query = "INSERT INTO transactions (user_id,amount,codes,datetime,type)VALUES($user_id,$code_bonus,$refer_bonus_codes,'$datetime','code_bonus')";
                $db->sql($sql_query);
            }

        }
        $error['update_users'] = " <section class='content-header'><span class='label label-success'>Refer Bonus Added Successfully</span></section>";
    }




}


?>
<section class="content-header">
    <h1>
    Referal Bonus</h1>
    <small><?php echo isset($error['update_users']) ? $error['update_users'] : ''; ?></small>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-10">
            <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <form name="add_admin_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="mobile_number">Mobile Number</label> <i class="text-danger asterik">*</i>
                                   <input type="text" id='mobile' name="mobile" class='form-control' required>
                                </div>
                                <input style="margin-top:22px;margin-left:22px;" type="submit" class="btn-primary btn" value="Search" name="btnSearch" />&nbsp;
                            </div>
                        </div>
                    
                </form>
                <form id='add_suspense_form' method="post" enctype="multipart/form-data">
                    <?php if(isset($_POST['btnSearch'])){ 
                            $mobile = $db->escapeString($fn->xss_clean($_POST['mobile']));
                            $refer_code = $db->escapeString($fn->xss_clean($_POST['mobile']));
                            if($_SESSION['role'] == 'Super Admin'){
                                $join = "WHERE id IS NOT NULL";
                            }
                            else{
                                $refer_code = $_SESSION['refer_code'];
                                $join = "WHERE refer_code REGEXP '^$refer_code'";
                            }
                            $sql_query = "SELECT id,name,refer_code,mobile FROM users $join AND mobile = '$mobile' OR refer_code = '$refer_code'";
                            $db->sql($sql_query);
                            $ressus = $db->getResult();
                            if(count($ressus)>0){
                            ?>
                            <input type="hidden" name="type" value="<?php echo $type?>">
                            <input type="hidden" name="user_id" value="<?php echo $ressus[0]['id']?>">
                            <input  type="hidden" name="refer_code" value="<?php echo $ressus[0]['refer_code']?>">
                            
                            <div class="row">
                                <div class="form-group">
                                        <div class='col-md-6'>
                                            <label for="mobile_number">User Details</label> <i class="text-danger asterik">*</i>
                                            <input type="text" id='name' name="name" value="<?php echo $ressus[0]['name'] .' - '. $ressus[0]['refer_code'] .' - '. $ressus[0]['mobile'] ?>"  class='form-control' readonly>
                                        </div>
                                </div>
                             </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <div class='col-md-6'>
                                            <label for="exampleInputEmail1">Total Referal Count</label> <i class="text-danger asterik">*</i>
                                            <input type="text" class="form-control" id="referal_count" name="referred_by" value="1"  readonly>
                                        </div>
                                    </div>
                                    
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-2">
                                        <input type="submit" class="btn-primary btn" value="Send Referral Bonus" name="btnAdd" />&nbsp;
                                    </div>
                                    </div>
                                </div>
                                <?php }else{ echo '<div class="text-danger">Mobile number not found in the system</div>'; } ?>
                    <?php } ?>
                </form>


            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>

<script>
    $(document).on('change', '#mobile', function() {
        $.ajax({
            url: 'public/db-operation.php',
            method: 'POST',
            data: 'user_id=' + $('#mobile').val() + '&referred_by_code_change=1',
            success: function(data) {
                $('#referred_by').val(data);
            }
        });
    });
</script>

<?php $db->disconnect(); ?>