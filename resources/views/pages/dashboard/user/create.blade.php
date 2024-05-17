@extends('layouts.app')

@section('content')

<form class="w-1/2" id="create-form">
    <div class="py-5">
        <label for="name" class="mb-2 block font-semibold">Name</label>
        <input type="text" name="name" id="name" class="border rounded p-2 w-full" placeholder="Masukkan Name">
    </div>
    <div class="py-5">
        <label for="email" class="mb-2 block font-semibold">Email</label>
        <input type="email" name="email" id="email" class="border rounded p-2 w-full" placeholder="Masukkan Email">
    </div>
    <div class="py-5">
        <label for="password" class="mb-2 block font-semibold">Password</label>
        <input type="password" name="password" id="password" class="border rounded p-2 w-full" placeholder="Masukkan Password">
    </div>
    <div class="py-5">
        <label for="phone" class="mb-2 block font-semibold">Phone</label>
        <input type="number" name="phone" id="phone" class="border rounded p-2 w-full" placeholder="Masukkan Phone">
    </div>
    <div class="py-5">
        <label for="usertype" class="mb-2 block font-semibold">Role</label>
        <select name="usertype" id="usertype" class="border rounded p-2 w-full">
            <option value="admin">Admin</option>
            <option value="guru">Guru</option>
            <option value="bk">BK</option>
        </select>
    </div>
    <button type="submit" class="bg-yellow-500 text-white rounded p-2 w-fit">Simpan</button>
</form>

@endsection

@section('script')
<script>
    async function submitUserForm(event) {
        event.preventDefault();

        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const password = document.getElementById('password').value;
        const usertype = document.getElementById('usertype').value;

        try {
            const response = await fetch('{{ route('user.create') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    phone: phone,
                    password: password,
                    usertype: usertype
                })
            });

            const data = await response.json();

            if (response.ok) {
                alert(data.message);
                window.location.href = data.redirect;
            } else {
                alert(data.message);
            }
        } catch (error) {
            alert('An error occurred: ' + error.message);
        }
    }

    document.getElementById('create-form').addEventListener('submit', submitUserForm);
</script>
@endsection
