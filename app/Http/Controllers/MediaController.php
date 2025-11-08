<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image; // اختیاری، اگر از intervention استفاده کردی

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:media-list', ['only' => ['index', 'show','manager']]);
        $this->middleware('permission:media-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:media-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:media-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        // simple paginated list (ajax)
        $media = Media::latest()->paginate(24);
        if ($request->ajax()) {
            return view('admin.media.partials.grid', compact('media'))->render();
        }
        return view('admin.media.library', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|image|max:5120' // تا 5MB
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $mime = $file->getClientMimeType();
        $size = $file->getSize();
        $ext = $file->getClientOriginalExtension();

        $filename = Str::random(40) . '.' . $ext;

        // مسیر public/media
        $destination = public_path('media-upload');
        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }

        $file->move($destination, $filename);

        $media = Media::create([
            'filename'       => $filename,
            'original_name'  => $originalName,
            'mime'           => $mime,
            'size'           => $size,
            'user_id'        => Auth::id() ?? null,
        ]);

        return response()->json([
            'success' => true,
            'media'   => [
                'id'            => $media->id,
                'url'           => $media->url,
                'thumbnail'     => $media->url, // همون فایل اصلی رو برمی‌گردونیم
                'original_name' => $media->original_name,
            ]
        ]);
    }

    public function destroy(Media $media)
    {
        @unlink(public_path('media-upload/' . $media->filename));
        $media->delete();
        return response()->json(['success' => true]);
    }

    public function manager_ckeditor(Request $request)
    {
        $funcNum = $request->get('CKEditorFuncNum'); // ممکن باشه null اگر مستقیم باز کنی
        $media = Media::latest()->paginate(24);
        return view('admin.media.manager_ckeditor', compact('media', 'funcNum'));
    }

    public function manager(Request $request)
    {
        $funcNum = $request->get('CKEditorFuncNum'); // ممکن باشه null اگر مستقیم باز کنی
        $media = Media::latest()->paginate(24);
        return view('admin.media.manager', compact('media', 'funcNum'));
    }
}
