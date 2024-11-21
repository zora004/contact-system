@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Login</h2>

            <!-- Show Validation Errors -->
            {{-- @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}

            <form action="#" method="POST">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-600">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full p-2 mt-2 border border-gray-300 rounded-lg" required>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-600">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full p-2 mt-2 border border-gray-300 rounded-lg" required>
                </div>

                <!-- Login Button -->
                <div class="mb-4">
                    <button type="button" onclick="loginUser()"
                        class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-700" id="login-form">
                        Login
                    </button>
                </div>

                <!-- Register Link -->
                {{-- <div class="text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register</a>
                </p>
                </div> --}}
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            loginUser = function() {
                let email = $('#email').val()
                let password = $('#password').val()
                $.ajax({
                    url: '/api/login',
                    method: 'POST',
                    data: {
                        'email': email,
                        'password': password
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        localStorage.setItem('token', data.token)
                        window.location.href = '/api/dashboard'
                    },
                    error: function(error) {
                        console.error("Error fetching users:", error);
                    }
                })
            }
        })
    </script>
@endsection
