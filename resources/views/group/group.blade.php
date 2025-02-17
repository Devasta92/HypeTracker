<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hypeTracker - Group</title>
</head>
<body>
    @auth
        <p>Group View</p>
        <form action="/logout" method="POST">
            @csrf
            <button>Log out</button>
        </form>
        <div>
            <form action="/group/{{ $group->id }}/createPost" method="POST">
                @csrf
                <input name="postTitle" type="text" placeholder="title">
                <input name="postDescription" type="text" placeholder="description">
                <label for="image">Choose an image</label>
                <input name="postImage" type="file" id="image">
                <input name='group_id' type="hidden" value="{{$group->id}}">
                <button>Create post</button>
            </form>
        </div>   
    @endauth
</body>
</html>