@extends('layouts.main')

@section('container')
    <div class="w-screen h-screen flex justify-center items-center bg-gray-100">
        <form class="p-10 bg-white rounded flex justify-center items-center flex-col shadow-md" action="/login" method="POST">
            @csrf
            <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-gray-600 mb-2" viewbox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
            </svg>
            <p class="mb-5 text-3xl uppercase text-gray-600">Login</p>
            @if(session()->has('loginError'))
            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ session('loginError') }}
                </p>
            </div>
            @endif
            <input type="email" name="email" class="mb-5 p-3 w-80 focus:border-purple-700 rounded border-2 outline-none" autocomplete="off" placeholder="Email" required>
            <input type="password" name="password" class="mb-5 p-3 w-80 focus:border-purple-700 rounded border-2 outline-none" autocomplete="off" placeholder="Password" required>
            <button class="bg-purple-600 hover:bg-purple-900 text-white font-bold p-2 rounded w-80" id="login" type="submit"><span>Login</span></button>
        </form>
    </div>
@endsection