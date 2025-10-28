<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="max-age=604800" />
    <title>Jhyal | One of the Biggest Online Shopping Platform</title>

    <!-- Favicon -->
    <link href="{{ asset('favicon.ico') }}" rel="shortcut icon" type="image/x-icon">

    <!-- jQuery -->
    <script src="{{ asset('js/jquery-2.0.0.min.js') }}" type="text/javascript"></script>

    <!-- Bootstrap4 files-->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Font awesome 5 -->
    <link href="{{ asset('fonts/fontawesome/css/all.min.css') }}" type="text/css" rel="stylesheet">

    <!-- Custom style -->
    <link href="{{ asset('css/ui.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" media="only screen and (max-width: 1200px)" />

    <!-- Custom javascript -->
    <script src="{{ asset('js/script.js') }}" type="text/javascript"></script>

    <!-- Additional Styles -->
    <link rel="stylesheet" href="{{ asset('css/TemplateStyle.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // jQuery code
        });
    </script>
</head>
<body>

<header class="section-header">
    <!-- Top Bar -->
    <nav class="navbar navbar-expand-sm navbar-light border-bottom py-2">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarTop">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="#" class="nav-link">English</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">USD</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fa fa-envelope"></i> Email</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fa fa-phone"></i> Call Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Header -->
    <section class="header-main border-bottom">
        <div class="container">
            <div class="row align-items-center py-3">
                <!-- Logo -->
                <div class="col-lg-2 col-md-3 col-6">
                    <a href="/" class="brand-wrap">
                        <img class="logo" src="{{ asset('images/jhyal.png') }}" alt="Jhyal Logo">
                    </a>
                </div>

                <!-- Store Link -->
                <div class="col-lg-1 col-md-2 col-6">
                    <a href="{{ url('/allproducts') }}" class="btn btn-outline-primary">Store</a>
                </div>

                <!-- Search Bar -->
                <div class="col-lg-6 col-md-5 col-sm-12">
                    <form action="#" class="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for products..." style="font-size: 16px; padding: 10px;">
                            <button class="btn btn-primary" type="submit" style="padding: 10px 20px;">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </div>
                    </form>
                </div>

                <!-- User and Cart Section -->
                <div class="col-lg-3 col-md-2 col-12 text-end">
                    <div class="d-flex align-items-center justify-content-end">
                        <!-- User Section -->
                        @guest
                            <!-- Guest User -->
                            <div class="widget-header me-3">
                                <small class="title text-muted">Welcome guest!</small>
                                <div>
                                    <a href="{{ route('login') }}">Sign in</a> <span class="dark-transp"> | </span>
                                    <a href="{{ route('register') }}"> Register</a>
                                </div>
                            </div>
                        @else
                            <!-- Authenticated User -->
                            <div class="d-flex flex-column align-items-end me-3">
                                <!-- Welcome Message -->
                                <small class="title text-muted">Welcome, {{ \Illuminate\Support\Str::before(Auth::user()->name, ' ') }}!</small>

                                <!-- User Dropdown -->
                                <div class="dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" 
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-user"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <span class="dropdown-item">{{ Auth::user()->name }}</span>
                                        
                                        @if(Auth::user()->isAdmin())  <!-- Check if user is admin -->
                                            <!-- Admin specific menu items -->
                                            <a class="dropdown-item" href="{{ route('getAddresses') }}">{{ __('Address Book') }}</a>
                                            <a class="dropdown-item" href="{{ route('getManageCategory') }}">{{ __('Manage Category') }}</a>
                                            <a class="dropdown-item" href="{{ route('getManageProduct') }}">{{ __('Manage Product') }}</a>
                                            <a class="dropdown-item" href="{{ route('allProducts') }}">{{ __('All Product') }}</a>
                                        @endif

                                        <!-- Logout Option -->
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color:red;">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endguest

                        <!-- Cart Icon -->
                        <a href="{{ route('viewCart') }}" class="position-relative">
                            <div class="icon icon-sm rounded-circle border"><i class="fa fa-shopping-cart"></i></div>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartItemCount ?? 0 }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</header>

<Section id="PageContent">
    @yield('content')
</Section>

<footer class="footer">
    <p>© 2025 Jhyal. All Rights Reserved.</p>
</footer>

</body>
</html>