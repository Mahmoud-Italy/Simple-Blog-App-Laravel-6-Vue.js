<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>window.Laravel = { csrfToken: '{{  csrf_token() }}' }</script>
        <title>Blog</title>
        <link href="{{ url('assets/frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ url('assets/frontend/css/blog-home.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ url('assets/backend/vendors/font-awesome/css/font-awesome.min.css') }}">
        <link rel="shortcut icon" href="{{ url('assets/backend/images/favicon.png') }}"/>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>

            <div id="app">
                <router-view></router-view>
            </div>
            
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ url('assets/frontend/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ url('assets/frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
