<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
      <nav>
        <div class="nav toggle">
          <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>

        <ul class="nav navbar-nav navbar-right">
          <li class="">
            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <img src="{{ url('themes/AdminLTE-2.4.3/dist/img/user2-160x160.jpg') }}" alt="">{{ Helpers::getNama() }}
              <span class=" fa fa-angle-down"></span>
            </a>
            <ul class="dropdown-menu dropdown-usermenu pull-right">
              <li>
                <a href="" title="Keluar" data-toggle="modal" data-target="#modalLogout" data-id="{{ Helpers::getId() }}">
                  {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ url('logout') }}" method="POST" class="d-none">

                </form>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <!-- /top navigation -->
  <!-- MODAL LOGOUT -->
  @include('modal.header.modal_logout')