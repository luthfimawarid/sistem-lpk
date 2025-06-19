<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 4px 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Rapor Siswa: {{ $user->nama_lengkap }}</h2>
    
    <h3>Tugas Harian</h3>

    @php
        $tanggalChunks = collect(range(1, 31))->chunk(10);
        $nilaiChunks = collect($tugas->toArray())->chunk(10);
    @endphp

    @foreach($tanggalChunks as $index => $tanggalChunk)
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    @foreach($tanggalChunk as $tgl)
                        <th>{{ $tgl }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nilai</td>
                    @foreach($tanggalChunk as $i => $tgl)
                        @php
                            $nilai = $nilaiChunks[$index][$i] ?? null;
                        @endphp
                        <td>{{ $nilai !== null ? $nilai : '-' }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    @endforeach

    <h3>Evaluasi Mingguan</h3>
    <table>
        <thead>
            <tr>
                @for($i = 1; $i <= 5; $i++)
                    <th>Eva {{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            <tr>
                @for($i = 0; $i < 5; $i++)
                    <td>{{ $evaluasi[$i] ?? '-' }}</td>
                @endfor
            </tr>
        </tbody>
    </table>

    <h3>Tryout (Choka)</h3>
    <table>
        <thead>
            <tr><th>Choka I1</th><th>Choka I2</th></tr>
        </thead>
        <tbody>
            <tr><td>{{ $tryout[0] }}</td><td>{{ $tryout[1] }}</td></tr>
        </tbody>
    </table>

    <h3>Rata-Rata Nilai</h3>
    <table>
        <thead>
            <tr>
                <th>Tugas</th>
                <th>Evaluasi</th>
                <th>Tryout</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ round($rataTugas, 2) }}</td>
                <td>{{ round($rataEvaluasi, 2) }}</td>
                <td>{{ round($rataTryout, 2) }}</td>
                <td>{{ round(($rataTugas + $rataEvaluasi + $rataTryout) / 3, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
