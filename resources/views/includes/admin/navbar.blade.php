		<!-- Navbar Superior (Limpia, Ligera y sin botones recargados) -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom" style="background-color: #ffffff; padding: 0.6rem 1.25rem;">
			<!-- Left navbar links -->
			<ul class="navbar-nav align-items-center">
				<li class="nav-item">
					<a class="nav-link text-secondary pl-0 pr-3" data-widget="pushmenu" href="#" role="button" title="Ocultar/Mostrar menú">
						<i class="fas fa-bars"></i>
					</a>
				</li>
				<li class="nav-item">
					<span class="font-weight-bold text-dark" style="font-size: 1rem; letter-spacing: 0.2px;">
						SICREFyM <span class="text-muted font-weight-normal" style="font-size: 0.9rem;">| Panel de Administración</span>
					</span>
				</li>
			</ul>

			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto align-items-center">
				<li class="nav-item">
					<div class="d-flex align-items-center">
						<span class="text-secondary mr-3 d-none d-sm-inline" style="font-size: 0.88rem;">
							<strong class="text-dark">{{ auth('revisor')->user()->nombre ?? 'Administrador' }} {{ auth('revisor')->user()->apellido_paterno ?? '' }}</strong>
							<span class="text-muted ml-1">({{ auth('revisor')->user()->rol ?? 'Revisor' }})</span>
						</span>
						<a class="btn btn-outline-secondary btn-sm" href="{{ route('logout') }}"
							onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
							title="Cerrar sesión">
							<i class="fas fa-sign-out-alt mr-1"></i> Cerrar Sesión
						</a>
						<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
							@csrf
						</form>
					</div>
				</li>
			</ul>
		</nav>
		<!-- /.navbar -->
    
		<!-- Main Sidebar Container (Fondo gris oscuro #343a40 clásico, sin iconografía y sin colores saturados) -->
		<aside class="main-sidebar sidebar-dark-primary elevation-2" style="background-color: #343a40;">
			<!-- Brand Logo -->
			<a href="{{ route('revisores.index') }}" class="brand-link" style="border-bottom: 1px solid #4b545c; background-color: #2c3136; padding: 12px 16px;">
				<img src="/img/icono-uni.ico" alt="Logo UNISON" class="brand-image img-circle" style="opacity: .95; max-height: 28px;">
				<span class="brand-text font-weight-bold text-white ml-2" style="font-size: 1.05rem; letter-spacing: 0.5px;">SICREFyM 2026</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar px-2 pt-2">
				<!-- Menú Lateral limpio, estilizado y sin iconografía ni colores chillones -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						
						<li class="nav-item mb-1">
							<a href="{{ route('revisores.index') }}" id="tab-dashboard" class="nav-link {{ request()->routeIs('revisores.index') ? 'active' : '' }}">
								<p>Panel General</p>
							</a>
						</li>

						<li class="nav-item mb-1">
							<a href="{{ route('revisores.lista-espera') }}" id="tab-lista-espera" class="nav-link {{ request()->routeIs('revisores.lista-espera') || request()->routeIs('validaciones.*') ? 'active' : '' }}">
								<p>
									En Espera de Revisión
									@if(($conteoEsperaGlobal ?? 0) > 0)
										<span class="badge badge-secondary right font-weight-bold ml-2">{{ $conteoEsperaGlobal }}</span>
									@endif
								</p>
							</a>
						</li>

						<li class="nav-item mb-1">
							<a href="{{ route('revisores.lista-inscritos') }}" id="tab-lista-inscritos" class="nav-link {{ request()->routeIs('revisores.lista-inscritos') ? 'active' : '' }}">
								<p>Inscritos con Folio</p>
							</a>
						</li>

						<li class="nav-item mb-1">
							<a href="{{ route('revisores.lista-asistentes') }}" id="tab-lista-asistentes" class="nav-link {{ request()->routeIs('revisores.lista-asistentes') ? 'active' : '' }}">
								<p>Directorio de Asistentes</p>
							</a>
						</li>

						<li class="nav-item mb-1">
							<a href="{{ route('revisores.crear-asistente') }}" id="tab-crear-asistente" class="nav-link {{ request()->routeIs('revisores.crear-asistente') ? 'active' : '' }}">
								<p>Inscripción Manual</p>
							</a>
						</li>

						<li class="nav-header text-muted border-top mt-3 pt-2" style="border-top: 1px solid rgba(255,255,255,0.08) !important; font-size: 0.72rem; letter-spacing: 0.5px;">
							ACCESOS EXTERNOS
						</li>

						<li class="nav-item mb-1">
							<a href="{{ url('/') }}" target="_blank" class="nav-link">
								<p>Portal de Aspirantes</p>
							</a>
						</li>

					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
		<!-- /.sidebar -->
		</aside>