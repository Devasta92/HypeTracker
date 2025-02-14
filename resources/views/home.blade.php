<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hypeTracker - Home</title>
</head>
<body>

    @auth
        <p>Welcome to WOMBO COM</p>
        <form action="/logout" method="POST">
            @csrf
            <button>Log out</button>
        </form>

        <div style="border: 2px solid rgb(68, 3, 3);">
            <form action="/createGroup" method="POST">
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
                    <a href="{{ route ('groups.showGroup', $group->id)}} ">{{$group['name']}}</a>
                </div>                
            @endforeach
        </div>

    @else
    <!-- Register area -->
    <div style="border: 2px solid rgb(68, 3, 3);">
        <h2>Register</h2>
        <!-- Die Action "/register" wird ausgelöst beim klick auf den button in dieser Form. Siehe dann routes /d -->
        <form action="/register" method="POST"> 
            @csrf <!-- ist unbedingt notwendig, um Forms abzuschicken, ist ein Sicherheitsfeature von Laravel (Cross-site request forgery) /d -->
            <input name='name' type="text" placeholder="name">
            <input name='email' type="text" placeholder="email">
            <input name='password' type="password" placeholder="password">
            <button>Register</button>
        </form> 
    </div>
    <!-- Login area -->
    <div style="border: 2px solid rgb(68, 3, 3);">
        <h2>Login</h2>
        <!-- Die Action "/Login" wird ausgelöst beim klick auf den button in dieser Form. Siehe dann routes /d -->
        <form action="/login" method="POST"> 
            @csrf <!-- ist unbedingt notwendig, um Forms abzuschicken, ist ein Sicherheitsfeature von Laravel (Cross-site request forgery) /d -->
            <input name="loginname" type="text" placeholder="name">
            <input name="loginpassword" type="password" placeholder="password">
            <button>Log in</button>
        </form> 
    </div>
    @endauth
</body>
</html>