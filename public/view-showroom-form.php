<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
// session_start();
$showroom_id = $_GET['id'];
?>
<section class="content-header">
    <h1>View Showroom</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
<div class="row">
            <div class="col-md-4">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Showroom Details</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                    <table class="table table-bordered">
                        <?php
                        $sql = "SELECT * FROM showroom WHERE id = $showroom_id";
                        $db->sql($sql);
                        $res = $db->getResult();
                        $num = $db->numRows();
                        if($num >= 1){

                           $sql="SELECT * FROM showroom WHERE id = $showroom_id";
                            $db->sql($sql);
                            $res = $db->getResult();
                            ?>
                            <tr>
                                <th style="width: 200px">ID</th>
                                <td><?php echo $res[0]['id'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Showroom Name</th>
                                <td><?php echo $res[0]['showroom_name'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Mobile</th>
                                <td><?php echo $res[0]['mobile'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Password</th>
                                <td><?php echo $res[0]['password'] ?></td>
                            </tr>
                            <tr>
                               <th style="width: 200px">Alternate Mobile Number</th>
                                <td><?php echo $res[0]['alternate_mobile']; ?></td>  
                            </tr>
                            <tr>
                                <th style="width: 200px">Brand</th>
                                <td><?php echo $res[0]['brand'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Working Hours</th>
                                <td><?php echo $res[0]['working_hours'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Address</th>
                                <td><?php echo $res[0]['address'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Pin Code</th>
                                <td><?php echo $res[0]['pincode'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">GST TIN</th>
                                <td><?php echo $res[0]['gst_tin'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Account Number</th>
                                <td><?php echo $res[0]['account_no']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">IFSC Code</th>
                                <td><?php echo $res[0]['ifsc_code']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">status</th>
                                <td><?php if($res[0]['status']== '1'){?>
                                   <p class='text text-success'>Activated</p> 
                                <?php }else{?>
                                    <p class='text text-danger'>Deactivated</p> 
                                <?php }?></td>
                            </tr>
                           
                            <?php
                        }
                        else{
                            echo "<tr><td colspan='2'>No Data Found</td></tr>";
                        }
                        ?>
    
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="showrooms.php" class="btn btn-sm btn-default btn-flat pull-left">Back</a>
                    </div>
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
<script>
    document.getElementById('valid').valueAsDate = new Date();

</script>
