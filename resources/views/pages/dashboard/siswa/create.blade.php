@extends('layouts.app')

@section('content')

<form class="w-1/2">
    <div class="py-5">
        <label for="name" class="mb-2 block font-semibold">Nama</label>
        <input type="text" name="nama" id="nama" class="border rounded p-2 w-full" placeholder="Masukkan Name">
    </div>
    <div class="py-5">
        <label for="nis" class="mb-2 block font-semibold">NIS</label>
        <input type="number" name="nis" id="nis" class="border rounded p-2 w-full" placeholder="Masukkan Nis">
    </div>
    <div class="py-5">
        <label for="kelas" class="mb-2 block font-semibold">Kelas</label>
        <input type="number" name="kelas" id="kelas" class="border rounded p-2 w-full" placeholder="Masukkan Kelas">
    </div>
    <div class="py-5">
        <label for="wali_kelas" class="mb-2 block font-semibold">Wali Kelas</label>
        <input type="text" name="wali_kelas" id="wali_kelas" class="border rounded p-2 w-full" placeholder="Masukkan Wali kelas">
    </div>
    <button type="submit" class="bg-yellow-500 text-white rounded p-2 w-fit">Simpan Perubahan</button>
</form>

@endsection