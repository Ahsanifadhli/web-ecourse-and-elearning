<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // 1. Tampilkan Daftar Siswa
    public function index()
    {
        // PERBAIKAN DI SINI:
        // Gunakan 'role' bukan 'is_admin'
        // Kita ambil user yang role-nya 'student'
        $students = User::where('role', 'student')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('admin.students.index', compact('students'));
    }

    // 2. Hapus Siswa
    public function destroy(User $student)
    {
        // PERBAIKAN DI SINI:
        // Cek jika role-nya admin, jangan dihapus
        if ($student->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus akun Admin.');
        }

        $student->delete();

        return back()->with('success', 'Data siswa berhasil dihapus.');
    }
}
