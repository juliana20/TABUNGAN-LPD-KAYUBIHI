<!DOCTYPE html>
<html lang="en">
<!-- head -->
@include('themes.gentelella.partials.head')
<style>
    .left_col {
        background: #ffff!important;
        /* border-right: 1px solid #ddd; */
    }
    .nav.child_menu>li>a, .nav.side-menu>li>a {
        color: #000;
    }
    .nav.side-menu>li:hover{
        background: #1a96ef!important;
    }
    .menu_section h3 {
        color: #000!important;
        text-shadow: 1px 1px #fff!important;
    }
    .nav li.current-page {
        background: #1a96ef!important;
    }
    .nav.side-menu>li.active>a {
        background: transparent!important;
    }
    .nav.side-menu>li.current-page>a {
        color: #ffff!important;
    }
    .profile_info span {
        color: #000!important;
    }
    .profile_info h2 {
        color: #000!important;
    }
    .nav.side-menu>li.active, .nav.side-menu>li.current-page {
        border-right: 5px solid #1085bd!important;
    }
    .nav_title {
        background: #fff!important;
        /* border-bottom: 1px solid #D9DEE4!important; */
    }
    .navbar-brand, .navbar-nav>li>a, .site_title {
        color: #000!important;
    }
    .nav_menu {
        background: #fff!important;
    }
    .sidebar-footer {
        background: #fff!important;
    }
    .sidebar-footer a {
        background: #fff!important;
    }
    .sidebar-footer a:hover {
        background: #fff!important;
    }
    .main_container {
        background: #fff!important;
    }
    footer {
        background: #1a96ef!important;
    }
    .nav-md .container.body .col-md-3.left_col {
        min-height: auto!important;
    }
    @media (min-width: 992px)
    {
        footer {
            margin-left: 0px!important;
        }
    }
    .nav-sm .container.body .col-md-3.left_col {
        min-height: auto!important;
    }
       

</style>
<!-- end head -->
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="#" class="site_title" style="font-size: 13px!important;font-weight: 600!important;padding-left: 6px!important"><i class="fa fa-book" aria-hidden="true"></i> <span style="margin-left: 2px">{{ config('app.app_abbreviation') }}</span></a>
                        </div>

                        <div class="clearfix"></div>
                        <!-- menu profile quick info -->
                        {{-- @include('themes.gentelella.partials.menu_profile') --}}
                        <!-- menu profile quick info -->
                        <br />
                        <!-- sidebar menu -->
                        @include('themes.gentelella.partials.sidebar.'.Helpers::getJabatan())
                        {{-- @include('themes.gentelella.partials.sidebar.Admin') --}}
                        <!-- sidebar menu -->

      
                    </div>
                </div>
                <!-- top navigation -->
                @include('themes.gentelella.partials.top_navigation')
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    @yield('bread')
                    @include('themes.gentelella.partials.modal_data_collect')
                    @yield('content')
                    @include('sweet::alert')
                    {{-- @include('notify::messages') --}}
                    <!-- Laravel 7 or greater -->
                    {{-- <x:notify-messages />
                    @notifyJs --}}
                </div>
                <!-- /page content -->

                <!-- footer content -->
                @include('themes.gentelella.partials.footer')
                <!-- /footer content -->

            </div>
        </div>
        <!-- jQuery -->
        @include('themes.gentelella.partials.bottom')
    </body>
</html>