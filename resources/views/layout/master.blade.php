<!DOCTYPE html>
<html>
    <head>
        <title>{{ trans('multi_language.project') }}</title>
        <meta charset="utf-8">
        <meta name="language" content="{{ Session::get('locale') ? session('locale') : 'en' }}">
        <meta name="token" content="{{ csrf_token() }}">
        <base href="{{asset('')}}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="js/project.js"></script>
    </head>
    <body>
        @include('layout.header')
        @if (!Auth::check())
            @include('page.login')
        @endif
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
