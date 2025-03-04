@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 text-center">
        <h1 class="text-5xl font-bold text-gray-800">Welcome to Our Platform</h1>
        <p class="text-lg text-gray-600 mt-4">Your journey starts here.
            @auth
                <span class="text-green-500 font-semibold">You are logged in.</span>
            @else
                Register or log in to continue.
            @endauth
        </p>

        <div class="mt-6 space-x-4">
            @if (Auth::check())
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    Register
                </a>
            @endif
        </div>
    </div>
@endsection
