@extends('layouts.app')

@section('content')

<div class="block mt-5" x-data="{ open: 'profile' }">
    <div class="bg-white rounded-lg w-[400px] min-h-[200px]">
        @if (Auth::user()->photo)
        <div class="flex justify-center items-center min-h-[200px]">
            <img src="{{ asset('storage/' . Auth::user()->photo)}}" alt="User Photo" class="rounded-full w-32 h-32 object-cover shadow-xl">
        </div>        
        @else
        <div class="flex justify-center items-center min-h-[200px]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-32 h-32">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
        </div>
        @endif
    </div>
    <div class="bg-white w-full rounded-lg min-h-fit mt-5 p-5">
        <div class="flex gap-10">
            <div @click="open = 'profile'" :class="{ 'text-blue-500': open === 'profile' }" class="cursor-pointer">
                Edit Profile
            </div>
            <div @click="open = 'password'" :class="{ 'text-blue-500': open === 'password' }" class="cursor-pointer">
                Ubah Password
            </div>
        </div>
        <div class="border-b-2 my-3 opacity-90"></div>
        <div x-show="open === 'profile'" x-transition>
            <div>
                <form class="w-1/2" action="{{ route('profile.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="py-5">
                        <label for="photo" class="mb-2 block font-semibold">Photo</label>
                        <input type="file" name="photo" id="photo" class="border rounded p-2 w-full">
                        @error('photo')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="py-5">
                        <label for="name" class="mb-2 block font-semibold">Name</label>
                        <input type="text" name="name" id="name" class="border rounded p-2 w-full" value="{{ $data->name }}" placeholder="Masukkan Name">
                        @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="py-5">
                        <label for="email" class="mb-2 block font-semibold">Email</label>
                        <input type="email" name="email" id="email" class="border rounded p-2 w-full" value="{{ $data->email }}" placeholder="Masukkan Email">
                        @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="py-5">
                        <label for="phone" class="mb-2 block font-semibold">Phone</label>
                        <input type="number" name="phone" id="phone" class="border rounded p-2 w-full" value="{{ $data->phone }}" placeholder="Masukkan Phone">
                        @error('phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="bg-yellow-500 text-white rounded p-2 w-fit">Simpan Perubahan</button>
                </form>
            </div>
        </div>
        <div x-show="open === 'password'" x-transition>
            <div>
                <form class="w-1/2" action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <div class="py-5">
                        <label for="old_password" class="mb-2 block font-semibold">Password Lama</label>
                        <input type="password" name="old_password" id="old_password" class="border rounded p-2 w-full" placeholder="Masukkan Password Lama">
                        @error('old_password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="py-5">
                        <label for="new_password" class="mb-2 block font-semibold">Password Baru</label>
                        <input type="password" name="new_password" id="new_password" class="border rounded p-2 w-full" placeholder="Masukkan Password Baru">
                        @error('new_password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="py-5">
                        <label for="new_password_confirmation" class="mb-2 block font-semibold">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="border rounded p-2 w-full" placeholder="Masukkan Konfirmasi Password Baru">
                        @error('new_password_confirmation')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="bg-yellow-500 text-white rounded p-2 w-fit">Simpan Perubahan</button>
                </form>
            </div>
        </div>        
    </div>
</div>

@endsection
