<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\SubMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubMaterialController extends Controller
{
    public function create(Material $material)
    {
        return view('admin.submaterials.create', compact('material'));
    }

    public function store(Request $request, Material $material)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required|in:video,pdf',
            'file' => 'required|file|max:102400',
        ]);

        // Validasi File Mime Type (Sama seperti sebelumnya)
        if ($request->type === 'video') {
            $request->validate(['file' => 'mimetypes:video/mp4,video/mpeg,video/quicktime']);
        } else {
            $request->validate(['file' => 'mimetypes:application/pdf']);
        }

        $filePath = $request->file('file')->store('submaterials', 'public');

        $material->subMaterials()->create([
            'title' => $request->title,
            'type' => $request->type,
            'file_path' => $filePath,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.courses.show', $material->course_id)
                         ->with('success', 'Konten berhasil ditambahkan ke ' . $material->title);
    }

    public function destroy(SubMaterial $subMaterial)
    {
        if($subMaterial->file_path) Storage::disk('public')->delete($subMaterial->file_path);
        $subMaterial->delete();
        return back()->with('success', 'Konten dihapus.');
    }
}
