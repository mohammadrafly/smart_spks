@extends('layouts.app')

@section('content')

<form class="w-1/2" action="{{ route('jenispelanggaran.update', $data->id) }}" method="POST">
    @csrf
    <div class="py-5">
        <label for="kode_kriteria" class="mb-2 block font-semibold">Kode Kriteria</label>
        <select name="kode_kriteria" id="kode_kriteria" class="border rounded p-2 w-full">
            <option value="">Pilih Kode Kriteria</option>
            @foreach($kriteria as $item)
                <option value="{{ $item->kode }}" {{ $item->kode == $data->kode_kriteria ? 'selected' : '' }}>{{ $item->kode }}</option>
            @endforeach
        </select>
        @if($errors->has('kode_kriteria'))
            <span class="text-red-500">{{ $errors->first('kode_kriteria') }}</span>
        @endif
    </div> 
    <div class="py-5">
        <label for="jenis_pelanggaran" class="mb-2 block font-semibold">Jenis Pelanggaran</label>
        <input type="text" name="jenis_pelanggaran" id="jenis_pelanggaran" class="border rounded p-2 w-full" placeholder="Masukkan Jenis Pelanggaran" value="{{ $data->jenis_pelanggaran }}">
        @if($errors->has('jenis_pelanggaran'))
            <span class="text-red-500">{{ $errors->first('jenis_pelanggaran') }}</span>
        @endif
    </div> 
    <div class="py-5">
        <label for="point" class="mb-2 block font-semibold">Point</label>
        <input type="number" name="point" id="point" class="border rounded p-2 w-full" placeholder="Masukkan Point" value="{{ $data->point }}">
        @if($errors->has('point'))
            <span class="text-red-500">{{ $errors->first('point') }}</span>
        @endif
    </div>     
    <button type="submit" class="bg-green-500 text-white rounded p-2 w-fit px-10">Simpan</button>
</form>

@endsection
