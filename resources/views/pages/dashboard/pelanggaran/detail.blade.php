@extends('layouts.app')

@section('content')
<div class="container mx-auto" id="printThis">
    <div class="flex justify-between items-center mb-6 px-4">
        <div class="text-2xl font-bold">
            Detail Pelanggaran
        </div>
        <div>
            <button id="printButton" class="bg-blue-500 text-white py-2 px-4 rounded">
                Print
            </button>
        </div>
    </div>
    <div class="mb-4 px-4">
        <p class="py-2">Nama : {{ $data->siswa->nama }}</p>
        <p class="py-2">NIS : {{ $data->siswa->nis }}</p>
        <p class="py-2">Kelas : {{ $data->siswa->kelas }}</p>
    </div>
    <div>
        <table class="w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">No.</th>
                    <th class="py-2 px-4 border-b">Pelanggaran</th>
                    <th class="py-2 px-4 border-b">Poin</th>
                    <th class="py-2 px-4 border-b">Utility</th>
                    <th class="py-2 px-4 border-b">Nilai SMART</th>
                    <th class="py-2 px-4 border-b">Tindakan</th>
                    <th class="py-2 px-4 border-b">Sanksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalSmart = 0;
                @endphp

                @foreach ($list as $index => $item)
                @php
                    $utility = $item->kriteria->bobot / 100 * $item->jenis->point;
                    $totalSmart += $utility;
                @endphp
                <tr>
                    <td class="py-5 px-4 border-b text-sky-500">{{ $index + 1 }}</td>
                    <td class="py-5 px-4 border-b">{{ $item->jenis->jenis_pelanggaran }}</td>
                    <td class="py-5 px-4 border-b">{{ $item->jenis->point }}</td>
                    <td class="py-5 px-4 border-b">{{ $utility }}</td>
                    <td class="py-5 px-4 border-b"></td>
                    <td class="py-5 px-4 border-b"></td>
                </tr>
                @endforeach
                <tr>
                    <td class="py-5 px-4 border-b" colspan="4"></td>
                    <td class="py-5 px-4 border-b">{{ $totalSmart }}</td>
                    <td class="py-5 px-4 border-b">{{ $data->tindakan->tindakan_sekolah }}</td>
                    <td class="py-5 px-4 border-b">{{ $data->sanksi->jenis_sanksi }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('printButton').addEventListener('click', function() {
        var printContents = document.getElementById('printThis').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();  // Reload the page to restore the original content
    });
</script>
@endsection
