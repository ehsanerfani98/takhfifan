<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with('author')->latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $page = new Page();
        $page->title = $validated['title'];
        $page->slug = Str::slug($validated['title']);
        $page->description = $validated['description'];
        $page->user_id = auth()->id();
        $page->is_published = $request->is_published;

        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/pages');
            $file->move($destinationPath, $filename);
            $page->featured_image = 'uploads/pages/' . $filename;
        }

        $page->save();

        return redirect()->route('pages.show', $page->slug)->with('success', 'صفحه با موفقیت ساخته شد!');
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->with('author')->firstOrFail();
        return view('admin.pages.show', compact('page'));
    }

    public function edit($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $page->title = $validated['title'];
        $page->slug = Str::slug($validated['title']);
        $page->description = $validated['description'];
        $page->is_published = $request->is_published;

        if ($request->hasFile('featured_image')) {

            if (!is_null($page->featured_image) && !empty($page->featured_image)) {
                $filePath = public_path($page->featured_image);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/pages');
            $file->move($destinationPath, $filename);
            $page->featured_image = 'uploads/pages/' . $filename;

        }

        $page->save();

        return redirect()->route('pages.show', $page->slug)->with('success', 'صفحه با موفقیت بروزرسانس شد!');
    }

    public function destroy($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        if ($page->featured_image) {
            $filePath = public_path($page->featured_image);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $page->delete();
        return redirect()->route('pages.index')->with('success', 'صفحه با موفقیت حذف شد!');
    }
}
