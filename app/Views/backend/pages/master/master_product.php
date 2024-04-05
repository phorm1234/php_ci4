<?php $this->extend('backend/layout/pages_layout') ?>
<?php $this->section('content') ?>


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
							<table class="data-table table stripe hover nowrap" id="table_master_product">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">Product Code</th>
										<th>Product Group</th>
										<th>Product Name</th>
										<th>Create By</th>
										<th>Create Date</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
									<!-- <tr>
										<td class="table-plus">Gloria F. Mead</td>
										<td>25</td>
										<td>Sagittarius</td>
										<td>2829 Trainer Avenue Peoria, IL 61602</td>
										<td>29-03-2018</td>
										<td>
											<div class="dropdown">
												<a
													class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
													href="#"
													role="button"
													data-toggle="dropdown"
												>
													<i class="dw dw-more"></i>
												</a>
												<div
													class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
												>
													<a class="dropdown-item" href="#"
														><i class="dw dw-eye"></i> View</a
													>
													<a class="dropdown-item" href="#"
														><i class="dw dw-edit2"></i> Edit</a
													>
													<a class="dropdown-item" href="#"
														><i class="dw dw-delete-3"></i> Delete</a
													>
												</div>
											</div>
										</td>
									</tr>							 -->
								</tbody>
							</table>
						</div>
					</div>
					<!-- Simple Datatable End -->
		
		
	
				</div>
	
			</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

        $(document).ready(function() {
            $('#table_master_product').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo route_to('admin.master.get_table_masterproduct'); ?>",
                    "type": "POST"
                },
                "columns": [
                    { "data": "product_code" },
                    { "data": "product_name" },
                    { "data": "create_by" },
                    { "data": "create_date" },
                    {
                        "data": null,
                    "render": function(data, type, row) {
                        return '<div class="dropdown"> \
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown"> \
                                            <i class="dw dw-more"></i> \
                                        </a> \
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"> \
                                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a> \
                                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a> \
                                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a> \
                                        </div> \
                                    </div>';
                        }
                    }
                ]
            });
        });
</script>
    </script>

<?php $this->endSection() ?>