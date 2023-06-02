<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
if (isset($_POST['btnAdd'])) {
        $user_id = $db->escapeString(($_POST['user_id']));
        $discount = $db->escapeString(($_POST['discount']));
        $expiry_date = $db->escapeString(($_POST['expiry_date']));
        $error = array();
       
        if (empty($user_id)) {
            $error['user_id'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($discount)) {
            $error['discount'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($expiry_date)) {
            $error['expiry_date'] = " <span class='label label-danger'>Required!</span>";
        }
      
       if (!empty($discount) && !empty($expiry_date) ) 
       {
            $sql_query = "INSERT INTO scratch_cards (user_id,discount,expiry_date)VALUES('$user_id','$discount','$expiry_date')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }
            if ($result == 1) {
                
                $error['add_scratch_cards'] = "<section class='content-header'>
                                                <span class='label label-success'>scratch_cards Added Successfully</span> </section>";
            } else {
                $error['add_scratch_cards'] = " <span class='label label-danger'>Failed</span>";
           }
        }
    }
?>
<section class="content-header">
    <h1>Add New scratch cards <small><a href='scratch_cards.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to scratch_cards</a></small></h1>

    <?php echo isset($error['add_scratch_card']) ? $error['add_scratch_card'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-10">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                </div>
                <form url="add_scratch_card_form" method="post" enctype="multipart/form-data">
                <div class="box-body">
    <div class="row">
      <div class="form-group">
        <div class="col-md-6">
          <label for="user_id">Select users</label> <i class="text-danger asterisk">*</i>
          <select id="user_id" name="user_id" class="form-control">
            <option value="">--Select--</option>
            <?php
            $sql = "SELECT * FROM `users` LIMIT 10";
            $db->sql($sql);
            $result = $db->getResult();
            foreach ($result as $value) {
              $selected = $value['id'] == $res[0]['user_id'] ? 'selected="selected"' : '';
              echo "<option value='" . $value['id'] . "' $selected>" . $value['name'] . "</option>";
            }
            ?>
          </select>
        </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="discount">Discount</label> <i class="text-danger asterisk">*</i>
          <input type="text" class="form-control" name="discount" id="discount" required>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="expiry_date">Expiry Date</label> <i class="text-danger asterisk">*</i>
          <input type="date" class="form-control" name="expiry_date" id="expiry_date" required>
        </div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
                        <input type="reset" onClick="refreshPage()" class="btn-warning btn" value="Clear" />
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_scratch_cards_form').validate({

        ignore: [],
        debug: false,
        rules: {
            discount: "required",
            expiry_date: "required",
        }
    });
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

<?php $db->disconnect(); ?>