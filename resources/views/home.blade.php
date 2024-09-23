@extends('templates.main')

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
    </section>
    <script>
        function editMessage(button) {
            // Получаем id кнопки
            const buttonId = button.id;

            // Находим тег p с таким же id
            const pElement = document.querySelector(`p[id="${buttonId}"]`);

            // Заменяем p на textarea
            const textarea = document.createElement('textarea');
            textarea.id = buttonId;
            textarea.value = pElement.textContent;
            textarea.classList.add('textarea-edit'); // Добавить класс для стилизации (опционально)

            pElement.replaceWith(textarea);
            button.remove();
        }
    </script>
@endsection
