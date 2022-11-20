<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

if (isset($_POST['btnUpdate'])) {
    $mobile = $db->escapeString(($_POST['mobile']));
    $refer_code = $db->escapeString(($_POST['refer_code']));
    $error = array();

    if (!empty($mobile) && !empty($refer_code)) {

    $sql_query = "UPDATE users SET refer_code='$refer_code' WHERE id =  $mobile";
    $db->sql($sql_query);
    $update_result = $db->getResult();
    if (!empty($update_result)) {
        $update_result = 0;
    } else {
        $update_result = 1;
    }

    // check update result
    if ($update_result == 1) {
        $error['update_users'] = " <section class='content-header'><span class='label label-success'>Refer code updated Successfully</span></section>";
    } else {
        $error['update_users'] = " <span class='label label-danger'>Failed update refer code</span>";
    }


    }
}


?>
<section class="content-header">
    <h1>
    Manage Referal Codes</h1>
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
                                <div class='col-md-6'>
                                       <label for="">Mobile Number</label> <i class="text-danger asterik">*</i>
                                        <select id='mobile' name="mobile" class='form-control' required>
                                            <option value="">select</option>
                                                <?php
                                                $sql = "SELECT id,mobile,name FROM `users` ORDER BY ID DESC LIMIT 10 ";
                                                $db->sql($sql);
                                                $result = $db->getResult();
                                                foreach ($result as $value) {
                                                ?>
                                                    <option value='<?= $value['id'] ?>'><?= $value['name'] .' - '. $value['mobile']?></option>
                                            <?php } ?>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-6'>
                                    <label for="exampleInputEmail1">Refer Code</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" id="refer_code" name="refer_code" value="" >
                                </div>
                            </div>
                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-2">
                                   <input type="submit" class="btn-primary btn" value="Update" name="btnUpdate" />&nbsp;
                               </div>
                            </div>

                        </div>
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
    $(document).ready(function () {
        $('#mobile').select2({
        width: 'element',
        placeholder: 'Type in Mobile to search',

    });
    });

</script>
<script>
    $(document).on('change', '#mobile', function() {
        $.ajax({
            url: 'public/db-operation.php',
            method: 'POST',
            data: 'user_id=' + $('#mobile').val() + '&refer_code_change=1',
            success: function(data) {
                $('#refer_code').val(data);
            }
        });
    });
</script>

<?php $db->disconnect(); ?>