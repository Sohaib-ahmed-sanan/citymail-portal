@include('layout.header')
@include('layout.sidebar')
<div class="app-main">
@include('layout.topbar')
@yield('content')
@include('layout.footer')
</div>
</body>
</html>