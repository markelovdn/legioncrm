<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.parts.styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            @include('layouts.parts.navbar')

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/" class="brand-link">
{{--                <img src="{{asset("/storage/images/logo.png")}}" alt="LegionCRM Logo" class="brand-image">--}}
{{--                <span class="brand-text font-weight-light">LEGIONCRM</span>--}}
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                @guest

                    <!-- Authentication Links -->
                @if (Route::has('login'))
                        @include('left-menu.register')

                    @endif

                    @else
                        @include('layouts.parts.left-sidebar')

                <!-- /.sidebar-menu -->
                @endguest
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
        <!-- Main content -->
        @yield('content')
        <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">

        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">

            <!-- Control sidebar content goes here -->

                <div class="p-3 control-sidebar-content">
                    <form method="GET" action="/competitors">
                        <input class="form-control" style="display: none"  name="competition_id" type="text" value="">
                        <h6>Возрастная категория</h6>

                        <div class="d-flex">
                            <select class="custom-select mb-3 text-light border-0 bg-white" name="agecategory_id">
                                <option value="">Все</option>

                                        <option value="{}" f></option>

                            </select>
                        </div>

                            <h6>Весовая категория</h6>
                            <div class="d-flex">
                                <select class="custom-select mb-3 text-light border-0 bg-white" name="weightcategory_id">
                                    <option value="">Все</option>

                                        <option value=""></option>

                                </select>
                            </div>

                        <h6>Тренер</h6>
                        <div class="d-flex">
                            <select class="custom-select mb-3 text-light border-0 bg-white" name="coach_id">
                                <option value="">Все</option>

                                    <option value=""></option>

                            </select>

                        </div>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-info">Выбрать</button>
                        </div>
                    </form>
                </div>

        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
@include('layouts.parts.scripts')
</body>
</html>
