<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name', 'FreshMart') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Sign in to {{ config('app.name', 'FreshMart') }}
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Welcome back! Please sign in to your account.
                </p>
            </div>
            
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-6" method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email address
                        </label>
                        <div class="mt-1">                            <input id="email" name="email" type="email" autocomplete="email" required 
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
                        </label>                        <div class="mt-1">                            <input id="password" name="password" type="password" autocomplete="current-password" required 
                                   class="input-field @error('password') input-error @enderror">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" 
                                   class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded" 
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="ml-2 block text-sm text-gray-900">
                                Remember me
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-green-600 hover:text-green-500">
                                    Forgot your password?
                                </a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit" 
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Sign in
                        </button>
                    </div>

                    @if (Route::has('register'))
                        <div class="text-center">
                            <span class="text-sm text-gray-600">Don't have an account?</span>
                            <a href="{{ route('register') }}" class="font-medium text-green-600 hover:text-green-500">
                                Sign up here
                            </a>
                        </div>
                    @endif                </form>

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
