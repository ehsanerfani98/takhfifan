<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Events\JoinUserConversionEvent;
use App\Events\OnlineEvent;
use App\Events\OnlineEventUser;
use App\Models\Conversation;
use App\Models\ConversationUserStatus;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{

    // لیست گفتگوهای کاربر یا مشاور
    public function index()
    {
        $user = Auth::user();

        $conversations = $user->hasRole('advisor')
            ? $user->conversationsAsAdvisor()->with('user')->get()
            : $user->conversationsAsUser()->with('advisor')->get();

        return view('site.chat.index', compact('conversations'));
    }

    // شروع یک گفتگو با مشاور (اگر وجود نداشت)
    public function startConversationUser(User $advisor)
    {

        $user = Auth::user();

        $conversation = Conversation::where('user_id', $user->id)
            ->where('advisor_id', $advisor->id);

        if ($conversation->exists()) {
            $conversation->id = $conversation->first()->id;
            broadcast(new JoinUserConversionEvent(false, $user))->toOthers();
        } else {
            if ($user->hasRole('User')) {
                $conversation = Conversation::firstOrCreate([
                    'user_id' => $user->id,
                    'advisor_id' => $advisor->id
                ]);
            }
            broadcast(new JoinUserConversionEvent(true, $user))->toOthers();
        }

        return redirect()->route('user.chat.room', [$conversation->id, $advisor->id]);
    }

    // نمایش صفحه‌ی چت روم
    public function showConversation(Conversation $conversation, $user_id)
    {
        $user = Auth::user();

        // بررسی وضعیت آنلاین کاربر مقابل
        $user_status = User::findOrFail($user_id)->is_online;

        // اطمینان از دسترسی کاربر یا مشاور
        $this->authorizeAccess($conversation);

        // علامت‌گذاری پیام‌های خوانده‌نشده از طرف مقابل به عنوان خوانده‌شده
        $conversation->messages()
            ->where('sender_id', $user_id)
            ->where('seen', false)
            ->update(['seen' => true]);

        // بارگذاری پیام‌ها با اطلاعات ارسال‌کننده
        $messages = $conversation->messages()->with('sender')->get();

        if ($user->hasRole('User')) {
            return view('site.chat.room', [
                'conversation' => $conversation,
                'messages' => $messages,
                'user_status' => $user_status,
                'user_id' => $user_id,
            ]);
        }
    }


    // ارسال پیام از فرم Blade
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string',
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);
        $this->authorizeAccess($conversation);

        $senderId = Auth::id();

        // تشخیص آی‌دی کاربر مقابل
        $receiverId = $conversation->user_id == $senderId
            ? $conversation->advisor_id
            : $conversation->user_id;


        // بررسی حضور کاربر مقابل در روم
        $inRoom = ConversationUserStatus::where('conversation_id', $conversation->id)
            ->where('user_id', $receiverId)
            ->where('in_room', true)
            ->exists();

        // ایجاد پیام با توجه به وضعیت seen
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $senderId,
            'message' => $request->message,
            'seen' => $inRoom ? 1 : 0,
        ]);
        // ارسال ایونت برای کاربران دیگر
        broadcast(new ChatEvent($message, $conversation->id, Auth::user(), $receiverId))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'پیام با موفقیت ارسال شد',
            'receiverId' => $receiverId,
            'data' => $message,
        ]);
    }


    protected function authorizeAccess(Conversation $conversation)
    {
        $user = Auth::user();
        $userId = $user->id;
        if ($user->hasRole('User')) {
            if ($conversation->user_id !== $userId) {
                abort(403, 'دسترسی غیرمجاز به گفتگو.');
            }
        }
        if ($user->hasRole('advisor')) {
            if ($conversation->advisor_id !== $userId) {
                abort(403, 'دسترسی غیرمجاز به گفتگو.');
            }
        }
    }

    public function onlineAdvisors(Request $request)
    {
        $currentUser = User::findOrFail($request->user_id);

        // دریافت همه مشاوران آنلاین
        $advisors = User::role('advisor')
            ->where('is_online', true)
            ->with('document')
            ->get();

        // محاسبه تعداد پیام‌های خوانده نشده برای هر مشاور
        $advisorsWithUnreadCounts = $advisors->map(function ($advisor) use ($currentUser) {
            $name = $advisor->document
                ? trim($advisor->document->first_name . ' ' . $advisor->document->last_name)
                : ($advisor->email ?? $advisor->phone);

            return [
                'id' => $advisor->id,
                'name' => $name,
                'is_online' => $advisor->is_online,
                'unread_count' => getUnreadCount($advisor->id, $currentUser->id),
            ];
        });

        return response()->json($advisorsWithUnreadCounts);
    }







    // public function onlineAdvisors()
    // {
    //     $advisors = User::role('advisor')
    //         ->where('is_online', true)
    //         ->with('document') // eager load
    //         ->get();

    //     $formatted = $advisors->map(function ($advisor) {
    //         if ($advisor->document) {
    //             $name = trim($advisor->document->first_name . ' ' . $advisor->document->last_name);
    //         } elseif ($advisor->email) {
    //             $name = $advisor->email;
    //         } else {
    //             $name = $advisor->phone;
    //         }

    //         return [
    //             'id' => $advisor->id,
    //             'name' => $name,
    //         ];
    //     });

    //     return response()->json($formatted);
    // }

    // public function onlineUsers(Request $request)
    // {
    //     $currentUser = User::findOrFail($request->user_id);

    //     // دریافت همه کانورژن‌هایی که کاربر در آن‌ها حضور دارد
    //     $conversations = Conversation::query()
    //         ->where('user_id', $currentUser->id)
    //         ->orWhere('advisor_id', $currentUser->id)
    //         ->with(['user.document', 'advisor.document'])
    //         ->get();

    //     // استخراج کاربران طرف مقابل (نه خود کاربر)
    //     $relatedUsers = $conversations->map(function ($conversation) use ($currentUser) {
    //         return $conversation->user_id === $currentUser->id
    //             ? $conversation->advisor
    //             : $conversation->user;
    //     })->unique('id'); // حذف تکراری‌ها

    //     // فرمت‌دهی به خروجی
    //     $formatted = $relatedUsers->map(function ($user) {
    //         if ($user->document) {
    //             $name = trim($user->document->first_name . ' ' . $user->document->last_name);
    //         } elseif ($user->email) {
    //             $name = $user->email;
    //         } else {
    //             $name = $user->phone;
    //         }

    //         return [
    //             'id' => $user->id,
    //             'name' => $name,
    //             'is_online' => $user->is_online,
    //         ];
    //     })->values(); // مرتب‌سازی اندیس‌ها

    //     return response()->json($formatted);
    // }

    public function onlineUsers(Request $request)
    {
        $currentUser = User::findOrFail($request->user_id);

        // دریافت همه کانورژن‌هایی که کاربر در آن‌ها حضور دارد
        $conversations = Conversation::query()
            ->where('user_id', $currentUser->id)
            ->orWhere('advisor_id', $currentUser->id)
            ->with(['user.document', 'advisor.document', 'messages'])
            ->get();

        // استخراج کاربران طرف مقابل (نه خود کاربر)
        $relatedUsers = $conversations->map(function ($conversation) use ($currentUser) {
            return $conversation->user_id === $currentUser->id
                ? $conversation->advisor
                : $conversation->user;
        })->unique('id'); // حذف تکراری‌ها

        // محاسبه تعداد پیام‌های خوانده نشده برای هر کاربر
        $usersWithUnreadCounts = $relatedUsers->map(function ($user) use ($currentUser) {
            $unreadCount = getUnreadCount($user->id, $currentUser->id);

            $name = $user->document
                ? trim($user->document->first_name . ' ' . $user->document->last_name)
                : ($user->email ?? $user->phone);

            return [
                'id' => $user->id,
                'name' => $name,
                'is_online' => $user->is_online,
                'unread_count' => $unreadCount,
            ];
        });

        return response()->json($usersWithUnreadCounts);
    }

    public function advisors()
    {
        return view('site.chat.advisors');
    }

    public function markOnline(Request $request)
    {
        $user = auth()->user();

        if (!$user->hasRole('advisor')) {
            return response()->json(['error' => 'unauthorized'], 403);
        }

        $user->update(['is_online' => true]);
        broadcast(new OnlineEvent($user))->toOthers();

        return response()->json(['success' => true]);
    }

    public function markOffline(Request $request)
    {
        $user = auth()->user();

        if ($user->hasRole('advisor')) {
            $user->update(['is_online' => false]);
            broadcast(new OnlineEvent($user))->toOthers();
        }

        return response()->json(['success' => true]);
    }
    public function markOnlineUser(Request $request)
    {
        $user = auth()->user();

        if (!$user->hasRole('User')) {
            return response()->json(['error' => 'unauthorized'], 403);
        }

        $user->update(['is_online' => true]);
        broadcast(new OnlineEventUser($user))->toOthers();

        return response()->json(['success' => true]);
    }

    public function markOfflineUser(Request $request)
    {
        $user = auth()->user();

        if ($user->hasRole('User')) {
            $user->update(['is_online' => false]);
            broadcast(new OnlineEventUser($user))->toOthers();
        }

        return response()->json(['success' => true]);
    }

    public function setInRoom(Request $request)
    {
        ConversationUserStatus::updateOrCreate(
            ['conversation_id' => $request->conversation_id, 'user_id' => $request->user_id],
            ['in_room' => $request->status]
        );
    }
}
