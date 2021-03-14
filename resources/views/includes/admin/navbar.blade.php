		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					

					<a class="btn btn-outline-dark btn-sm lo-btn" style="float: right; position: relative; top: 0.5px; margin-left: 2em; font-size: 1em;"  href="{{ route('logout') }}"
						onclick="event.preventDefault();
										document.getElementById('logout-form').submit();">
						{{ __('Logout') }}
					</a>
		
					<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
						@csrf
					</form>
		
					
				</li>
			</ul>
		</nav>
      <!-- /.navbar -->
    
      <!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href="{{route('revisores.index')}}" class="brand-link">
				<span class="brand-text font-weight-light" >SICRFyM</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					<!-- Add icons to the links using the .nav-icon class
						with font-awesome or any other icon font library -->
{{-- 						<li class="nav-item has-treeview menu-open">
							<a href="#" class="nav-link active">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								<p>
									Algo aquí
									<i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="#" class="nav-link active">
										<i class="far fa-circle nav-icon"></i>
										<p>Puede?</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="#" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>o no?</p>
									</a>
								</li>
							</ul>
						</li> --}}
						<li class="nav-item">
							<a href="{{route('revisores.lista-espera')}}" class="nav-link">
								<i class="nav-icon fa fa-user-plus"></i>
								<p>
									Asistentes en espera.
								</p>
							</a>
						</li>
{{--                         <li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-address-book"></i>
								<p>
									Asistentes inscritos.
								</p>
							</a>
						</li> --}}
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
		<!-- /.sidebar -->
		</aside>