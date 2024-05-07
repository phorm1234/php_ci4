<?php $this->extend('backend/layout/pages_layout') ?>
<?php $this->section('content') ?>



            <!-- Modal -->
            <div
                class="modal fade"
                id="modal_product"
                tabindex="-1"
                role="dialog"
                aria-labelledby="myLargeModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="productLabel">
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
                            <form>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Product Code</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input
                                            class="form-control"
                                            type="text"
                                            placeholder="0000"
                                            id="input_product_code"
                                        />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Product Group</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input
                                            class="form-control"
                                            placeholder="000000"
                                            type="text"
                                            id="input_product_group"
                                        />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Product Name</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input
                                            class="form-control"
                                            placeholder="Test"
                                            type="text"
                                            id="input_product_name"
                                        />
                                    </div>
                                </div>                       
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button type="button" onclick="saveproduct_modal()" class="btn btn-primary">
                                Save changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>			
            <!-- Modal -->



			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>DataTable</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?= route_to('admin.home') ?>">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Master Product
										</li>
									</ol>
								</nav>
							</div>
					
						</div>
					</div>
					<!-- Simple Datatable start -->
                    <div class="card-box mb-30">
                        <div class="pb-20">
                            <!-- Add Product button -->
                            <div class="text-left mb-3">
                                <button id="btn_add_product" onclick="modal_product(1,0)" class="btn btn-primary">Add Product</button>
                            </div>

                            <table class="data-table table stripe hover nowrap" id="table_master_product">
                                <thead>
                                    <tr>
                                        <th class="table-plus datatable-nosort">Product Code</th>
                                        <th>Product Group</th>
                                        <th>Product Name</th>
                                        <th>Create By</th>
                                        <th>Created date</th>
                                        <!-- <th class="datatable-nosort">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Table body content goes here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

					<!-- Simple Datatable End -->
		
		
	
				</div>
	
			</div>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script src="/backend/vendors/scripts/jquery-3.5.1.js"></script>
<script src="/backend/vendors/scripts/sweetalert2.js"></script>
<script>

        $(document).ready(function() {
            // Check if DataTable instance exists
            // if ($.fn.DataTable.isDataTable('#table_master_product')) {
            //     // Destroy the DataTable instance
            //     datatable_product().Destroy();

            //     // $('#table_master_product').DataTable().clear().destroy();
            // }else {
            //     datatable_product();

            // }
                // Initialize the DataTable

                datatable_product();
        });

        function datatable_product() {
           var product_table = $('#table_master_product').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "<?php echo route_to('master.get_table_masterproduct'); ?>",
                        "type": "POST"
                    },
                    "columns": [
                        { "data": "product_code" },
                        { "data": "product_group" },
                        { "data": "product_name" },
                        { "data": "create_by" },
                        { "data": "created_date" }
                      
                    ],
                    "paging": true, // Enable pagination
                    "pageLength": 10, // Optional: Set the number of records per page
                    "stateSave": true,
                    "destroy":true
                });
        }
        // {
        //                     "data": null,
        //                     "render": function(data, type, row) {
        //                         var productCode = row.product_code;

        //                         return '<div class="dropdown" style="display:none"> \
        //                                     <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown"> \
        //                                         <i class="dw dw-more"></i> \
        //                                     </a> \
        //                                     <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list "> \
        //                                         <a style="display:none" class="dropdown-item" onclick="modal_product(2,'+productCode+')"><i class="dw dw-edit2"></i> Edit</a> \
        //                                         <a class="dropdown-item" onclick="modal_product(3,'+productCode+')"><i class="dw dw-delete-3"></i> Delete</a> \
        //                                     </div> \
        //                                 </div>';
        //                     }
        //                 }
        //temp for save with modal
        var type_temp;
        var id_temp;
        function modal_product(type,id) { //type 1 = insert , 2 = edit , 3 = delete
            //when click storage type and id
            type_temp = type;
            id_temp = id;

           let input_productcode = document.getElementById("input_product_code");
           let input_productgroup = document.getElementById("input_product_group");
           let input_productname = document.getElementById("input_product_name");


            if(type == 1) {
                $('#productLabel').html('Master Product : Insert');

                input_productcode.value='';
                input_productgroup.value='';
                input_productname.value='';
                $('#modal_product').modal('show');
            }else if (type == 2) {
                $('#productLabel').html('Master Product : Edit');

                $.ajax({
                url: "<?php echo base_url('getproductbyid'); ?>",
                type: 'POST',
                data: {
                    'product_id': id
                },
                success: function(response) {
                    $.each(response, function (key, productdata){

                        input_productcode.value=productdata.product_code;
                        input_productgroup.value=productdata.product_group;
                        input_productname.value=productdata.product_name;
                        // $('#input_product_code').val(productdata.product_code);
                        // $('#input_product_group').val(productdata.product_group);
                        // $('#input_product_name').val(productdata.product_name);
                        // alert(productdata['product_name']);
                    });
                    // Handle success
                    $('#modal_product').modal('show');
                },
                error: function(xhr, status, error) {
                    alert('fail error');
                    // Handle error
                }
            });
            } else if (type == 3) {
                $('#productLabel').html('Master Product : Delete');

                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this product!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Perform delete action
                        deleteProduct(id);
                    }
                });



            }

       

           
        }

        function deleteProduct(productCode) {
            // alert(productCode);
            $.ajax({
                url: "<?php echo base_url('delete_product'); ?>",
                type: 'POST',
                data: {
                    'product_code': productCode
                },
                success: function(response) {
                    // Handle success
                    Swal.fire({
                        title: 'Deleted!',
                        text: response.message,
                        icon: 'success'
                    });
                    $('#table_master_product').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete product.',
                        icon: 'error'
                    });
                }
            });
        }

        function saveproduct_modal() {
   
           let input_productcode = document.getElementById("input_product_code");
           let input_productgroup = document.getElementById("input_product_group");
           let input_productname = document.getElementById("input_product_name");
           let icon_sweet;
           let icon_title;

            if (type_temp == 1) {
                // Insert operation
                $.ajax({
                    url: "<?php echo base_url('insertproduct'); ?>",
                    type: 'POST',
                    data: {
                        'product_code': input_productcode.value,
                        'product_group': input_productgroup.value,
                        'product_name': input_productname.value
                    },
                    success: function(response) {
                        // Handle success
                        if (response.status_message==0) {
                            // icon_sweet='error';
                            // icon_title='Oops...';
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        } else if (response.status_message==1) {
                            // icon_sweet='success';
                            // icon_title='Success!';
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message
                            }).then((result) => {
                                // Reload the data table or do any other action
                                $('#table_master_product').DataTable().ajax.reload();
                                $('#modal_product').modal('hide');
                            });
                        } else if (response.status_message==2) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        }
                        // alert(response.error);
                        // alert('Product inserted successfully!');
                        $('#table_master_product').DataTable().ajax.reload();
                        $('#modal_product').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        // alert(response.error);
                        // alert('Failed to insert product.');
                    }
                });
            } else if (type_temp == 2) {
                // input_productcode.readOnly = true;
                // Update operation
                $.ajax({
                    url: "<?php echo base_url('updateproduct'); ?>",
                    type: 'POST',
                    data: {
                        'product_code': input_productcode.value,
                        'product_group': input_productgroup.value,
                        'product_name': input_productname.value
                    },
                    success: function(response) {
                        // Handle success
                        // if (response.status_message==0) {
                        //     icon_sweet='error';
                        //     icon_title='Oops...';
                        // } else if (response.status_message==1) {
                        //     icon_sweet='success';
                        //     icon_title='Success!';
                        // } else if (response.status_message==2) {
                        //     icon_sweet='error';
                        //     icon_title='Oops...';
                        // }
                        // alert(response.message);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message
                        }).then((result) => {
                            // Reload the data table or do any other action
                            $('#table_master_product').DataTable().ajax.reload();
                            $('#modal_product').modal('hide');
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        alert('Failed to update product.');
                    }
                });
            }



        }

    </script>

<?php $this->endSection() ?>