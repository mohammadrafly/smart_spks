@extends('layouts.app')

@section('content')

<form action="{{ url('dashboard/siswa/update/' . $data->id) }}" method="POST" class="w-1/2">
    @csrf
    <div class="py-5">
        <label for="nama" class="mb-2 block font-semibold">Name</label>
        <input type="text" name="nama" id="nama" class="border rounded p-2 w-full" value="{{ old('nama', $data->nama) }}" placeholder="Masukkan Nama">
        @error('nama')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
    </div>
    <div class="py-5">
        <label for="nis" class="mb-2 block font-semibold">NIS</label>
        <input type="number" name="nis" id="nis" class="border rounded p-2 w-full" value="{{ old('nis', $data->nis) }}" placeholder="Masukkan NIS">
        @error('nis')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
    </div>
    <div class="py-5">
        <label for="kelas" class="mb-2 block font-semibold">Kelas</label>
        <input type="text" name="kelas" id="kelas" class="border rounded p-2 w-full" value="{{ old('kelas', $data->kelas) }}" placeholder="Masukkan Kelas">
        @error('kelas')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
    </div>
    <div class="py-5">
        <label for="wali_kelas_id" class="mb-2 block font-semibold">Wali Kelas</label>
        <select name="wali_kelas_id" id="wali_kelas_id" class="border rounded p-2 w-full">
            <option value="" disabled {{ old('wali_kelas_id', $data->wali_kelas_id) === null ? 'selected' : '' }}>Masukkan Wali Kelas</option>
            @foreach ($wali as $option)
                <option value="{{ $option->id }}" {{ old('wali_kelas_id', $data->wali_kelas_id) == $option->id ? 'selected' : '' }}>
                    {{ $option->name }}
                </option>
            @endforeach
        </select>
        @error('wali_kelas_id')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
    </div>    
    <button type="submit" class="bg-yellow-500 text-white rounded p-2 w-fit px-10">Simpan Perubahan</button>
</form>

@endsection
