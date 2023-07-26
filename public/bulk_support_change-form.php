<?php
include_once('includes/crud.php');
$db = new Database();
$db->connect();
$db->sql("SET NAMES 'utf8'");
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>

<section class="content-header">
    <h1>Bulk Upload<small></small></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border"></div>
                <form method="post" id="add_form" action="public/db-operation.php" enctype="multipart/form-data">
                    <input type="hidden" id="bulk_suppoort_change" name="bulk_suppoort_change" required="" value="1" aria-required="true">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">CSV File</label>
                            <input type="file" name="upload_file" class="form-control" accept=".csv" />
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" id="submit_btn" name="btnAdd">Upload</button>
                    </div>
                    <div class="form-group">
                        <div id="result" style="display: none;"></div>
                    </div>
                    <input type="hidden" name="type1" id="type1" value="" />
                </form>
            </div>
        </div>
        <div class="separator"></div>
    </div>
</section>



<script>
    $('#add_form').validate({
        rules: {
            upload_file: "required",
            type: "required"
        }
    });

    $('#add_form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        if ($("#add_form").validate().form()) {
            if (confirm('Are you sure? Want to upload')) {
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    beforeSend: function() {
                        $('#submit_btn').html('Please wait..').attr('disabled', 'true');
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        $('#result').html(result);
                        $('#result').show().delay(6000).fadeOut();
                        $('#submit_btn').html('Upload').removeAttr('disabled');
                        $('#add_form')[0].reset();
                    }
                });
            }
        }
    });
</script>
