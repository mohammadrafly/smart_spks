<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name') }}  | {{ $title }}</title>
  @vite('resources/css/app.css')
</head>
<body>
    <div class="flex justify-center items-center bg-white">
        <div class="w-full min-h-screen flex justify-between items-center mx-64">
            <div class="w-1/2">
                <img src="{{ asset('assets/images/hero.jpeg')}}" alt="" class="w-full">
            </div>
            <div class="w-1/2">
                <div class="flex justify-center items-center">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite('resources/js/app.js')
    @yield('script')
</body>
</html>