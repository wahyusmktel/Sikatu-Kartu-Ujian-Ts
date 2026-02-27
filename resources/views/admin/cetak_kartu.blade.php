{{-- <h3>Kartu Ujian</h3>

Nama Siswa: {{ $kartu->siswa->nama }}<br>
Kelas: {{ $kartu->siswa->rombel_saat_ini }}<br>
Username Ujian: {{ $kartu->username_ujian }}<br>
Password Ujian: {{ $kartu->password_ujian }}<br>
Nama Ujian: {{ $kartu->ujian->nama_ujian }}<br>
Tahun Pelajaran: {{ $kartu->ujian->tahun_pelajaran }}<br>
Semester: {{ $kartu->ujian->semester }}<br>
Link Ujian: {{ $kartu->ujian->link_ujian }}<br>
Tanggal Mulai: {{ $kartu->ujian->tgl_mulai }}<br>
Tanggal Akhir: {{ $kartu->ujian->tgl_akhir }}<br>

<p>Dicetak oleh: {{ $kartu->siswa->nama }} pada {{ $tanggalCetak }}</p> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KARTU PESERTA UJIAN - {{ $kartu->siswa->nama }}</title>

    {{-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css"> --}}
</head>

<body>
<style>
    html, body {
        min-height: 842px;
        font-family: "Roboto";
        font-size: 14px;
    }
    .value {
        text-align: left;
        width: 50%;
    }
    table {
        width: 100%;
    }
    .foto {
        border: 1px solid black !important;
        width: 120px;
        height: 150px;
        padding: 5px;
    }
    small {
        font-size: 10px;
        font-weight: normal;
    }
</style>

<div class="sheet padding-15mm">
    <div class="content">
        <table>
            <tr>
                <td style="text-align: left;">
                    <img width="130px" class="img-fluid" src="https://cdn2.ypt.or.id/ppdb/images/ts.png" alt="">
                </td>
                <td width="60%" style="text-align: center; font-size: 15px;">
                    <b>
                        KARTU PESERTA UJIAN<br>
                        {{ $kartu->ujian->nama_ujian }} {{ $kartu->ujian->semester }} Tahun Pelajaran {{ $kartu->ujian->tahun_pelajaran }}<br>
                    </b><br>
                </td>
                <td style="text-align: right;">
                    <img width="100px" class="img-fluid" src="https://cdn2.ypt.or.id/ppdb/images/ypt.png" alt="">
                </td>
            </tr>
        </table>
        <hr>
        <br>
        <table>
            <tr>
                <td width="80%">
                    <table>
                        <tbody>
                        <tr>
                            <th colspan="3" style="text-align: left">DATA IDENTITAS</th>
                        </tr>
                        <tr>
                            <td width="15%">Nama Siswa</td>
                            <td width="1%">:</td>
                            <td class="value">{{ $kartu->siswa->nama }}</td>
                        </tr>
                        <tr>
                            <td>Kelas</td>
                            <td>:</td>
                            <td class="value">{{ $kartu->siswa->rombel_saat_ini }}</td>
                        </tr>
                        <tr>
                            <td>Username Ujian</td>
                            <td>:</td>
                            <td class="value">{{ $kartu->username_ujian }}</td>
                        </tr>
                        <tr>
                            <td>Password Ujian</td>
                            <td>:</td>
                            <td class="value">{{ $kartu->password_ujian }}</td>
                        </tr>
                        <tr>
                            <td>Nama Ujian</td>
                            <td>:</td>
                            <td class="value">{{ $kartu->ujian->nama_ujian }} {{ $kartu->ujian->semester }} Tahun Pelajaran {{ $kartu->ujian->tahun_pelajaran }}</td>
                        </tr>
                        <tr>
                            <td>Link Ujian</td>
                            <td>:</td>
                            <td class="value">{{ $kartu->ujian->link_ujian }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Mulai</td>
                            <td>:</td>
                            <td class="value">{{ $kartu->ujian->tgl_mulai }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Akhir</td>
                            <td>:</td>
                            <td class="value">{{ $kartu->ujian->tgl_akhir }}</td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td width="70%">
                    <p><h3>CATATAN :</h3></p>
                    <p>Silahkan gunakan informasi diatas untuk login di dalam aplikasi ujian, apabila terdapat masalah dalam melakukan login ke dalam aplikasi silahkan dapat menghubungi pengawas ruang masing - masing.
                    Untuk link ujian dapat berubah sewaktu - waktu, perubahan akan di informasikan oleh pengawas ruang.</p><br><br><p>Dicetak oleh: {{ $kartu->siswa->nama }} pada {{ $tanggalCetak }}</p>
                </td>
                {{-- <td width="30%">
                    <center><b>Tanda Tangan</b></center>
                    <br><br><br><br>
                    <center><b><u>( {{ $kartu->siswa->nama }} )</b></u></center>
                </td> --}}
            </tr>
        </table>
    </div>
</div>

</body>
</html>
