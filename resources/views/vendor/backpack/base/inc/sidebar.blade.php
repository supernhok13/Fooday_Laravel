@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="https://placehold.it/160x160/00a65a/ffffff/&text={{ mb_substr(Auth::user()->name, 0, 1) }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">{{ trans('backpack::base.administration') }}</li>
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')."/foods") }}"><i class="fa fa-dashboard"></i> <span>Foods</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')."/food_type") }}"><i class="fa fa-dashboard"></i> <span>Food Type</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')."/customer") }}"><i class="fa fa-dashboard"></i> <span>Customer</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')."/bill") }}"><i class="fa fa-dashboard"></i> <span>Bills</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')."/bill_detail") }}"><i class="fa fa-dashboard"></i> <span>Bill Detail</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')."/menu") }}"><i class="fa fa-dashboard"></i> <span>Menu</span></a></li>

          @role("Member")
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')."/user-read") }}"><i class="fa fa-dashboard"></i> <span>User</span></a></li>
          @endrole

          @hasrole("Admin")
          <!-- Users, Roles Permissions -->
          <li class="treeview">
            <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
            </ul>
          </li>
          @endhasrole
          <!-- ======================================= -->
          <li class="header">{{ trans('backpack::base.user') }}</li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li>

        </ul>

      </section>
      <!-- /.sidebar -->
    </aside>
@endif
