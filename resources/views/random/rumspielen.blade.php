<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Coding Play Area</h1>
    <div>
    <h2>Part 1</h2>
    <?php
    echo $_SERVER['PHP_SELF'] . "\n </br>";
    echo $_SERVER['REQUEST_METHOD'] . "\n </br>";
    echo $_SERVER['HTTP_HOST'] . "\n </br>";
    echo $_SERVER['REQUEST_URI'] . "\n </br>";
    ?>
    </div>
    <div>
    <h2>Part 2</h2>
    <?php
    $bar = array(3,2,3,1);
    $arr = get_defined_vars();

    print_r(array_keys($arr));
    echo "\n </br> </br> \n"; # le linebreak face

    print_r(array_keys($_SERVER));
    echo "\n </br> </br> \n"; # le linebreak face

    print_r(array_keys($_GET));
    echo "\n </br> </br> \n"; # le linebreak face
    ?>
    </div>
</body>
</html>
