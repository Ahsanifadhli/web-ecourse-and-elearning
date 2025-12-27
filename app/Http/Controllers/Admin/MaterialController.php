<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    // Simpan Bab Baru
    public function store(Request $request, Course $course)
    {
        $request->validate(['title' => 'required']);
        $course->materials()->create(['title' => $request->title]);
        return back()->with('success', 'Bab berhasil ditambahkan!');
    }

    // Hapus Bab
    public function destroy(Material $material)
    {
        $material->delete();
        return back()->with('success', 'Bab dihapus.');
    }
}
