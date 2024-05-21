@extends('layouts.app')

@section('content')

<div class="grid grid-cols-3 gap-5 mb-20">
    <div class="flex justify-center items-center">
        <div>
            <div class="font-semibold py-5">
                Siswa Yang Melakukan Pelanggaran
            </div>
            <div class="flex justify-items-start items-center">
                <div class="rounded-full p-3 bg-[#FFECDF]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-[#FF771D] w-8 h-8 ">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <div class="ml-5 text-3xl font-semibold">
                    {{ $countPelanggar }}
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center items-center">
        <div>
            <div class="font-semibold py-5">
                Jumlah Siswa
            </div>
            <div class="flex justify-items-start items-center">
                <div class="p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-[#4154F1] w-8 h-8 ">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <div class="ml-5 text-3xl font-semibold">
                    {{ $countSiswa }}
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center items-center">
        <div>
            <div class="font-semibold py-5">
                Sub Kriteria Pelanggaran
            </div>
            <div class="flex justify-items-start items-center">
                <div class="rounded-full p-3 bg-[#FFECDF]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-[#FF771D] w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>  
                </div>
                <div class="ml-5 text-3xl font-semibold">
                    {{ $countSubKriteria }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="flex items-center">
    <div class="w-full">
        <canvas id="donat"></canvas>
    </div>
    <div class="w-full">
        <div class="container mx-auto px-4 py-8">
            <div class="block">
                <div class="flex items-center">
                    <div class="bg-[#95CE7A] text-center p-4 rounded-lg my-2 mr-10">
                    </div>
                    <p class="text-base font-semibold">Pelanggaran Ringan</p>
                </div>
                <div class="flex items-center">
                    <div class="bg-[#5470C6] text-center p-4 rounded-lg my-2 mr-10">
                    </div>
                    <p class="text-base font-semibold">Pelanggaran Sedang</p>
                </div>
                <div class="flex items-center">
                    <div class="bg-[#FAC858] text-center p-4 rounded-lg my-2 mr-10">
                    </div>
                    <p class="text-base font-semibold">Tindak Pidana Ringan (TIPIRING)</p>
                </div>
                <div class="flex items-center">
                    <div class="bg-[#EE6666] text-center p-4 rounded-lg my-2 mr-10">
                    </div>
                    <p class="text-base font-semibold">Tindak Pidana Berat (TIPIRAT)</p>
                </div>
            </div>
          </div>
    </div>
</div>

@endsection

@section('script')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const data = @json($data);

    const ctx = document.getElementById('donat').getContext('2d');

    const myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: data.map(row => row.label),
            datasets: [
                {
                    label: 'Tingkat',
                    data: data.map(row => row.value),
                    backgroundColor: ['#95CE7A', '#5470C6', '#FAC858', '#EE6666'],
                    hoverBackgroundColor: ['#95CE7A', '#5470C6', '#FAC858', '#EE6666'] 
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
</script>

@endsection
