@extends('layouts.app')

@section('content')

<form class="w-1/2" action="{{ route('sanksi.update', $data->id) }}" method="POST">
    @csrf
    <div class="py-5">
        <label for="rentang_point" class="mb-2 block font-semibold">Rentang Point</label>
        <input type="text" name="rentang_point" id="rentang_point" class="border rounded p-2 w-full" placeholder="Masukkan Rentang Point" value="{{ old('rentang_point', $data->rentang_point) }}">
        @if($errors->has('rentang_point'))
            <span class="text-red-500">{{ $errors->first('rentang_point') }}</span>
        @endif
    </div>
    <div class="py-5">
        <label for="jenis_sanksi" class="mb-2 block font-semibold">Jenis Sanksi</label>
        <textarea name="jenis_sanksi" id="jenis_sanksi" class="border rounded p-2 w-full" placeholder="Masukkan Sanksi Sekolah">{{ old('jenis_sanksi', $data->jenis_sanksi) }}</textarea>
        @if($errors->has('jenis_sanksi'))
            <span class="text-red-500">{{ $errors->first('jenis_sanksi') }}</span>
        @endif
    </div>    
    <button type="submit" class="bg-green-500 text-white rounded p-2 w-fit px-10">Simpan</button>
</form>

@endsection
