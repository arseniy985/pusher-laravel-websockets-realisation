import axios from "axios";
import $ from "jquery";

function renderMessages(messages) {
    messages.data.forEach((message) => {
        $('#messagesContainer').append(`
            <div class="message w-fit bg-gray-100 mb-2 ml-2 p-2 border-2">
               <h2 class="text-2xl font-bold">${message.user_login}</h2>
               <p class="text-xl">${message.message}</p>
           </div>
        `)
    })
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

// Интервал для проверки прокрутки
let scrollCheckInterval = null;

// Обработчик события прокрутки
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
