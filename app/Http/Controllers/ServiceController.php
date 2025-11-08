<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $services = Service::where('is_active', 1)->get();
        return view('admin.services.create', compact(['services']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'icon'        => 'required',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'rules' => 'nullable|string',
            'parent_id'   => 'nullable|uuid|exists:services,id',
        ]);

        Service::create([
            'icon'        => $request->icon,
            'name'        => $request->name,
            'description' => $request->description,
            'rules' => $request->rules,
            'is_active'   => $request->has('is_active'),
            'parent_id'   => $request->filled('parent_id') ? $request->parent_id : null,
        ]);

        return redirect()->route('services.index')
            ->with('success', 'خدمت جدید با موفقیت ایجاد شد.');
    }

    public function edit(Service $service)
    {
        $services = Service::where('is_active', 1)->get();
        return view('admin.services.edit', compact(['service', 'services']));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'icon'        => 'required',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'rules' => 'nullable|string',
            'parent_id'   => [
                'nullable',
                'uuid',
                'exists:services,id',
                Rule::notIn([$service->id]),
            ],
        ]);

        $service->update([
            'icon'        => $request->icon,
            'name'        => $request->name,
            'description' => $request->description,
            'rules' => $request->rules,
            'is_active'   => $request->has('is_active'),
            'parent_id'   => $request->filled('parent_id') ? $request->parent_id : null,
        ]);

        return redirect()->route('services.index')
            ->with('success', 'خدمت با موفقیت بروزرسانی شد.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'خدمت حذف شد.');
    }
}
