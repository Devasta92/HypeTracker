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
                    <a href="/users/profile" class="text-sm hover:text-pink-300">{{auth()->user()->name}}</a>
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
        <a class="text-sm ml-5 hover:text-pink-600" href="{{ route('groups.edit', $group)}}">Edit</a>
    </div>
    {{-- GROUP NAME END--}}

        {{-- POST CREATION FORMULAR SECTION START --}}
        @auth
            <div>
                {{-- Die Action "/register" wird ausgelöst beim klick auf den button in dieser Form. Siehe dann routes /d --}}
                <form action="/posts/create" method="POST" class="grid grid-cols-2 gap-4 max-w-lg w-full mx-auto my-10 bg-gray-200 p-6 rounded shadow-md justify-between align-middle items-center"> 
                    @csrf {{-- ist unbedingt notwendig, um Forms abzuschicken, ist ein Sicherheitsfeature von Laravel (Cross-site request forgery) /d --}}
                    <p class="col-span-2 text-center font-bold text-2xl">CREATE NEW POST</p>
                    <p class="my-2 font-bold">Post title: </p><input name='postTitle' type="text" placeholder="title" class="my-2">
                    <p class="my-2 font-bold">Post description: </p><textarea name='postDescription' type="text" placeholder="description" class="my-2" rows="4"></textarea>
                    <label for="image" class="font-bold">Choose an image:</label>
                    <input name="postImage" type="file" id="image">
                    <input name='group_id' type="hidden" value="{{$group->id}}">
                    <button class="px-2 py-2 bg-gray-700 text-white rounded text-sm col-span-2 text-center">Create new post!</button>
                </form> 
            </div>
        @endauth
        {{-- POST CREATION FORMULAR SECTION END --}}
        
        {{-- USER INVITE FORMULAR START --}}
        @auth
            <div>
                <form action="/groups/{{ $group->id }}/users" method="POST" class="grid grid-cols-2 gap-4 max-w-lg w-full mx-auto my-10 bg-gray-200 p-6 rounded shadow-md justify-between align-middle items-center"> 
                    @csrf {{-- ist unbedingt notwendig, um Forms abzuschicken, ist ein Sicherheitsfeature von Laravel (Cross-site request forgery) /d --}}
                    <p class="col-span-2 text-center font-bold text-2xl">INVITE USER</p>
                    <p class="my-2 font-bold">Username: </p><input name='username' type="text" placeholder="username" class="my-2">
                    <input name='group_id' type="hidden" value="{{$group->id}}">
                    <button class="px-2 py-2 bg-gray-700 text-white rounded text-sm col-span-2 text-center">Invite user!</button>
                </form> 
            </div>
        @endauth
        {{-- USER INVITE FORMULAR END --}} 

        {{-- POST PRESENTATION START --}}
        <div>
            @foreach($posts as $post)
                <div class="gap-4 max-w-lg w-full mx-auto my-10 bg-gray-200 p-6 rounded shadow-md justify-between align-middle items-center">
                    <!-- per Route verweise ich auf die route mit dem Namen 'groups.showGroup und gebe außerdem auch die GruppenId mit. -->                    
                    <p class="font-bold text-3xl text-gray-800">{{$post['title']}}</p>
                    <p class="font-bold text-lg">{{$post->user->name}}</p>
                    <p style="border-color: black">{{$post['description']}}</p>
                    <div class="grid grid-cols-2 mt-4">
                        <a href="/posts/{{ $post->id }}/edit" class="hover:text-blue-700">Edit</a>
                        <form action="/posts/{{ $post->id }}/delete" class="m-0" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="hover:text-red-500">Delete</button>
                        </form>
                    </div>
                </div>                
            @endforeach
        </div>
        {{-- POST PRESENTATION END --}}

        {{-- GROUP MEMBER PRESENTATION START --}}
        <div>            
            <div class="gap-4 max-w-lg w-full mx-auto my-10 bg-gray-200 p-6 rounded shadow-md justify-between align-middle items-center">
                <p class="text-center font-bold text-2xl">LIST OF MEMBERS:</p>
                @foreach($group->members as $member)
                <div>
                    <p class="font-bold text-gray-800">{{ $member->name }}</p>                    
                    <form action="/groups/{{$group->id}}/users/{{$member->id}}/delete" class="m-0" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="hover:text-red-500 text-xs">Delete</button>
                    </form>                    
                </div>
                @endforeach    
            </div>            
        </div>        
        {{-- GROUP MEMBER PRESENTATION END --}}

</body>
</html>