<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - @yield('title')</title>
</head>
<style>
    body {
        position: relative;
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        -premailer-width: 570px;
        background-color: #ffffff;
        margin: 0 auto;
        padding: 0;
        font-size: 14px;
    }

    .bg-primary {
        background-color: #696cff;
    }

    .vertical-middle {
        vertical-align: middle;
    }

    .clr-white {
        color: #fff;
    }
    
    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .w-100 {
        width: 100%;
    }
    
    .bt-1 {
        border-top: 1px solid #000;
    }
    
    .py-2 {
        padding-top: 6px;
        padding-bottom: 6px;
    }
    
    .page-break {
        page-break-after: always;
    }
</style>

@stack('style')

<body>
    @yield('content')
</body>
</html>