<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    // 1. TAMPILKAN DAFTAR SISWA
    public function index(Request $request)
    {
        // Fitur pencarian sederhana
        $query = User::where('role', 'student');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $students = $query->latest()->paginate(10); // 10 siswa per halaman

        return view('admin.students.index', compact('students'));
    }

    // 2. RESET PASSWORD (Jadi '12345678')
    public function resetPassword(User $student)
    {
        $student->update([
            'password' => Hash::make('12345678')
        ]);

        return back()->with('success', 'Password siswa ' . $student->name . ' berhasil direset menjadi: 12345678');
    }

    // 3. HAPUS SISWA
    public function destroy(User $student)
    {
        $student->delete();
        return back()->with('success', 'Data siswa berhasil dihapus dari sistem.');
    }
}
