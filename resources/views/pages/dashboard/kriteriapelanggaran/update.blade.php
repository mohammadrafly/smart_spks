@extends('layouts.app')

@section('content')

<form class="w-1/2" action="{{ route('kriteriapelanggaran.update', $data->id) }}" method="POST">
    @csrf
    <div class="py-5">
        <label for="kriteria" class="mb-2 block font-semibold">Kriteria</label>
        <input type="text" name="kriteria" id="kriteria" class="border rounded p-2 w-full" placeholder="Masukkan Kriteria" value="{{ $data->kriteria }}"> <!-- Use $data->kriteria to fill the input -->
        @if($errors->has('kriteria'))
            <span class="text-red-500">{{ $errors->first('kriteria') }}</span>
        @endif
    </div> 
    <div class="py-5">
        <label for="bobot" class="mb-2 block font-semibold">Bobot</label>
        <input type="number" name="bobot" id="bobot" class="border rounded p-2 w-full" placeholder="Masukkan Bobot" value="{{ $data->bobot }}" max="100"> <!-- Use $data->bobot to fill the input -->
        @if($errors->has('bobot'))
            <span class="text-red-500">{{ $errors->first('bobot') }}</span>
        @endif
    </div>     
    <button type="submit" class="bg-green-500 text-white rounded p-2 w-fit px-10">Simpan</button>
</form>

@endsection
