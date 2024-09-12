import Pusher from "pusher-js";
import $ from "jquery";

let pusher = new Pusher('96d501fee268e058e957', {cluster: 'eu'});
let channel = pusher.subscribe('messages');
channel.bind('store_message', (message) => {
    console.log(message);
    $('#messagesContainer').prepend(`
        <div class="message w-fit bg-gray-100 mb-2 ml-2 p-2 border-2">
            <h2 class="text-2xl font-bold">${message.user.login}</h2>
            <p class="text-xl">${message.message}</p>
        </div>
    `)
});
