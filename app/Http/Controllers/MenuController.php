<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('children')
            ->ordered()
            ->latest()->paginate(10);

        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $parentMenus = Menu::root()->active()->ordered()->get();
        return view('admin.menus.create', compact('parentMenus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'nullable|string|max:500',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        Menu::create($validated);

        return redirect()->route('menus.index')
            ->with('success', 'منو با موفقیت ایجاد شد.');
    }

    public function edit(Menu $menu)
    {
        $parentMenus = Menu::root()
            ->active()
            ->where('id', '!=', $menu->id)
            ->ordered()
            ->get();

        return view('admin.menus.edit', compact('menu', 'parentMenus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'nullable|string|max:500',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $menu->update($validated);

        return redirect()->route('menus.index')
            ->with('success', 'منو با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('menus.index')
            ->with('success', 'منو با موفقیت حذف شد.');
    }
}