<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mission3-1</title>
</head>
<body>
    <form action="" method="post" value="コメント">
        <input type="text" name="name" value="お名前">
        <input type="text" name="com"　value="コメント">
        <input type="submit" name="submit">
    </form>
    <?php
    $num = 
    $name = $_POST["name"];
    $com = $_POST["com"];
    $date = date( "Y年m月d日 H時i分s秒" );
    
    $filename = "mission_3-1.txt";
    $fp = fopen($filename,"a");
    fwrite($fp, $name.$com.$data.PHP_EOL);

    ?>
</body>
</html>