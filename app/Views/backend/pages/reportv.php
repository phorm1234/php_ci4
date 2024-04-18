<?php $this->extend('backend/layout/pages_layout') ?>
<?php $this->section('content') ?>
<?php 
// foreach ($select_cust as $customer) {
//     echo '<pre>';
//     echo $customer->customer_code.' : '.$customer->name_tbt;
//     // var_dump('<pre>', $customer->customer_code.' : '.$customer->name_tbt);
// }

// die;



?>
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
                    <form action="<?= route_to('gen_reportv') ?>" method="POST" enctype="multipart/form-data">
                        <div class="pd-20 card-box mb-30">
                            <div class="clearfix mb-20">
                                <div class="pull-left">
                                    <h4 class="text-blue h4">Select Month/Year & Put IC File</h4>
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
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <!-- Include SheetJS library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
        $(".yearpicker").yearpicker({
            year: 2021,
            startYear: 2019,
            endYear: 2050,
        });
        });
        // Retrieve Excel data from the hidden div
        var excelDataJson = document.getElementById('excelData').textContent;
        var excelData = JSON.parse(excelDataJson);

        // Convert Excel data to HTML table using SheetJS
        var worksheet = XLSX.utils.aoa_to_sheet(excelData);
        var excelTable = XLSX.utils.sheet_to_html(worksheet);

        // Display HTML table on the page
        document.getElementById('excelTable').innerHTML = excelTable;
        </script>
<?php $this->endSection() ?>