<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('static.head')
    </head>
    <body>
        @yield('content')
        
        <script src="{{ mix('js/app.js') }}"></script>
        @include('static.footer')
    </body>
    
</html>
