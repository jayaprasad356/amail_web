<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;


?>
<?php
if (isset($_POST['btnAdd'])) {

        $date = $db->escapeString(($_POST['date']));
        $amount = $db->escapeString($_POST['amount']);
        $remarks = $db->escapeString(($_POST['remarks']));
        $error = array();
       
        if (empty($date)) {
            $error['date'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($amount)) {
            $error['amount'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($remarks)) {
            $error['remarks'] = " <span class='label label-danger'>Required!</span>";
        }
       
       if (!empty($date) && !empty($amount) && !empty($remarks)) 
       {
        $sql_query = "SELECT * FROM expenses WHERE date = '$date'";
        $db->sql($sql_query);
        $res = $db->getResult();
        $num = $db->numRows($res);
        if ($num >= 1) {
            $error['add_expenses'] = " <span class='label label-danger'>expenses Already Added</span>";
            
        }else{
            $sql_query = "INSERT INTO expenses (date,amount,remarks)VALUES('$date','$amount','$remarks')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                echo $num;
                
                $error['add_expenses'] = "<section class='content-header'>
                                                <span class='label label-success'>expenses Added Successfully</span> </section>";
            } else {
                $error['add_expenses'] = " <span class='label label-danger'>Failed</span>";
            }
        }
            
        }
           

    }
?>
<section class="content-header">
    <h1>Add New expenses <small><a href='expenses.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to expenses</a></small></h1>

    <?php echo isset($error['add_expenses']) ? $error['add_expenses'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form url="add-expenses-form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                       <div class="row">
                            <div class="form-group">
                                <div class='col-md-12'>
                                    <label for="exampleInputdate">date</label> <i class="text-danger asterik">*</i>
                                    <input type="date" class="form-control" name="date" required>
                                </div>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                            <div class='col-md-12'>
                                    <label for="exampleInputamount">amount</label> <i class="text-danger asterik">*</i>
                                    <input type="text"  class="form-control" name="amount" required></textarea>
                                </div>
                                <br>
                                <div class="form-group">
                                <div class='col-md-12'>
                                    <label for="exampleInputremarks">remarks</label> <i class="text-danger asterik">*</i>
                                    <textarea type="text" rows="3" class="form-control" name="remarks" required></textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                  
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Submit</button>
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
    $('#add_admin_form').validate({

        ignore: [],
        debug: false,
        rules: {
            name: "required",
            role: "required",
            password: "required",
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