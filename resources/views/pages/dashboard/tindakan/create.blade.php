@extends('layouts.app')

@section('content')

<form class="w-1/2" action="{{ route('tindakan.create') }}" method="POST">
    @csrf
    <div class="py-5">
        <label for="rentang_point" class="mb-2 block font-semibold">Rentang Point</label>
        <input type="text" name="rentang_point" id="rentang_point" class="border rounded p-2 w-full" placeholder="Masukkan Rentang Point" value="{{ old('rentang_point') }}">
        @if($errors->has('rentang_point'))
            <span class="text-red-500">{{ $errors->first('rentang_point') }}</span>
        @endif
    </div>
    <div class="py-5">
        <label for="tindakan_sekolah" class="mb-2 block font-semibold">Tindakan Sekolah</label>
        <textarea name="tindakan_sekolah" id="tindakan_sekolah" class="border rounded p-2 w-full" placeholder="Masukkan Rentang Point">{{ old('tindakan_sekolah') }}</textarea>
        @if($errors->has('tindakan_sekolah'))
            <span class="text-red-500">{{ $errors->first('tindakan_sekolah') }}</span>
        @endif
    </div>    
    <button type="submit" class="bg-green-500 text-white rounded p-2 w-fit px-10">Simpan</button>
</form>

@endsection
