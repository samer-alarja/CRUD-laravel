<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel App')</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Laravel Mix for styles and scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    /* Basic reset for padding, margin, and box-sizing */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Body and overall page styling */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background-color: #f4f4f4;
    }

    /* Navbar styling */
    .navbar {
        position: fixed;
        top: 0px;
        left: 0;
        width: 100%;
        z-index: 1000;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #333;
        padding: 15px 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .navbar .logo a {
        color: white;
        font-size: 24px;
        font-weight: bold;
        text-decoration: none;
    }

    .nav-links {
        display: flex;
        list-style: none;
    }

    .nav-links li {
        margin-left: 20px;
    }

    .nav-links a {
        color: white;
        text-decoration: none;
        font-size: 18px;
        transition: color 0.3s ease;
    }

    .nav-links a:hover {
        color: #ff6347;
        /* Hover color */
    }

    /* Hamburger Menu */
    .hamburger-menu {
        display: none;
        font-size: 30px;
        color: white;
        cursor: pointer;
    }

    /* Mobile View */
    @media (max-width: 768px) {
        .nav-links {
            display: none;
            flex-direction: column;
            width: 100%;
            position: absolute;
            top: 70px;
            left: 0;
            background-color: #333;
            padding: 20px;
        }

        .nav-links.active {
            display: flex;
        }

        .nav-links li {
            margin: 15px 0;
        }

        .hamburger-menu {
            display: block;
        }
    }
</style>

<body>
    <nav class="navbar">
        <div class="logo">
            <a href="{{ url('/') }}"></a>
        </div>

        @if (!Auth::user())
            <ul class="nav-links">
                <li><a href="login">login</a></li>
                <li><a href="register">register</a></li>
            </ul>
        @elseif(Auth::user()->usertype == 'admin')
            <ul class="nav-links" style="margin-bottom:0px">
                <li><a href="/chatify">chat</a></li>
                <li><a href="/admin/show">all user</a></li>
                <li><a href="/admin/products">all course</a></li>
                <li><a href="{{route('profile.edit')}}">
                        {{ __('Profile') }}
                    </a>
                </li>
                <li><a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="route('logout')" onclick="event.preventDefault();
                                                                            this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </a></li>
            </ul>
        @elseif(Auth::user()->usertype == 'user')
            <ul class="nav-links" style="margin-bottom:0px">
                <li><a href="/chatify">chat</a></li>
                <li><a href="{{ route('showcorse', ['data' => Auth::user()->email])}}">show
                        course</a></li>
                <li><a href="{{route('profile.edit')}}">
                        {{ __('Profile') }}
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a href="route('logout')" onclick="event.preventDefault();
                                                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </li>
            </ul>
        @endif


        <div class="hamburger-menu" id="hamburger">
            &#9776;
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#hamburger').click(function () {
                $('.nav-links').toggleClass('active');
            });
        });
    </script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

</body>

</html>