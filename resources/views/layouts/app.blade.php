<!DOCTYPE html>
<html itemtype="http://schema.org/WebPage" lang="pt-BR">
@include('layouts.head')
<body>
{{--@if(!isset($_GET['notagmanager']))--}}
{{--    @include('googletagmanager::body')--}}
{{--@endif--}}
<div class="main">
    @include('layouts.header')
    @yield('content')
</div>
@include('layouts.footer')
</body>
</html>
