<?php

namespace App\Http\Controllers;

use App\Models\DocumentFile;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function show($user_id)
    {

        $user = User::findOrFail($user_id);
        $document = $user->document;
        if (is_null($document)) {
            return redirect()->back()->with('error', 'مدارکی برای این کاربر وجود ندارد');
        }
        return view('admin.users.document.show', compact('user', 'document'));
    }

    public function edit($user_id)
    {
        $user = User::findOrFail($user_id);
        $document = $user->document;
        return view('admin.users.document.edit', compact('user', 'document'));
    }

    public function update(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $document = $user->document;

        $validated = $request->validate([
            'type' => ['required', 'in:real,legal'],
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_address' => ['nullable', 'string'],
            'national_id' => ['nullable', 'string', 'max:20'],
            'is_verified' => ['nullable', 'boolean'],
            'needs_correction' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'files.*' => ['nullable', 'file', 'max:10240', 'mimetypes:image/jpeg,image/png'],
        ]);

        $document->update([
            'type' => $validated['type'],
            'first_name' => $validated['first_name'] ?? null,
            'last_name' => $validated['last_name'] ?? null,
            'mobile' => $validated['mobile'] ?? null,
            'company_name' => $validated['company_name'] ?? null,
            'company_address' => $validated['company_address'] ?? null,
            'national_id' => $validated['national_id'] ?? null,
            'is_verified' => $request->has('is_verified'),
            'needs_correction' => $request->has('needs_correction'),
            'description' => $validated['description'] ?? null,
        ]);

        if ($request->hasFile('files')) {
            $destinationPath = public_path('uploads/documents');
            if (!\File::exists($destinationPath)) {
                \File::makeDirectory($destinationPath, 0755, true);
            }

            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);

                $document->files()->create([
                    'path' => 'uploads/documents/' . $filename,
                ]);
            }
        }

        return redirect()->back()->with('success', 'مدرک با موفقیت ذخیره شد.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }

    public function deleteFile($id)
    {
        $file = DocumentFile::findOrFail($id);

        $fullPath = public_path($file->path);

        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }

        $file->delete();

        return response()->json(['success' => true]);
    }

}
