@extends('layouts.app')

@section('content')

<form class="w-1/2" action="{{ route('siswa.create') }}" method="POST">
    @csrf
    <div class="py-5">
        <label for="nama" class="mb-2 block font-semibold">Nama</label>
        <input type="text" name="nama" id="nama" class="border rounded p-2 w-full" placeholder="Masukkan Nama" value="{{ old('nama') }}">
        @if($errors->has('nama'))
            <span class="text-red-500">{{ $errors->first('nama') }}</span>
        @endif
    </div>
    <div class="py-5">
        <label for="nis" class="mb-2 block font-semibold">NIS</label>
        <input type="number" name="nis" id="nis" class="border rounded p-2 w-full" placeholder="Masukkan NIS" value="{{ old('nis') }}">
        @if($errors->has('nis'))
            <span class="text-red-500">{{ $errors->first('nis') }}</span>
        @endif
    </div>
    <div class="py-5">
        <label for="kelas" class="mb-2 block font-semibold">Kelas</label>
        <input type="text" name="kelas" id="kelas" class="border rounded p-2 w-full" placeholder="Masukkan Kelas" value="{{ old('kelas') }}">
        @if($errors->has('kelas'))
            <span class="text-red-500">{{ $errors->first('kelas') }}</span>
        @endif
    </div>
    <div class="py-5">
        <label for="wali_kelas" class="mb-2 block font-semibold">Wali Kelas</label>
        <select name="wali_kelas_id" id="wali_kelas_id" class="border rounded p-2 w-full">
            <option value="" disabled selected>Masukkan Wali Kelas</option>
            @foreach ($wali as $option)
                <option value="{{ $option->id }}" {{ old('wali_kelas_id') == $option->id ? 'selected' : '' }}>
                    {{ $option->name }}
                </option>
            @endforeach
        </select>
        @if($errors->has('wali_kelas_id'))
            <span class="text-red-500">{{ $errors->first('wali_kelas_id') }}</span>
        @endif
    </div>    
    <button type="submit" class="bg-green-500 text-white rounded p-2 w-fit px-10">Simpan</button>
</form>

@endsection
