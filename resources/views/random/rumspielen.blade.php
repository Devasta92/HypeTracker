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
</body>
</html>
