<?php $this->extend('backend/layout/pages_layout') ?>
<?php $this->section('content') ?>
<!-- ------ Page content here ------ -->

<!-- New section for importing balance stock -->
<form id="importForm" enctype="multipart/form-data">
    <div class="pd-20 card-box mb-30">
        <div class="clearfix mb-20">
            <div class="pull-left">
                <h4 class="text-blue h4">Select Year to Import Balance Stock</h4>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6 col-sm-6">

                <div class="form-group">
                    <label>Choose Range of Month/Year</label>
                    <input class="form-control yearpicker" id="input_year" placeholder="Select Month" type="text"
                        name="input_year" />
                </div>
            </div>
            <!-- 
        <div class="col-md-12 col-sm-12">
            <button type="submit" class="btn btn-success btn-lg btn-block">
                Submit
        </div> -->
            <div class="col-md-6 col-sm-6">
                <div class="import-section">
                    <h2>Import Balance Stock</h2>

                    <div class="form-group">
                        <label for="excelFile">Upload Excel File:</label>
                        <input type="file" id="excelFile" name="excel_file" accept=".xlsx, .xls" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Import</button>
                    <div id="importResult"></div>
                </div>
            </div>

        </div>
    </div>
</form>

<script src="/backend/vendors/scripts/jquery-3.5.1.js"></script>
<script src="/backend/vendors/scripts/sweetalert2.js"></script>
<script>
$(document).ready(function() {
    // $('#select_minibea_customer').selectpicker();

    $(".yearpicker").yearpicker({
        year: 2024,
        startYear: 2019,
        endYear: 2050,
    });
});
$('#importForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: '<?= base_url("reportv/importBalanceStock") ?>',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#importResult').html('<div class="alert alert-success">' + response.message +
                '</div>');
        },
        error: function(xhr, status, error) {
            $('#importResult').html('<div class="alert alert-danger">' + xhr.responseText +
                '</div>');
        }
    });
});
</script>
<?php $this->endSection() ?>