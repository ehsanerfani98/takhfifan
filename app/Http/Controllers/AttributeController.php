<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:attribute-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:attribute-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:attribute-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:attribute-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $attributes = Attribute::orderBy('sort_order')->latest()->paginate(10);
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.attributes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'slug'  => 'required|unique:attributes',
            'label' => 'required',
            'type'  => 'required|in:string,number,boolean,select,range',
            'sort_order'  => 'required',
        ]);

        Attribute::create($request->all());

        return redirect()->route('attributes.index')->with('success', 'ویژگی ایجاد شد');
    }

    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name'  => 'required',
            'slug'  => 'required|unique:attributes,slug,' . $attribute->id,
            'label' => 'required',
            'type'  => 'required|in:string,number,boolean,select,range',
            'sort_order'  => 'required',
        ]);

        if(is_null($request->is_multiple)){
            $request['is_multiple'] = 0;
        }

        if(is_null($request->is_active)){
            $request['is_active'] = 0;
        }

        if(is_null($request->show_in_card)){
            $request['show_in_card'] = 0;
        }

        if(is_null($request->is_filter)){
            $request['is_filter'] = 0;
        }

        if(is_null($request->format_thousands)){
            $request['format_thousands'] = 0;
        }

        $attribute->update($request->all());

        return redirect()->route('attributes.index')->with('success', 'ویژگی بروزرسانی شد');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('attributes.index')->with('success', 'ویژگی حذف شد');
    }
}
