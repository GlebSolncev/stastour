<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layout.header')
</head>
<body class="antialiased {{isset($theme) ? 'theme--'.$theme : null}}">
    <div class="static">
        @include('component.header', ['theme' => isset($theme) ? $theme : null])

        @yield('content')

        @include('component.footer')
        @include('layout.footer')
    </div>

    <div class="aside">
        @include('component.aside-menu')
    </div>

    <div class="modal" js-module="modals"></div>

</body>
</html>
