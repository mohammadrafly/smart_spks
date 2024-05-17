@extends('layouts.app')

@section('content')

<form class="w-1/2" action="{{ route('user.create')}}" method="POST">
    @csrf
    <div class="py-5">
        <label for="name" class="mb-2 block font-semibold">Name</label>
        <input type="text" name="name" id="name" class="border rounded p-2 w-full" placeholder="Masukkan Name" value="{{ old('name') }}">
        @error('name')
        <p class="text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div class="py-5">
        <label for="email" class="mb-2 block font-semibold">Email</label>
        <input type="email" name="email" id="email" class="border rounded p-2 w-full" placeholder="Masukkan Email" value="{{ old('email') }}">
        @error('email')
        <p class="text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div class="py-5">
        <label for="password" class="mb-2 block font-semibold">Password</label>
        <input type="password" name="password" id="password" class="border rounded p-2 w-full" placeholder="Masukkan Password">
        @error('password')
        <p class="text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div class="py-5">
        <label for="password_confirmation" class="mb-2 block font-semibold">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="border rounded p-2 w-full" placeholder="Konfirmasi Password">
        @error('password_confirmation')
        <p class="text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div class="py-5">
        <label for="phone" class="mb-2 block font-semibold">Phone</label>
        <input type="number" name="phone" id="phone" class="border rounded p-2 w-full" placeholder="Masukkan Phone" value="{{ old('phone') }}">
        @error('phone')
        <p class="text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div class="py-5">
        <label for="usertype" class="mb-2 block font-semibold">Role</label>
        <select name="usertype" id="usertype" class="border rounded p-2 w-full">
            <option value="admin" {{ old('usertype') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="guru" {{ old('usertype') == 'guru' ? 'selected' : '' }}>Guru</option>
            <option value="bk" {{ old('usertype') == 'bk' ? 'selected' : '' }}>BK</option>
        </select>
        @error('usertype')
        <p class="text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="bg-green-500 text-white rounded p-2 w-fit px-10">Simpan</button>
</form>

@endsection
