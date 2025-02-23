<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>hypeTracker - Home</title>
</head>
<body class="bg-pink-200 font-mono">

    {{-- HEADER ELEMENT START --}}
    <header class="flex justify-between items-center px-8 py-2 text-2xl bg-gray-900 text-white">
        {{-- NAVIGATION LINKS HOME/GROUPS START --}}
        <nav class="flex space-x-10">
            <a href="/" class="hover:text-pink-300">Home</a>
            @auth
                <a href="/groups/overview" class="hover:text-pink-300">Groups</a>            
            @endauth
        </nav>
        {{-- NAVIGATION LINKS HOME/GROUPS END --}}

        {{-- LOGIN FORMULAR START --}}
        @guest
            <div class="flex space-x-4">
                <form action="/users/login" method="POST" class="m-0"> 
                    @csrf
                    <input name="loginname" type="text" placeholder="name" class="px-2 py-2 rounded bg-gray-800 text-white border border-gray-700">
                    <input name="loginpassword" type="password" placeholder="password" class="px-2 py-2 rounded bg-gray-800 text-white border border-gray-700">
                    <button class="px-2 py-2 bg-pink-500 text-white rounded hover:bg-pink-600 text-sm">Sign in</button>
                </form> 
                <a href=/users/register class="text-sm m-0 content-center justify-center">Register</a>
            </div>
        @endguest
        {{-- LOGIN FORMULAR END --}}
        {{-- PROFILE/LOGIN SECTION START --}}
        @auth
            <div>                
                <form action="/users/logout" method="POST" class="m-0">
                    @csrf
                    <a href="{{ route('users.edit', auth()->user()->id) }}" class="text-sm hover:text-pink-300">{{auth()->user()->name}}</a>
                    <button class="text-sm hover:text-pink-300">Log out</button>
                </form>
            </div>
        @endauth
        {{-- PROFILE/LOGIN SECTION END --}}
    </header>
    {{-- HEADER ELEMENT END --}}
           
    {{-- EDIT USER FORMULAR START --}}
    @auth
        <div>
            <form action="/users/{{auth()->user()->id}}/edit" method="POST" class="grid grid-cols-2 gap-4 max-w-lg w-full mx-auto my-10 bg-gray-200 p-6 rounded shadow-md justify-between align-middle items-center"> 
                @csrf
                @method('PUT')
                <p class="col-span-2 text-center font-bold text-2xl">EDIT USER INFORMATION</p>
                <p class="my-2 font-bold">Username: </p><input name='name' type="text" value="{{$user->name}}" class="my-2" placeholder="Username">
                <p class="my-2 font-bold">Email: </p><input name='email' type="text" value="{{$user->email}}" class="my-2" placeholder="Email">
                <hr class="w-48 h-1 mt-4 bg-gray-100 border-0 rounded-sm dark:bg-gray-700 col-span-2 mx-auto">
                <p class="col-span-2 text-center font-bold text-lg">CHANGE PASSWORD</p>                
                <p class="my-2 font-bold">New Password: </p><input name='newPassword' type="password" class="my-2" placeholder="New password">
                <p class="my-2 font-bold">Repeat new Password: </p><input name='newPassword_confirmation' type="password" class="my-2" placeholder="Repeat new password">
                <hr class="w-48 h-1 mt-4 bg-gray-100 border-0 rounded-sm dark:bg-gray-700 col-span-2 mx-auto">
                <p class="col-span-2 text-center font-bold text-lg">CONFIRM CHANGES</p>                

                <p class="my-2 font-bold">Current Password: </p><input name='password' type="password" class="my-2 border-red-600 border-2" placeholder="Current password">

                <button class="px-2 py-2 bg-gray-700 text-white rounded text-sm col-span-2 text-center">Save changes!</button>
            </form> 
        </div>
    @endauth
    {{-- EDIT USER FORMULAR END --}} 

</body>
</html>