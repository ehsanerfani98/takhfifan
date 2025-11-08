<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:attribute-values-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:attribute-values-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:attribute-values-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:attribute-values-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $values = AttributeValue::with('attribute')->paginate(10);
        return view('admin.attribute_values.index', compact('values'));
    }

    public function create()
    {
        $attributes = Attribute::where('type', 'select')->pluck('name', 'id');
        return view('admin.attribute_values.create', compact('attributes'));
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        $attribute = Attribute::find($request->attribute_id);
        if ($attribute->type !== 'select') {
            return back()->with('error', 'فقط برای ویژگی‌های انتخابی (select) می‌توان مقدار ایجاد کرد');
        }

        AttributeValue::create([
            'attribute_id' => $request->attribute_id,
            'value'        => $request->value,
            'slug'         => $request->slug,
            'is_active'    => $request->boolean('is_active'),
        ]);

        return redirect()->route('attribute-values.index')->with('success', 'مقدار ایجاد شد');
    }

    public function edit($id)
    {
        $attributeValue = AttributeValue::findOrFail($id);
        $attributes = Attribute::where('type', 'select')->pluck('name', 'id');

        if ($attributeValue->attribute->type !== 'select') {
            return redirect()->route('attribute-values.index')
                ->with('error', 'ویرایش فقط برای ویژگی‌های انتخابی (select) مجاز است');
        }

        return view('admin.attribute_values.edit', compact('attributeValue', 'attributes'));
    }

    public function update(Request $request, $id)
    {
        $attributeValue = AttributeValue::findOrFail($id);

        if ($attributeValue->attribute->type !== 'select') {
            return redirect()->route('attribute-values.index')
                ->with('error', 'ویرایش فقط برای ویژگی‌های انتخابی (select) مجاز است');
        }

        $this->validateRequest($request, $id);

        $attribute = Attribute::find($request->attribute_id);
        if ($attribute->type !== 'select') {
            return back()->with('error', 'فقط برای ویژگی‌های انتخابی (select) می‌توان مقدار ایجاد کرد');
        }

        $attributeValue->update([
            'attribute_id' => $request->attribute_id,
            'value'        => $request->value,
            'slug'         => $request->slug,
            'is_active'    => $request->boolean('is_active'),
        ]);

        return redirect()->route('attribute-values.index')->with('success', 'مقدار با موفقیت ویرایش شد');
    }

    public function destroy(AttributeValue $attributeValue)
    {
        if ($attributeValue->carAttributeValues()->exists()) {
            return redirect()->route('attribute-values.index')
                ->with('error', 'این مقدار در حال استفاده است و نمی‌توان آن را حذف کرد');
        }

        $attributeValue->delete();
        return redirect()->route('attribute-values.index')->with('success', 'مقدار حذف شد');
    }

    private function validateRequest(Request $request, $id = null)
    {
        $rules = [
            'attribute_id' => 'required|exists:attributes,id',
            'value'        => 'required',
            'slug'         => 'required|unique:attribute_values,slug' . ($id ? ',' . $id : ''),
        ];

        $messages = [
            'attribute_id.required' => 'انتخاب ویژگی الزامی است',
            'attribute_id.exists'   => 'ویژگی انتخاب‌شده معتبر نیست',
            'value.required'        => 'مقدار الزامی است',
            'slug.required'         => 'نامک الزامی است',
            'slug.unique'           => 'این نامک قبلاً استفاده شده است',
        ];

        $request->validate($rules, $messages);
    }
}
