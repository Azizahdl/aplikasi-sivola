<table>
    <thead>
        <tr>
            <th colspan="6" style="font-weight: bold; text-align: center;">
                RIWAYAT LATIHAN SISWA
            </th>
        </tr>

        <tr>
            <th colspan="6" style="text-align: center;">
                Tanggal Export: {{ date('d-m-Y H:i') }}
            </th>
        </tr>

        <tr>
            <th colspan="6" style="text-align: center; font-style: italic;">
                Periode:
                {{ $dateFrom ? date('d-m-Y', strtotime($dateFrom)) : 'Awal' }}
                s/d
                {{ $dateTo ? date('d-m-Y', strtotime($dateTo)) : 'Sekarang' }}
                @if($status && $status !== 'semua')
                    &nbsp;|&nbsp; Status: {{ $status }}
                @endif
            </th>
        </tr>

        <tr><th colspan="6"></th></tr>

        <tr>
            <th style="background-color: #4B49AC; color: #ffffff; border: 1px solid #000; text-align: center;">No</th>
            <th style="background-color: #4B49AC; color: #ffffff; border: 1px solid #000; text-align: center; width:180px;">Tanggal</th>
            <th style="background-color: #4B49AC; color: #ffffff; border: 1px solid #000; text-align: center; width:200px;">Nama Siswa</th>
            <th style="background-color: #4B49AC; color: #ffffff; border: 1px solid #000; text-align: center; width:250px;">Materi</th>
            <th style="background-color: #4B49AC; color: #ffffff; border: 1px solid #000; text-align: center; width:120px;">Skor (%)</th>
            <th style="background-color: #4B49AC; color: #ffffff; border: 1px solid #000; text-align: center; width:120px;">Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($riwayat as $key => $item)
        <tr>
            <td style="border: 1px solid #000; text-align: center;">
                {{ $key + 1 }}
            </td>

            <td style="border: 1px solid #000;">
                {{ $item->created_at->format('d-m-Y H:i') }}
            </td>

            <td style="border: 1px solid #000;">
                {{ $item->siswa->nama ?? '-' }}
            </td>

            <td style="border: 1px solid #000;">
                {{ $item->materi->teks_bacaan ?? '-' }}
            </td>

            <td style="border: 1px solid #000; text-align: center;">
                {{ round($item->skor_similarity * 100, 1) }}
            </td>

            <td style="border: 1px solid #000; text-align: center;">
                {{ $item->status_validasi }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>