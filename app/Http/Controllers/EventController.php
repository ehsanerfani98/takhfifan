<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Event;
use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Event $event)
    {
        $user = Auth::user();
        if ($user->hasRole('Admin')) {
            $events = Event::with('type')
                ->orderBy('send_date', 'desc')
                ->paginate(10);
        } else {
            $events = Event::where('user_id', $user->id)
                ->with('type')
                ->orderBy('send_date', 'desc')
                ->paginate(10);
        }
        return view('admin.events.index', compact('event', 'events'));
    }

    public function create(Event $event)
    {
        $eventTypes = EventType::all();
        $user = Auth::user()->load('contacts');
        return view('admin.events.create', compact('event', 'eventTypes', 'user'));
    }

    public function store(Request $request, Event $event)
    {
        $this->validate($request, [
            'type_id' => 'required|exists:event_types,id',
            'contact_id' => 'required',
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'send_date' => 'required|date',
            'remind_at' => 'required|date|before:send_date',
            'status' => 'sometimes|in:pending,sent,failed',
        ]);

        $event = new Event($request->all());
        $event->user_id = Auth::id();
        $contact = Contact::findOrFail($request->contact_id);
        $contact->events()->save($event);

        return redirect()->route('events.index', $event->id)
            ->with('success', 'رویداد با موفقیت ایجاد شد.');
    }

    public function edit(Event $event)
    {
        if ($event->status == 'sent') {
            return redirect()->back()->with('error', 'رویدادهای ارسال شده قابلیت ویرایش ندارند!');
        }

        $eventTypes = EventType::all();
        $user = Auth::user()->load('contacts');
        return view('admin.events.edit', compact('event', 'eventTypes', 'user'));
    }

    public function update(Request $request, Event $event)
    {

        $this->validate(
            $request,
            [
                'type_id' => 'required|exists:event_types,id',
                'contact_id' => 'required',
                'title' => 'required|string|max:255',
                'notes' => 'nullable|string',
                'send_date' => 'required|date',
                'remind_at' => 'required|date|before:send_date',
                'status' => 'sometimes|in:pending,sent,failed',
            ],
            [
                'remind_at' => 'تاریخ یادآوری باید قبل از تاریخ ارسال پیام باشد'
            ]
        );

        $event->update($request->all());
        $contact = Contact::findOrFail($request->contact_id);
        $contact->events()->save($event);

        return redirect()->route('events.index', $event->id)
            ->with('success', 'رویداد با موفقیت ویرایش شد.');
    }

    public function destroy(Event $event)
    {

        $event->delete();

        return redirect()->route('events.index', $event->id)
            ->with('success', 'رویداد با موفقیت حذف شد.');
    }
}
