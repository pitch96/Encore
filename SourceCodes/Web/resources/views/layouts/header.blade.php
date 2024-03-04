<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <div class="user-panel d-flex">
                <div class="image">
                    <img src="{{ Auth::user()->user_profile ? asset('user-images/'.Auth::user()->user_profile) : asset('no-image.png') }}" class="img-circle"
                        alt="User Image">
                </div>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" style="font-size: 20px;"
                aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->first_name }}
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ url('admin/purchase') }}">
                    My Purchases
                </a>
                <a class="dropdown-item" href="{{ url('admin/profile') }}">
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
    </ul>
</nav>
