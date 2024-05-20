<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name') }}  | {{ $title }}</title>
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
</head>
<body class="min-h-screen flex flex-col" x-data="{ open: true }">
    @include('layouts.partials.navbar')
    
    <div class="flex flex-1 w-full">
        @include('layouts.partials.sidebar')

        <div class="flex-1 p-10 bg-sky-50">
            <div class="text-[#6888E4] font-semibold text-2xl">
                {{ $title }}
            </div>
            <div class="bg-white p-5 mt-5">
                <div>
                    @include('components.flash')
                </div>
                @yield('content')
            </div>

            @yield('secondtable')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="{{ asset('assets/js/app.js')}}"></script>
    @vite('resources/js/app.js')
    @yield('script')

    <script>
        async function logout(event) {
            event.preventDefault();
            
            const confirmed = confirm("Are you sure you want to log out?");
            if (!confirmed) {
                return;
            }
    
            try {
                const response = await fetch("{{ route('dashboard.logout') }}", {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                });
                
                const data = await response.json();

                if (response.ok) {
                    alert(data.message)
                    window.location.href = data.redirect;
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('An error occurred: ' + error.message);
            }
        }
    </script>
</body>
</html>
