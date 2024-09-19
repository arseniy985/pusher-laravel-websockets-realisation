@extends('templates.main')

@section('additional_links')
@endsection

@section('content')

    @auth
        <article class="grid w-screen justify-items-center gap-y-4 mb-4" id="messageForm">
            @csrf
            <textarea name="text" id="content" class="w-auto justify-self-center border-2 border-black p-2 rounded-xl" style="width: 60vw" placeholder="Ваше сообщение:"></textarea>
            <input type="submit" name="messageSend" value="Отправить сообщение" class="text-slate-600 w-auto px-4 border-slate-500 border-2 rounded-md">
        </article>
        @vite('resources/js/message/store_message.js')
    @endauth

    <section class="messages" id="messagesContainer">
        @vite('resources/js/message/get_messages.js')
        @vite('resources/js/message/get_new_message.js')
    </section>

@endsection
