<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="bootstrap material admin template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="author" content="Deepesh suryawanshi">

    <!-- Preload critical resources -->
    <link rel="preload" href="{{ asset('global/css/bootstrap.min.css') }}" as="style">
    <link rel="preload" href="{{ asset('assets/css/site.min.css') }}" as="style">
    <link rel="preload" href="{{ asset('global/vendor/jquery/jquery.js') }}" as="script">

    <title>{{ config('app.name', 'Deepesh.ai') }} - @stack('title', 'Dashboard')</title>

    <link rel="apple-touch-icon" href="{{ asset('assets/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- Core Stylesheets -->
    <link rel="stylesheet" href="{{ asset('global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('global/css/bootstrap-extend.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/site.min.css') }}">

    <!-- Essential Plugins -->
    <link rel="stylesheet" href="{{ asset('global/vendor/animsition/animsition.css') }}">
    <link rel="stylesheet" href="{{ asset('global/vendor/asscrollable/asScrollable.css') }}">
    <link rel="stylesheet" href="{{ asset('global/vendor/switchery/switchery.css') }}">
    <link rel="stylesheet" href="{{ asset('global/vendor/slidepanel/slidePanel.css') }}">
    <link rel="stylesheet" href="{{ asset('global/vendor/flag-icon-css/flag-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('global/vendor/waves/waves.css') }}">

    <!-- Load additional plugins only when needed -->
    @stack('plugin-styles')



    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('global/fonts/material-design/material-design.min.css') }}">
    <link rel="stylesheet" href="{{ asset('global/fonts/brand-icons/brand-icons.min.css') }}">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic&display=swap'>

    <!-- my css inject 💉 -->
    @stack('styles')

    <!-- Loading styles -->
    <style>
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.3s ease;
        }

        .page-loader.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .loader-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <!-- Scripts -->
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
</head>

<body class="@yield('body-class', 'dashboard')">
    <!-- Loading spinner -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-spinner"></div>
    </div>

    @include('layouts.navigation')
    <!-- Page Content -->
    <main class="page">
        {{-- Breadcrumb Section --}}
        <div class="page-header">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            @stack('breadcrumb')
            </ol>
            <h1 class="page-title">@stack('page-title', 'Dashboard')</h1>
            <div class="page-header-actions d-flex align-items-center">
            @stack('page-actions')
            <button type="button"
                class="btn btn-sm btn-icon btn-primary btn-round waves-effect waves-classic ml-2"
                data-toggle="tooltip" data-original-title="Back"
                onclick="window.history.back();">
                <i class="icon md-arrow-left" aria-hidden="true"></i>
            </button>
            </div>
        </div>
        @yield('content', "No Content Provided")
    </main>
    <!-- Footer -->
    <footer class="site-footer">
        <div class="site-footer-legal">© 2018 <a
                href="http://themeforest.net/item/remark-responsive-bootstrap-admin-template/11989202">Remark</a></div>
        <div class="site-footer-right">
            Crafted with <i class="red-600 icon md-favorite"></i> by <a
                href="https://themeforest.net/user/creation-studio">Creation Studio</a>
        </div>
    </footer>
    <!-- Core Scripts - Load Immediately -->
    <script src="{{ asset('global/vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('global/vendor/popper-js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('global/vendor/bootstrap/bootstrap.js') }}"></script>

    <!-- Essential Scripts for Layout -->
    <script src="{{ asset('global/vendor/babel-external-helpers/babel-external-helpers.js') }}"></script>
    <script src="{{ asset('global/vendor/animsition/animsition.js') }}"></script>
    <script src="{{ asset('global/vendor/mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('global/vendor/asscrollbar/jquery-asScrollbar.js') }}"></script>
    <script src="{{ asset('global/vendor/asscrollable/jquery-asScrollable.js') }}"></script>
    <script src="{{ asset('global/vendor/ashoverscroll/jquery-asHoverScroll.js') }}"></script>
    <script src="{{ asset('global/vendor/waves/waves.js') }}"></script>

    <!-- Core Framework Scripts -->
    <script src="{{ asset('global/js/Component.js') }}"></script>
    <script src="{{ asset('global/js/Plugin.js') }}"></script>
    <script src="{{ asset('global/js/Base.js') }}"></script>
    <script src="{{ asset('global/js/Config.js') }}"></script>

    <!-- Essential Plugins -->
    <script src="{{ asset('global/vendor/switchery/switchery.js') }}"></script>
    <script src="{{ asset('global/vendor/slidepanel/jquery-slidePanel.js') }}"></script>

    <!-- Menu and layout scripts -->
    <script src="{{ asset('assets/js/Section/Menubar.js') }}"></script>
    <script src="{{ asset('assets/js/Section/GridMenu.js') }}"></script>
    <script src="{{ asset('assets/js/Section/Sidebar.js') }}"></script>
    <script src="{{ asset('assets/js/Section/PageAside.js') }}"></script>
    <script src="{{ asset('assets/js/Plugin/menu.js') }}"></script>

    <!-- Configuration -->
    <script src="{{ asset('global/js/config/colors.js') }}"></script>
    <script src="{{ asset('assets/js/config/tour.js') }}"></script>
    <script>Config.set('assets', "{{ asset('assets') }}");</script>

    <!-- Site initialization -->
    <script src="{{ asset('assets/js/Site.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/asscrollable.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/slidepanel.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/switchery.js') }}"></script>

    <!-- Load additional plugins only when needed -->
    @stack('plugin-scripts')

    <!-- Initialize breakpoints -->
    <script src="{{ asset('global/vendor/breakpoints/breakpoints.js') }}"></script>
    <script>
        if (typeof Breakpoints !== 'undefined') {
            Breakpoints();
        }
    </script>

    <!-- My JS inject 💉 -->
    @stack('scripts')

</body>
<script>
    // Hide loading spinner when page is ready
    document.addEventListener('DOMContentLoaded', function () {
        const loader = document.getElementById('pageLoader');
        if (loader) {
            setTimeout(() => {
                loader.classList.add('hidden');
                setTimeout(() => loader.remove(), 300);
            }, 100);
        }
    });

    // Site initialization
    $(document).ready(function () {
        if (typeof Site !== 'undefined') {
            Site.run();
        }
    });
</script>

</html>