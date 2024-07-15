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
                            </form>
                  
						</div>
                   
					</div>
                    <div class="pd-20 card-box mb-30">
                    <div class="clearfix mb-20">
							<div class="pull-left">
								<h4 class="text-blue h4">NG Table</h4>
								<!-- <p>Add class <code>.table</code></p> -->
							</div>
                        </div>
                        <div class="row">
							<div class="col-md-3 col-sm-12">							
									<div class="form-group" >
										<label>DATE NG</label>
										<input
                                            id="search_date_ng_table"
                                            name="search_date_ng_table"
											class="form-control month-picker"
											placeholder="Select Date"
											type="text"
                                        
										/>
									</div>						
							</div>
                            <div class="col-md-3 col-sm-12">
										<label class="weight-600">NG CUST&PART FROM SALE</label>
                                        <select
                                                id="select_ng_cust_table"
                                                name="select_ng_cust_table"
                                                class=" form-control"
                                                data-style="btn-outline-primary"
                                                data-size="5"
                                            >
                                            <?php 
                                               if(sizeof($cuspart_sale)>0) {
                                                echo '<option value="all" selected>All Part</option>';
                                                foreach ($cuspart_sale as $cuspart_sale_sub) {
                                                    // echo '<pre>';
                                                    echo '<option value="'.$cuspart_sale_sub['INB_CUSTPART'].'_'.$cuspart_sale_sub['INB_CUSTCODE'].'">'.$cuspart_sale_sub['INB_CUSTCODE'].' : '.$cuspart_sale_sub['INB_CUSTPART'].'</option>';
                                             
                                               }
                                            } else {
                                                echo '<option value="0">None Data</option>';
                                            }    
                                            // if(sizeof($cust_sale)>0) {
                                            //     echo '<option value="all" selected>All Customer</option>';
                                            //     foreach ($cust_sale as $cust_sale_sub) {
                                            //         // echo '<pre>';
                                            //         echo '<option value="'.$cust_sale_sub['INB_CUSTCODE'].'">'.$cust_sale_sub['INB_CUSTCODE'].'</option>';
                                             
                                            //    }
                                            // } else {
                                            //     echo '<option value="0">None Data</option>';
                                            // }    
                                            ?>                                 
                                            </select>							
                                </div>
                            <div class="col-md-3 col-sm-12">
										<label class="weight-600"></label>
                                        <button onclick="fetchData()" type="button" class="btn btn-primary">Search</button>

                                </div>
                                <!-- <div class="col-md-3 col-sm-12 ">
                                    <button type="button" class="btn btn-primary">Search</button>
                                </div> -->
						</div>
                            <table class="table" id="ng_table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">NG Date</th>
                                        <th scope="col">NG Customer</th>
                                        <th scope="col">NG Part</th>
                                        <th scope="col">NG Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr>
                                        <th scope="row">1</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                        <td><span class="badge badge-primary">Primary</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Jacob</td>
                                        <td>Thornton</td>
                                        <td>@fat</td>
                                        <td><span class="badge badge-secondary">Secondary</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Larry</td>
                                        <td>the Bird</td>
                                        <td>@twitter</td>
                                        <td><span class="badge badge-success">Success</span></td>
                                    </tr> -->
                                </tbody>
                            </table>
                </div>



    <script src="/backend/vendors/scripts/jquery-3.5.1.js"></script>
    <script src="/backend/vendors/scripts/sweetalert2.js"></script>
    <script>

$(document).ready(function(){

        

            // Get the current date
            // var currentDate = new Date();
            // // Get the current month (zero-based index, so January is 0)
            // var currentMonth = currentDate.getMonth() + 1; // Adding 1 to get 1-based index
            // // Format the current month as MM/YYYY
            // var formattedMonth = ('0' + currentMonth).slice(-2) + '/' + currentDate.getFullYear();
            // // Set the input value to the current month     
            // Trigger initial data load
            fetchData();
        });
        // $('#search_date_ng_table').val('firstinit');
            $(document).on('change', '#search_date_ng_table,#select_ng_cust_table', function(){
        
                fetchData();
            });

        function fetchData(){
                var date = $('#search_date_ng_table').val();
                // var part = $('#select_ng_part_table').val();
                var cust = $('#select_ng_cust_table').val();
            
                        $.ajax({
                        url: '<?= site_url('searchngtable') ?>',
                        type: 'POST',
                        data: {date: date,  cust: cust},
                        dataType: 'json',
                        success: function(response){
                            $('#ng_table tbody').empty(); // Clear table body
                            $.each(response, function(index, data){
                                // Append data to the table
                                $('#ng_table tbody').append(
                                    '<tr>' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td>' + data.ng_date + '</td>' +
                                    '<td>' + data.ng_customer + '</td>' +
                                    '<td>' + data.ng_part + '</td>' +
                                    '<td>' + data.ng_quantity + '</td>' +
                                    '</tr>'
                                );
                            });
                        },
                        error: function(xhr, status, error){
                            console.error(xhr.responseText);
                        }
                    });
                
          
            }

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