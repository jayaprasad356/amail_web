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

                $user_id = $db->escapeString(($_POST['user_id']));
                $discount = $db->escapeString(($_POST['discount']));
                $expiry_date = $db->escapeString(($_POST['expiry_date']));
                $status = $db->escapeString(($_POST['status']));
                $is_scratched = $db->escapeString(($_POST['is_scratched']));
                $error = array();

     if (!empty($discount) && !empty($expiry_date)) 
       {
    
        $sql_query = "UPDATE scratch_cards SET user_id='$user_id', discount='$discount',expiry_date='$expiry_date',status='$status',is_scratched=$is_scratched WHERE id =  $ID";
        $db->sql($sql_query);
        $update_result = $db->getResult();
        if (!empty($update_result)) {
            $update_result = 0;
        } else {
            $update_result = 1;
        }

        // check update result
        if ($update_result == 1) {
            $error['update_scratch_cards'] = " <section class='content-header'><span class='label label-success'>scratch cards Details updated Successfully</span></section>";
        } else {
            $error['update_scratch_cards'] = " <span class='label label-danger'>Failed update scratch cards</span>";
        }


    }
}

// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM scratch_cards WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();
if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "scratch_cards.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>
        Edit scratch cards<small><a href='scratch_cards.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to scratch_cards</a></small></h1>
    <small><?php echo isset($error['update_scratch_cards']) ? $error['update_scratch_cards'] : ''; ?></small>
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
                <form id="edit_scratch_cards_form" method="post" enctype="multipart/form-data">
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
          <label for="discount">Discount</label><i class="text-danger asterisk">*</i>
          <input type="number" class="form-control" name="discount" value="<?php echo $res[0]['discount']; ?>">
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="form-group">
        <div class="col-md-6">
          <label for="expiry_date">Expiry Date</label> <i class="text-danger asterisk">*</i>
          <input type="date" class="form-control" name="expiry_date" value="<?php echo $res[0]['expiry_date']; ?>">
        </div>
      </div>
    </div>
    <br>
    <div class="row">
    <div class="form-group">
      <div class="col-md-6">
        <label>Status</label><i class="text-danger asterisk">*</i><br>
        <div id="status" class="btn-group">
          <label class="btn btn-success" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
            <input type="radio" name="status" value="1" <?= ($res[0]['status'] == 1) ? 'checked' : ''; ?>> Active
          </label>
          <label class="btn btn-danger" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
            <input type="radio" name="status" value="0" <?= ($res[0]['status'] == 0) ? 'checked' : ''; ?>> Inactive
          </label>
        </div>
      </div>
      <div class="col-md-6">
        <label>is Scratched</label><i class="text-danger asterisk">*</i><br>
        <div id="status" class="btn-group">
          <label class="btn btn-success" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
            <input type="radio" name="is_scratched" value="1" <?= ($res[0]['is_scratched'] == 1) ? 'checked' : ''; ?>> Yes
          </label>
          <label class="btn btn-danger" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
            <input type="radio" name="is_scratched" value="0" <?= ($res[0]['is_scratched'] == 0) ? 'checked' : ''; ?>> No
          </label>
        </div>
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
