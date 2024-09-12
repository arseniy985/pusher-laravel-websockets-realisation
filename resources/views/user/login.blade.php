@extends('templates.main')

@section('content')
    <form class="grid justify-items-center gap-y-4" action="{{ route('user.login') }}" method="post">
        @csrf
        <div class="">
            <h1 class="text-4xl font-bold mt-4">Войдите в аккаунт:</h1>
        </div>
        <div class="">
            <label for="login" class="text-slate-600 text-lg">Логин:</label>
            <input class="border-2 border-slate-500 rounded px-1" type="text" placeholder="Ваш логин" name="login" id="login">
        </div>
        <div class="">
            <label for="password" class="text-slate-600 text-lg">Пароль:</label>
            <input class="border-2 border-slate-500 rounded px-1" type="text" placeholder="Ваш пароль" name="password" id="password">
        </div>
        <div class="">
            <input type="submit" value="Войти" class="text-slate-600 px-4 border-slate-500 border-2 rounded-md">
        </div>
        <h2 class="text-slate-600 text-xl mb-4">Нет аккаунта? <a href="{{ route('user.showRegisterForm') }}" class="text-black">Создайте </a>его</h2>
    </form>
@endsection
