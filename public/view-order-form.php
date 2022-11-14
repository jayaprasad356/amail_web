<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
// session_start();
$order_id = $_GET['id'];
?>
<section class="content-header">
    <h1>View Order</h1>
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
                        <h3 class="box-title">Order Detail</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                    <table class="table table-bordered">
                        <?php
                        $sql = "SELECT * FROM orders WHERE id = $order_id";
                        $db->sql($sql);
                        $res = $db->getResult();
                        $num = $db->numRows();
                        if($num >= 1){

                            $sql = "SELECT *,orders.id AS id,orders.status AS status,orders.model AS model,orders.price AS price FROM orders,products WHERE orders.product_id=products.id AND orders.id = $order_id";
                            $db->sql($sql);
                            $res = $db->getResult();
                            ?>
                            <tr>
                                <th style="width: 200px">ID</th>
                                <td><?php echo $res[0]['id'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Name</th>
                                <td><?php echo $res[0]['name'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Mobile</th>
                                <td><?php echo $res[0]['mobile'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Address</th>
                                <td><?php echo $res[0]['address'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">PinCode</th>
                                <td><?php echo $res[0]['pincode'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Product Name</th>
                                <td><?php echo $res[0]['product_name'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Brand</th>
                                <td><?php echo $res[0]['brand'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Product Variant ID</th>
                                <td><?php echo $res[0]['product_variant_id'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Model</th>
                                <td><?php echo $res[0]['model'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">price</th>
                                <td><?php echo $res[0]['price']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">customised tyre size</th>
                                <td><?php echo $res[0]['customised_tyre_size']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">status</th>
                                <td><?php if($res[0]['status']== '1'){?>
                                   <p class='text text-success'>Booked</p> 
                                <?php }else{?>
                                    <p class='text text-info'>Delivered</p> 
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
                        <a href="orders.php" class="btn btn-sm btn-default btn-flat pull-left">Back</a>
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
