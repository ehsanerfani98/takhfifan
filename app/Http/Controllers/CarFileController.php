<?php

namespace App\Http\Controllers;

use App\Models\CarFile;
use Illuminate\Http\Request;

class CarFileController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:car-files-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:car-files-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:car-files-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:car-files-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $carFiles = CarFile::paginate(10);
        return view('admin.car_files.index', compact('carFiles'));
    }

    public function create()
    {
        return view('admin.car_files.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:car_files,title',
        ]);

        CarFile::create([
            'title' => $request->title,
        ]);

        return redirect()->route('car-files.index')->with('success', 'پرونده ایجاد شد.');
    }

    public function edit(CarFile $carFile)
    {
        return view('admin.car_files.edit', compact('carFile'));
    }

    public function update(Request $request, CarFile $carFile)
    {
        $request->validate([
            'title' => 'required|string|unique:car_files,title,' . $carFile->id,
        ]);

        $carFile->update([
            'title' => $request->title,
        ]);

        return redirect()->route('car-files.index')->with('success', 'پرونده ویرایش شد.');
    }

    public function destroy(CarFile $carFile)
    {
        $carFile->delete();
        return redirect()->route('car-files.index')->with('success', 'پرونده حذف شد.');
    }
}
