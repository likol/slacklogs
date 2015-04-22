<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crenosmart Slack logs @yield('page_subtitle')</title>
    <link rel="stylesheet" type="text/css" href="/css/all.css">
</head>
<body>

<header class="header">
    @yield('search-input')
    <a class="logo" href="http://laravel.tw">
        <img src="/app/img/laravel.png">
    </a>
</header>

<section class='container'>
    <main class='content'>
        @yield('content')
    </main>
    <aside>
    @yield('channel')
    @yield('timeline')
    </aside>
</section>

<script type="text/javascript" src="/js/all.js"></script>
</body>
</html>
