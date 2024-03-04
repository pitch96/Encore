<nav class="nav">
    <div class="container">
        <div id="nav-wrapper">
            <div class="nav-left">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('frontend/images/logo.png') }}" alt="logo" class="img-fluid">
                </a>
            </div>
            <div class="nav-right">
                <ul>
                    @if (!Auth::user())
                        <li>
                            <a href="{{ url('login') }}" class="text-decoration-none">
                                <button class="btn-grad" role="button"><i class="fas fa-phone-volume"
                                        aria-hidden="true"></i> Login / Sign Up</button>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <div class="user-panel d-flex">
                                <div class="image">
                                    <img src="{{ Auth::user()->user_profile ? asset('user-images/' . Auth::user()->user_profile) : asset('no-image.png') }}"
                                        class="img-circle elevation-2" alt="User Image">
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="dropdownMenuButton" class="nav-link dropdown-toggle dropdownMenuSize" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->first_name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" id="user_menu_subparent"
                                aria-labelledby="dropdownMenuButton">
                                
                                @if(Auth::user()->user_type === config('constants.ADMIN_TYPE') || Auth::user()->user_type === config('constants.PROMOTER_TYPE'))
                                <a class="dropdown-item" href="{{ url('admin/purchase') }}">
                                    My Purchases
                                </a>
                                @endif
                                <a class="dropdown-item" href="@if(Auth::user()->user_type === config('constants.ADMIN_TYPE') || Auth::user()->user_type === config('constants.PROMOTER_TYPE')){{ url('admin/profile') }} @else {{ url('account') }} @endif">
                                    My Account
                                </a>
                                <a class="dropdown-item" href="{{ url('checkout') }}">
                                    My Cart
                                </a>
                                <a class="dropdown-item" href="{{ url('logout') }}">
                                    {{ __('Logout') }}
                                </a>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>
