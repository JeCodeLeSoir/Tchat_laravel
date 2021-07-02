(() => {
    //JeCodeLeSoir
    //Folder -> resources/views/pages

    const FormSentTchat = document.querySelector("#send-message-tchat");

    if (FormSentTchat) {
        const messages = document.querySelector(".messages");
        const MessageInput = document.querySelector("#send-message-tchat input[id='message']")

        const evtSource = new EventSource("api/ServerSendEvent", {
            withCredentials: true
        });

        evtSource.addEventListener('message', (event) => {

            const infos = JSON.parse(event.data);
            console.log(infos)

            infos.forEach(info => {

                var messageBlock = document.createElement('div')
                messageBlock.classList.add('message')
                messageBlock.id = info.id
                messages.appendChild(messageBlock)

                messageBlock.innerHTML =
                    `<span class="author">${ info.name }</span> à dit :
            <div class="text">${ info.message }</div>
            <span class="date">${ info.created_at }</span>`


                messages.scrollTop = messages.scrollHeight;

            });
        })

        FormSentTchat.addEventListener('submit', (event) => {
            event.preventDefault();
            const data = new FormData(event.target);

            //File -> app/http/controller/tchat/TchatController.php
            fetch('api/send', {
                'method': 'post',
                'body': data,
            }).then(async (event) => {
                const text = await event.text();
            }).catch((err) => {

            });

            MessageInput.value = ""
            messages.scrollTop = messages.scrollHeight;
        });
    };
})()