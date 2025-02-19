<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>hypeTracker - Home</title>
</head>
<body class="bg-pink-200 font-mono">
    <header class="flex justify-between items-center px-8 py-2 text-2xl bg-gray-900 text-white">
        <!-- Navigation links -->
        <nav class="flex space-x-10">
            <a href="/" class="hover:text-pink-300">Home</a>
            @auth
            <a href="/group-overview" class="hover:text-pink-300">Groups</a>
            <a href="/profile" class="hover:text-pink-300">Profile</a>
            @endauth
        </nav>

        <!-- Login-Formular -->
        @guest
        <div class="flex space-x-4">
            <form action="/login" method="POST" class="m-0"> 
                @csrf
                <input name="loginname" type="text" placeholder="name" class="px-2 py-2 rounded bg-gray-800 text-white border border-gray-700">
                <input name="loginpassword" type="password" placeholder="password" class="px-2 py-2 rounded bg-gray-800 text-white border border-gray-700">
                <button class="px-2 py-2 bg-pink-500 text-white rounded hover:bg-pink-600 text-sm">Sign in</button>
            </form> 
            <a href=/register-window class="text-sm m-0 content-center justify-center">Register</a>
        </div>
        @endguest
    </header>
           
        <!-- Register area -->
        <div>
            <!-- Die Action "/register" wird ausgelöst beim klick auf den button in dieser Form. Siehe dann routes /d -->
            <form action="/register" method="POST" class="grid grid-cols-2 gap-4 max-w-lg w-full mx-auto my-10 bg-gray-200 p-6 rounded shadow-md justify-between align-middle items-center"> 
                @csrf <!-- ist unbedingt notwendig, um Forms abzuschicken, ist ein Sicherheitsfeature von Laravel (Cross-site request forgery) /d -->
                <p class="my-2">Username: </p><input name='name' type="text" placeholder="name" class="my-2">
                <p class="my-2">Email: </p><input name='email' type="text" placeholder="email" class="my-2">
                <p class="my-2">Password: </p><input name='password' type="password" placeholder="password" class="my-2">
                <button class="px-2 py-2 bg-gray-700 text-white rounded text-sm">Register</button>
            </form> 
        </div>
</body>
</html>