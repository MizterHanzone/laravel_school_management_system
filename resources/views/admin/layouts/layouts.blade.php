<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />

    @yield('style')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Hi! {{ Auth::user()->name }} {{Auth::user()->last_name}}</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <span class="brand-text font-weight-light">Admin Panel</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.list') }}"
                                class="nav-link {{ request()->routeIs('admin.list') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Admin List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.change.password') }}"
                                class="nav-link {{ request()->routeIs('admin.change.password') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-key"></i>
                                <p>Change password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('academic_year.index') }}"
                                class="nav-link {{ request()->routeIs('academic_year.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Academic Year</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('class.index') }}"
                                class="nav-link {{ request()->routeIs('class.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Class</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('subject.index') }}"
                                class="nav-link {{ request()->routeIs('subject.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book-open"></i>
                                <p>Subject</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('assign_subject_to_class.index') }}"
                                class="nav-link {{ request()->routeIs('assign_subject_to_class.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>Assign Subject</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('assign.classe.to.teacher') }}"
                                class="nav-link {{ request()->routeIs('assign.classe.to.teacher') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>Assign Class</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student.attendance.index') }}"
                                class="nav-link {{ request()->routeIs('student.attendance.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar-check"></i>
                                <p>Attendance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('time.table.index') }}"
                                class="nav-link {{ request()->routeIs('time.table.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar-check"></i>
                                <p>Schedule Study</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('examination.index') }}"
                                class="nav-link {{ request()->routeIs('examination.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-check"></i>
                                <p>Exam Name</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('exam.schedule.index') }}"
                                class="nav-link {{ request()->routeIs('exam.schedule.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Exam Schedules</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register.mark.index') }}"
                                class="nav-link {{ request()->routeIs('register.mark.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>Mark</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student.index') }}"
                                class="nav-link {{ request()->routeIs('student.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>Student</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('parent.index') }}"
                                class="nav-link {{ request()->routeIs('parent.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>Parent</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('teacher.index') }}"
                                class="nav-link {{ request()->routeIs('teacher.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                <p>Teacher</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->

        @yield('content')

        <!-- Footer -->
        <footer class="main-footer">
            <strong>&copy; {{ date('Y') }} Admin Panel.</strong> All rights reserved.
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    @yield('script')
</body>

</html>
