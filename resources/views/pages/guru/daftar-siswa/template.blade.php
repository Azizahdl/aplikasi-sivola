<table >
    <thead>
        <tr>
            <th colspan="7" style="font-weight: bold; text-align: center;">FORMAT IMPORT DATA SISWA</th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center;">Isi data pada baris di bawah header, lalu unggah kembali melalui menu Import</th>
        </tr>
        <tr>
            <th colspan="7"></th>
        </tr>
        <tr>
            <th style="background-color: #4B49AC; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center;">No</th>
            <th style="background-color: #4B49AC; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 200px;">nama</th>
            <th style="background-color: #4B49AC; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 120px;">nis</th>
            <th style="background-color: #4B49AC; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 120px;">nisn</th>
            <th style="background-color: #4B49AC; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 120px;">tanggal_lahir</th>
            <th style="background-color: #4B49AC; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 110px;">jenis_kelamin</th>
            <th style="background-color: #4B49AC; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 250px;">email</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 1; $i <= 5; $i++)
        <tr>
            <td style="border:1px solid #000000; padding:6px; text-align:center;">{{ $i }}</td>
            <td style="border:1px solid #000000; padding:6px;"></td>
            <td style="border:1px solid #000000; padding:6px;"></td>
            <td style="border:1px solid #000000; padding:6px;"></td>
            <td style="border:1px solid #000000; padding:6px;"></td>
            <td style="border:1px solid #000000; padding:6px;"></td>
            <td style="border:1px solid #000000; padding:6px;"></td>
        </tr>
        @endfor
    </tbody>
</table>