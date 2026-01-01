@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <h1 class="text-3xl font-bold text-gray-800 mb-8">Dashboard Overview</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-indigo-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase">Total Kursus</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ $totalCourses }}</h2>
                </div>
                <div class="bg-indigo-100 p-3 rounded-full text-indigo-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase">Total Siswa</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ $totalStudents }}</h2>
                </div>
                <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase">Pendaftaran Aktif</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ $totalEnrollments }}</h2>
                </div>
                <div class="bg-green-100 p-3 rounded-full text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase">Rata-rata Nilai</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ number_format($averageGrade, 1) }}</h2>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full text-yellow-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Popularitas Kursus (Jumlah Siswa)</h3>
        <div class="relative h-80 w-full">
            <canvas id="courseChart"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('courseChart').getContext('2d');

    // Data dari Controller Laravel dikirim ke JS
    const labels = {!! json_encode($chartLabels) !!};
    const dataValues = {!! json_encode($chartValues) !!};

    new Chart(ctx, {
        type: 'bar', // Jenis grafik: Bar, Line, Pie, dll
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Siswa',
                data: dataValues,
                backgroundColor: 'rgba(79, 70, 229, 0.6)', // Warna Indigo Transparan
                borderColor: 'rgba(79, 70, 229, 1)',      // Warna Indigo Solid
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Supaya sumbu Y tidak pecahan (misal 1.5 orang)
                    }
                }
            }
        }
    });
</script>
@endsection
