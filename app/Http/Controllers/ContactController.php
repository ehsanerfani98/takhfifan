<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->hasRole('Admin')) {
            $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        } else {
            $contacts = Contact::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return view('admin.contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^[0][9][0-9]{9,9}$/',
        ]);

        $input = $request->all();
        $input['user_id'] = Auth::id();
        Contact::create($input);

        return redirect()->back()->with('success', 'مخاطب با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^[0][9][0-9]{9,9}$/',
        ]);

        $contact->update($request->all());

        return redirect()->route('contacts.index')->with('success', 'مخاطب با موفقیت ویرایش شد.');
    }

    public function destroy(Contact $contact)
    {

        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'مخاطب با موفقیت حذف شد.');
    }
}
