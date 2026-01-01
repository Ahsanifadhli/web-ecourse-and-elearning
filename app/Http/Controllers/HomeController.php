<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua kursus untuk ditampilkan di halaman depan
        $courses = Course::withCount('students')->latest()->get();

        return view('welcome', compact('courses'));
    }

    public function courseDetail(Course $course)
    {
        // Halaman detail kursus sebelum enroll (Preview)
        // Kita load materi juga biar tamu bisa lihat "Oh isinya ini aja" (tapi gak bisa akses isinya)
        $course->loadCount(['materials', 'students']);

        return view('frontend.course_detail', compact('course'));
    }
}
