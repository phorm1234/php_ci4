<?php $this->extend('backend/layout/pages_layout') ?>
<?php $this->section('content') ?>
<?php 
// foreach ($select_cust as $customer) {
//     echo '<pre>';
//     echo $customer->customer_code.' : '.$customer->name_tbt;
//     // var_dump('<pre>', $customer->customer_code.' : '.$customer->name_tbt);
// }

// die;
// var_dump('<pre>',$select_reportv_mb);
// die;
?>
      <!-- Modal insert ic -->
       <div
                class="modal fade"
                id="modal_result_insertic"
                tabindex="-1"
                role="dialog"
                aria-labelledby="myLargeModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="icLabel">
                                Large modal
                            </h4>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-hidden="true"
                            >
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3 id="all_rows_excel"></h3>
                            <h3 id="rows_excel"></h3>
                            <h3 id="rows_insert"></h3>                  
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>			
        <!--End Modal -->




         <!-- Modal Update minibea -->
       <div
                class="modal fade"
                id="modal_update_minibea"
                tabindex="-1"
                role="dialog"
                aria-labelledby="myLargeModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="minibeaLabel">
                                UPDATE MINIBEA CUSTOMER
                            </h4>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-hidden="true"
                            >
                                ×
                            </button>
                        </div>
                        <div class="modal-body">
                        <div class="form-group">
								<div class="row">
									<div class="col-md-6 col-sm-12">
										<label class="weight-600">MINIBEA FROM IC</label>
                                        <select
                                                id="select_minibea_ic"
                                                name="select_minibea_ic"
                                                class="form-control"
                                                data-style="btn-outline-primary"
                                                data-size="5"
                                            >
                                        
                                            </select>
									
									</div>
									<div class="col-md-6 col-sm-12">
										<label class="weight-600">CUSTOMER MINIBEA UPDATE(FROM MASTER)</label>
                                        <select
                                                id="select_minibea_customer"
                                                name="select_minibea_customer"
                                                class="selectpicker form-control"
                                                data-style="btn-outline-primary"
                                                data-size="5"
                                            >
                                            <?php 
                                            foreach ($select_custmb as $customer_mb) {
                                                // echo '<pre>';
                                                echo '<option value="'.$customer_mb->customer_code.'">'.$customer_mb->customer_code.' : '.$customer_mb->name_tbt.'</option>';
                                                // var_dump('<pre>', $customer->customer_code.' : '.$customer->name_tbt);
                                            }
                                            
                                            // die;
                                            
                                            ?>
                                            </select>
								
									</div>
								</div>
							</div>              
                        </div>
                        <div class="modal-footer">
                        <button
                                type="button"
                                class="btn btn-success"
                                onclick="update_minibea()"
                            >
                                Update
                            </button>
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>			
        <!--End Modal -->


    <div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Generate Report V</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?= route_to('admin.home') ?>">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
										<a href="<?= route_to('admin.reportv') ?>">Report V</a>
										</li>
									</ol>
								</nav>
							</div>					
						</div>
					</div>
                    <!-- <form action="<?= route_to('gen_reportv') ?>" method="POST" enctype="multipart/form-data"> -->
                    <form id="reportForm" enctype="multipart/form-data">
                        <div class="pd-20 card-box mb-30">
                            <div class="clearfix mb-20">
                                <div class="pull-left">
                                    <h4 class="text-blue h4">Select Month/Year & Put IC File</h4>
                                </div>
                            </div>
                            <div class ="row">
                               <div class="col-md-6 col-sm-6">
                                      <label class="weight-600">SPECIAL CASE</label>
                                                <div class="custom-control custom-checkbox mb-5">
                                                    <input
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="customCheck1"
                                                        name="special_check"
                                                    />
                                                    <label class="custom-control-label" for="customCheck1"
                                                        >Check If don't want delete Current Data in Range Date Data</label
                                                    >
                                                </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                      <label class="weight-600">MINIABEA CASE</label>
                                                <div class="custom-control custom-checkbox mb-5">
                                                <button  onclick="modal_minibea()" type="button" class="btn btn-primary btn-lg btn-block">
                                                Update Minibea </button>
                                                </div>
                                    </div>
                              </div>


                            <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                
                                            <div class="form-group">
                                                    <label>Choose Range of Month/Year</label>
                                                    <input
                                                        class="form-control datetimepicker-range"
                                                        placeholder="Select Month"
                                                        type="text" name="input_date"
                                                    />
                                            </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label>IC File</label>
                                            <div class="custom-file">
                                                <input type="file" name="input_icfile" class="custom-file-input" />
                                                <label class="custom-file-label">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                            
                                    <div class="col-md-12 col-sm-12">
                                       <button id="submitBtn" type="button" class="btn btn-success btn-lg btn-block">
                                        Submit
                                    </div>
                                    
                      
                            </div>
                        </div>
                    </form>

                    <form action="<?= route_to('show_reportv') ?>" method="POST" enctype="multipart/form-data">
                        <div class="pd-20 card-box mb-30">
                            <div class="clearfix mb-20">
                                <div class="pull-left">
                                    <h4 class="text-blue h4">Select Year to Export ReportV</h4>
                                </div>
                            </div>
                            <div class="row">

                                    <div class="col-md-6 col-sm-6">

                                            <div class="form-group">
                                                    <label>Choose Range of Month/Year</label>
                                                    <input
                                                        class="form-control yearpicker"
                                                        placeholder="Select Month"
                                                        type="text" name="input_year"
                                                    />
                                            </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                            <label>Customer Select</label>
                                            <select
                                                name="select_cust"
                                                class="selectpicker form-control"
                                                data-style="btn-outline-primary"
                                                data-size="5"
                                            >
                                            <?php 
                                            foreach ($select_cust as $customer) {
                                                // echo '<pre>';
                                                echo '<option value="'.$customer->customer_code.'">'.$customer->customer_code.' : '.$customer->name_tbt.'</option>';
                                                // var_dump('<pre>', $customer->customer_code.' : '.$customer->name_tbt);
                                            }
                                            
                                            // die;
                                            
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                                <label>Type Document Select</label>
                                                <select
                                                    class="custom-select2 form-control"
                                                    name="state"
                                                    style="width: 100%; height: 38px"
                                                >
                                                    <optgroup label="Type Document">
                                                        <option value="1">Type A</option>
                                                        <option value="2">Type B</option>
                                                        <option value="3">Type C</option>
                                                        <option value="4">Type D</option>
                                                        <option value="5">Type E</option>
                                                    </optgroup>
                                                
                                                </select>
                                            </div>
                                    </div> -->
                                    <div class="col-md-12 col-sm-12">
                                    <button type="submit" class="btn btn-success btn-lg btn-block">
                                        Submit
                                    </div>

                            
                            </div>
                        </div>
                    </form>

                        <div class="pd-20 card-box mb-30" style="display:none">
                            <div class="clearfix mb-20">
                                <div class="pull-left">
                                    <h4 class="text-blue h4">Excel Preview</h4>
                                    <!-- <p>Add class <code>.table</code></p> -->
                                </div>
                         
                                <div id="excelData" style="display: none;" style="width: 800px; height: 600px; overflow: auto;">
                                    <!-- Store the Excel data as JSON -->
                                    <?php if(isset($excelData)) json_encode($excelData); ?>
                                </div>
                                <div id="excelTable" style="width: 800px; height: 600px; overflow: auto;"></div>
                            </div>
                        </div>
                    <div>

                    </div>
				</div>
			</div>
    </div>
    <!-- Year Picker CSS -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  -->
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
        $('#submitBtn').click(function() {
            var formData = new FormData($('#reportForm')[0]);
            $.ajax({
                type: 'POST',
                url: '<?= site_url('gen_reportv') ?>', // Update the URL accordingly
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Handle success response here
                    console.log(response);
                    alert(response.message);
                    $('#icLabel').text('Result Insert IC File');
                    $('#all_rows_excel').text('Excel All Data Rows : '+response.highest_row);
                    $('#rows_excel').text('Excel Rows To be Insert : '+response.count_excel);
                    $('#rows_insert').text('Excel Rows Insert : '+response.count_insert);


                    // $("#modal_result_insertic .modal-body").text('Excel Rows To be Insert : '+response.highest_row+'<br>\
                    // Excel Rows To be Insert : '+response.count_excel+'<br>\
                    // Excel Rows Insert : '+response.count_insert+'\
                    // ');

                    $('#modal_result_insertic').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle error response here
                    console.error(xhr.responseText);
                }
            });
        });


        function modal_minibea() {
            $('#select_minibea_ic').empty();
            $.ajax({
                type: 'POST',
                url: '<?= site_url('get_mb_v') ?>', // Update the URL accordingly
                success: function(response) {
                    // Handle success response here
                    console.log(response);
                    // alert(response.message);
                    // var optionsHtml = '';
                    var selectOption = $('#select_minibea_ic'); 
                    $.each(response.select_reportv_mb, function(index, item) {
                        // alert(item.exp_entry);
                    $('#select_minibea_ic').append($('<option>', {
                            value: item.exp_entry,
                            text: item.customer_code + ' - ' + item.exp_entry
                        }));
                    });
                
                },
                error: function(xhr, status, error) {
                    // Handle error response here
                    console.error(xhr.responseText);
                }
            });
            // $("#select_minibea_ic").removeClass("selectpicker");

            // $("#select_minibea_ic").addClass("selectpicker");
            // $('#select_minibea_ic').selectpicker();

            $('#modal_update_minibea').modal('show');
        }

        function update_minibea() {
            var val_ic = $("#select_minibea_ic").val();
            var val_tbt = $("#select_minibea_customer").val();
            // alert(val_ic);
            // alert(val_tbt);
            $.ajax({
                type: 'POST',
                data: {
                    'minibea_ic': val_ic,
                    'minibea_customer': val_tbt
                },
                url: '<?= site_url('update_mb_v') ?>', // Update the URL accordingly
                success: function(response) {
                    // Handle success response here
                    console.log(response);
                    // alert(response.message);
                    if (response.message == "Data updated successfully.") {
                        Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message
                            });
                    } else {
                        Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error response here
                    console.error(xhr.responseText);
                }
            });
            $('#modal_update_minibea').modal('hide');
        }
        </script>
<?php $this->endSection() ?>