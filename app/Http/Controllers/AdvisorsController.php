<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvisorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:advisor-list', ['only' => ['chat']]);
        $this->middleware('permission:advisor-create', ['only' => ['startConversationAdvisor', 'showConversationAdvisor']]);
    }

    public function chat()
    {
        return view('admin.advisors.chat');
    }

    public function startConversationAdvisor(User $advisor)
    {
        $user = Auth::user();

        // اگر قبلاً گفتگویی با این مشاور داشته، ادامه بده
        if ($user->hasRole('advisor')) {
            $conversation = Conversation::firstOrCreate([
                'user_id' => $advisor->id,
                'advisor_id' => $user->id
            ]);
        }

        // اگر درخواست AJAX باشد
        if (request()->wantsJson()) {
            return response()->json([
                'conversation_id' => $conversation->id
            ]);
        }

        return redirect()->route('advisor.chat.room', [$conversation->id, $advisor->id]);
    }

    public function showConversationAdvisor(Conversation $conversation, $user_id)
    {
        $user = Auth::user();
        $user_status = User::findOrFail($user_id)->is_online;

        // اطمینان از دسترسی کاربر یا مشاور
        $this->authorizeAccess($conversation);

        $conversation->messages()
            ->where('sender_id', $user_id)
            ->where('seen', false)
            ->update(['seen' => true]);

        $messages = $conversation->messages()->with('sender')->get();

        // اگر درخواست AJAX باشد
        if (request()->wantsJson()) {
            return response()->json([
                'conversation' => $conversation,
                'messages' => $messages,
                'user_status' => $user_status,
                'user_id' => $user_id
            ]);
        }

        if ($user->hasRole('advisor')) {
            return view('admin.advisors.room', [
                'conversation' => $conversation,
                'messages' => $messages,
                'user_status' => $user_status,
                'user_id' => $user_id
            ]);
        }
    }
    protected function authorizeAccess(Conversation $conversation)
    {
        $userId = Auth::id();
        if ($conversation->advisor_id !== $userId) {
            abort(403, 'دسترسی غیرمجاز به گفتگو.');
        }
    }
}
