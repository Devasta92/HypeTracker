<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>hypeTracker - Group</title>
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
                    <a href="/users/profile" class="text-sm hover:text-pink-300">Profile</a>
                    <button class="text-sm hover:text-pink-300">Log out</button>
                </form>
            </div>
        @endauth
        {{-- PROFILE/LOGIN SECTION END --}}
    </header>
    {{-- HEADER ELEMENT END --}}

    {{-- GROUP NAME START--}}
    <div class="flex text-5xl justify-center font-bold my-4">
        <div>{{ $group->name }}</div>
    </div>
    {{-- GROUP NAME END--}}          
        

    {{-- EDIT GROUP FORMULAR START --}}
    @auth
    <div>
        <form action="/groups/{{$group->id}}/edit" method="POST" class="grid grid-cols-2 gap-4 max-w-lg w-full mx-auto my-10 bg-gray-200 p-6 rounded shadow-md justify-between align-middle items-center"> 
            @csrf {{-- ist unbedingt notwendig, um Forms abzuschicken, ist ein Sicherheitsfeature von Laravel (Cross-site request forgery) /d --}}
            @method('PUT')
            <p class="col-span-2 text-center font-bold text-2xl">EDIT GROUP</p>
            <p class="my-2 font-bold">Group name: </p><input name='name' type="text" value="{{$group->name}}" class="my-2">
            <p class="my-2 font-bold">Group description: </p><textarea name='description' type="text" placeholder="description" class="my-2" rows="5">{{$group->description}}</textarea>
            <button class="px-2 py-2 bg-gray-700 text-white rounded text-sm col-span-2 text-center">Save changes!</button>
        </form> 
    </div>
    @endauth
    {{-- EDIT GROUP FORMULAR END --}}  

</body>
</html>