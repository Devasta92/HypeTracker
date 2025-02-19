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
        @auth
        <div>
            <form action="/logout" method="POST" class="m-0">
                @csrf
                <button class="text-sm">Log out</button>
            </form>
        </div>
        @endauth
    </header>


        @auth


            <div style="border: 2px solid rgb(68, 3, 3);">
                <form action="/create-group" method="POST">
                    @csrf
                    <input type="text" name="groupName" placeholder="group name">
                    <button>Create new Group</button>
                </form>
            </div>

            <div>
                <p>Group overview</p>
                @foreach($groups as $group)
                    <div>
                        <!-- per Route verweise ich auf die route mit dem Namen 'groups.showGroup und gebe außerdem auch die GruppenId mit. -->
                        <a href="{{ route('groups.showGroup', $group->id)}} ">{{$group['name']}}</a>
                    </div>
                    <div>
                        <form action="/delete-group/{{$group->id}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button>Delete</button>
                        </form>
                    </div>                
                @endforeach
            </div>

        @else
        
        @endauth
</body>
</html>