<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <span class="brand-link">
       <a href="{{ url('/') }}"> <img src="{{ asset('assets/dist/img/brand_logo.png') }}" alt="5Star" class="brand-image"></a>
        <img src="{{ asset('assets/dist/img/mobile-logo.png') }}" alt="5Star" class="mobile-logo">
    </span>
    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            {{ Auth::user()->user_type === config('constants.ADMIN_TYPE') ? 'Admin' : 'Promoter' }} Dashboard
                        </p>
                    </a>
                </li>

                {{-- Start Users Menu --}}
                @if (Auth::user()->user_type === config('constants.ADMIN_TYPE'))
                    <li class="nav-item toggle-menu" data-value="0">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('admin/manage/users') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Manage Users</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('admin/manage/promoters') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Manage Promoters</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                {{-- End Users Menu --}}

                {{-- Start Category Menu --}}
                @if (Auth::user()->user_type === config('constants.ADMIN_TYPE'))
                    <li class="nav-item toggle-menu" data-value="0">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-list-alt" aria-hidden="true"></i>
                            <p>
                                Category
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('admin/create/category') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/manage/categories') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Manage Categories</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item toggle-menu" data-value="0">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-dollar" aria-hidden="true"></i>
                            <p>
                                Event Charge
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('admin/update/charge') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Update Charge</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                {{-- End Category Menu --}}

                {{-- Start Events Menu --}}
                <li class="nav-item toggle-menu" data-value="0">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-calendar" aria-hidden="true"></i>
                        <p>
                            Events
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/create/event') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Event</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/manage/events') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>My Events</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/mycancelled/events') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>My Cancelled Events</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- End Events Menu --}}

                <li class="nav-item toggle-menu" data-value="0">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-info-circle" aria-hidden="true"></i>
                        <p>
                            Event Details
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/event/details') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Events</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Start Tickets Menu --}}
                <li class="nav-item toggle-menu" data-value="0">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-ticket" aria-hidden="true"></i>
                        <p>
                            Tickets
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/create/ticket') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Ticket</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/manage/tickets') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Tickets</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- End Tickets Menu --}}

                {{-- Start Promotion Menu --}}
                @if (Auth::user()->user_type === config('constants.ADMIN_TYPE'))
                    <li class="nav-item toggle-menu" data-value="0">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-bullhorn" aria-hidden="true"></i>
                            <p>
                                Promotional Event
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('admin/promotion/list') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Promotional Events</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/admin/cancelled/event/list') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Refund Requests</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item toggle-menu" data-value="0">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-rocket" aria-hidden="true"></i>
                            <p>
                                Subscribed Users
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('admin/subscribed/users/list') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Subscribed Users List</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item toggle-menu" data-value="0">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-cog" aria-hidden="true"></i>
                            <p>
                                Settings
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('admin/banner/images') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Manage Banner Images</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/add/banner') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Banner</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('admin/transfer/payments') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Transfer Payments</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                {{-- End Promotion Menu --}}

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        <div class="logout">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('admin/logout') }}" class="nav-link">
                        <i class="nav-icon fa fa-sign-out mr-2"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
