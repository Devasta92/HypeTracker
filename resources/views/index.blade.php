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
                <a href="{{route('groups.show.all')}}" class="hover:text-pink-300">Groups</a>            
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
                <a href={{ route('users.register.form') }} class="text-sm m-0 content-center justify-center">Register</a>
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

            {{-- POST PRESENTATION START --}}
            <div>
                @foreach($posts as $post)
                    <article class="gap-4 max-w-lg w-full mx-auto my-10 bg-gray-200 p-6 rounded shadow-md justify-between align-middle items-center">
                        <p class="font-bold text-3xl text-gray-800">{{$post['title']}}</p><div class="text-sm text-gray-500 hover:text-gray-800 text-right"><a href="{{ route('groups.show.single', $post['group_id'])}}">{{$post->group->name}}</a></div>
                        <p class="font-bold text-lg">{{$post->user->name}}</p>
                        <p>{{$post['description']}}</p>
                    <hr class="h-1 bg-pink-300 w-1/2 mx-auto my-3">
                    <div class="mt-4 bg-gray-200 text-center">    
                        <p class="font-bold">Aktuelle Bewertung:</p>
                        <p>{{ $post->avgPostRating() }}</p>
                    </div>
                    <hr class="h-1 bg-pink-300 w-1/2 mx-auto my-3">
                    <div class="mt-4 bg-gray-200 text-center">    
                        <p class="font-bold">Bewertung abgeben:</p>                    
                        <form action="/posts/{{ $post->id }}/rate" class="m-0" method="POST">
                            @csrf
                            <button name="rating_value" class="hover:bg-red-800 bg-gray-700 text-white w-8" value="1">1</button>
                            <button name="rating_value" class="hover:bg-red-400 bg-gray-700 text-white w-8" value="2">2</button>
                            <button name="rating_value" class="hover:bg-orange-400 bg-gray-700 text-white w-8" value="3">3</button>
                            <button name="rating_value" class="hover:bg-green-400 bg-gray-700 text-white w-8" value="4">4</button>
                            <button name="rating_value" class="hover:bg-green-700 bg-gray-700 text-white w-8" value="5">5</button>
                        </form>
                    </div>
                    {{-- EDIT/DELETE BUTTONS START --}}
                    <div class="grid grid-cols-2 mt-4">
                        <a href="/posts/{{ $post->id }}/edit" class="hover:text-blue-700">Edit</a>
                        <form action="/posts/{{ $post->id }}/delete" class="m-0" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="hover:text-red-500">Delete</button>
                        </form>
                    </div>
                    {{-- EDIT/DELETE BUTTONS END --}} 
                    </article>                
                @endforeach
            </div>
            {{-- POST PRESENTATION END --}}

</body>
</html>


{{-- VIEWS ZERSTÖRT UND REDIRECTS. STRUKTUR ANPASSEN --}}