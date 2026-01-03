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
        // 1. Validasi
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:file,youtube',
            // Validasi bersyarat (Conditional Validation)
            'link' => 'nullable|required_if:type,youtube|url',
            'file' => 'nullable|required_if:type,file|file|mimes:pdf,mp4,doc,docx,ppt,pptx|max:102400',
            'description' => 'nullable|string'
        ]);

        // 2. Siapkan Data Dasar
        $data = [
            'material_id' => $material->id,
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description, // <-- Tambahkan ini biar deskripsi tersimpan
        ];

        // 3. Logika Percabangan
        if ($request->type === 'youtube') {
            // Simpan Link YouTube
            $data['link'] = $request->link; // Pastikan key-nya 'link', bukan 'url'
            $data['file_path'] = null;
            
        } else {
            // Simpan File Upload
            if ($request->hasFile('file')) {
                $data['file_path'] = $request->file('file')->store('materials', 'public');
            }
            $data['link'] = null;
        }

        // 4. Simpan ke Database
        \App\Models\SubMaterial::create($data);

        return back()->with('success', 'Materi berhasil ditambahkan!');
    }

    public function destroy(SubMaterial $subMaterial)
    {
        if($subMaterial->file_path) Storage::disk('public')->delete($subMaterial->file_path);
        $subMaterial->delete();
        return back()->with('success', 'Konten dihapus.');
    }
}
