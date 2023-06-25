<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
<div class="app-brand demo">
	<a href="/admin/dashboard" class="app-brand-link">
	<span class="app-brand-logo demo">
	</span>
	<span class="app-brand-text demo menu-text fw-bolder ms-2">Museum</span>
	</a>
	<a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none"><i class="bx bx-chevron-left bx-sm align-middle"></i></a>
</div>
<div class="menu-inner-shadow"></div>
<ul class="menu-inner py-1">
	<!-- Dashboard -->
	<li class="menu-item {{ (request()->is('admin/dashboard*')) ? 'active' : '' }}">
		<a href="/admin/dashboard" class="menu-link">
		<i class="menu-icon tf-icons bx bx-home-circle"></i>
		<div data-i18n="Analytics">Dashboard</div>
		</a>
	</li>
	<!-- Components -->
	<li class="menu-header small text-uppercase">
		<span class="menu-header-text">Master</span>
	</li>
	<!-- Cards -->
	{{-- <li class="menu-item {{ (request()->is('admin/jenis-museum*')) ? 'active' : '' }}">
		<a href="/admin/jenis-museum" class="menu-link">
		<i class="menu-icon tf-icons bx bx-disc"></i>
		<div data-i18n="Basic">Jenis Museum</div>
		</a>
	</li> --}}
	<li class="menu-item {{ (request()->is('admin/museum*') || request()->is('admin/museum/*')) ? 'active' : '' }}">
		<a href="/admin/museum" class="menu-link">
		<i class="menu-icon tf-icons bx bx-arch"></i>
		<div data-i18n="Basic">Museum</div>
		</a>
	</li>
	<!-- User interface -->
</ul>
</aside>
<!-- / Menu -->