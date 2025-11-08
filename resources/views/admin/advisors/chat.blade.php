@extends('admin.layout')

@section('css')
    <style>
        .chat-container {
            display: flex;
            height: calc(100vh - 245px);
            background-color: #f0f2f5;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }

        /* Sidebar styles */
        .chat-sidebar {
            width: 30%;
            min-width: 300px;
            border-right: 1px solid #e9edef;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar-header {
            padding: 10px 16px;
            background-color: #f0f2f5;
            border-bottom: 1px solid #e9edef;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user-list {
            flex: 1;
            overflow-y: auto;
        }

        .user-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid #e9edef;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .user-item:hover {
            background-color: #f5f6f6;
        }

        .user-item.active {
            background-color: #e9edef;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #dfe5e7;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 12px;
            color: #54656f;
            font-weight: bold;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-weight: 500;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-status {
            display: flex;
            align-items: center;
            font-size: 12px;
            color: #667781;
        }

        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-left: 4px;
        }

        .online {
            background-color: #00a884;
        }

        .offline {
            background-color: #d1d7db;
        }

        /* Chat area styles */
        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: #e5ddd5;
            background-image: url('https://web.whatsapp.com/img/bg-chat-tile-light_a4be512e7195b733d9110b408f075d.png');
            position: relative;
        }

        .chat-header {
            padding: 10px 16px;
            background-color: #f0f2f5;
            border-bottom: 1px solid #e9edef;
            display: flex;
            align-items: center;
        }

        .chat-messages {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .message {
            max-width: 65%;
            margin-bottom: 8px;
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
            padding: 8px 12px;
            border-radius: 7.5px;
            position: relative;
            box-shadow: 0 1px 0.5px rgba(0, 0, 0, 0.13);
            word-wrap: break-word;
            line-height: 1.4;
        }

        .received .message-content {
            background-color: #fff;
            border-top-right-radius: 0;
            margin-right: 20px;
        }

        .received .message-content::before {
            content: '';
            position: absolute;
            top: 0;
            right: -8px;
            width: 0;
            height: 0;
            border: 8px solid transparent;
            border-top: 0;
            border-right: 0;
            border-left: 8px solid #fff;
        }

        .sent .message-content {
            background-color: #d9fdd3;
            border-top-left-radius: 0;
            margin-left: 20px;
        }

        .sent .message-content::after {
            content: '';
            position: absolute;
            top: 0;
            left: -8px;
            width: 0;
            height: 0;
            border: 8px solid transparent;
            border-top: 0;
            border-left: 0;
            border-right: 8px solid #d9fdd3;
        }

        .message-time {
            font-size: 11px;
            color: rgba(0, 0, 0, 0.45);
            margin-top: 4px;
            display: block;
            text-align: right;
            direction: ltr;
        }

        .message-sender {
            font-weight: 500;
            margin-bottom: 4px;
            font-size: 13px;
        }

        .sent {
            align-self: flex-end;
        }

        .received {
            align-self: flex-start;
        }

        .chat-input {
            padding: 8px 16px;
            background-color: #f0f2f5;
            display: flex;
            align-items: center;
        }

        .message-input {
            flex: 1;
            border-radius: 8px;
            border: none;
            padding: 9px 12px;
            font-size: 15px;
            background-color: #fff;
            resize: none;
            max-height: 100px;
            margin: 5px 8px;
            box-shadow: none;
        }

        .message-input:focus {
            outline: none;
        }

        .btn-send {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #00a884;
            border: none;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-send:hover {
            background-color: #008069;
        }

        .empty-chat {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #667781;
            text-align: center;
            padding: 20px;
        }

        .empty-chat-icon {
            font-size: 120px;
            margin-bottom: 20px;
            color: #e9edef;
        }

        /* Scrollbar styling */
        .user-list::-webkit-scrollbar,
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .user-list::-webkit-scrollbar-track,
        .chat-messages::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        .user-list::-webkit-scrollbar-thumb,
        .chat-messages::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .user-list::-webkit-scrollbar-thumb:hover,
        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .chat-container {
                flex-direction: column;
                height: calc(100vh - 120px);
            }

            .chat-sidebar {
                width: 100%;
                min-width: auto;
                border-right: none;
                border-bottom: 1px solid #e9edef;
                height: 40%;
            }

            .chat-area {
                height: 60%;
            }
        }

        .unread-count {
            position: absolute;
            top: -5px;
            left: -5px;
            background-color: #ff3b30;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
        }

        .user-avatar-container {
            position: relative;
            width: 40px;
            height: 40px;
            margin-left: 12px;
        }
    </style>
@endsection

@section('content')
    <div class="chat-container">
        <!-- Sidebar with user list -->
        <div class="chat-sidebar">
            <div class="sidebar-header">
                <h5 class="mb-0">کاربران آنلاین</h5>
            </div>
            <div id="user-list" class="user-list"></div>
        </div>

        <!-- Chat area -->
        <div class="chat-area" id="chat-area">
            <div class="empty-chat" id="empty-chat">
                <div class="empty-chat-icon">
                    <i class="fas fa-comment-dots"></i>
                </div>
                <h4>گفتگو را شروع کنید</h4>
                <p class="text-center">برای شروع گفتگو، یک کاربر را از لیست سمت راست انتخاب کنید.</p>
            </div>

            <!-- Dynamic chat content will be loaded here -->
            <div id="active-chat" style="display: flex;height: 100%;flex-direction: column;">

                <div id="messages" class="chat-messages"></div>

                <div class="chat-input">
                    <form id="chat-form" class="d-flex align-items-center w-100">
                        @csrf
                        <input type="hidden" name="conversation_id" id="conversation-id">
                        <textarea name="message" id="message" class="form-control message-input" placeholder="پیام خود را بنویسید..."
                            rows="1" required></textarea>
                        <button type="submit" class="btn-send">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userList = document.getElementById('user-list');
            const emptyChat = document.getElementById('empty-chat');
            const activeChat = document.getElementById('active-chat');
            const messagesBox = document.getElementById('messages');
            const form = document.getElementById('chat-form');
            const messageInput = document.getElementById('message');
            const conversationIdInput = document.getElementById('conversation-id');

            let currentUserId = "{{ auth()->id() }}";
            let activeConversation = null;
            let activeUser = null;


            window.Echo.private(`conversations.user.${currentUserId}`)
                .listen('.chat.message.sent', (e) => {
                    const msgConversationId = e.user.message.conversation_id;

                    // اگر مکالمه فعالی وجود نداشت یا پیام برای مکالمه‌ای غیر از مکالمه فعال فعلی بود
                    if (!activeConversation || msgConversationId !== activeConversation.id) {
                        const userId = e.target_user_id ?? e.user.id;
                        const unreadCount = e.user.unread_count || 1;

                        updateUnreadCount(userId, unreadCount);
                    }
                });



            // Auto-resize textarea
            messageInput.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });

            // Initialize the chat
            function initChat() {
                fetch(`/api/online-users?user_id=${currentUserId}`)
                    .then(res => res.json())
                    .then(data => updateUserList(data));

                setupEchoListeners();
            }

            // Update user list
            function updateUserList(users) {
                userList.innerHTML = '';
                users.forEach(user => addUserToSidebar(user));
            }

            // Add user to sidebar
            // function addUserToSidebar(user) {
            //     const userItem = document.createElement('div');
            //     userItem.className = 'user-item';
            //     userItem.id = `user-item-${user.id}`;
            //     userItem.dataset.userId = user.id;

            //     // Get first letter of name for avatar
            //     const avatarLetter = user.name ? user.name.charAt(0).toUpperCase() : 'U';

            //     userItem.innerHTML = `
        //         <div class="user-avatar">${avatarLetter}</div>
        //         <div class="user-info">
        //             <div class="user-name">${user.name}</div>
        //             <div class="user-status">
        //                 <span class="status-indicator ${user.is_online ? 'online' : 'offline'}"></span>
        //                 <span>${user.is_online ? 'آنلاین' : 'آفلاین'}</span>
        //             </div>
        //         </div>
        //     `;

            //     userItem.addEventListener('click', () => startChatWithUser(user));
            //     userList.appendChild(userItem);
            // }

            // Add user to sidebar
            function addUserToSidebar(user) {
                const userItem = document.createElement('div');
                userItem.className = 'user-item';
                userItem.id = `user-item-${user.id}`;
                userItem.dataset.userId = user.id;

                // Get first letter of name for avatar
                const avatarLetter = user.name ? user.name.charAt(0).toUpperCase() : 'U';

                // Create unread badge if there are unread messages
                const unreadBadge = user.unread_count > 0 ?
                    `<div class="unread-count">${user.unread_count}</div>` :
                    '';

                userItem.innerHTML = `
        <div class="user-avatar-container">
            <div class="user-avatar">${avatarLetter}</div>
            ${unreadBadge}
        </div>
        <div class="user-info">
            <div class="user-name">${user.name}</div>
            <div class="user-status">
                <span class="status-indicator ${user.is_online ? 'online' : 'offline'}"></span>
                <span>${user.is_online ? 'آنلاین' : 'آفلاین'}</span>
            </div>
        </div>
    `;

                userItem.addEventListener('click', () => startChatWithUser(user));
                userList.appendChild(userItem);
            }

            function updateUnreadCount(userId, count) {
                const userItem = document.getElementById(`user-item-${userId}`);
                if (userItem) {
                    const avatarContainer = userItem.querySelector('.user-avatar-container');
                    let unreadBadge = avatarContainer.querySelector('.unread-count');

                    if (count > 0) {
                        if (!unreadBadge) {
                            unreadBadge = document.createElement('div');
                            unreadBadge.className = 'unread-count';
                            avatarContainer.appendChild(unreadBadge);
                        }
                        unreadBadge.textContent = count;
                    } else if (unreadBadge) {
                        unreadBadge.remove();
                    }
                }
            }

            // Start chat with selected user
            function startChatWithUser(user) {
                // Mark active user in sidebar
                document.querySelectorAll('.user-item').forEach(item => {
                    item.classList.remove('active');
                });
                document.getElementById(`user-item-${user.id}`).classList.add('active');

                // Show loading state
                emptyChat.style.display = 'none';
                activeChat.style.display = 'flex';
                messagesBox.innerHTML = '<div class="text-center py-4">در حال بارگذاری...</div>';

                // Set active user info
                activeUser = user;

                // Fetch or create conversation
                fetch(`/admin/chat/start/${user.id}`, {
                        headers: {
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            loadConversation(data.conversation_id, user.id);
                        }
                    })
                    .catch(error => {
                        console.error('Error starting conversation:', error);
                        messagesBox.innerHTML =
                            '<div class="text-center py-4 text-danger">خطا در بارگذاری گفتگو</div>';
                    });
            }

            // Load conversation messages
            function loadConversation(conversationId, userId) {
                fetch(`/admin/chat/room/${conversationId}/${userId}`, {
                        headers: {
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        updateUnreadCount(userId, 0);
                        activeConversation = data.conversation;
                        conversationIdInput.value = activeConversation.id;

                        // Clear and render messages
                        messagesBox.innerHTML = '';
                        if (data.messages && data.messages.length > 0) {
                            data.messages.forEach(msg => {
                                addMessageToChatFirst(msg, false);
                            });
                            messagesBox.scrollTop = messagesBox.scrollHeight;
                        } else {
                            messagesBox.innerHTML =
                                '<div class="text-center py-4">هیچ پیامی وجود ندارد. گفتگو را شروع کنید!</div>';
                        }

                        // Setup Echo listener for this conversation
                        setupConversationListener(activeConversation.id);
                    })
                    .catch(error => {
                        console.error('Error loading conversation:', error);
                        messagesBox.innerHTML =
                            '<div class="text-center py-4 text-danger">خطا در بارگذاری پیام‌ها</div>';
                    });
            }

            function addMessageToChatFirst(msg, isNew = true) {
                const isMe = msg.sender_id == currentUserId;
                const time = new Date(msg.created_at).toLocaleTimeString('fa-IR', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${isMe ? 'received' : 'sent'}`;

                let senderName = msg.sender.name;
                if (msg.sender.document) {
                    senderName = `${msg.sender.document.first_name} ${msg.sender.document.last_name}`.trim();
                } else if (msg.sender.email) {
                    senderName = msg.sender.email;
                } else {
                    senderName = msg.sender.phone;
                }

                if (!isMe) {
                    messageDiv.innerHTML = `
                        <div class="message-sender">${senderName}</div>
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

                if (isNew) {
                    messagesBox.scrollTop = messagesBox.scrollHeight;
                }
            }

            function addMessageToChat(msg, isNew = true) {
                const isMe = msg.id == currentUserId;
                const time = new Date(msg.message.created_at).toLocaleTimeString('fa-IR', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${isMe ? 'received' : 'sent'}`;

                let senderName = msg.name;


                if (!isMe) {
                    messageDiv.innerHTML = `
                        <div class="message-sender">${senderName}</div>
                        <div class="message-content">
                            ${msg.message.message}
                            <span class="message-time">${time}</span>
                        </div>
                    `;
                } else {
                    const seenClass = msg.message.seen == 1 ? 'fa-check-double text-info' : 'fa-check';
                    messageDiv.innerHTML = `
                        <div class="message-content">
                            ${msg.message.message}
                            <span class="message-time">${time} <i class="fas ${seenClass}"></i></span>
                        </div>
                    `;
                }

                messagesBox.appendChild(messageDiv);

                if (isNew) {
                    messagesBox.scrollTop = messagesBox.scrollHeight;
                }
            }


            window.Echo.channel('user.join')
                .listen('.user.is.join', (e) => {
                    if (e.status) {
                        addUserToSidebar(e.user);
                    }
                });


            // Setup Echo listeners
            function setupEchoListeners() {
                // User status changes
                window.Echo.channel('users.status')
                    .listen('.user.status.changed', (e) => {

                        const userItem = document.getElementById(`user-item-${e.user.id}`);
                        if (userItem) {
                            const statusElement = userItem.querySelector('.user-status span:nth-child(2)');
                            const indicator = userItem.querySelector('.status-indicator');

                            if (e.user.is_online) {
                                statusElement.textContent = 'آنلاین';
                                indicator.classList.remove('offline');
                                indicator.classList.add('online');
                            } else {
                                statusElement.textContent = 'آفلاین';
                                indicator.classList.remove('online');
                                indicator.classList.add('offline');
                            }

                            // Update status in active chat if this is the current user
                            if (activeUser && activeUser.id === e.user.id) {
                                activeUser.is_online = e.user.is_online;
                            }
                        }
                    });

                // Online advisors presence channel
                window.Echo.join('online.advisors')
                    .here((users) => {
                        markMeOnline();
                    })
                    .leaving((user) => {
                        if (user.id === currentUserId) {
                            markMeOffline();
                        }
                    });
            }

            // Setup conversation listener
            let activeChannel = null;

            function setupConversationListener(conversationId) {
                // اگر کانال قبلی وجود داشت، آن را ترک کن
                if (activeChannel) {
                    window.Echo.leave(activeChannel);
                }

                // ثبت کانال جدید
                activeChannel = `rooms.${conversationId}`;

                window.Echo.join(`rooms.${conversationId}`)
                    .here((users) => {
                        // console.log('اعضا حاضر:', users);
                        set_in_room(true, conversationId, currentUserId);
                    })
                    .joining((user) => {
                        set_in_room(true, conversationId, currentUserId);
                        document.querySelectorAll('.message.received .message-time i.fas').forEach((icon) => {
                            icon.classList.remove('fa-check');
                            icon.classList.add('fa-check-double', 'text-info');
                        });
                    })
                    .leaving((user) => {
                        set_in_room(false, conversationId, currentUserId);
                    })
                    .listen('.chat.message.sent', (e) => {
                        if (e.user.message.conversation_id == conversationId) {
                            addMessageToChat(e.user);
                        }
                    });

                window.addEventListener('beforeunload', function() {
                    set_in_room(false, conversationId, currentUserId);
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
                        .then(response => {})
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }

            }

            // Send message
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const message = messageInput.value.trim();
                if (!message || !activeConversation) return;

                fetch("{{ route('chat.send') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            conversation_id: activeConversation.id,
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

            // Mark user online/offline
            function markMeOnline() {
                fetch('/mark-online', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({})
                });
            }

            function markMeOffline() {
                fetch('/mark-offline', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({})
                });
            }

            window.addEventListener('beforeunload', markMeOffline);

            // Initialize the chat
            initChat();
        });
    </script>
@endsection
