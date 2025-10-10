<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        /* Style untuk notifikasi */
        #notification-area {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            width: 350px;
        }

        .alert-auto-close {
            position: relative;
            overflow: hidden;
        }

        .alert-auto-close .progress {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: rgba(0,0,0,0.1);
        }

        .alert-auto-close .progress-bar {
            transition: width 2s linear;
        }
    </style>
    @stack('style')

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script>
            function showNotifCreate(message, type = 'success', duration = 5000){
                // Tentukan kelas alert berdasarkan type
                let alertClass;
                switch(type) {
                    case 'success':
                        alertClass = 'alert-success';
                        break;
                    case 'warning':
                        alertClass = 'alert-warning';
                        break;
                    case 'error':
                        alertClass = 'alert-danger';
                        break;
                    case 'info':
                    default:
                        alertClass = 'alert-info';
                        break;
                }

                // Buat elemen notifikasi
                const notificationId = 'notif-' + Date.now();
                const notification = $(
                    `<div id="${notificationId}" class="alert ${alertClass} alert-auto-close alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        ${message}
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 100%"></div>
                        </div>
                    </div>`
                );

                // Tambahkan notifikasi ke area notifikasi
                $('#notification-area').append(notification);

                // Animasikan progress bar
                setTimeout(function() {
                    notification.find('.progress-bar').css('width', '0%');
                }, 10);

                // Hilangkan notifikasi setelah 2 detik
                setTimeout(function() {
                    $('#' + notificationId).alert('close');
                }, duration);
            }
        </script>
        @stack('sctipts')
    </div>
</body>
</html>
