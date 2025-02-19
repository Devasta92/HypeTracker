<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>hypeTracker - Group</title>
</head>
<body class="bg-pink-200 font-mono">
    <header class="flex justify-between">
        <div class="navbar flex justify-evenly py-3 text-3xl bg-gray-900 text-white">
            <a href="/">Home</a>
            <a href="/group-overview">Groups</a>
            <a href="/profile">Profile</a>
        </div>
        <div>

        </div>
    </header>

    @auth
        <p>Group View</p>
        <form action="/logout" method="POST">
            @csrf
            <button>Log out</button>
        </form>
        <div>
            <form action="/group/{{ $group->id }}/create-post" method="POST">
                @csrf
                <input name="postTitle" type="text" placeholder="title">
                <textarea name="postDescription" placeholder="description" cols="25" rows="4"></textarea>
                <label for="image">Choose an image</label>
                <input name="postImage" type="file" id="image">
                <input name='group_id' type="hidden" value="{{$group->id}}">
                <button>Create post</button>
            </form>
        </div>   
        <div>
            <p>Post overview</p>
            @foreach($posts as $post)
                <div>
                    <!-- per Route verweise ich auf die route mit dem Namen 'groups.showGroup und gebe außerdem auch die GruppenId mit. -->
                    <p>Title: {{$post['title']}}</p>
                    <p style="border-color: black">Description: {{$post['description']}}</p>
                    <a href="/group/{{ $post->group_id }}/edit-post/{{ $post->id }}">Edit</a>
                    <form action="/group/{{ $post->group_id }}/delete-post/{{ $post->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>Delete</button>
                    </form>
                </div>                
            @endforeach
        </div>
    @endauth
</body>
</html>