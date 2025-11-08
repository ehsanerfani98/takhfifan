@extends('site.layout')

@section('content')
    <div class="container">
        <h4>مشاورهای آنلاین</h4>
        <div id="advisor-list" class="row"></div>
    </div>
@endsection

@section('css')
    <style>
        .unread-badge {
            background-color: #ff3b30;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
            margin-left: 8px;
        }

        .advisor-item {
            transition: all 0.3s ease;
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const list = document.getElementById('advisor-list');
            const currentUserId = "{{ auth()->id() }}";
            let unreadCounts = {}; // شیء برای ذخیره تعداد پیام‌های خوانده نشده

            function updateList(advisors) {
                // ذخیره وضعیت unread_count قبل از پاک کردن لیست
                const existingItems = list.querySelectorAll('[id^="advisor-"]');
                existingItems.forEach(item => {
                    const advisorId = item.id.replace('advisor-', '');
                    const unreadBadge = item.querySelector('.unread-badge');
                    if (unreadBadge) {
                        unreadCounts[advisorId] = parseInt(unreadBadge.textContent);
                    }
                });

                list.innerHTML = '';
                advisors.forEach(advisor => {
                    // اگر تعداد خوانده نشده ذخیره شده وجود دارد، از آن استفاده کنید
                    if (unreadCounts[advisor.id] !== undefined) {
                        advisor.unread_count = unreadCounts[advisor.id];
                    }
                    addAdvisor(advisor);
                });
            }

            function addAdvisor(user) {
                const existingItem = document.getElementById(`advisor-${user.id}`);
                if (existingItem) {
                    // اگر آیتم وجود دارد، فقط آن را به روز کنید
                    const unreadBadge = existingItem.querySelector('.unread-badge');
                    if (user.unread_count > 0) {
                        if (!unreadBadge) {
                            existingItem.querySelector('div').insertAdjacentHTML('afterbegin',
                                `<span class="unread-badge">${user.unread_count}</span>`);
                        } else {
                            unreadBadge.textContent = user.unread_count;
                        }
                    } else if (unreadBadge) {
                        unreadBadge.remove();
                    }
                    return;
                }

                const li = document.createElement('div');
                li.id = `advisor-${user.id}`;
                li.className = 'bg-white p-3 shadow col-12 col-md-6 col-xl-6 d-flex justify-content-between align-items-center mb-3 advisor-item';

                // نمایش تعداد پیام‌های خوانده نشده
                const unreadBadge = user.unread_count > 0 ?
                    `<span class="unread-badge">${user.unread_count}</span>` : '';

                li.innerHTML = `
                    <div>
                        ${unreadBadge}
                        ${user.name}
                    </div>
                    <a href="/chat/start/${user.id}" class="btn btn-sm btn-success">شروع چت</a>
                `;

                list.appendChild(li);
            }

            function removeAdvisor(id) {
                const el = document.getElementById(`advisor-${id}`);
                if (el) el.remove();
            }

            // دریافت اولیه لیست آنلاین‌ها
            fetch(`/api/online-advisors?user_id=${currentUserId}`)
                .then(res => res.json())
                .then(data => {
                    // ذخیره تعداد پیام‌های خوانده نشده اولیه
                    data.forEach(advisor => {
                        if (advisor.unread_count > 0) {
                            unreadCounts[advisor.id] = advisor.unread_count;
                        }
                    });
                    updateList(data);
                });

            // گوش دادن به تغییرات وضعیت مشاوران
            window.Echo.channel('advisors.status')
                .listen('.advisor.status.changed', (e) => {
                    if (e.advisor.is_online) {
                        // هنگام آنلاین شدن، اگر تعداد خوانده نشده ذخیره شده وجود دارد، از آن استفاده کنید
                        if (unreadCounts[e.advisor.id] !== undefined) {
                            e.advisor.unread_count = unreadCounts[e.advisor.id];
                        }
                        addAdvisor(e.advisor);
                    } else {
                        removeAdvisor(e.advisor.id);
                    }
                });

            // گوش دادن به پیام‌های جدید
            window.Echo.private(`conversations.user.${currentUserId}`)
                .listen('.chat.message.sent', (e) => {
                    const advisorId = e.user.id;
                    // ذخیره تعداد خوانده نشده
                    const unreadCount = e.user.unread_count || 1;
                    unreadCounts[advisorId] = unreadCount;

                    const advisorElement = document.getElementById(`advisor-${advisorId}`);

                    if (advisorElement) {
                        let unreadBadge = advisorElement.querySelector('.unread-badge');

                        if (unreadCount > 0) {
                            if (!unreadBadge) {
                                advisorElement.querySelector('div').insertAdjacentHTML('afterbegin',
                                    `<span class="unread-badge">${unreadCount}</span>`);
                            } else {
                                unreadBadge.textContent = unreadCount;
                            }
                        } else if (unreadBadge) {
                            unreadBadge.remove();
                        }
                    }
                });
        });
    </script>
@endpush