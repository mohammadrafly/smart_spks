@extends('layouts.auth')

@section('content')
<div class="block max-w-md mx-auto w-full">
    <div class="font-bold text-4xl text-center mb-10">Create an Account</div>
    <form id="register-form">
        @csrf
        <div class="py-5">
            <label for="name" class="mb-2 block font-semibold">Name</label>
            <input type="text" name="name" id="name" class="border rounded p-2 w-full" placeholder="Masukkan Nama">
        </div>
        <div class="py-5">
            <label for="email" class="mb-2 block font-semibold">Email</label>
            <input type="email" name="email" id="email" class="border rounded p-2 w-full" placeholder="Masukkan Email">
        </div>
        <div class="py-5">
            <label for="phone" class="mb-2 block font-semibold">Phone</label>
            <input type="number" name="phone" id="phone" class="border rounded p-2 w-full" placeholder="Masukkan No. HP">
        </div>
        <div class="py-5">
            <label for="password" class="mb-2 block font-semibold">Password</label>
            <input type="password" name="password" id="password" class="border rounded p-2 w-full" placeholder="Masukkan Password">
        </div>
        <div class="py-5">
            <button type="submit" class="bg-[#0056F8] text-white rounded p-2 w-full">Register</button>
        </div>
        <div class="flex justify-center items-center">
            <span>
                Already have an account? <a href="{{ route('login') }}" class="text-blue-500">Sign in</a>
            </span>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    async function submitRegisterForm(event) {
        event.preventDefault();

        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const password = document.getElementById('password').value;

        try {
            const response = await fetch('{{ route('register') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    phone: phone,
                    password: password
                })
            });

            const data = await response.json();

            if (response.ok) {
                alert(data.message);
                window.location.href = data.redirect;
            } else {
                alert('Registration failed: ' + data.message);
            }
        } catch (error) {
            alert('An error occurred: ' + error.message);
        }
    }

    document.getElementById('register-form').addEventListener('submit', submitRegisterForm);
</script>
@endsection
