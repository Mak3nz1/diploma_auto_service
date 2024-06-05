<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Security</title>
</head>

<body class="min-h-screen bg-gray-50">
  
    <header class="flex items-center justify-between p-6">
        <a href="/" class="flex items-center gap-3">
        <span class="text-2xl font-black">Home Page</span>
        </a>
        <div>
    <a href="{{ route('register') }}" class="rounded-md bg-green-600 py-3 px-6 font-semibold text-xl text-white shadow-lg transition duration-150 ease-in-out hover:bg-green-700 hover:shadow-xl focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Register</a>
</div>
    </header>
    <main class="flex flex-col justify-center p-6 pb-12">
        <div class="mx-auto max-w-md">
            <svg class="mx-auto h-2 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="0.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
            </svg>
            <h2 class="mt-2 text-3xl font-bold text-gray-900 sm:mt-6 sm:text-4xl">Welcome back!</h2>
        </div>
        <div class="mx-auto mt-6 w-full max-w-md rounded-xl bg-white/80 p-6 shadow-xl backdrop-blur-xl sm:mt-10 sm:p-10">
            @if (session('status'))
                <div class="flex gap-3 rounded-md border border-green-500 bg-green-50 p-4 mb-6">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-lg font-medium text-green-800">{{ session('status') }}</h3>
                </div>
            @endif
            <form action="{{ route('login') }}" method="post" autocomplete="off">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="{{ $errors->has('email') ? 'text-red-400' : 'text-gray-400' }} h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-7 5H8a2 2 0 01-2-2V9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="{{ $errors->has('email') ? 'text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 border-red-300' : 'border-gray-300 focus:border-green-500 focus:ring-green-500 placeholder:text-gray-400' }} w-full rounded-md pl-10 text-md" placeholder="john@example.com" />
                        @error('email')
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @enderror
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="{{ $errors->has('password') ? 'text-red-400' : 'text-gray-400' }} h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required class="{{ $errors->has('password') ? 'text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 border-red-300' : 'border-gray-300 focus:border-green-500 focus:ring-green-500 placeholder:text-gray-400' }} w-full rounded-md pl-10 text-md" placeholder="Minimum 8 characters" />
                        @error('password')
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @enderror
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="remember" name="remember" class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500" />
                        <label for="remember" class="text-sm text-gray-900">Remember me</label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full items-center justify-center rounded-md bg-green-600 py-2 px-4 font-semibold text-white shadow-lg transition duration-150 ease-in-out hover:bg-green-700 hover:shadow-xl focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Log In</button>
                </div>
            </form>
        </div>
    </main>
</body>

<style>
    /* Ваші стилі залишаються незмінними */

    /* Нові стилі */
    .text-3xl {
        font-size: 1.875rem; /* Збільшено розмір тексту */
    }

    .text-lg {
        font-size: 1.125rem; /* Збільшено розмір тексту */
    }

    .text-md {
        font-size: 1rem; /* Збільшено розмір тексту */
    }

    .input-field {
        font-size: 1rem; /* Збільшено розмір тексту у полі вводу */
        padding: 0.75rem 1rem; /* Збільшено розмір внутрішнього відступу у полі вводу */
    }
</style>

</html>

<style>
    button {
        width: 100%; /* Змінює ширину кнопки на 100% від батьківського елемента */
    height: 28px; /* Автоматично змінює висоту кнопки в залежності від змісту */
}
    body {
        font-family: 'Times New Roman', sans-serif;
        padding: 20px;
    }

    h2 {
        color: #333;
    }

    .btn {
        display: inline-block;
        margin: 10px 0;
        padding: 10px 20px;
        text-decoration: none;
        color: #fff;
        background-color: #007bff;
        border-radius: 5px;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .btn-warning,
    .btn-danger {
        margin-right: 5px;
    }

    .back-to-home-button {
        display: inline-block;
        margin-top: 20px;
        text-decoration: none;
        color: #fff;
        background-color: #007bff;
        padding: 10px 20px;
        border-radius: 5px;
    }

    .back-to-home-button:hover {
        background-color: #0056b3;
    }

    /* New Styles */
    .min-h-screen {
        min-height: 100vh;
    }

    .fill-current {
        fill: currentColor;
    }

    .fill-green-600 {
        fill: #10B981;
    }

    .bg-gray-50 {
        background-color: #f9fafb;
    }

    .text-green-600 {
        color: #10B981;
    }

    .text-green-800 {
        color: #047857;
    }

    .text-red-400 {
        color: #DC2626;
    }

    .text-red-500 {
        color: #EF4444;
    }

    .text-red-600 {
        color: #DC2626;
    }

    .placeholder-red-300::placeholder {
        color: #F87171;
    }

    .border-red-300 {
        border-color: #F87171;
    }

    .focus:border-red-500 {
        border-color: #EF4444;
    }

    .focus:ring-red-500 {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.5);
    }

    .bg-green-600 {
        background-color: #047857;
    }

    .hover:bg-green-700:hover {
        background-color: #065F68;
    }

    .hover:shadow-xl:hover {
        box-shadow: 0 4px 10px rgba(4, 120, 87, 0.1);
    }

    .focus:shadow-xl:focus {
        box-shadow: 0 4px 10px rgba(4, 120, 87, 0.1);
    }

    .focus:outline-none:focus {
        outline: 2px solid transparent;
    }

    .focus:ring-2:focus {
        box-shadow: 0 0 0 2px #10B981;
    }

    .focus:ring-offset-2:focus {
        box-shadow: 0 0 0 2px rgba(4, 120, 87, 0.5);
    }

    .text-sm {
        font-size: 0.875rem;
    }

    .text-md {
        font-size: 1.125rem;
    }

    .text-lg {
        font-size: 1.25rem;
    }

    .font-black {
        font-weight: 900;
    }

    .rounded-md {
        border-radius: 0.375rem;
    }

    .rounded-xl {
        border-radius: 0.75rem;
    }

    .shadow-xl {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .backdrop-blur-xl {
        backdrop-filter: blur(20px);
    }
    .max-w-md {
            max-width: 28rem; /* Змініть потрібну ширину контейнера */
        }

        .rounded-xl {
            border-radius: 1rem; /* Змініть потрібний радіус для закруглення контейнера */
        }

        .backdrop-blur-xl {
            backdrop-filter: blur(20px); /* Змініть потрібний ефект блюру */
        }

        .h-2 {
            height: 1.5px; /* Змініть потрібну висоту лінії */
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }
</style>

</html>
