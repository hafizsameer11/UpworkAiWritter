<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            background-color: #171717;
            color: white;
        }

        /* For Chrome, Edge, Safari */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
            /* Track color */
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 4px;
            border: 2px solid transparent;
            background-clip: content-box;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        * {
            scrollbar-width: thin;
            scrollbar-color: #212121 transparent;
        }

        .main_container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .header {
            height: 60px;
            flex-shrink: 0;
        }

        .chat-container {
            flex: 1;
            overflow-y: auto;
        }

        .message-box {
            word-wrap: break-word;
            max-width: 75%;
            padding: 1rem;
            border-radius: 0.5rem;
        }

        .user-msg {
            background-color: #303030;
            color: white;
            align-self: end;
        }

        .bot-msg {
            background-color: #171717;
        }

        textarea {
            all: unset;
            background-color: transparent;
            border: none;
            color: white;
            resize: none;
            width: 100%;
        }

        #chat-form {
            background-color: #282828;
            flex-shrink: 0;
        }

        #message-input,
        #prompt-input {
            background-color: #171717;
        }

        #prompt-input::placeholder,
        #message-input::placeholder {
            color: white;
        }

        pre {
            background-color: #1e1e1e;
            padding: 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.95rem;
            color: #e0e0e0;
        }
    </style>
</head>

<body>
    <div class="container mx-auto main_container px-3 py-2">
        <div class="d-flex align-items-center justify-content-between  gap-2 header">
            <h1 class="h4 mb-0">{{$bot->name}}</h1>
            <form action="{{route('auth.logout')}}">
                <button type="submit" class="btn btn-danger">
                    Logout
                </button>
            </form>
        </div>
        <hr>
        <div class="d-flex flex-column chat-container px-2 py-2" id="chat-box">
        </div>

        <form id="chat-form" class="p-3 rounded d-flex align-items-end gap-2">
            <textarea id="message-input" rows="1" required placeholder="Enter your message..."
                class="form-control text-white border-0 bg-dark flex-grow-1" style="overflow:hidden;"></textarea>
            <textarea id="prompt-input" rows="1" placeholder="Enter your prompt (optional)..."
                class="form-control text-white border-0 bg-dark" style="overflow:hidden;"></textarea>
            <div class="d-flex gap-2 align-items-end">
                <button type="submit" class="btn p-0">
                    <img src="{{asset('website/send.svg')}}" alt="send" style="height: 40px;width: 40px;">
                </button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');
        const promptInput = document.getElementById('prompt-input');
        const botId = {{ $bot->id }};
        const userId = {{ auth()->id() }};

        function appendMessage(text, timestamp, isUser = true) {
            const msgDiv = document.createElement('div');
            msgDiv.className = 'd-flex flex-column mb-3 ' + (isUser ? 'align-items-end' : 'align-items-start');

            // Detect AI message formatting
            const isAI = !isUser && text.trim().length > 0;

            msgDiv.innerHTML = isAI
                ? `
            <div class="message-box bot-msg position-relative">
                <pre class="mb-2" style="white-space: pre-wrap; font-family: inherit;">${text}</pre>
                
            </div>
            <div class='d-flex align-items-center'>
                <small class=" mt-1" style='color:white'>${timestamp}</small>
                <button class="mx-4 btn btn-sm btn-copy" >
                    <img src="{{asset('website/copy.svg')}}" width="20" height='20' />
                    </button>
                </div>
        `
                : `
            <div class="message-box ${isUser ? 'user-msg' : 'bot-msg'}">${text}</div>
                <small class=" mt-1" style='color:white'>${timestamp}</small>
               
        `;

            chatBox.appendChild(msgDiv);
            chatBox.scrollTop = chatBox.scrollHeight;
            if (isAI) {
                const btn = msgDiv.querySelector('.btn-copy');
                const content = msgDiv.querySelector('pre').textContent;
                btn.addEventListener('click', () => {
                    navigator.clipboard.writeText(content).then(() => {
                        btn.innerText = "Copied!";
                        setTimeout(() => btn.innerHTML = "<img src='{{asset('website/copy.svg')}}' width='30' height='30' />", 1500);
                    });
                });
            }
        }


        $.ajax({
            url: `/api/proposals/${botId}/${userId}`,
            method: 'GET',
            success: function (proposals) {
                proposals.forEach(item => {
                    const time = new Date(item.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                    if (item.custom_prompt) {
                        appendMessage(`Prompt: ${item.custom_prompt}`, time, true);
                    }

                    appendMessage(item.job_post, time, true);

                    if (item.ai_response) {
                        appendMessage(item.ai_response, time, false);
                    }
                });
            },
            error: function (err) {
                console.error('Failed to fetch proposals:', err);
            }
        });

        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = Math.min(textarea.scrollHeight, 150) + 'px';
        }

        [messageInput, promptInput].forEach(textarea => {
            textarea.addEventListener('input', () => autoResize(textarea));
        });

        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const text = messageInput.value.trim();
            const prompt = promptInput.value.trim();
            if (!text) return;

            const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            // show user message immediately
            if (prompt) {
                appendMessage(`Prompt: ${prompt}`, time, true);
            }
            appendMessage(text, time, true);

            // Reset input fields
            messageInput.value = '';
            promptInput.value = '';
            autoResize(messageInput);
            autoResize(promptInput);

            // Prepare the object
            const payload = {
                user_id: {{ auth()->id() }},
                bot_id: {{ $bot->id }},
                job_post: text,
                ...(prompt && { custom_prompt: prompt }) // only include if exists
            };
            $.ajax({
                url: '/api/proposals/create',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(payload),
                success: function (data) {
                    console.log(data)
                    appendMessage(data.proposal.ai_response || 'AI has no response.', new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }), false);
                },
                error: function (err) {
                    console.error(err);
                    appendMessage('An error occurred. Please try again later.', new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }), false);
                }
            });
        });
    </script>
</body>

</html>