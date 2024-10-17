import Pusher from "pusher-js";
import $ from "jquery";

function scr(text) {
    return text.replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function renderMessage(message) {
    $('#messagesContainer').prepend(`
        <div class="message w-fit bg-gray-100 mb-2 ml-2 p-2 border-2">
            <h2 class="text-2xl font-bold">${scr(message.user.login)}</h2>
            <p style="word-break: break-all" class="text-xl">${scr(message.message)}</p>
        </div>
    `)
}

let PUSHER_APP_KEY = $('meta[name="pusher-app-key"]').attr('content');
let PUSHER_APP_CLUSTER = $('meta[name="pusher-app-cluster"]').attr('content');

console.log(PUSHER_APP_KEY)
console.log(PUSHER_APP_CLUSTER)

new Pusher(PUSHER_APP_KEY, {cluster: PUSHER_APP_CLUSTER})
    .subscribe('messages')
    .bind('store_message', (message) => {
        renderMessage(message);
        console.log(message);
    });
