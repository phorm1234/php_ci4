<div class="left-side-bar">
			<div class="brand-logo">
				<a href="index.html">
					<img src="/backend/vendors/images/deskapp-logo.svg" alt="" class="dark-logo" />
					<img
						src="/backend/vendors/images/deskapp-logo-white.svg"
						alt=""
						class="light-logo"
					/>
				</a>
				<div class="close-sidebar" data-toggle="left-sidebar-close">
					<i class="ion-close-round"></i>
				</div>
			</div>
			<div class="menu-block customscroll">
				<div class="sidebar-menu">
					<ul id="accordion-menu">
						<li class="dropdown">
							<a href="<?= route_to('admin.home') ?>" class="dropdown-toggle  no-arrow">
								<span class="micon bi bi-house"></span
								><span class="mtext">Home</span>
							</a>
							<!-- <ul class="submenu">
								<li><a href="index.html">Dashboard style 1</a></li>
								<li><a href="index2.html">Dashboard style 2</a></li>
								<li><a href="index3.html">Dashboard style 3</a></li>
							</ul> -->
						</li>				
						<li>
							<a href="<?= route_to('admin.reportv') ?>" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-receipt-cutoff"></span
								><span class="mtext">Report V</span>
							</a>
						</li>
						<li>
							<div class="dropdown-divider"></div>
						</li>
						<li>
							<div class="sidebar-small-cap">Extra</div>
						</li>
						<li>
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon bi bi-server"></span
								><span class="mtext">Master</span>
							</a>
							<ul class="submenu">
								<li><a href="introduction.html">TBT Group Name</a></li>
								<!-- <li><a href="getting-started.html">Getting Started</a></li>
								<li><a href="color-settings.html">Color Settings</a></li>
								<li>
									<a href="third-party-plugins.html">Third Party Plugins</a>
								</li> -->
							</ul>
						</li>
				
					</ul>
				</div>
			</div>
		</div>