<?php $this->extend('backend/layout/pages_layout') ?>
<?php $this->section('content') ?>
<?php 
// var_dump('<pre>',$cuspart_sale);
// die;

?>
<div class="pd-20 card-box mb-30">
        <form id="reportForm" method="POST" enctype="multipart/form-data">
						<div class="clearfix mb-20">
							<div class="pull-left">
								<h4 class="text-blue h4">NG Part </h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-sm-12">							
									<div class="form-group">
										<label>DATE NG</label>
										<input
                                            id="date_ng"
                                            name="date_ng"
											class="form-control date-picker"
											placeholder="Select Date"
											type="text"
										/>
									</div>						
							</div>
                            <div class="col-md-4 col-sm-12">
										<label class="weight-600">NG PART FROM SALE</label>
                                        <select
                                                id="select_ng_part"
                                                name="select_ng_part"
                                                class=" form-control"
                                                data-style="btn-outline-primary"
                                                data-size="5"
                                            >
                                            <?php 
                                            if(sizeof($cuspart_sale)>0) {
                                                foreach ($cuspart_sale as $cuspart_sale_sub) {
                                                    // echo '<pre>';
                                                    echo '<option value="'.$cuspart_sale_sub['INB_CUSTPART'].'_'.$cuspart_sale_sub['INB_CUSTCODE'].'">'.$cuspart_sale_sub['INB_CUSTCODE'].' : '.$cuspart_sale_sub['INB_CUSTPART'].'</option>';
                                             
                                               }
                                            } else {
                                                echo '<option value="0">None Data</option>';
                                            }    
                                            ?>
                                            <!-- <option value="1">CUSTOMOR_CODE : CUSTOMER_PART</option>
                                            <option value="2">CUSTOMOR_CODE : CUSTOMER_PART</option>
                                            <option value="3">CUSTOMOR_CODE : CUSTOMER_PART</option> -->
                                            </select>							
									</div>
                                <div class="col-md-4 col-sm-12">
                                     <label>NG Quantity</label>
                                    <input
                                        id="ng_quantity"
                                        name="ng_quantity"
                                        class="form-control"
                                        type="text"
                                        placeholder="NG Quantity"
                                    />
                                </div>
                                <div class="col-md-12 col-sm-12">
                                       <button id="submitBtn" type="button" class="btn btn-success btn-lg btn-block">
                                        Submit
                                    </div>
					
						</div>
					</div>
                </form>

    <script src="/backend/vendors/scripts/jquery-3.5.1.js"></script>
    <script src="/backend/vendors/scripts/sweetalert2.js"></script>
    <script>

        $('#submitBtn').click(function() {
            var formData = new FormData($('#reportForm')[0]);
            $.ajax({
                type: 'POST',
                url: '<?= site_url('ng_from_sale') ?>', // Update the URL accordingly
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Handle success response here
                    console.log(response);
                    // alert(response.message);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message
                    });
                    // $('#icLabel').text('Result Insert IC File');
                    // $('#all_rows_excel').text('Excel All Data Rows : '+response.highest_row);
                    // $('#rows_excel').text('Excel Rows To be Insert : '+response.count_excel);
                    // $('#rows_insert').text('Excel Rows Insert : '+response.count_insert);


                    // $("#modal_result_insertic .modal-body").text('Excel Rows To be Insert : '+response.highest_row+'<br>\
                    // Excel Rows To be Insert : '+response.count_excel+'<br>\
                    // Excel Rows Insert : '+response.count_insert+'\
                    // ');

                    // $('#modal_result_insertic').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle error response here
                    console.error(xhr.responseText);
                }
            });
        });


    </script>
<?php $this->endSection() ?>