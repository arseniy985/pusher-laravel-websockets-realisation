@php use Illuminate\Support\Facades\Auth; @endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/js/app.js')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function isset(r) {
            return typeof r !== 'undefined';
        }
    </script>
    @yield('additional_links')
    <title>OGUZOK messager</title>
</head>
<body>
<header class="flex justify-between p-4 items-center">
    <div class="head-column flex ">
        <a class="text-xl font-bold" href="{{ route('home.index') }}">Главная страница</a>
    </div>
    <div class="head-column">
        <h1 class="text-2xl font-bold">OGUZOCHEK messager</h1>
    </div>
    <div class="head-column grid justify-items-center text-lg">
        @guest
            <a class="text-xl font-bold" href="{{ route('user.showLoginForm') }}">Авторизация</a>
        @endguest
        @auth
            <h2 class="font-lg">Привет, {{ Auth::user()->login }}</h2>
            <a class="font-bold" href="{{ route('user.logout') }}">Выйти из аккаунта</a>
        @endauth
    </div>
</header>

@if($errors->any())
    <div class="w-3/4 bg-red-400 p-4 ml-4">
        <h1 class="text-2xl font-extrabold">Возникла(-и) ошибка(-и):</h1>
        <ul>
            @foreach($errors->all() as $error)
                <li class="text-large">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<main class="w-screen">
    @yield('content')
</main>
<hr>
</body>
</html>
