import axios from "axios";
import Pusher from "pusher-js";
import $ from "jquery";

function renderMessages(messages) {
    if (isset(messages.data)) { // если вызов идет при изначальной загрузки страницы
        messages.data.forEach((message) => {
            $('#messagesContainer').append(`
            <div class="message w-fit bg-gray-100 mb-2 ml-2 p-2 border-2">
               <h2 class="text-2xl font-bold">${screen(message.user_login)}</h2>
               <p class="text-xl">${screen(message.message)}</p>
           </div>
        `)
        })
    } else {
        $('#messagesContainer').prepend(`
            <div class="message w-fit bg-gray-100 mb-2 ml-2 p-2 border-2">
                <h2 class="text-2xl font-bold">${screen(messages.user.login)}</h2>
                <p class="text-xl">${screen(messages.message)}</p>
            </div>
        `)
    }

}

let page = {page: 0};

// Функция для загрузки сообщений
function loadMessages() {
    axios.get('/api/message', {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        params: {
            page: page.page
        },
    })
        .then(response => {
            console.log('Сообщения загружены-' + page.page);
            console.log(response.data)
            // Отрисовываем полученные сообщения
            renderMessages(response);

            page.page++;

        })
        .catch(error => {
            console.error(error);
        });
}

// Загружаем первую страницу сообщений
loadMessages(page.page);

// Обрабатываем новые сообщения
new Pusher('96d501fee268e058e957', {cluster: 'eu'})
    .subscribe('messages')
    .bind('store_message', (message) => {
        renderMessages(message);
    });


// ЗАгрузка сообщений по прокрутке
let scrollCheckInterval = null;

$(window).scroll(function() {
    // Очищаем интервал, если он уже был установлен
    clearInterval(scrollCheckInterval);

    // Запускаем интервал, чтобы проверять прокрутку каждые 2 секунды
    scrollCheckInterval = setInterval(function() {
        const scrollY = $(window).scrollTop();
        const documentHeight = $(document).height();

        // Проверяем, достигли ли мы конца страницы
        if (scrollY + $(window).height() >= documentHeight - 200) {
            // Загружаем следующую страницу сообщений
            loadMessages(page.page);
        }
    }, 600); // 2000 миллисекунд = 2 секунды
});
