import axios from "axios";
import $ from "jquery";

$('input').on('click', () => {
    axios.post('/message', {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        text: $('textarea#content').val()
    })
        .then((response) => {
                let errorResponse = $('#errorResponse');
                if(isset(response.data.error)) {
                    if (errorResponse.length) {
                        errorResponse.val(response.data.error);
                    } else {
                        $('#messageForm').append('<p class="w-full bg-red-500 p-2" id="errorResponse">' + response.data.error + '</p>');
                    }
                } else
                if (errorResponse.length) {
                    errorResponse.remove();
                }
                $('textarea#content').val('');
            })
        .catch((response) => {
            if ($('#errorResponse').length) {
                $('#errorResponse').val(response.error);
            } else {
                $('#messageForm').append('<p class="w-full bg-red-500 p-2" id="errorResponse">' + response.error + '</p>');
            }
        })
});
