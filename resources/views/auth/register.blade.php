<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - {{ config('app.name', 'FreshMart') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Create your account
                </h2>                <p class="mt-2 text-center text-sm text-gray-600">
                    Join {{ config('app.name', 'FreshMart') }} today!
                </p>
            </div>
            
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-6" method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Full Name
                        </label>                        <div class="mt-1">                            <input id="name" name="name" type="text" autocomplete="name" required 
                                   class="input-field @error('name') input-error @enderror" 
                                   value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email address
                        </label>                        <div class="mt-1">                            <input id="email" name="email" type="email" autocomplete="email" required 
                                   class="input-field @error('email') input-error @enderror" 
                                   value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>                        <div class="mt-1">                            <input id="password" name="password" type="password" autocomplete="new-password" required 
                                   class="input-field @error('password') input-error @enderror">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            Confirm Password
                        </label>
                        <div class="mt-1">                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Create Account
                        </button>
                    </div>

                    <div class="text-center">
                        <span class="text-sm text-gray-600">Already have an account?</span>
                        <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500">
                            Sign in here
                        </a>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        ← Back to homepage
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
