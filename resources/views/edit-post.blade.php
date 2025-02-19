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
        <p>Edit Post</p>
        <form action="/group/{{$post->group_id}}/edit-post/{{$post->id}}" method="POST">
            @csrf
            @method('PUT')
            <input type="text" name="title" value="{{$post->title}}">
            <textarea name="description" cols="30" rows="5">{{$post->description}}</textarea>
            <button>Save Changes</button>
        </form>       
    @endauth
</body>
</html>