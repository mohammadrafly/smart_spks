<div class="bg-white flex justify-between items-center w-full">
    <div class="min-w-[300px] flex justify-between items-center">
        <img src="{{ asset('assets/images/logo.png')}}" alt="" class="w-20">
        <div class="p-5 flex justify-center items-center font-bold text-3xl text-[#6888E4]">
            {{ env('APP_NAME')}}
        </div>
    </div>
    <div class="p-10 flex justify-between items-center w-full">
        <div x-on:click="open = ! open">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>  
        </div>
        <div x-data="{ open: false }" class="relative">
            <div class="flex justify-between items-center cursor-pointer" x-on:click="open = ! open">
                <div>
                    @if (Auth::user()->photo)
                        <img src="{{asset('storage/'. Auth::user()->photo)}}" alt="" class="w-8 h-8 rounded-full">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    @endif
                </div>
                <div class="mx-2">
                    {{ Auth::user()->name }}
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>  
                </div>
            </div>

            <div x-show="open" x-transition x-cloak class="fixed right-0 mr-10 p-2 w-[200px] shadow-lg bg-[#6888E4] rounded-lg mt-5">
                <ul class="mx-2">
                    <a href="{{ route('profile.update')}}">
                        <li class="transition duration-300 p-2 hover:bg-gray-50 rounded-lg my-2 bg-white text-[#6888E4]">
                            Profile
                        </li>
                    </a>
                    <a href="#" onclick="logout(event)">
                        <li class="transition duration-300 p-2 hover:bg-red-600 rounded-lg my-2 bg-red-500 text-white">
                            Logout
                        </li>
                    </a>
                </ul>
            </div>            
        </div>
    </div>
</div>
