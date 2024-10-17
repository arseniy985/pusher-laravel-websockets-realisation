import axios from "axios";
import $ from "jquery";

function scr(text) {
    return text.replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function renderMessages(messages) {
    messages.data.forEach((message) => {
        $('#messagesContainer').append(`
            <div class="message w-fit bg-gray-100 mb-2 ml-2 p-2 border-2">
               <h2 class="text-2xl font-bold">${scr(message.user_login)}</h2>
               <p style="word-break: break-all" class="text-xl">${scr(message.message)}</p>
           </div>
        `)
    })
}

let page = {page: 0};

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

loadMessages(page.page);

let scrollCheckInterval = null;

$(window).scroll(function() {
    clearInterval(scrollCheckInterval);

    scrollCheckInterval = setInterval(function() {
        const scrollY = $(window).scrollTop();
        const documentHeight = $(document).height();

        if (scrollY + $(window).height() >= documentHeight - 200) {
            loadMessages(page.page);
        }
    }, 600);
});
