<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>日次収支システム</title>

        <!-- favicon -->
        <link rel="shortcut icon" type="image/x-icon"  href="{{ asset('image/favicon.svg') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Chart.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

        <!-- Scripts -->
        <script src="{{ asset('js/navigation.js') }}" defer></script>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">

        <!-- LINE AWESOME -->
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&family=Zen+Maru+Gothic:wght@700&display=swap" rel="stylesheet">

        <!-- ニュースティッカー用 -->
        <link rel="stylesheet" href="{{ asset('css/ticker.css') }}">
        <script src="{{ asset('js/ticker.js') }}" defer></script>
        
    </head>
    <body style="font-family:Zen Maru Gothic" class="bg-slate-100">
        <div class="min-h-screen">
            @include('layouts.navigation')
            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="mx-5 py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            <!-- Alert -->
            <x-alert/>
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
