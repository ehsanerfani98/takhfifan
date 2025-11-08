@extends('site.layout')
@section('css')
    <style>
        .chat-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            height: 90vh;
            display: flex;
            flex-direction: column;
            background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH4AkEEjIZY3XpFQAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAALUlEQVQ4y2NgGAXDFmzatMmKAQ38v3///n8GNPB/06ZNVugKGBkZGdEVMjIyMgIA0XQK6Q0BfSIAAAAASUVORK5CYII=');
            background-repeat: repeat;
            height: 80vh;
        }

        .chat-header {
            padding: 15px;
            display: flex;
            align-items: center;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(45deg, #25D366, #128C7E);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .status {
            opacity: 0.8;
            font-size: 0.8rem;
        }

        .chat-body {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            background-image: url('https://web.whatsapp.com/img/bg-chat-tile-light_a4be512e7195b6b733d9110b408f075d.png');
            background-repeat: repeat;
            display: flex;
            flex-direction: column;
        }

        .message {
            max-width: 70%;
            margin-bottom: 15px;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-content {
            padding: 10px 15px;
            border-radius: 10px;
            position: relative;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            word-wrap: break-word;
        }

        .received .message-content {
            background-color: white;
            border-top-left-radius: 0;
            margin-right: 20px;
        }

        .received .message-content::before {
            content: '';
            position: absolute;
            top: 0;
            right: -10px;
            width: 0;
            height: 0;
            border: 10px solid transparent;
            border-top: 0;
            border-right: 0;
            border-left: 10px solid white;
        }

        .sent .message-content {
            background-color: #dcf8c6;
            border-top-left-radius: 0;
            color: #000;
            margin-left: 20px;
        }

        .sent .message-content::after {
            content: '';
            position: absolute;
            top: 0;
            left: -10px;
            width: 0;
            height: 0;
            border: 10px solid transparent;
            border-top: 0;
            border-left: 0;
            border-right: 10px solid #dcf8c6;
        }

        .message-time {
            font-size: 11px;
            color: rgba(0, 0, 0, 0.5);
            margin-top: 5px;
            display: block;
            text-align: left;
        }

        .message-sender {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 0.9rem;
            text-align: left;
        }

        .sent {
            align-self: flex-end;
        }

        .received {
            align-self: flex-start;
        }

        .chat-footer {
            background-color: #f0f0f0;
            padding: 10px 15px;
            display: flex;
            align-items: center;
        }

        .message-input {
            flex: 1;
            border-radius: 20px;
            border: none;
            padding: 10px 15px;
            font-size: 14px;
            background-color: white;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
            resize: none;
            max-height: 100px;
            margin: 0 10px;
        }

        .message-input:focus {
            outline: none;
            box-shadow: inset 0 1px 4px rgba(0, 0, 0, 0.2);
        }

        .btn-send {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(45deg, #25D366, #128C7E);
            border: none;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-send:hover {
            transform: scale(1.05);
            box-shadow: 0 3px 10px rgba(37, 211, 102, 0.4);
        }

        .btn-attachment {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            border: none;
            color: #555;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Scrollbar styling */
        #messages::-webkit-scrollbar {
            width: 6px;
        }

        #messages::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        #messages::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        #messages::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        .wrap-status {
            background: white;
            width: fit-content;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px;
            border-radius: 4px;
        }

        .circle-status-online {
            width: 12px;
            height: 12px;
            background: #198754;
            border-radius: 50%;
        }

        .circle-status-offline {
            width: 12px;
            height: 12px;
            background: #c8301c;
            border-radius: 50%;
        }

        span.status-title {
            color: black;
        }
    </style>
@endsection

@section('content')
    <div class="chat-container">
        <div class="chat-header bg-success text-white">
            <div class="d-flex align-items-center">
                <div>
                    <small class="status"></small>
                </div>
            </div>
        </div>

        <div id="messages" class="chat-body">
            @foreach ($messages as $msg)
                @php

                    if ($msg->sender->document) {
                        $name = trim($msg->sender->document->first_name . ' ' . $msg->sender->document->last_name);
                    } elseif ($msg->sender->email) {
                        $name = $msg->sender->email;
                    } else {
                        $name = $msg->sender->phone;
                    }

                @endphp
                <div class="message {{ $msg->sender_id == auth()->id() ? 'received' : 'sent' }}">
                    @if ($msg->sender_id != auth()->id())
                        <div class="message-sender">{{ $name }}</div>
                    @endif
                    <div class="message-content">
                        {{ $msg->message }}
                        <span class="message-time">
                            {{ $msg->created_at->format('H:i') }}
                            @if ($msg->sender_id == auth()->id())
                                <i class="fas {{ $msg->seen == 1 ? 'fa-check-double text-info' : 'fa-check' }}"></i>
                            @endif
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="chat-footer">
            <form id="chat-form" class="d-flex align-items-center w-100">
                @csrf
                <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                {{-- <button type="button" class="btn-attachment">
                    <i class="fas fa-paperclip"></i>
                </button> --}}
                <textarea name="message" id="message" class="form-control message-input" placeholder="پیام خود را بنویسید..."
                    rows="1" required></textarea>
                <button type="submit" class="btn-send">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
@endsection



@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            @if ($user_status)
                document.querySelector('.status').innerHTML =
                    '<div class="wrap-status"><span class="circle-status-online"></span><span class="status-title">آنلاین</span></div>';
            @else
                document.querySelector('.status').innerHTML =
                    '<div class="wrap-status"><span class="circle-status-offline"></span><span class="status-title">آفلاین</span></div>';
            @endif

            window.Echo.channel('advisors.status')
                .listen('.advisor.status.changed', (e) => {
                    if (e.advisor.id == "{{ $user_id }}") {
                        if (e.advisor.is_online) {
                            document.querySelector('.status').innerHTML =
                                '<div class="wrap-status"><span class="circle-status-online"></span><span class="status-title">آنلاین</span></div>';
                        } else {
                            document.querySelector('.status').innerHTML =
                                '<div class="wrap-status"><span class="circle-status-offline"></span><span class="status-title">آفلاین</span></div>';
                        }
                    }
                });


            const userId = "{{ auth()->id() }}";
            const conversationId = "{{ $conversation->id }}";
            const messagesBox = document.getElementById('messages');
            const form = document.getElementById('chat-form');
            const messageInput = document.getElementById('message');


            // window.Echo.join('join.room')
            //     .here((users) => {
            //         joinroom();
            //     })

            // function joinroom() {
            //     var advisor_id = "{{ $user_id }}";

            //     fetch(`/joinroom?advisor_id=${advisor_id}`, {
            //         method: 'POST',
            //         headers: {
            //             'Content-Type': 'application/json',
            //             'X-CSRF-TOKEN': "{{ csrf_token() }}"
            //         },
            //         body: JSON.stringify({})
            //     });
            // }


            // Auto-resize textarea
            messageInput.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });

            // Scroll to bottom initially
            messagesBox.scrollTop = messagesBox.scrollHeight;

            // Listen to chat events
            // window.Echo.private(`rooms.${conversationId}`)
            //     .listen('.chat.message.sent', (e) => {
            //         addMessage(e.user, e.user.message.message, e.user.message.created_at);
            //         messagesBox.scrollTop = messagesBox.scrollHeight;
            //     });

            window.Echo.join(`rooms.${conversationId}`)
                .here((users) => {
                    // console.log('اعضا حاضر:', users);
                    set_in_room(true, conversationId, userId);
                })
                .joining((user) => {
                    set_in_room(true, conversationId, userId);
                    document.querySelectorAll('.message.received .message-time i.fas').forEach((icon) => {
                        icon.classList.remove('fa-check');
                        icon.classList.add('fa-check-double', 'text-info');
                    });
                })
                .leaving((user) => {
                    set_in_room(false, conversationId, userId);
                })
                .listen('.chat.message.sent', (e) => {
                    addMessage(e.user, e.user.message, e.user.message.created_at);
                    messagesBox.scrollTop = messagesBox.scrollHeight;
                });

            window.addEventListener('beforeunload', function() {
                set_in_room(false, conversationId, userId);
            });

            function set_in_room(status, conversationId, user_id) {
                fetch('/set-in-room', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            user_id: user_id,
                            conversation_id: conversationId,
                            status: status
                        })
                    })
                    .then(response => {
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            // Add message to chat
            function addMessage(user, msg, timestamp) {
                const isMe = user.id == userId;
                const time = new Date(timestamp).toLocaleTimeString('fa-IR', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${isMe ? 'received' : 'sent'}`;


                if (!isMe) {
                    messageDiv.innerHTML = `
                <div class="message-sender">${user.name}</div>
                <div class="message-content">
                    ${msg.message}
                    <span class="message-time">${time}</span>
                </div>
            `;
                } else {
                    const seenClass = msg.seen == 1 ? 'fa-check-double text-info' : 'fa-check';

                    messageDiv.innerHTML = `
                <div class="message-content">
                    ${msg.message}
                    <span class="message-time">${time} <i class="fas ${seenClass}"></i></span>
                </div>
            `;
                }

                messagesBox.appendChild(messageDiv);
                messagesBox.scrollTop = messagesBox.scrollHeight;
            }

            // Send message via AJAX
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const message = messageInput.value.trim();
                if (!message) return;

                fetch("{{ route('chat.send') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            conversation_id: conversationId,
                            message: message,
                        }),
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('خطا در ارسال پیام');
                        return response.json();
                    })
                    .then(() => {
                        messageInput.value = '';
                        messageInput.style.height = 'auto';
                    })
                    .catch(error => {
                        console.error(error);
                        alert(error.message);
                    });
            });
        });
    </script>
@endpush
