<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Hasil Ranking HSE Awards</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #aaa; padding: 6px; text-align: center; }
        th { background: #eee; }
    </style>
</head>
<body>
    <div style="text-align: center; margin-bottom: 18px;">
        <h2 style="margin-bottom: 8px;">Riwayat Perhitungan HSE Awards</h2>
        <img src="{{ public_path('img/logo-qhse.png') }}" alt="Logo QHSE" style="width: 130px; height: 130px; margin-bottom: 8px;">
        <div style="font-size: 16px; font-weight: bold; margin-bottom: 18px;">Health Safety and Environment Awards</div>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sesi</th>
                <th>Pemenang</th>
                <th>Dihitung Oleh</th>
                <th>Tanggal Dihitung</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rankingBatches as $batch)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $batch->nama_sesi ?? 'Tanpa Nama Sesi' }}</td>
                <td>{{ optional($batch->details->where('rank', 1)->first())->proyek->nama_proyek ?? '-' }}</td>
                <td>{{ $batch->user->name ?? 'N/A' }}</td>
                <td>{{ $batch->calculated_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 