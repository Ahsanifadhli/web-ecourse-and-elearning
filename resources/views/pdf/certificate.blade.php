<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat Kelulusan</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* RESET MARGIN - WAJIB */
        @page { margin: 0px; }
        body { margin: 0px; font-family: 'Helvetica', sans-serif; color: #333; }

        /* UTILITAS */
        .page {
            width: 100%;
            height: 100%;
            position: relative;
            box-sizing: border-box;
            overflow: hidden; /* KUNCI BIAR GAK BOCOR KE HALAMAN 3 */
        }
        .page-break { page-break-after: always; }
        .center { text-align: center; }
        .bold { font-weight: bold; }

        /* --- HALAMAN 1: SERTIFIKAT --- */
        .page-1 { padding: 0; }

        .border-blue {
            width: 100%; height: 100%;
            border: 15px solid #1a237e;
            padding: 0; box-sizing: border-box;
            position: absolute; top: 0; left: 0;
        }

        .content-wrapper { padding: 40px; text-align: center; }

        .border-gold {
            border: 3px solid #ffc107;
            padding: 20px; /* Dikurangi dikit biar aman */
            height: 580px; /* Tinggi fix disesuaikan */
            position: relative;
        }

        h1.title { font-size: 44px; color: #1a237e; text-transform: uppercase; margin: 5px 0 10px 0; letter-spacing: 2px; }
        h3.subtitle { font-size: 16px; color: #555; margin: 5px 0; font-weight: normal; }

        .student-name {
            font-size: 34px; font-weight: bold; color: #000;
            border-bottom: 2px solid #ccc; display: inline-block;
            margin: 20px 0; padding-bottom: 5px; min-width: 400px;
        }

        .course-title { font-size: 24px; font-weight: bold; color: #1a237e; margin: 10px 0 20px 0; }
        .desc { font-size: 13px; color: #666; max-width: 85%; margin: 0 auto; line-height: 1.4; }

        /* Footer Tanda Tangan */
        .footer-table { width: 100%; margin-top: 30px; } /* Margin dikurangi dikit */
        .footer-table td { vertical-align: bottom; }

        .sign-area {
            border-bottom: 1px solid #333;
            width: 200px; height: 50px;
            display: inline-block; margin-bottom: 5px; position: relative;
        }

        /* --- HALAMAN 2: TRANSKRIP --- */
        .page-2 { padding: 40px; } /* Padding dikurangi biar muat */

        .header-transcript { border-bottom: 3px solid #1a237e; padding-bottom: 10px; margin-bottom: 20px; }
        .header-transcript h2 { margin: 0; color: #1a237e; }

        .info-table { width: 100%; margin-bottom: 20px; font-size: 14px; }
        .info-table td { padding: 4px; vertical-align: top; }

        .score-table { width: 100%; border-collapse: collapse; font-size: 12px; }
        .score-table th { background-color: #1a237e; color: white; padding: 10px; border: 1px solid #999; text-align: left; }
        .score-table td { padding: 8px; border: 1px solid #ccc; }
        .bg-gray { background-color: #f5f5f5; }

        .footer-note {
            position: absolute; bottom: 30px; left: 40px; right: 40px;
            text-align: center; font-size: 10px; color: #888;
            border-top: 1px dashed #ccc; padding-top: 10px;
        }
    </style>
</head>
<body>
    {{-- LOGIKA PHP GAMBAR --}}
    @php
        $pathLogo = public_path('images/logo.png');
        $logoData = file_exists($pathLogo) ? base64_encode(file_get_contents($pathLogo)) : null;

        $pathSign = public_path('images/Tanda_Tangan_Ahsani.png');
        $signData = file_exists($pathSign) ? base64_encode(file_get_contents($pathSign)) : null;
    @endphp

    {{-- HALAMAN 1 --}}
    <div class="page page-1">
        <div class="border-blue">
            <div class="content-wrapper">
                <div class="border-gold">

                    @if($logoData)
                        <img src="data:image/png;base64,{{ $logoData }}" height="65" style="margin-bottom: 5px;">
                    @else
                        <div style="height: 45px;"></div>
                    @endif

                    <h1 class="title">Sertifikat Kelulusan</h1>
                    <h3 class="subtitle">No. Dokumen: {{ $certificate_id }}</h3>

                    <br>
                    <h3 class="subtitle">Diberikan kepada:</h3>
                    <div class="student-name">{{ $student_name }}</div>

                    <h3 class="subtitle">Atas keberhasilannya menyelesaikan kursus:</h3>
                    <div class="course-title">{{ $course_name }}</div>

                    <p class="desc">
                        Dengan ini menyatakan bahwa siswa tersebut telah menyelesaikan seluruh modul pembelajaran,
                        tugas praktikum, dan lulus evaluasi akhir dengan predikat yang memuaskan.
                    </p>

                    <table class="footer-table">
                        <tr>
                            <td width="50%" align="left" style="padding-left: 10px; font-size: 10px; color: #777;">
                                <b>Keaslian Dokumen:</b><br>
                                Sertifikat ini diterbitkan secara digital oleh sistem.<br>
                                Scan QR Code atau cek ID untuk verifikasi.<br>
                                Tanggal Terbit: {{ $date }}
                            </td>
                            <td width="50%" align="right" style="padding-right: 10px;">
                                <p style="margin-bottom: 5px; font-size: 14px;">Jakarta, {{ $date }}</p>
                                <div class="sign-area">
                                    @if($signData)
                                        <img src="data:image/png;base64,{{ $signData }}"
                                        height="70"
                                        style=" left: 70px; right: 50px; position: absolute; bottom: -15px;">
                                    @endif
                                </div>
                                <div class="bold">Administrator</div>
                                <div style="font-size: 12px; color: #555;">Kepala Akademik</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- PAGE BREAK --}}
    <div class="page-break"></div>

    {{-- HALAMAN 2 --}}
    <div class="page page-2">
        <div class="header-transcript">
            <h2>Transkrip Nilai Akademik</h2>
            <p style="margin:0; font-size: 12px; color: #555;">Lampiran Sertifikat No: {{ $certificate_id }}</p>
        </div>

        <table class="info-table">
            <tr><td width="130"><strong>Nama Siswa</strong></td><td>: {{ $student_name }}</td></tr>
            <tr><td><strong>Kursus</strong></td><td>: {{ $course_name }}</td></tr>
            <tr><td><strong>Tanggal Lulus</strong></td><td>: {{ $date }}</td></tr>
        </table>

        <table class="score-table">
            <thead>
                <tr>
                    <th width="8%" class="center">No</th>
                    <th>Materi / Aktivitas Pembelajaran</th>
                    <th width="20%">Jenis Evaluasi</th>
                    <th width="15%" class="center">Nilai Akhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transcript as $index => $item)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['type'] }}</td>
                    <td class="center bold">{{ $item['score'] }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-gray">
                    <td colspan="3" align="right" style="padding-right: 15px;"><strong>Rata-Rata Akhir</strong></td>
                    <td class="center" style="font-size: 14px; color: #1a237e;"><strong>{{ $average_score }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="footer-note">
            Dokumen ini dicetak secara otomatis oleh sistem Ruang Belajar dan sah tanpa tanda tangan basah.<br>
            Disimpan di server pada: {{ now()->format('d-m-Y H:i:s') }}
        </div>
    </div>
</body>
</html>
