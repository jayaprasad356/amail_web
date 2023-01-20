<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<?php

if (isset($_POST['btnAdd'])) {

    $user_ids = $fn->xss_clean_array($_POST['user_ids']);

    $error = array();

    if (!empty($user_ids)) {
        foreach ($user_ids as $user_id) {
            $sql_query = "INSERT INTO task_champions (user_id) VALUES ('$user_id')";
            $db->sql($sql_query);
            $result = $db->getResult();
        }

        if (!empty($result)) {
            $result = 0;
        } else {
            $result = 1;
        }
        if ($result == 1) {
            $error['add_champion'] = "<section class='content-header'>
                                      <span class='label label-success'>Champions Added Successfully</span> </section>";
        } else {
            $error['add_champion'] = " <span class='label label-danger'>Failed</span>";
        }
    }
}


?>
<section class="content-header">
    <h1>Add Champions</h1>
    <?php echo isset($error['add_champion']) ? $error['add_champion'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_champion_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                               <div class="col-md-12">
                                        <label for="exampleInputEmail1">Select Champions</label> <i class="text-danger asterik">*</i><br>
                                        <select id='user_ids' name="user_ids[]" multiple>
                                        <option value=''>Select</option>
                                                    <?php
                                                    $sql = "SELECT id,name FROM `users`";
                                                    $db->sql($sql);

                                                    $result = $db->getResult();
                                                    foreach ($result as $value) {
                                                    ?>
                                                        <option value='<?= $value['id'] ?>'><?= $value['name'] ?></option>
                                                    <?php } ?>
                                        </select>
                                </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                 
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Add" name="btnAdd" />&nbsp;
                        <input type="reset" onClick="refreshPage()" class="btn-warning btn" value="Clear" />
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_product_form').validate({

        ignore: [],
        debug: false,
        rules: {
            user_ids: "required",
         }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
    $(document).ready(function () {
        $('#user_ids').select2({
        width: '100%',
        placeholder: 'Type in name to search',

    });
    });
</script>

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>

<?php $db->disconnect(); ?>
