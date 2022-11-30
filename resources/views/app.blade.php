<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dr. Dentix</title>

    <!-- Fonts -->
    <!-- Styles -->
    <link rel="shortcut icon" href="{{ asset('images/head.png') }}" type="image/x-icon">

    <!-- Scripts -->
    @routes
    {{-- @vite('resources/js/app.js') --}}
    @vite(['resources/js/app.js', 'resources/scss/app.scss', 'resources/css/app.css'])
    @inertiaHead
</head>

<body class="font-sans antialiased">

    {{-- @inertia --}}

    @php
        if (!empty(Auth::user()) && Auth::user()->type_user == 'Administrator'):
            $isLog = 'adminlte::page';
        else:
            $isLog = 'Admin';
        endif;
    @endphp

    @section('content_header')
        @inertia
    @stop
    @extends($isLog)
    @section('content')
        @inertia
    @stop


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>



</body>

</html>
