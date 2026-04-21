<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TestimonialController extends Controller
{
    /* ADMIN LIST */
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimoni.index', compact('testimonials'));
    }
/* CREATE FORM */
public function create()
{
    return view('admin.testimoni.create');
}

    /* PUBLIC / ADMIN INPUT */
public function storeAdmin(Request $request)
{
    $request->validate([
        'name' => 'required',
        'message' => 'required',
        'rating' => 'required|integer|min:1|max:5',
        'service' => 'nullable',
        'media' => 'nullable|image|max:10240' // hanya gambar
    ]);

    $mediaPath = null;

    if ($request->hasFile('media') && $request->file('media')->isValid()) {
        $file = $request->file('media');
        $filename = Str::uuid() . '.' . $file->extension();
        $file->move(public_path('img/testimoni'), $filename);

        $mediaPath = 'img/testimoni/' . $filename;
    }

    Testimonial::create([
        'name' => $request->name,
        'service' => $request->service,
        'message' => $request->message,
        'rating' => $request->rating,
        'media' => $mediaPath,
        'media_type' => 'image', // langsung image
        'status' => 'pending'
    ]);

    return redirect('/admin/testimoni')->with('success', 'Testimoni berhasil ditambahkan');
}




    /* EDIT FORM */
    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimoni.edit', compact('testimonial'));
    }

    /* UPDATE */
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $data = $request->only('name','service','message','rating');

        if ($request->hasFile('media')) {
            // hapus file lama
            if ($testimonial->media && file_exists(public_path($testimonial->media))) {
                unlink(public_path($testimonial->media));
            }

            $filename = Str::uuid().'.'.$request->media->extension();
            $request->media->move(public_path('img/testimoni'), $filename);
            $data['media'] = 'img/testimoni/'.$filename;
            $data['media_type'] = str_contains($request->media->getMimeType(),'video') ? 'video' : 'image';
        }

        $testimonial->update($data);

        return redirect('/admin/testimoni')->with('success','Testimoni diupdate');
    }

    /* DELETE */
    public function destroy($id)
    {
        $t = Testimonial::findOrFail($id);
        if ($t->media && file_exists(public_path($t->media))) {
            unlink(public_path($t->media));
        }
        $t->delete();

        return back()->with('success','Testimoni dihapus');
    }
    public function approve($id)
{
    $testimonial = Testimonial::findOrFail($id);
    $testimonial->update(['status' => 'approved']);
    return back()->with('success', 'Testimoni disetujui');
}

public function reject($id)
{
    $testimonial = Testimonial::findOrFail($id);
    $testimonial->update(['status' => 'rejected']);
    return back()->with('success', 'Testimoni ditolak');
}
public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'service' => 'required',
        'message' => 'required',
        'rating' => 'required|integer|min:1|max:5',
        'media' => 'nullable|image|max:10240'
    ]);

    $mediaPath = null;

    if ($request->hasFile('media') && $request->file('media')->isValid()) {
        $file = $request->file('media');
        $filename = Str::uuid().'.'.$file->extension();
        $file->move(public_path('img/testimoni'), $filename);
        $mediaPath = 'img/testimoni/'.$filename;
    }

    Testimonial::create([
        'name' => $request->name,
        'service' => $request->service,
        'message' => $request->message,
        'rating' => $request->rating,
        'media' => $mediaPath,
        'media_type' => 'image',
        'status' => 'pending'
    ]);

    return back()->with('success', 'Testimoni berhasil dikirim, menunggu persetujuan admin');
}

}
