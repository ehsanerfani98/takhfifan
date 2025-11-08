<?php

namespace App\Http\Controllers;

use App\Models\CarFile;
use App\Models\CarFileItem;
use Illuminate\Http\Request;

class CarFileItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:car-file-items-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:car-file-items-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:car-file-items-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:car-file-items-delete', ['only' => ['destroy']]);
    }

    public function index(CarFile $carFile)
    {
        $items = $carFile->items()->paginate(10);
        return view('admin.car_file_items.index', compact('carFile', 'items'));
    }

    public function create(Request $request)
    {
        $carFile = CarFile::with('items')->findOrFail($request->carfile_id);

        return view('admin.car_file_items.create', compact('carFile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:car_file_items,title,NULL,id,car_file_id,' . $request->car_file_id,
        ]);

        CarFileItem::create([
            'car_file_id' => $request->car_file_id,
            'title' => $request->title,
        ]);

        return redirect()->back()->with('success', 'آیتم اضافه شد.');
    }

    public function edit($item_id)
    {
        $item = CarFileItem::where('id', $item_id)->with('carFile')->first();
        return view('admin.car_file_items.edit', compact('item'));
    }

    public function update(Request $request, CarFileItem $car_file_item)
    {

        $item = $car_file_item->load('carFile');
        $request->validate([
            'title' => 'required|string|unique:car_file_items,title,' . $item->id . ',id,car_file_id,' . $item->carFile->id,
        ]);

        $item->update([
            'title' => $request->title,
        ]);

        return redirect()->route('car-file-items.create', ["carfile_id" => $item->carFile->id])->with('success', 'آیتم ویرایش شد.');
    }

    public function destroy($item_id)
    {
        CarFileItem::findOrFail($item_id)->delete();
        return redirect()->back()->with('success', 'آیتم حذف شد.');
    }
}
