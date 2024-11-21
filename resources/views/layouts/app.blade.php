@include('layouts.header')
@auth
    @include('layouts.nav')
@endauth

@yield('content')
@include('layouts.footer')
