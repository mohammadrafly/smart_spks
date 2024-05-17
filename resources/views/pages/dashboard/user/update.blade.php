@extends('layouts.app')

@section('content')

<form class="w-1/2">
    <div class="py-5">
        <label for="name" class="mb-2 block font-semibold">Name</label>
        <input type="text" name="name" id="name" class="border rounded p-2 w-full" value="{{ $data->name }}" placeholder="Masukkan Name">
    </div>
    <div class="py-5">
        <label for="email" class="mb-2 block font-semibold">Email</label>
        <input type="email" name="email" id="email" class="border rounded p-2 w-full" value="{{ $data->email }}" placeholder="Masukkan Email">
    </div>
    <div class="py-5">
        <label for="phone" class="mb-2 block font-semibold">Phone</label>
        <input type="number" name="phone" id="phone" class="border rounded p-2 w-full" value="{{ $data->phone }}" placeholder="Masukkan Phone">
    </div>
    <div class="py-5">
        <label for="usertype" class="mb-2 block font-semibold">Role</label>
        <select name="usertype" id="usertype" class="border rounded p-2 w-full">
            <option value="{{ $data->usertype }}" selected>{{ $data->usertype }}</option>
            <option value="admin">Admin</option>
            <option value="guru">Guru</option>
            <option value="bk">BK</option>
        </select>
    </div>
    <button type="submit" class="bg-yellow-500 text-white rounded p-2 w-fit">Simpan Perubahan</button>
</form>

@endsection