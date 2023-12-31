@php

use Illuminate\Support\Facades\Auth;
$url = $_SERVER['REQUEST_URI'];

@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">

    <title>Bootstrap Example</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        <?php
        if (strpos($url, '/ftube') !== false) {
            echo '
                    .navbar {
                        background-color: #23272e !important;
                        color: #fff !important;
                    }
                    .navbar a.navbar-brand {
                        color: #fff !important;
                    }';
        }
        ?>
    </style>

    <title>Home Page</title>
</head>

<body>
    <div class="alert alert-info alert-dismissible fade show" id="guestAlert" role="alert" style="display: none;">
        <p>You are not logged in. Please <a href="{{ route('login') }}">log in</a> or <a href="{{ route('register') }}">register</a> to access this feature.</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light mb-5" style="background-color: #d3d3d3;">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between w-100">
                <a class="navbar-brand" href="{{ route('welcome') }}">
                    <span>
                        <svg width="35" height="35" viewBox="0 20 190 190" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M122.06 139.29C118.83 137.81 119.54 133.72 114.45 131.41C113.464 130.974 112.391 130.771 111.313 130.818C110.236 130.865 109.184 131.16 108.24 131.68C106.368 133.633 104.197 135.277 101.81 136.55C101.09 137.69 100.65 139.46 101.57 142.09C103.29 147.03 107.03 146.66 108.06 149.57C111.06 158.01 99.22 160.81 96.69 153.57C95.62 150.57 98.91 148.37 97.24 143.57C96.9343 142.707 96.444 141.92 95.8033 141.266C95.1625 140.611 94.3867 140.104 93.53 139.78C81.96 142.99 67.53 142.38 56.34 138.78C55.8413 139.017 55.395 139.352 55.0275 139.764C54.66 140.176 54.3786 140.658 54.2 141.18C53.11 143.82 55.15 145.49 54.43 147.35C52.33 152.74 44.78 149.03 46.57 144.43C47.32 142.49 49.92 142.6 50.86 139.99C51.45 138.35 51.44 137.49 51.05 136.74C48.8486 135.764 46.768 134.536 44.85 133.08C43.2296 133.086 41.6665 133.68 40.45 134.75C36.32 137.98 37.9 141.43 35.45 143.34C28.43 149 22 138.66 28 134C30.54 132 33.62 134.4 37.62 131.27C38.8625 130.296 39.6911 128.889 39.94 127.33C38.9638 125.302 38.4547 123.081 38.45 120.83C37.5247 119.558 36.1842 118.649 34.66 118.26C29.66 116.68 27.66 120.03 24.74 119.1C16.2 116.43 21.04 105.29 28.31 107.58C31.39 108.58 31.19 112.35 36.03 113.88C37.5584 114.355 39.2106 114.23 40.65 113.53C42.1859 111.336 44.462 109.77 47.06 109.12C48.4754 113.859 51.6825 117.858 56 120.27C53.5 123.27 54.72 128.94 60.12 128.94C60.7811 128.957 61.4387 128.838 62.0527 128.593C62.6668 128.348 63.2246 127.98 63.6922 127.512C64.1598 127.045 64.5275 126.487 64.773 125.873C65.0184 125.259 65.1365 124.601 65.12 123.94C69.1018 124.874 73.1801 125.334 77.27 125.31C90.2 125.31 100.27 120.31 102.27 110.74C104.446 111.211 106.493 112.149 108.27 113.49C108.83 113.567 109.4 113.526 109.944 113.371C110.488 113.216 110.994 112.95 111.43 112.59C113.75 110.92 112.89 108.43 114.49 107.22C119.1 103.73 123.49 110.69 119.56 113.66C117.89 114.92 115.74 113.46 113.56 115.19C112.26 116.19 111.81 116.94 111.71 117.73C112.506 119.45 112.808 121.358 112.58 123.24C113.382 124.904 114.792 126.197 116.52 126.85C121.77 129.23 124.37 125.85 127.52 127.22C136.44 131.22 130.28 143.08 122.06 139.29ZM80 132.3C79.6205 132.304 79.2455 132.383 78.8963 132.532C78.5472 132.68 78.2308 132.897 77.9653 133.168C77.6997 133.439 77.4901 133.76 77.3485 134.112C77.2069 134.464 77.1361 134.841 77.14 135.22C77.1439 135.6 77.2226 135.975 77.3715 136.324C77.5203 136.673 77.7365 136.989 78.0077 137.255C78.2788 137.52 78.5996 137.73 78.9518 137.872C79.3039 138.013 79.6805 138.084 80.06 138.08C83.73 138.08 83.75 132.3 80 132.3ZM101 121.3C100.234 121.308 99.5016 121.62 98.9652 122.168C98.4289 122.715 98.132 123.454 98.14 124.22C98.148 124.987 98.4601 125.718 99.0077 126.255C99.5553 126.791 100.294 127.088 101.06 127.08C104.73 127.08 104.75 121.3 101 121.3ZM98.88 101.14C97.57 102.64 97.04 104.99 96.88 107.4C96.88 107.58 96.88 107.76 96.88 107.95C96.88 111.55 93.94 114.44 89.88 116.39C89.909 115.706 89.7971 115.023 89.5512 114.384C89.3053 113.744 88.9307 113.162 88.4507 112.674C87.9706 112.185 87.3953 111.801 86.7604 111.544C86.1256 111.287 85.4447 111.163 84.76 111.18C80.13 111.18 78.49 115.92 80.14 119.01C79.14 119.11 78.14 119.17 77.14 119.17C66.2 119.17 53.14 114.39 53.14 105.5C53.1101 104.3 53.335 103.107 53.8 102C53.5135 101.107 52.9495 100.33 52.19 99.7801C49.94 98.0201 47.78 99.5301 46.19 98.3301C41.56 94.8601 47.06 88.8401 51 91.8001C52.67 93.0601 51.86 95.5201 54.12 97.1401C54.8389 97.7583 55.7276 98.1452 56.67 98.2501C58.0585 97.0273 59.5396 95.914 61.1 94.9201C61.2627 94.0114 61.2234 93.0781 60.9849 92.1863C60.7464 91.2945 60.3146 90.4662 59.72 89.7601C56.67 85.5001 53.12 86.9501 51.32 84.4501C46.09 77.1901 56.63 71.1801 61.09 77.3701C63 80.0001 60.48 83.0001 63.43 87.1001C63.9535 87.8217 64.6229 88.4251 65.3947 88.8713C66.1665 89.3175 67.0234 89.5965 67.91 89.6901C69.104 88.5108 69.9991 87.0635 70.5209 85.4685C71.0427 83.8735 71.1761 82.177 70.91 80.5201C72.3524 80.7497 73.7714 81.1078 75.15 81.5901C75.7121 81.4531 76.2385 81.1975 76.6938 80.8405C77.1491 80.4835 77.5229 80.0333 77.79 79.5201C79.28 77.0801 77.53 75.1101 78.54 73.3901C81.45 68.3901 88.13 73.2701 85.65 77.5401C84.65 79.3401 82.06 78.8201 80.72 81.2601C79.9 82.7501 79.77 83.5901 80.01 84.3801C81.095 85.3833 81.9493 86.6102 82.5139 87.9759C83.0785 89.3416 83.3399 90.8135 83.28 92.2901C83.3243 94.2332 82.8279 96.1505 81.8462 97.8279C80.8644 99.5054 79.4359 100.877 77.72 101.79L80.72 106.16C80.72 106.16 87.47 101.68 89.5 100.56C89.79 100.56 90.04 100.66 90.31 100.71C91.65 100.71 93.31 100.56 95.38 98.1201C98.76 94.1201 96.67 91.1201 98.7 88.7801C104.57 82.0401 112.83 90.9301 107.82 96.6801C105.68 99.1101 102.18 97.3201 98.83 101.14H98.88ZM69.99 100.3C69.2235 100.309 68.4921 100.623 67.9567 101.171C67.4213 101.72 67.1257 102.459 67.135 103.225C67.1443 103.992 67.4577 104.723 68.0062 105.258C68.5548 105.794 69.2935 106.089 70.06 106.08C73.73 106.08 73.75 100.3 69.94 100.3H69.99Z" fill="#000000"></path>
                            </g>
                        </svg>
                        shtNet
                    </span>
                </a>
                <!-- <div class="mx-4">
                    <form class="d-flex mb-0">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </div> -->
                <div class="d-flex align-items-center">
                    @auth
                    <a href="{{ url('/chatify') }}">
                        <i class="fa-solid fa-comments fa-lg me-3 text-primary" id="chatifyLink"></i>
                    </a>
                    <a href="{{ route('user.add.post') }}" class="px-1 py-0 fa-lg me-3 text-dark">
                        <i class="fa-solid fa-square-plus"></i>
                    </a>
                    <a href="{{ route('users.liked') }}" class="fa-solid fa-heart fa-lg text-danger text-decoration-none"></a>
                    @endauth
                    <div class="ms-3">
                        @auth
                        <div class="btn-group dropstart">
                            <div class="rounded-circle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user fa-lg"></i>
                            </div>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">{{ Auth::user()->name }}</li>
                                <li><a class="dropdown-item text-decoration-none" href="{{ route('settings') }}">Settings</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @else
                        <a href="{{ route('login') }}">
                            <i class="fa-solid fa-arrow-right-to-bracket fa-lg text-dark"></i>
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
        document.getElementById('chatifyLink').addEventListener('click', function(e) {
            @guest
            e.preventDefault();
            document.getElementById('guestAlert').style.display = 'block';
            @endguest
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
