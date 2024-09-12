import axios from "axios";
import $ from "jquery";

axios.get('/message',{
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
})
    .then((response) => {
        console.log(response);
        response.data.forEach((message) => {
            $('#messagesContainer').append(`
                <div class="message w-fit bg-gray-100 mb-2 ml-2 p-2 border-2">
                   <h2 class="text-2xl font-bold">${message.user.login}</h2>
                   <p class="text-xl">${message.message}</p>
               </div>
            `)
        })
    })
