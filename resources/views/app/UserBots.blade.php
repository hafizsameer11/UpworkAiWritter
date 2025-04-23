<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upwork Ai Writer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            color: white;
            background: #212121;
        }

        .card-container {
            min-height: 100vh;
            display: 'flex';
            align-items: 'center';
            justify-content: 'center';
            flex-direction: 'column';
        }

        .heading {
            width: fit-content;
        }

        .tools {
            display: flex;
            align-items: center;
            padding: 9px;
        }

        .circle {
            padding: 0 4px;
        }

        .box {
            display: inline-block;
            align-items: center;
            width: 10px;
            height: 10px;
            padding: 1px;
            border-radius: 50%;
        }

        .red {
            background-color: #ff605c;
        }

        .yellow {
            background-color: #ffbd44;
        }

        .green {
            background-color: #00ca4e;
        }
    </style>
</head>

<body>
    <div class="py-4 mx-auto container card-container">
        <h1 class="heading mb-4">Select Your Chat</h1>
        <div class="row w-100 justify-content-center" id="card_container">
            @foreach ($bots as $bot)
                <div class="col-md-4 mb-4">
                    <div class="card text-bg-dark shadow w-100 h-100">
                        <div class="tools">
                            <div class="circle">
                                <span class="red box"></span>
                            </div>
                            <div class="circle">
                                <span class="yellow box"></span>
                            </div>
                            <div class="circle">
                                <span class="green box"></span>
                            </div>
                        </div>
                        <div class="card-header">
                            <img src="{{asset('storage/' . $bot->image)}}" alt="{{$bot->name}}"
                                style="width: 100%;height:200px;">
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="mb-0">{{$bot->name}}</h6>
                            </div>
                        </div>

                        <div class="card-footer ">
                            <div class='py-1 d-flex justify-content-end'>
                                <a href="{{url('/CreateProposal/' . $bot->id . '')}}" class="btn btn-light">
                                    Open Chat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{--
    <script>
        const chatbotData = [
            {
                id: 1,
                title: "WordPress Chatbot",
                description: "Helps you generate proposals, troubleshoot plugins, and optimize SEO for WordPress websites."
            },
            {
                id: 2,
                title: "MERN Stack Chatbot",
                description: "Expert guidance on MongoDB, Express, React, and Node for full-stack development."
            },
            {
                id: 3,
                title: "React Chatbot",
                description: "Your assistant for building SPAs, handling state, hooks, and component architecture in React."
            },
            {
                id: 4,
                title: "React Native Chatbot",
                description: "Get help with building mobile apps using React Native, Expo, navigation, and deployment."
            },
            {
                id: 5,
                title: "Laravel Chatbot",
                description: "Ask anything about Laravel MVC, Eloquent, migrations, queues, and API building."
            },
            {
                id: 6,
                title: "Python Chatbot",
                description: "Discuss automation, data analysis, or web development using Django and Flask."
            },
            {
                id: 7,
                title: "DevOps Chatbot",
                description: "Support for CI/CD, Docker, GitHub Actions, server deployment, and monitoring tools."
            },
            {
                id: 8,
                title: "Flutter Chatbot",
                description: "Helps you build cross-platform apps with Dart and Flutter with animations and widgets."
            },
            {
                id: 9,
                title: "Shopify Chatbot",
                description: "Your go-to for Liquid templates, theme customization, and Shopify store setup."
            },
            {
                id: 10,
                title: "Next.js Chatbot",
                description: "Get SSR/SSG advice, route optimization, API routes, and performance tuning tips."
            },
            {
                id: 11,
                title: "Vue.js Chatbot",
                description: "Build modern frontends using Vue, Pinia, Vue Router, and component design."
            },
            {
                id: 12,
                title: "Django Chatbot",
                description: "Support for backend logic, models, authentication, and REST API with Django."
            }
        ];

        const container = document.getElementById('card_container');

        chatbotData.forEach(bot => {
            const col = document.createElement('div');
            col.className = 'col-md-4 mb-4';
            col.innerHTML = `
            <div class="card text-bg-dark shadow w-100 h-100">
                <div class="tools">
                    <div class="circle">
                    <span class="red box"></span>
                    </div>
                    <div class="circle">
                    <span class="yellow box"></span>
                    </div>
                    <div class="circle">
                    <span class="green box"></span>
                    </div>
                </div>
              <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                  <h6 class="mb-0">${bot.title}</h6>
                </div>
              </div>
              <div class="card-body">
                <p>${bot.description}</p>
              </div>
              <div class="card-footer ">
                 <div class='py-1 d-flex justify-content-end'><button class="btn btn-light" onclick="openChat(${bot.id})">Open Chat</button></div>
              </div>
            </div>
          `;

            container.appendChild(col);
        });

        function openChat(id) {
            alert(`Chatbot ${id} opened! (Replace this with your logic)`);
        }
    </script>
    --}}
</body>

</html>