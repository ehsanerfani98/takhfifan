@extends('admin.layout')
@section('title', 'کاربران آنلاین در سامانه')


@section('content')
        <div class="col-md-12">
            <div id="user-list" class="row"></div>
        </div>
@endsection

@section('js')
    @vite(['resources/js/app.js'])
    <script>
        window.currentUserId = "{{ auth()->id() }}";
        document.addEventListener('DOMContentLoaded', function() {


            const list = document.getElementById('user-list');

            function updateList(users) {
                list.innerHTML = '';
                users.forEach(adduser);
            }

            function adduser(user) {
                const li = document.createElement('li');
                li.id = `user-${user.id}`;
                li.className = 'col-md-6 col-lg-3 card shadow p-3 d-flex flex-row justify-content-between align-items-center mb-2';
                li.innerHTML = `
${user.name}
<a href="/admin/chat/start/${user.id}" class="btn btn-sm btn-success">شروع چت</a>
`;
                list.appendChild(li);
            }


            function removeuser(id) {
                const el = document.getElementById(`user-${id}`);
                if (el) el.remove();
            }

            fetch('/api/online-users')
                .then(res => res.json())
                .then(data => updateList(data));

            window.Echo.channel('users.status')
                .listen('.user.status.changed', (e) => {
                    if (e.user.is_online) {
                        adduser(e.user);
                    } else {
                        removeuser(e.user.id);
                    }
                });


            window.Echo.join('online.advisors')
                .here((users) => {
                    markMeOnline();
                })
                .leaving((user) => {
                    if (user.id === currentUserId) {
                        markMeOffline();
                    }
                });


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

            window.addEventListener('beforeunload', function() {
                markMeOffline();
            });

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



        });
    </script>
@endsection
