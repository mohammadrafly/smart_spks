@extends('layouts.app')

@section('content')

<form class="w-1/2" action="{{ route('user.update', $data->id) }}" method="POST">
    @csrf
    <div class="py-5">
        <label for="name" class="mb-2 block font-semibold">Name</label>
        <input type="text" name="name" id="name" class="border rounded p-2 w-full" value="{{ old('name', $data->name) }}" placeholder="Masukkan Name">
        @if($errors->has('name'))
            <div class="text-red-500 mt-2">
                {{ $errors->first('name') }}
            </div>
        @endif
    </div>
    <div class="py-5">
        <label for="email" class="mb-2 block font-semibold">Email</label>
        <input type="email" name="email" id="email" class="border rounded p-2 w-full" value="{{ old('email', $data->email) }}" placeholder="Masukkan Email">
        @if($errors->has('email'))
            <div class="text-red-500 mt-2">
                {{ $errors->first('email') }}
            </div>
        @endif
    </div>
    <div class="py-5">
        <label for="phone" class="mb-2 block font-semibold">Phone</label>
        <input type="number" name="phone" id="phone" class="border rounded p-2 w-full" value="{{ old('phone', $data->phone) }}" placeholder="Masukkan Phone">
        @if($errors->has('phone'))
            <div class="text-red-500 mt-2">
                {{ $errors->first('phone') }}
            </div>
        @endif
    </div>
    <div class="py-5">
        <label for="usertype" class="mb-2 block font-semibold">Role</label>
        <select name="usertype" id="usertype" class="border rounded p-2 w-full">
            <option value="{{ $data->usertype }}" selected>{{ $data->usertype }}</option>
            <option value="admin" {{ old('usertype', $data->usertype) == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="bk/guru" {{ old('usertype', $data->usertype)  == 'bk/guru' ? 'selected' : '' }}>BK/Guru</option>
        </select>
        @if($errors->has('usertype'))
            <div class="text-red-500 mt-2">
                {{ $errors->first('usertype') }}
            </div>
        @endif
    </div>
    <button type="submit" class="bg-yellow-500 text-white rounded p-2 w-fit px-10">Simpan Perubahan</button>
</form>

@endsection
