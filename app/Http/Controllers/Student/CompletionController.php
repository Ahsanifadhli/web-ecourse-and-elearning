<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\SubMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompletionController extends Controller
{
    // Toggle: Jika belum selesai -> tandai selesai. Jika sudah -> batalkan.
    public function toggle(SubMaterial $subMaterial)
    {
        $user = Auth::user();

        // Cek apakah sudah ada di tabel completions?
        if ($user->completedSubMaterials()->where('sub_material_id', $subMaterial->id)->exists()) {
            // Kalau sudah, detach (hapus status selesai) - Unmark
            $user->completedSubMaterials()->detach($subMaterial->id);
            $message = 'Status selesai dibatalkan.';
        } else {
            // Kalau belum, attach (simpan status selesai) - Mark as Complete
            $user->completedSubMaterials()->attach($subMaterial->id);
            $message = 'Materi ditandai selesai!';
        }

        return back()->with('success', $message);
    }
}
