<table>
    <thead>
        <tr>
            <th colspan="7" style="font-weight: bold; text-align: center;">DAFTAR SISWA</th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center;">Tanggal Export: {{ date('d-m-Y H:i') }}</th>
        </tr>
        <tr>
            <th></th> </tr>
        <tr>
            <th style="background-color: #4B49AC; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center;">No</th>
            <th style="background-color: #4B49AC; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 200px;">Nama Lengkap</th>
            <th style="background-color: #4B49AC; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 120px;">NIS</th>
            <th style="background-color: #4B49AC; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 120px;">NISN</th>
            <th style="background-color: #4B49AC; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 120px;">Tanggal Lahir</th>
            <th style="background-color: #4B49AC; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 110px;">Jenis Kelamin</th>
            <th style="background-color: #4B49AC; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 250px;">Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach($siswa as $key => $item)
        <tr>
            <td style="border: 1px solid #000000; text-align: center;">{{ $key + 1 }}</td>
            <td style="border: 1px solid #000000;">{{ $item->nama }}</td>
            <td style="border: 1px solid #000000;">{{ $item->nis }}</td>
            <td style="border: 1px solid #000000;">{{ $item->nisn }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->tanggal_lahir?->format('d-m-Y') }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : ($item->jenis_kelamin == 'P' ? 'Perempuan' : '') }}</td>
            <td style="border: 1px solid #000000;">{{ $item->user->email ?? '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>