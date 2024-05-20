@extends('layouts.auth')

@section('content')
    
<div class="block max-w-md mx-auto w-full">
    <div class="font-bold text-4xl text-center mb-10">Sign In to Your Account</div>
    <form id="login-form">
        @csrf
        <div class="py-5">
            <label for="email" class="mb-2 block font-semibold">Email</label>
            <input type="email" name="email" id="email" class="border rounded p-2 w-full" placeholder="Masukkan Email">
        </div>
        <div class="py-5">
            <label for="password" class="mb-2 block font-semibold">Password</label>
            <input type="password" name="password" id="password" class="border rounded p-2 w-full" placeholder="Masukkan Password">
        </div>
        <div class="py-5">
            <button type="submit" class="bg-[#0056F8] text-white rounded p-2 w-full">Login</button>
        </div>
        <div class="flex justify-center items-center">
            <span>
                Don’t have account?<a href="{{ route('register')}}" class="text-blue-500"> Create an account</a>
            </span>
        </div>
        
    </form>
</div>

@endsection

@section('script')
<script>
    async function submitLoginForm(event) {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        try {
            const response = await fetch('{{ route('login') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            });

            const data = await response.json();

            if (response.ok) {
                alert(data.message);
                window.location.href = data.redirect;
            } else {
                alert('Login failed: ' + data.message);
            }
        } catch (error) {
            alert('An error occurred: ' + error.message);
        }
    }

    document.getElementById('login-form').addEventListener('submit', submitLoginForm);
</script>
@endsection
