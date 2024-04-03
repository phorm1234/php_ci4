<?php $this->extend('backend/layout/pages_layout') ?>
<?php $this->section('content') ?>
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
					<div class="pd-20 card-box mb-30">
						<div class="clearfix mb-20">
							<div class="pull-left">
								<h4 class="text-blue h4">Select Month/Year & Put IC File</h4>
							</div>
						</div>
						<div class="row">

                                <div class="col-md-6 col-sm-6">
                                <form action="<?= route_to('admin.reportv.genv') ?>" method="POST">

                                        <div class="form-group">
                                                <label>Choose Month/Year</label>
                                                <input
                                                    class="form-control month-picker"
                                                    placeholder="Select Month/Year"
                                                    type="text" name="input_ym"
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

                            </form>
						</div>
					</div>
				</div>
			</div>
    </div>
<?php $this->endSection() ?>