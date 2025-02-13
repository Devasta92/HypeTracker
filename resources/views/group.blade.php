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
            
        </div>   
    @endauth
</body>
</html>