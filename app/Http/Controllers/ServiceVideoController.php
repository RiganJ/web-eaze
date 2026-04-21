<?php

// app/Http/Controllers/ServiceVideoController.php
namespace App\Http\Controllers;

use App\Models\ServiceVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceVideoController extends Controller
{
  // FRONTEND
public function index()
{
    $allVideos = ServiceVideo::where('is_active', 1)
                    ->latest()
                    ->get();

    $categories = ['Carwash', 'Laundry', 'Cucian Motor', 'Homecleaning'];

    $videos = collect();

    foreach ($categories as $category) {
        $videos[$category] = $allVideos->where('title', $category);
    }

    return view('videos.index', compact('videos'));
}


  // ADMIN STORE
   /* =========================
     * ADMIN LIST VIDEO
     * ========================= */
    public function adminIndex()
    {
        $videos = ServiceVideo::latest()->paginate(10);
        return view('admin.video.index', compact('videos'));
    }

    /* =========================
     * FORM TAMBAH VIDEO
     * ========================= */
    public function create()
    {
        return view('admin.video.create');
    }

    /* =========================
     * SIMPAN VIDEO
     * ========================= */
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|in:Laundry,Cucian Motor,Carwash,Homecleaning',
        'description' => 'nullable|string',
        'video' => 'required|mimes:mp4|max:51200',
        'thumbnail' => 'required|image|max:2048',
    ]);

    // VIDEO
    $videoName = time() . '-' . uniqid() . '.mp4';
    $request->video->move(public_path('assets/videos'), $videoName);

    // THUMBNAIL
    $thumbName = time() . '-' . uniqid() . '.' . $request->thumbnail->extension();
    $request->thumbnail->move(public_path('assets/thumbnails'), $thumbName);

    ServiceVideo::create([
        'title' => $request->title,
        'description' => $request->description,
        'video_path' => 'assets/videos/' . $videoName,
        'thumbnail' => 'assets/thumbnails/' . $thumbName,
        'is_active' => 1
    ]);

    return back()->with('success', 'Video berhasil diupload');
}

    /* =========================
     * HAPUS VIDEO
     * ========================= */
    public function destroy($id)
    {
        $video = ServiceVideo::findOrFail($id);

        // hapus file thumbnail & video
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        if ($video->video_path) {
            Storage::disk('public')->delete($video->video_path);
        }

        $video->delete();

        return back()->with('success', 'Video berhasil dihapus');
    }
}
