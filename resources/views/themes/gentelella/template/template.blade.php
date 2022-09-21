<!DOCTYPE html>
<html lang="en">
<!-- head -->
@include('themes.gentelella.partials.head')
<!-- end head -->
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="#" class="site_title" style="font-size: 20px!important;"><i class="fa fa-book" aria-hidden="true"></i> <span style="margin-left: 10px">{{ config('app.app_abbreviation') }}</span></a>
                        </div>

                        <div class="clearfix"></div>
                        <!-- menu profile quick info -->
                        @include('themes.gentelella.partials.menu_profile')
                        <!-- menu profile quick info -->
                        <br />
                        <!-- sidebar menu -->
                        {{-- @include('themes.gentelella.partials.sidebar.'.Helpers::getJabatan()) --}}
                        @include('themes.gentelella.partials.sidebar.Admin')
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