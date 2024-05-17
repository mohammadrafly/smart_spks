@extends('layouts.app')

@section('content')

<form class="w-1/2" action="{{ route('kriteriapelanggaran.create') }}" method="POST">
    @csrf
    <div class="py-5">
        <label for="kriteria" class="mb-2 block font-semibold">Kriteria</label>
        <input type="text" name="kriteria" id="kriteria" class="border rounded p-2 w-full" placeholder="Masukkan Kriteria" value="{{ old('kriteria') }}">
        @if($errors->has('kriteria'))
            <span class="text-red-500">{{ $errors->first('kriteria') }}</span>
        @endif
    </div> 
    <div class="py-5">
        <label for="bobot" class="mb-2 block font-semibold">Bobot</label>
        @php
            $currentTotalBobot = App\Models\KriteriaPelanggaran::sum('bobot');
            $remainingBobot = 100 - $currentTotalBobot;
            $suggestedBobot = min($remainingBobot, old('bobot', $remainingBobot)); // Calculate suggested bobot
        @endphp
        <input type="number" name="bobot" id="bobot" class="border rounded p-2 w-full" placeholder="Masukkan Bobot" value="{{ $suggestedBobot }}" max="{{ $remainingBobot }}">
        @if($errors->has('bobot'))
            <span class="text-red-500">{{ $errors->first('bobot') }}</span>
        @endif
        <span class="text-red-500 animate-pulse">Saran: {{ $suggestedBobot }}%</span>
    </div>     
    <button type="submit" class="bg-green-500 text-white rounded p-2 w-fit px-10">Simpan</button>
</form>

@endsection
