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
                    <a href="/users/profile" class="text-sm hover:text-pink-300">{{auth()->user()->name}}</a>
                    <button class="text-sm hover:text-pink-300">Log out</button>
                </form>
            </div>
        @endauth
        {{-- PROFILE/LOGIN SECTION END --}}
    </header>
    {{-- HEADER ELEMENT END --}}

    {{-- GROUP CREATION FORMULAR SECTION START --}}
    @auth
        <div>
            {{-- Die Action "/register" wird ausgelöst beim klick auf den button in dieser Form. Siehe dann routes /d --}}
            <form action="groups/create" method="POST" class="grid grid-cols-2 gap-4 max-w-lg w-full mx-auto my-10 bg-gray-200 p-6 rounded shadow-md justify-between align-middle items-center"> 
                @csrf {{-- ist unbedingt notwendig, um Forms abzuschicken, ist ein Sicherheitsfeature von Laravel (Cross-site request forgery) /d --}}
                <p class="col-span-2 text-center font-bold text-2xl">CREATE NEW GROUP</p>
                <p class="my-2 font-bold">Group name: </p><input name='groupName' type="text" placeholder="name" class="my-2">
                <button class="px-2 py-2 bg-gray-700 text-white rounded text-sm col-span-2 text-center hover:bg-gray-500">Create new Group!</button>
            </form> 
        </div>
    @endauth
    {{-- GROUP CREATION FORMULAR SECTION END --}}

    {{-- GROUP OVERVIEW START --}}
    @auth
    <hr class="w-48 h-1 mx-auto my-4 bg-gray-100 border-0 rounded-sm md:my-10 dark:bg-gray-700">
        <div class="grid grid-cols-2 gap-4 max-w-lg w-full mx-auto my-10 bg-gray-200 p-6 rounded shadow-md justify-between align-middle items-center">
            <p class="text-2xl font-bold text-center col-span-2">YOUR GROUPS</p>
            @foreach($groups as $group)
                <div class="relative rounded gap-1 max-w-lg bg-gray-400 my-2 py-2 px-2 hover:bg-pink-400">
                    <a href="{{ route('groups.show.single', $group->id)}} " class="absolute inset-0"></a>
                    <div>
                        {{-- per Route verweise ich auf die route mit dem Namen 'groups.showGroup und gebe außerdem auch die GruppenId mit. --}}
                        <p class="hover:text-pink-800 font-bold text-xl text-center">{{$group['name']}}</p>
                    </div>                    
                </div>
             {{--<div>
                    <form action="/delete-group/{{$group->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="hover:text-red-600 hover:font-bold">Delete</button>
                    </form>
                </div> --}}                
            @endforeach
        </div>    
    @endauth
    {{-- GROUP OVERVIEW END --}}

</body>
</html>