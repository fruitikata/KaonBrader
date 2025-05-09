<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kaon Brader</title>
        
        <link rel="icon" type="image" href="{{ asset('kaonbraderrICON.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <!--styles(nasa notes)-->
        @endif
    </head>
    <body class="bg-[#FDFDFC] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col pt-16">
        <header class="fixed top-0 left-0 w-full bg-gray-200 p-6 shadow-md flex justify-between items-center text-sm lg:text-base">
            <a href="{{ url('/') }}">
                <img src="{{ asset('kaonbrader.png') }}" alt="KaonBrader Logo" class="h-8 w-auto">
            </a>
        
            @if (Route::has('login'))
                <nav class="flex items-center gap-3">
                    @auth
                        <!-- Hidden for now -->
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-4 py-1 text-[#F4B133] border border-transparent hover:border-[#5d5122ec] rounded-md text-base font-semibold font-[Poppins]">
                            Log in
                        </a>
        
                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-4 py-1 text-[#F4B133] border border-transparent hover:border-[#5e5840ec] rounded-md text-base font-semibold font-[Poppins]">
                                Sign up
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        
    
        
        
        <div class="flex flex-col-reverse below1040:flex-col lg:flex-row items-center justify-between min-h-screen px-8 lg:px-16">
            <!-- Left Side - Description -->
            <div class="text-center below1040:text-left lg:text-left">
                <h1 class="text-5xl lg:text-xl font-bold text-[#1b1b18] font-[Poppins]">
                    Recipe Sharing among Students
                </h1>
                <p class="mt-4 text-lg text-[#1b1b18] text-justify max-w-2xl mx-auto below1040:mx-0">
                    Discover budget-friendly student-made meals and share your own recipes with ease.
                    This platform is built by and for students, making it the perfect space to explore
                    creative, affordable dishes that fit your lifestyle and wallet. Whether you're cooking
                    in a dorm, apartment, or shared space, you can browse quick meals, add your own favorites,
                    and connect with others who know what it's like to cook on a student budget.
                    From instant noodle hacks to healthy meal preps, your next go-to recipe is just a click away.
                </p>
            </div>
        
            <!-- Right Side - Logo -->
            <div class="mt-10 below1040:mt-0 lg:mt-0">
                <img src="{{ asset('landIMG.png') }}" alt="KaonBraderLandingLogo" class="w-[400px] h-auto mx-auto">
            </div>
        </div>
        
        

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
