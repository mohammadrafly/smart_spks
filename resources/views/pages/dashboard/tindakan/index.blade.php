@extends('layouts.app')

@section('content')

    <div class="mb-10 flex justify-end items-center">
        <a href="{{route('tindakan.create')}}" class="rounded bg-green-500 text-white py-2 px-3 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>  
            Tambah Data
        </a>
    </div>
    <table id="table" class="display w-full">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Tindakan</th>
                <th>Rentang Point</th>
                <th>Tindakan Sekolah</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $tindakan )
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $tindakan->kode_tindakan }}</td>
                <td>{{ $tindakan->rentang_point }}</td>
                <td>{{ $tindakan->tindakan_sekolah }}</td>
                <td class="flex text-white">
                    <a href="{{ route('tindakan.update', $tindakan->id)}}" class="bg-yellow-500 rounded-lg p-2 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>  
                    </a>
                    <a href="{{ route('tindakan.delete', $tindakan->id)}}" class="bg-red-500 rounded-lg p-2" onclick="return confirmDelete()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </a>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>    

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
@endsection